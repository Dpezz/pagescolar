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

use PAGE\DemoBundle\Entity\DatosEvaluaciones;
use PAGE\DemoBundle\Controller\GetController;
use PAGE\DemoBundle\Controller\LoadController;

/**
 * @Route("/profile")
 */
class TestController extends Controller
{
/* Template */
    
    /**
     * @Route("/evaluaciones", name="evaluaciones")
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

        return array(
            'flag'=>$flag,
            'dataE'=>$this->getEvaluacionesAll($id_user),
            'dataD'=>$this->getDocentes($id_user),
            'dataC'=>$this->getCursos($id_user),
            'dataA'=>$this->getAsignaturas($id_user),
            'dataN'=>array('curso'=>'','asignatura'=>'','docente'=>''),
        );
    }

    /**
     * @Route("/evaluaciones/curso/{id}",defaults={"id"=-1}, name="evaluaciones_curso")
     * @Method("GET")
     * @Template()
     */
    public function evaluacionesCursoAction(Request $request,$id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id_user = $this->getUser()->getParent();

        $id_curso = $id;
        $id_asignatura = '';
        $id_docente = '';

        return $this->render('PAGEDemoBundle:Test:evaluaciones.html.twig',array(
            'flag'=>$flag,
            'dataE'=>$this->getEvaluaciones($id_user,$id_curso,$id_asignatura,$id_docente),
            'dataD'=>$this->getDocentes($id_user),
            'dataC'=>$this->getCursos($id_user),
            'dataA'=>$this->getAsignaturas($id_user),
            'dataN'=>array('curso'=>$this->getNameCurso($id_curso),
                'asignatura'=>$this->getNameAsignatura($id_asignatura),
                'docente'=>$this->getNameDocente($id_docente)),
        ));
    }

    /**
     * @Route("/evaluaciones/asignatura/{id}",defaults={"id"=-1}, name="evaluaciones_asignatura")
     * @Method("GET")
     * @Template()
     */
    public function evaluacionesAsignaturaAction(Request $request,$id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id_user = $this->getUser()->getParent();

        $id_curso = '';
        $id_asignatura = $id;
        $id_docente = '';

        return $this->render('PAGEDemoBundle:Test:evaluaciones.html.twig',array(
            'flag'=>$flag,
            'dataE'=>$this->getEvaluaciones($id_user,$id_curso,$id_asignatura,$id_docente),
            'dataD'=>$this->getDocentes($id_user),
            'dataC'=>$this->getCursos($id_user),
            'dataA'=>$this->getAsignaturas($id_user),
            'dataN'=>array('curso'=>$this->getNameCurso($id_curso),
                'asignatura'=>$this->getNameAsignatura($id_asignatura),
                'docente'=>$this->getNameDocente($id_docente))
        ));
    }

    /**
     * @Route("/evaluaciones/docente/{id}",defaults={"id"=-1}, name="evaluaciones_docente")
     * @Method("GET")
     * @Template()
     */
    public function evaluacionesDocenteAction(Request $request,$id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id_user = $this->getUser()->getParent();

        $id_curso = '';
        $id_asignatura = '';
        $id_docente = $id;

        return $this->render('PAGEDemoBundle:Test:evaluaciones.html.twig',array(
            'flag'=>$flag,
            'dataE'=>$this->getEvaluaciones($id_user,$id_curso,$id_asignatura,$id_docente),
            'dataD'=>$this->getDocentes($id_user),
            'dataC'=>$this->getCursos($id_user),
            'dataA'=>$this->getAsignaturas($id_user),
            'dataN'=>array('curso'=>$this->getNameCurso($id_curso),
                'asignatura'=>$this->getNameAsignatura($id_asignatura),
                'docente'=>$this->getNameDocente($id_docente))
        ));
    }

    /**
     * @Route("/evaluaciones/alumno/{id}",defaults={"id"=-1}, name="evaluaciones_alumno")
     * @Method("GET")
     * @Template()
     */
    public function evaluacionesAlumnoAction(Request $request,$id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id_user = $this->getUser()->getParent();

        $id_curso = $this->getAlumno($id_user,$id)->getCurso();
        $id_asignatura = '';
        $id_docente = '';

        return $this->render('PAGEDemoBundle:Test:evaluaciones.html.twig',array(
            'flag'=>$flag,
            'dataE'=>$this->getEvaluaciones($id_user,$id_curso,$id_asignatura,$id_docente),
            'dataD'=>$this->getDocentes($id_user),
            'dataC'=>$this->getCursos($id_user),
            'dataA'=>$this->getAsignaturas($id_user),
            'dataN'=>array('curso'=>$this->getNameCurso($id_curso),
                'asignatura'=>$this->getNameAsignatura($id_asignatura),
                'docente'=>$this->getNameDocente($id_docente)),
        ));
    }

    /**
     * @Route("/evaluaciones/filter", name="evaluaciones_filter")
     * @Method("POST")
     */
    public function evaluacionesFilterAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id_user = $this->getUser()->getParent();

        if(! $id_curso = $request->get('curso'))
            $id_curso = '';

        if(! $id_asignatura = $request->get('asignatura'))
            $id_asignatura = '';

        if(! $id_docente = $request->get('docente'))
            $id_docente = '';

        return $this->render('PAGEDemoBundle:Test:evaluaciones.html.twig',array(
            'flag'=>$flag,
            'dataE'=>$this->getEvaluaciones($id_user,$id_curso,$id_asignatura,$id_docente),
            'dataD'=>$this->getDocentes($id_user),
            'dataC'=>$this->getCursos($id_user),
            'dataA'=>$this->getAsignaturas($id_user),
            'dataN'=>array('curso'=>$this->getNameCurso($id_curso),
                'asignatura'=>$this->getNameAsignatura($id_asignatura),
                'docente'=>$this->getNameDocente($id_docente))
        ));
    }

    /**
     * @Route("/evaluaciones/new", name="evaluacion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request){
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
     * @Route("/evaluaciones/{id}", name="evaluacion_show")
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

/* GET */

    private function getAsignaturas($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->findBy(array('id_user'=>$id));
        return $data;
    }

    private function getCursos($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')->findBy(array('id_user'=>$id));
        return $data;
    }

    private function getDocentes($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocentes')->findBy(array('id_user'=>$id));
        return $data;
    }

    private function getAlumno($id_user,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findOneBy(array('id_user'=>$id_user,'id'=>$id));
        return $data;
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

    public function getEvaluacionesAll($id_user){
        $list = array();

        $em = $this->getDoctrine()->getManager();
        $data = $em->createQuery('SELECT i FROM PAGEDemoBundle:DatosEvaluaciones i where i.id_user = :user  
        ORDER BY i.fecha DESC')
        ->setParameter('user', $id_user)
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

    private function getEvaluacion($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->find($id);
        return $data;
    }

    private function getRegimen(){
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


/* POST EVALUACION */
    /**
     * @Route("/evaluacion/create",name="evaluacion_create")
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
        return new RedirectResponse($this->generateUrl('evaluaciones'));
    }

    /**
     * @Route("/evaluacion/evaluacion/{id}", name="evaluacion_edit")
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
        return new RedirectResponse($this->generateUrl('evaluaciones'));
    }

    /**
     * @Route("/evaluacion/delete")
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

                $this->deleteJsonEvaluacionNotas($id,$user->getIdCurso(),$user->getIdAsignatura(),$this->getUser()->getParent());

                $request->getSession()->set('flag',1);
                return new Response(1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response(0);
        }
    }

/* FUNCIONES */

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
        $url = "users/".$id_user."/grades/".$id_curso.$id_asignatura.".json";
        if(!file_exists($url)){
            $json = json_encode(
                array(
                    'id_curso'=>$id_curso,
                    'id_asignatura'=>$id_asignatura,
                    'year'=>date('Y'),
                    'evaluaciones'=>array()
                    )
                );
            $fh = fopen("users/".$id_user."/grades/".$id_curso.$id_asignatura.".json", 'w');
            fwrite($fh, $json);
            fclose($fh);
        }
    }

    private function deleteJsonEvaluacionNotas($id,$id_curso,$id_asignatura,$id_user){
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
}