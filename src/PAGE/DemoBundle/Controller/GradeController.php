<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

use PAGE\DemoBundle\Controller\GetController;
use PAGE\DemoBundle\Controller\LoadController;


/**
 * @Route("/profile")
 */
class GradeController extends Controller
{
    
/* Template */

    /**
     * @Route("/notas/{id}", name="notas")
     * @Method("GET")
     * @Template()
     */
    public function notasAction(Request $request,$id){
        $id_user = $this->getUser()->getParent();//id de institucion
        $id_curso = $id;//get Id

        if( is_null($request->get('asignatura')) ){
            if($user = $this->getEvaluacionesAll($id_user)){
                $id_asignatura = $user->getIdAsignatura();
            }else{
                $id_asignatura = '';
            }
        }else{
            $id_asignatura = $request->get('asignatura');
        }

        return array(
            'dataC'=>$this->getCursos($id_user),
            'dataAS'=>$this->getAsignaturas($id_user),
            'dataE'=>array('curso'=>$this->getNameCurso($id_curso),
            'asignatura'=>$this->getNameAsignatura($id_asignatura),
            'docente'=>$this->getNameDocente($this->getDocenteEvaluacion($id_user,$id_curso,$id_asignatura))
            ),
            'dataA'=>$this->getAlumnosCurso($id_user,$id_curso),
            'dataN'=>$this->getEvaluacionesFiltro($id_user,$id_curso,$id_asignatura)
        );
    }

    /**
     * @Route("/notas/alumno/{id}", name="notas_alumno")
     * @Method("GET")
     * @Template()
     */
    public function notasAlumnoAction(Request $request,$id){
        $id_user = $this->getUser()->getParent();//id de institucion
        $id_curso = $this->getAlumno($id_user,$id)->getCurso();//get Id curso

        return array(
            'dataC'=>$this->getCursos($id_user),
            'dataAS'=>$this->getAsignaturas($id_user),
            'curso'=>$this->getNameCurso($id_curso),
            'dataA'=>$this->getAlumnoCurso($id_user,$id_curso,$id),
            'dataN'=>$this->getEvaluacionesAsignaturas($id_user,$id_curso,$id)
        );
    }

    /**
     * @Route("/notas/filter", name="notas_filter")
     * @Method("POST")
     * @Template()
     */
    public function notasFilterAction(Request $request){
        $id_user = $this->getUser()->getParent();//id de institucion
        $id_curso = $request->get('curso');

        if( is_null($request->get('asignatura')) ){
            if($user = $this->getEvaluacionesAll($id_user)){
                $id_asignatura = $user->getIdAsignatura();
            }else{
                $id_asignatura = '';
            }
        }else{
            $id_asignatura = $request->get('asignatura');
        }

        return $this->render('PAGEDemoBundle:Grade:notas.html.twig',array(
            'dataC'=>$this->getCursos($id_user),
            'dataAS'=>$this->getAsignaturas($id_user),
            'dataE'=>array('curso'=>$this->getNameCurso($id_curso),
            'asignatura'=>$this->getNameAsignatura($id_asignatura),
            'docente'=>$this->getNameDocente($this->getDocenteEvaluacion($id_user,$id_curso,$id_asignatura))
            ),
            'dataA'=>$this->getAlumnosCurso($id_user,$id_curso),
            'dataN'=>$this->getEvaluacionesFiltro($id_user,$id_curso,$id_asignatura)
        ));
    }


    /**
     * @Route("/nota/{id}", name="nota")
     * @Method("GET")
     * @Template()
     */
    public function notaAction(Request $request, $id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id_user = $this->getUser()->getParent();//id de institucion
        $evaluacion = $this->getEvaluacion($id);

        return array(
            'flag'=>$flag,
            'id_curso'=>$evaluacion->getIdCurso(),
            'dataE'=> $this->getEvaluacionNota($id)[0],
            'dataA'=>$this->getAlumnosCurso($id_user,$evaluacion->getIdCurso()),
            'dataN'=>$this->getJsonNota($id,$evaluacion->getIdCurso(),$evaluacion->getIdAsignatura(),$id_user)
        );
    }


/* GET */

    public function getAsignaturas($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->findBy(array('id_user'=>$id));
        return $data;
    }

    public function getCursos($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')->findBy(array('id_user'=>$id));
        return $data;
    }

    public function getAlumnosCurso($id,$id_curso){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id,'curso'=>$id_curso));
        return $data;
    }

    public function getAlumnoCurso($id_user,$id_curso,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findOneBy(array('id_user'=>$id_user,'curso'=>$id_curso,'id'=>$id));
        return $data;
    }

    public function getAlumno($id_user,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findOneBy(array('id_user'=>$id_user,'id'=>$id));
        return $data;
    }

    private function getEvaluaciones($id_user,$id_curso,$id_asignatura){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(
            array('id_user'=>$id_user,'id_curso'=>$id_curso,'id_asignatura'=>$id_asignatura),array('fecha'=>'ASC')
        );
        return $data;
    }

    public function getDocenteEvaluacion($id,$id_curso,$id_asignatura){
        $em = $this->getDoctrine()->getManager();
        if($data = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')
        ->findOneBy(array('id_user'=>$id,'id_curso'=>$id_curso,'id_asignatura'=>$id_asignatura)))
            return $data->getIdDocente();

        return '';
    }

    private function getEvaluacionNota($id){
        $list = array();
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->find($id);

        $list[] = array(
            'id'=>$data->getId(),
            'curso'=>$this->getNameCurso($data->getIdCurso()),
            'asignatura'=>$this->getNameAsignatura($data->getIdAsignatura()),
            'docente'=>$this->getNameDocente($data->getIdDocente()),
            'fecha'=>$data->getFecha(),
        );
        
        return $list;
    }

    private function getEvaluacion($id){
        $list = array();
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->find($id);
        return $data;
    }

    private function getEvaluacionesAll($id){
        $list = array();
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findOneBy(array('id_user'=>$id));
        return $data;
    }

    public function getEvaluacionesFiltro($id_user,$id_curso,$id_asignatura){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(
            array('id_user'=>$id_user,'id_curso'=>$id_curso,'id_asignatura'=>$id_asignatura),array('fecha'=>'ASC')
        );

        $notas = $this->getJsonNotas($id_curso,$id_asignatura,$id_user);

        $lista = array();

        if(!is_null($notas)){
            $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')
            ->findBy(array('id_user'=>$id_user,'curso'=>$id_curso),array('plastname'=>'ASC'));
            foreach ($data as $key => $value) {
                $temp = array();
                $promedio = null;
                foreach ($this->getSemestres() as $clave => $valor) {
                    $cadena = null;
                    foreach ($notas['evaluaciones'] as $index => $item) {
                        if($valor['name'] == $item['semestre'])
                            foreach ($item['notas'] as $i => $var) {
                                if($var['id'] == $value->getId())
                                    $cadena .= $var['nota'].'-';
                            }
                    }
                    $promedio .= $this->getPromedio(rtrim($cadena,'-')).'-';
                    $temp[] = array('semestre'=>$valor['name'],'notas'=>rtrim($cadena,'-'),
                        'promedio'=>$this->getPromedio(rtrim($cadena,'-')));
                }
                $lista[] = array('id_alumno'=>$value->getId(), 'periodo'=>$temp,'promedio'=>$this->getPromedio(rtrim($promedio,'-')));
            }
        }
        return $lista;
    }

    public function getEvaluacionesAsignaturas($id_user,$id_curso,$id){
        $asignaturas = $this->getAsignaturas($id_user);
        $lista = array();

        foreach ($asignaturas as $key => $value) {
            $id_asignatura = $value->getId();
            $evaluaciones = $this->getEvaluaciones($id_user,$id_curso,$id_asignatura);
            $notas = $this->getJsonNotas($id_curso,$id_asignatura,$id_user);

            if(!is_null($notas)){
                $temp = array();
                $cadena = null;

                foreach ($evaluaciones as $clave => $valor) {
                    foreach ($notas['evaluaciones'] as $index => $item) {
                        if($item['id'] == $valor->getId()){
                            foreach ($item['notas'] as $i => $v) {
                                if($v['id'] == $id)
                                    $cadena .= $v['nota'].'-';
                            }
                        }
                    }
                }
                $temp = explode('-', rtrim($cadena,'-'));
                $lista[] = array('asignatura'=>$value->getId(), 'notas'=>$temp);
            }
        }
        return $lista;
    }

    private function getNameCurso($id){
        $em = $this->getDoctrine()->getManager();
        if($data = $em->getRepository('PAGEDemoBundle:DatosCursos')->find($id))
            return $data->getName().' '.$data->getIndice();

        return null;
    }

    private function getNameAsignatura($id){
        $em = $this->getDoctrine()->getManager();
        if($data = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->find($id))
            return $data->getName();

        return null;
    }

    private function getNameDocente($id){
        $em = $this->getDoctrine()->getManager();
        if($data = $em->getRepository('PAGEDemoBundle:DatosDocentes')->find($id))
            return $data->getName().' '.$data->getPlastname().' '.$data->getMlastname();

        return null;
    }

    public function getRegimen(){
        $id = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosInstitucion')->find($id);
        $num = 0;
        $regimen = $data->getRegimen();

        $list = array();
        if( !is_null($regimen)){
            $regimen = strtolower($regimen);
            if(strpos($regimen, 'tri') !== false ){
                $num = 3;
            }else{
                $num = 2;
            }
        
            for ($i=1; $i <= $num; $i++) { 
                $list[] = array(
                    'name' => $i.' '.str_replace('tral','tre', $regimen),
                    'id' => $i
                );
            }
        }
        return new JsonResponse($list);
    }

    private function getSemestres(){
        $id = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosInstitucion')->find($id);
        $num = 0;
        $regimen = $data->getRegimen();

        $list = array();
        if( !is_null($regimen)){
            $regimen = strtolower($regimen);
            if(strpos($regimen, 'tri') !== false ){
                $num = 3;
            }else{
                $num = 2;
            }
        
            for ($i=1; $i <= $num; $i++) { 
                $list[] = array(
                    'name' => $i.' '.str_replace('tral','tre', $regimen),
                    'id' => $i
                );
            }
        }
        return $list;
    }

    private function getPromedio($notas){
        $notas = explode('-', $notas);
        $suma = 0;
        foreach ($notas as $key => $value) {
            $suma = ($suma + str_replace(',', '.', $value));
        }
        return $promedio = $suma/count($notas);
    }

/* POST NOTAS */
    /**
     * @Route("/notas/edit/{id}",name="notas_edit")
     * @Method("POST")
     */
    public function editNotas(Request $request, $id){
        $exit = false;
        //$id = $request->query->get('id');
        $id_user = $this->getUser()->getParent();
        $user = $this->getEvaluacion($id);
        $alumnos = $this->getAlumnosCurso($id_user,$user->getIdCurso());

        try{
            $file = file_get_contents("users/".$id_user."/grades/".$user->getIdCurso().$user->getIdAsignatura().".json");
            $json = json_decode($file,true);

            $list_id = array();
            foreach ($json['evaluaciones'] as $key => $value) {
                $list_id[] = $value['id'];
            }

            $notas = array();
            foreach ($alumnos as $key => $value) {
                $notas[] = array('id'=>$value->getId(),'nota'=>$request->get('input_'.$value->getId()));
            }

            if(!in_array($id, $list_id)){
                
                if(count($json['evaluaciones']) == 0){
                    $json['evaluaciones'] = array(
                    array('id'=>$id,'semestre'=>$user->getSemestre(),'notas'=>$notas)
                    );
                }else{
                    $json['evaluaciones'][] = array('id'=>$id,'semestre'=>$user->getSemestre(),'notas'=>$notas);
                }
               
            }else{
                for ($i=0; $i < count($json['evaluaciones']); $i++) { 
                    if($json['evaluaciones'][$i]['id'] == $id){
                        $json['evaluaciones'][$i]['notas'] = $notas;
                    }
                }
            }

            $json = json_encode($json,true);
            file_put_contents("users/".$id_user."/grades/".$user->getIdCurso().$user->getIdAsignatura().".json", $json);
            $exit =true;

        }catch(Exception $e){
            $exit = false;
            $request->getSession()->set('flag',0);
        }

        if($exit){
            try{
                $em = $this->getDoctrine()->getManager();
                if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->find($id)){
                    $user->setIsActive(1);
                    $user->setFechaNotas(new \DateTime('now'));
                    $em->flush();
                    $request->getSession()->set('flag',1);
                }
            }catch(Exception $e){
                $request->getSession()->set('flag',0);
            }
        }else{
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('nota',array('id'=>$id)));
    }

/* FUNCIONES */


    private function editJsonNotas($id,$id_curso,$id_asignatura,$id_user,$semestre){
        $url = "users/".$id_user."/grades/".$id_curso.$id_asignatura.".json";
        if(file_exists($url)){
            $file = file_get_contents($url);
            $json = json_decode($file,true);

            foreach ($json['evaluaciones'] as $key => $value) {
                if($value['id'] == $id){
                    $json['evaluaciones'][$key]['semestre'] = $semestre;
                }
            }
            $json = json_encode($json,true);
            file_put_contents($url, $json);
        }
        return null;
    }

    private function deleteJsonNotas($id,$id_curso,$id_asignatura,$id_user){
        $url = "users/".$id_user."/grades/".$id_curso.$id_asignatura.".json";
        if(file_exists($url)){
            $file = file_get_contents($url);
            $json = json_decode($file,true);

            foreach ($json['evaluaciones'] as $key => $value) {
                if($value['id'] == $id){
                    unset($json['evaluaciones'][$key]);
                }
            }
            $json = json_encode($json,true);
            file_put_contents($url, $json);
        }
        return null;
    }

    private function getJsonNota($id,$id_curso,$id_asignatura,$id_user){
        $file = file_get_contents("users/".$id_user."/grades/".$id_curso.$id_asignatura.".json");
        $json = json_decode($file,true);

        for ($i=0; $i < count($json['evaluaciones']); $i++) { 
            
            if($json['evaluaciones'][$i]['id'] == $id){

                return $json['evaluaciones'][$i]['notas'];
            }
        }

        return null;
    }

    private function getJsonNotas($id_curso,$id_asignatura,$id_user){
        $url = "users/".$id_user."/grades/".$id_curso.$id_asignatura.".json";
        if(file_exists($url)){
            $file = file_get_contents($url);
            return json_decode($file,true);
        }
        return null;
    }
}