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

use PAGE\DemoBundle\Entity\User;
use PAGE\DemoBundle\Entity\DatosInstitucion;
use PAGE\DemoBundle\Entity\DatosAsignaturas;
use PAGE\DemoBundle\Entity\DatosCursos;
use PAGE\DemoBundle\Entity\DatosEvaluaciones;
use PAGE\DemoBundle\Entity\DatosDocentes;
use PAGE\DemoBundle\Entity\DatosAlumnos;

use PAGE\DemoBundle\Controller\GetController;
use PAGE\DemoBundle\Controller\LoadController;


/**
 * @Route("/profile/academico")
 */
class AcademicoController extends Controller
{
    
/* Template */

    /**
     * @Route("/cursos", name="academico_cursos")
     * @Method("GET")
     * @Template()
     */
    public function cursosAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id = $this->getUser()->getId();
        return array(
            'flag'=>$flag,
            'dataC'=>$this->getCursos($id)
        );
    }

    /**
     * @Route("/asignaturas", name="academico_asignaturas")
     * @Method("GET")
     * @Template()
     */
    public function asignaturasAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id = $this->getUser()->getId();
        return array(
            'flag'=>$flag,
            'dataA'=> $this->getAsignaturas($id)
        );
    }

    /**
     * @Route("/evaluaciones", name="academico_evaluaciones")
     * @Method("GET")
     * @Template()
     */
    public function evaluacionesAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id_user = $this->getUser()->getParent();

        if($this->getUser()->getRole() == 'ROLE_ALUMNO'){
            $item = $this->getAlumno($this->getUser()->getId());
            if(! $id_curso = $item->getCurso()){
                 $id_curso = '';
             }
        }else{
            if(! $id_curso = $request->get('curso'))
                $id_curso = '';
        }
        
        if(! $id_asignatura = $request->get('asignatura'))
            $id_asignatura = '';
        if(! $id_docente = $request->get('docente'))
            $id_docente = '';

        return array(
            'flag'=>$flag,
            'dataE'=>$this->getEvaluaciones($id_user,$id_curso,$id_asignatura,$id_docente),
            'dataD'=>$this->getDocentes($id_user),
            'dataC'=>$this->getCursos($id_user),
            'dataA'=>$this->getAsignaturas($id_user),
            'dataN'=>array('curso'=>$this->getNameCurso($id_curso),
                'asignatura'=>$this->getNameAsignatura($id_asignatura),
                'docente'=>$this->getNameDocente($id_docente))
        );
    }

    /**
     * @Route("/evaluacion/new", name="academico_evaluacion_new")
     * @Method("GET")
     * @Template()
     */
    public function evaluacionNewAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $load = new LoadController();
        $id_user = $this->getUser()->getParent();

        return array(
                'flag'=>$flag,
                'dataD'=>$this->getDocentes($id_user),
                'dataC'=>$this->getCursos($id_user),
                'dataA'=>$this->getAsignaturas($id_user),
                'dataS'=>$this->getSemestres(),
                'listaS'=>$load->sistemaAction(),
                'listaM'=>$load->momentoAction(),
                'listaE'=>$load->evaluadorAction(),
                'listaEV'=>$load->evaluaAction(),
                'listaED'=>$load->evaluacionDAction(),
                'listaF'=>$load->finalidadAction(),
                'listaI'=>$load->instrumentoAction(),
                'listaA'=>$load->aprendizajeAction(),
                'dataE'=>null
            );
    }

    /**
     * @Route("/evaluacion/{id}", name="academico_evaluacion")
     * @Method("GET")
     * @Template()
     */
    public function evaluacionAction(Request $request, $id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $load = new LoadController();
        $id_user = $this->getUser()->getParent();

        return array(
                'flag'=>$flag,
                'dataD'=>$this->getDocentes($id_user),
                'dataC'=>$this->getCursos($id_user),
                'dataA'=>$this->getAsignaturas($id_user),
                'dataS'=>$this->getSemestres(),
                'listaS'=>$load->sistemaAction(),
                'listaM'=>$load->momentoAction(),
                'listaE'=>$load->evaluadorAction(),
                'listaEV'=>$load->evaluaAction(),
                'listaED'=>$load->evaluacionDAction(),
                'listaF'=>$load->finalidadAction(),
                'listaI'=>$load->instrumentoAction(),
                'listaA'=>$load->aprendizajeAction(),
                'dataE'=>$this->getEvaluacion($id)
            );
    }

    /**
     * @Route("/notas/{id}", name="academico_notas")
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
     * @Route("/nota/{id}", name="academico_nota")
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
        //$id = $request->query->get('id');//id Evaluacion
        $evaluacion = $this->getEvaluacion($id);

        return array(
            'flag'=>$flag,
            'dataE'=> $this->getEvaluacionNota($id)[0],
            'dataA'=>$this->getAlumnosCurso($id_user,$evaluacion->getIdCurso()),
            'dataN'=>$this->getJsonNota($id,$evaluacion->getIdCurso(),$evaluacion->getIdAsignatura(),$id_user)
        );
    }

    /**
    * @Route("/asistencias/{id}", name="academico_asistencias")
    * @Method("GET")
    * @Template()
    */
    public function asistenciasAction(Request $request,$id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id_user = $this->getUser()->getParent();
        $id_curso = $id;//Id del Curso
           
        //Obtener la fecha de hoy y de inicio de clases
        $hoy = new \DateTime('now');
        $user = $this->getInstitucion($id_user);
        if(!is_null($user->getFechaInicio()) && !empty($user->getFechaInicio()))
            $inicio = $user->getFechaInicio();
        else
            $inicio = new \DateTime(date('Y').'-03-01');

        $dias = $inicio->diff($hoy);

        return array (
            'flag'=>$flag,
            'curso'=>$this->getNameCurso($id_curso),
            'dataC'=>$this->getCursos($id_user),
            'dataA'=>$this->getAlumnosCurso($id_user,$id_curso),
            'dataAS'=>$this->getJsonAsistencia($id_curso,$id_user),
            'dias'=>intval($dias->format('%a'))
            
        );
    }

    /**
    * @Route("/asistencia/{id}", name="academico_asistencia")
    * @Method("GET")
    * @Template()
    */
    public function asistenciaAction(Request $request, $id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id_user = $this->getUser()->getParent();
        $id_curso = $id;//get ID
        $fecha = $request->query->get('fecha');//get Fecha

        return array (
            'flag'=>$flag,
            'curso'=>$this->getNameCurso($id_curso),
            'id_curso'=>$id_curso,
            'fecha'=>$fecha,
            'dataA'=>$this->getAlumnosCurso($id_user,$id_curso),
            'dataAS'=>$this->jsonAsistenciaFecha($id_curso,$id_user,$fecha),
            'exist'=>$this->jsonAsistenciaFechaExist($id_curso,$id_user,$fecha)
        );
    }

/* GET */

    public function getInstitucion($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosInstitucion')->find($id);
        return $data;
    }

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

    public function getDocentes($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocentes')->findBy(array('id_user'=>$id));
        return $data;
    }

    public function getAlumnos($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id));
        return $data;
    }

    public function getAlumnosCurso($id,$id_curso){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id,'curso'=>$id_curso));
        return $data;
    }

    public function getAlumno($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->find($id);
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

    public function getEvaluaciones($id,$id_curso,$id_asignatura,$id_docente){
        $list = array();

        $em = $this->getDoctrine()->getManager();
        $data = $em->createQuery('SELECT i FROM PAGEDemoBundle:DatosEvaluaciones i where i.id_user = :user and 
            i.id_curso Like :curso and i.id_asignatura Like :asignatura and i.id_docente Like :docente 
            ORDER BY i.fecha DESC')
        ->setParameter('user', $id)
        ->setParameter('curso', '%'.$id_curso.'%')
        ->setParameter('asignatura', '%'.$id_asignatura.'%')
        ->setParameter('docente', '%'.$id_docente.'%')
        ->getResult();

        foreach ($data as $value) {
            $list[] = array(
                'id'=>$value->getId(),
                'idcurso'=>$this->getNameCurso($value->getIdCurso()),
                'idasignatura'=>$this->getNameAsignatura($value->getIdAsignatura()),
                'iddocente'=>$this->getNameDocente($value->getIdDocente()),
                'evaluador'=>$value->getEvaluador(),
                'semestre'=>$value->getSemestre(),
                'isactive'=>$value->getIsActive(),
                'fecha'=>$value->getFecha(),
                'fechanotas'=>$value->getFechaNotas(),
                'titulo'=>$value->getTitulo(),
                );
        }
        return $list;
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

    /**
     * @Route("/semestres")
     */
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

/* POST ASIGNATURA */

    /**
     * @Route("/create_asignatura")
     * @Method("POST")
     */
    public function createAsignatura(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        try{
            $user = new DatosAsignaturas();
            $id = $this->nuevoIdAsignatura();//id de la asignatura
            $id_user = $request->get('id');//id del User

            $user->setId($id);
            $user->setIdUser($id_user);
            $user->setName($request->get('name'));
            $user->setIsActive($request->get('active'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->set('flag',1);
            return new Response(1);
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response(0);
        }
    }

    /**
     * @Route("/edit_asignatura")
     * @Method("POST")
     */
    public function editAsignatura(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        try{
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            
            if($user = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->find($id)){
                $user->setName($request->get('name'));
                $user->setIsActive($request->get('active'));

                $em->flush();
                $request->getSession()->set('flag',1);
                return new Response(1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response(0);
        }
    }

    /**
     * @Route("/delete_asignatura")
     * @Method("POST")
     */
    public function deleteAsignatura(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        try{
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->find($id)){
                $em->remove($user);
                $em->flush();
                $request->getSession()->set('flag',1);
                return new Response(1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response(0);
        }
    }

/* POST CURSO */
    /**
     * @Route("/create_curso")
     * @Method("POST")
     */
    public function createCurso(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        try{
            $user = new DatosCursos();
            $id = $this->nuevoIdCursos();//id de la Curso
            $id_user = $request->get('id');//id del User

            $user->setId($id);
            $user->setIdUser($id_user);

            $user->setName($request->get('name'));
            $user->setIndice($request->get('indice'));
            $user->setIsActive($request->get('active'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            //crear json de curso - asistencia
            $this->newJsonAsistencia($id,$id_user);

            $request->getSession()->set('flag',1);
            return new Response(1);
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response("Error: ".$e);
        }
    }

    /**
     * @Route("/edit_curso")
     * @Method("POST")
     */
    public function editCurso(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        try{
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            
            if($user = $em->getRepository('PAGEDemoBundle:DatosCursos')->find($id)){
                $user->setName($request->get('name'));
                $user->setIndice($request->get('indice'));
                $user->setIsActive($request->get('active'));

                $em->flush();
                $request->getSession()->set('flag',1);
                return new Response(1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response(0);
        }
    }

    /**
     * @Route("/delete_curso")
     * @Method("POST")
     */
    public function deleteCurso(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        try{
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosCursos')->find($id)){
                $em->remove($user);
                $em->flush();
                //eliminar json de curso-asistencia
                $this->deleteJsonAsistencia($id);

                $request->getSession()->set('flag',1);
                return new Response(1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response(0);
        }
    }

/* POST EVALUACION */
    /**
     * @Route("/create_evaluacion",name="evaluacion_create")
     * @Method("POST")
     */
    public function createEvaluacion(Request $request){
        try{
            $user = new DatosEvaluaciones();
            $id = $this->nuevoIdEvaluacion();//id de la evaluacion
            $id_user = $this->getUser()->getParent();//id del User

            $id_curso = $request->get('curso');//id del Curso
            $id_asignatura = $request->get('asignatura');//id del Asignatura
  
            $user->setId($id);
            $user->setIdUser($id_user);
            $user->setIdDocente($request->get('docente'));
            
            $user->setIdCurso($id_curso);
            $user->setIdAsignatura($id_asignatura);

            $user->setSemestre($request->get('semestre'));
            $user->setSistema($request->get('sistema'));

            //Agregar fecha
            if( !empty($request->get('fecha'))){
                $fecha = str_replace('/', '-', $request->get('fecha'));
                $fecha = new \DateTime($fecha);
                $user->setFecha($fecha);
            }

            $user->setMomento($request->get('momento'));
            $user->setEvaluador($request->get('evaluador'));
            $user->setEvaluar($request->get('evalua'));
            $user->setEvaluacionDocente($request->get('evaluacionD'));
            $user->setFinalidad($request->get('finalidad'));
            $user->setInstrumento($request->get('instrumento'));
            $user->setAprendizaje($request->get('aprendizaje'));
            $user->setTitulo($request->get('titulo'));
            $user->setIsActive(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $em->flush();

            //crear .json
            $this->newJsonEvaluacion($id_curso,$id_asignatura,$id_user);
            
            $request->getSession()->set('flag',1);
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('academico_evaluaciones'));
    }

    /**
     * @Route("/edit_evaluacion/{id}", name="evaluacion_edit")
     * @Method("POST")
     */
    public function editEvaluacion(Request $request, $id)
    {
        try{
            //$id = $request->query->get('id');
            $id_user = $this->getUser()->getParent();
            $em = $this->getDoctrine()->getManager();
            
            if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->find($id)){
            
                $curso = $request->get('curso');
                $asignatura = $request->get('asignatura');

                $user->setIdDocente($request->get('docente'));
                $user->setIdAsignatura($asignatura);
                $user->setIdCurso($curso);

                $semestre = $request->get('semestre');
                $user->setSemestre($semestre);
                $user->setSistema($request->get('sistema'));

                //Agregar fecha
                if( !empty($request->get('fecha'))){
                    $fecha = str_replace('/', '-', $request->get('fecha'));
                    $fecha = new \DateTime($fecha);
                    $user->setFecha($fecha);
                }

                $user->setMomento($request->get('momento'));
                $user->setEvaluador($request->get('evaluador'));
                $user->setEvaluar($request->get('evalua'));
                $user->setEvaluacionDocente($request->get('evaluacionD'));
                $user->setFinalidad($request->get('finalidad'));
                $user->setInstrumento($request->get('instrumento'));
                $user->setAprendizaje($request->get('aprendizaje'));
                $user->setTitulo($request->get('titulo'));

                $em->flush();
                $this->editJsonNotas($id,$curso,$asignatura,$id_user,$user->getSemestre());
                $request->getSession()->set('flag',1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('academico_evaluaciones'));
    }

    /**
     * @Route("/delete_evaluacion")
     * @Method("POST")
     */
    public function deleteEvaluacion(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        try{
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->find($id)){
                $em->remove($user);
                $em->flush();

                $this->deleteJsonNotas($id,$user->getIdCurso(),$user->getIdAsignatura(),$this->getUser()->getParent());

                $request->getSession()->set('flag',1);
                return new Response(1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response(0);
        }
    }

/* POST NOTAS */
    /**
     * @Route("/edit_notas/{id}",name="notas_edit")
     * @Method("POST")
     */
    public function editNotas(Request $request, $id){
        $exit = false;
        //$id = $request->query->get('id');
        $id_user = $this->getUser()->getParent();
        $user = $this->getEvaluacion($id);
        $alumnos = $this->getAlumnosCurso($id_user,$user->getIdCurso());

        try{
            $file = file_get_contents("users/".$id_user."/notas/".$user->getIdCurso().$user->getIdAsignatura().".json");
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
            file_put_contents("users/".$id_user."/notas/".$user->getIdCurso().$user->getIdAsignatura().".json", $json);
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
        return new RedirectResponse($this->generateUrl('academico_nota',array('id'=>$id)));
    }

/* POST ASISTENCIA */
    /**
     * @Route("/create_asistencia/{id}", name="asistencia_create")
     * @Method("POST")
     */
    public function createAsistencia(Request $request, $id){
            $id_curso = $id;
            //$id_curso = 'kMrJ4FeG8KOvwM7';
            $fecha = str_replace('/', '-',$request->query->get('fecha'));
            //$fecha = '18/03/2015';
            $id_user = $this->getUser()->getParent();

            try{
                $file = file_get_contents("users/".$id_user."/asistencia/".$id_curso.".json");
                $json = json_decode($file,true);

                $ausentes = array();
                $data = $this->getAlumnosCurso($id_user,$id_curso);

                foreach ($data as $key => $value) {
                    if($request->get('presente_'.$value->getId()) != 1){
                        $ausentes[] = array('id'=>$value->getId(),'motivo'=>$request->get('motivo_'.$value->getId()));
                    }
                }

                $array = array('fecha'=>$fecha,'ausentes'=>$ausentes);
                $json['asistencia'][count($json['asistencia'])] = $array;
                
                $json = json_encode($json,true);
                file_put_contents("users/".$id_user."/asistencia/".$id_curso.".json", $json);
                $request->getSession()->set('flag',1);

            }catch(Exception $e){
                $exit = false;
                $request->getSession()->set('flag',0);
            }
            return new RedirectResponse($this->generateUrl('academico_asistencia',array('id'=>$id_curso,'fecha'=>$fecha)));
    }

    /**
     * @Route("/edit_asistencia/{id}", name="asistencia_edit")
     * @Method("POST")
     */
    public function editAsistencia(Request $request, $id){
            $id_curso = $id;
            //$id_curso = 'kMrJ4FeG8KOvwM7';
            $fecha = str_replace('/', '-',$request->query->get('fecha'));
            //$fecha = '18/03/2015';
            $id_user = $this->getUser()->getParent();

            try{
                $file = file_get_contents("users/".$id_user."/asistencia/".$id_curso.".json");
                $json = json_decode($file,true);

                $ausentes = array();
                $data = $this->getAlumnosCurso($id_user,$id_curso);

                foreach ($data as $key => $value) {
                    if($request->get('presente_'.$value->getId()) != 1){
                        $ausentes[] = array('id'=>$value->getId(),'motivo'=>$request->get('motivo_'.$value->getId()));
                    }
                }

                for ($i=0; $i < count($json['asistencia']) ; $i++) { 
                     if($fecha == $json['asistencia'][$i]['fecha'])
                            $json['asistencia'][$i]['ausentes'] = $ausentes;
                }
                /*
                foreach ($json['asistencia'] as $key => $value) {
                    if($fecha == $value['fecha'])
                        $value['ausentes'] = $ausentes;
                }
                */
                //$array = array('fecha'=>$fecha,'ausentes'=>$ausentes);
                //$json['asistencia'][count($json['asistencia'])] = $array;
                
                $json = json_encode($json,true);
                file_put_contents("users/".$id_user."/asistencia/".$id_curso.".json", $json);
                $request->getSession()->set('flag',1);

            }catch(Exception $e){
                $exit = false;
                $request->getSession()->set('flag',0);
            }
            return new RedirectResponse($this->generateUrl('academico_asistencia',array('id'=>$id_curso,'fecha'=>$fecha)));
    }

/* FUNCIONES */
    private function nuevoIdAsignatura(){
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $id = '';
        for($i=0; $i<15; $i++){
            $id .= $caracteres[rand(0, strlen($caracteres)-1)];
        }
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->find($id);

        if ($data){
           $exit = true;
           while($exit){
                $id = '';
                for($i=0; $i<15; $i++){
                    $id .= $caracteres[rand(0, strlen($caracteres)-1)];
                }
                $em = $this->getDoctrine()->getManager();
                $data = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->find($id);

                if (!$data)
                    $exit = false;
           }
        }
        return $id;
    }

    private function nuevoIdCursos(){
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $id = '';
        for($i=0; $i<15; $i++){
            $id .= $caracteres[rand(0, strlen($caracteres)-1)];
        }
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')->find($id);

        if ($data){
           $exit = true;
           while($exit){
                $id = '';
                for($i=0; $i<15; $i++){
                    $id .= $caracteres[rand(0, strlen($caracteres)-1)];
                }
                $em = $this->getDoctrine()->getManager();
                $data = $em->getRepository('PAGEDemoBundle:DatosCursos')->find($id);

                if (!$data)
                    $exit = false;
           }
        }
        return $id;
    }

    private function nuevoIdEvaluacion(){
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $id = '';
        for($i=0; $i<15; $i++){
            $id .= $caracteres[rand(0, strlen($caracteres)-1)];
        }
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->find($id);

        if ($data){
           $exit = true;
           while($exit){
                $id = '';
                for($i=0; $i<15; $i++){
                    $id .= $caracteres[rand(0, strlen($caracteres)-1)];
                }
                $em = $this->getDoctrine()->getManager();
                $data = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->find($id);

                if (!$data)
                    $exit = false;
           }
        }
        return $id;
    }

    private function newJsonEvaluacion($id_curso,$id_asignatura,$id_user){
        $url = "users/".$id_user."/notas/".$id_curso.$id_asignatura.".json";
        if(!file_exists($url)){
            $json = json_encode(
                array(
                    'id_curso'=>$id_curso,
                    'id_asignatura'=>$id_asignatura,
                    'year'=>date('Y'),
                    'evaluaciones'=>array()
                    )
                );
            $fh = fopen("users/".$id_user."/notas/".$id_curso.$id_asignatura.".json", 'w');
            fwrite($fh, $json);
            fclose($fh);
        }
    }

    private function newJsonAsistencia($id,$id_user){
        
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')->find($id);

        $json = json_encode(array('id'=>$data->getId(),'year'=>date('Y'),'asistencia'=>array()));

        $fh = fopen("users/".$id_user."/asistencia/".$id.".json", 'w');
        fwrite($fh, $json);
        fclose($fh);
    }

    private function jsonAsistenciaFecha($id,$id_user,$fecha){
        
        $file = file_get_contents("users/".$id_user."/asistencia/".$id.".json");
        $json = json_decode($file,true);

        $data = $json["asistencia"];
        $fecha = str_replace('/', '-', $fecha);
        $array = array();

        foreach ($data as $key => $value){
            if($value['fecha'] == $fecha){
                $array = $value["ausentes"];
            }
        }
        return $array;
    }

    private function jsonAsistenciaFechaExist($id,$id_user,$fecha){
        
        $file = file_get_contents("users/".$id_user."/asistencia/".$id.".json");
        $json = json_decode($file,true);

        $data = $json["asistencia"];
        $fecha = str_replace('/', '-', $fecha);

        foreach ($data as $key => $value){
            if($value['fecha'] == $fecha){
                return true;
            }
        }
        return false;
    }

    private function editJsonNotas($id,$id_curso,$id_asignatura,$id_user,$semestre){
        $url = "users/".$id_user."/notas/".$id_curso.$id_asignatura.".json";
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

    private function deleteJsonAsistencia($id){
        if(file_exists("users/".$this->getUser()->getParent()."/asistencia/".$id.".json")){
            unLink("users/".$this->getUser()->getParent()."/asistencia/".$id.".json");
        }
    }

    private function deleteJsonNotas($id,$id_curso,$id_asignatura,$id_user){
        $url = "users/".$id_user."/notas/".$id_curso.$id_asignatura.".json";
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

    private function getJsonAsistencia($id,$id_user){
        
        $fh = file_get_contents("users/".$id_user."/asistencia/".$id.".json");
        return json_decode($fh,true);
    }

    private function getJsonNota($id,$id_curso,$id_asignatura,$id_user){
        $file = file_get_contents("users/".$id_user."/notas/".$id_curso.$id_asignatura.".json");
        $json = json_decode($file,true);

        for ($i=0; $i < count($json['evaluaciones']); $i++) { 
            
            if($json['evaluaciones'][$i]['id'] == $id){

                return $json['evaluaciones'][$i]['notas'];
            }
        }

        return null;
    }

    private function getJsonNotas($id_curso,$id_asignatura,$id_user){
        $url = "users/".$id_user."/notas/".$id_curso.$id_asignatura.".json";
        if(file_exists($url)){
            $file = file_get_contents($url);
            return json_decode($file,true);
        }
        return null;
    }
}