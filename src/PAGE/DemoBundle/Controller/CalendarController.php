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
use PAGE\DemoBundle\Entity\DatosCalendarioDocentes;
use PAGE\DemoBundle\Entity\DatosCursos;
use PAGE\DemoBundle\Entity\DatosDocentes;
use PAGE\DemoBundle\Entity\DatosAlumnos;
use PAGE\DemoBundle\Entity\DatosAsignaturas;
use PAGE\DemoBundle\Entity\DatosEvaluaciones;


/**
 * @Route("/profile/calendario")
 */
class CalendarController extends Controller
{
/* Template */

    /**
     * @Route("/docentes/{id}", name="calendario_docente")
     * @Method("GET")
     * @Template()
     */
    public function docentesAction(Request $request, $id)
    {
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        if($this->getUser()->getRole() == 'ROLE_DOCENTE')
            $id = $this->getUser()->getId();
       
        return array(
            'flag'=>$flag,
            'id_docente'=>$id,
            'docente'=>$this->getNameDocente($id),
            'dataCD'=>$this->getCalendarioDocentes($id),
        );
    }

    /**
     * @Route("/alumnos/{id}", name="calendario_alumno")
     * @Method("GET")
     * @Template()
     */
    public function alumnosAction(Request $request, $id)
    {
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        if($this->getUser()->getRole() == 'ROLE_ALUMNO')
            $id = $this->getUser()->getId();

        $id_curso = $this->getAlumno($id)->getCurso();
        return array(
            'flag'=>$flag,
            'id_alumno'=>$id,
            'curso'=>$this->getNameCurso($id_curso),
            'alumno'=>$this->getNameAlumno($id),
            'dataCD'=>$this->getCalendarioAlumnos($id_curso),
        );
    }

    /**
     * @Route("/evaluaciones", name="calendario_evaluaciones")
     * @Method("GET")
     * @Template()
     */
    public function evaluacionesAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id = $this->getUser()->getParent();

        return array(
            'flag'=>$flag,
        );
    }

/* GET */

    private function getCalendarioDocentes($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCalendarioDocentes')->findBy(array('id_docente'=>$id));
        $list = array();
        foreach ($data as $value) {
            $list[] = array(
                'id'=>$value->getId(),
                'idcurso'=>$value->getIdCurso(),
                'idasignatura'=>$value->getIdAsignatura(),
                'iddocente'=>$value->getIdDocente(),
                'dia'=>$value->getDia(),
                'bloque'=>$value->getBloque(),
                'curso'=>$this->getNameCurso($value->getIdCurso()),
                'asignatura'=>$this->getNameAsignatura($value->getIdAsignatura()),
                );
        }
        return $list;
    }

    private function getCalendarioAlumnos($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCalendarioDocentes')->findBy(array('id_curso'=>$id));
        $list = array();
        foreach ($data as $value) {
            $list[] = array(
                'id'=>$value->getId(),
                'idcurso'=>$value->getIdCurso(),
                'idasignatura'=>$value->getIdAsignatura(),
                'iddocente'=>$value->getIdDocente(),
                'dia'=>$value->getDia(),
                'bloque'=>$value->getBloque(),
                'curso'=>$this->getNameCurso($value->getIdCurso()),
                'asignatura'=>$this->getNameAsignatura($value->getIdAsignatura()),
                'docente'=>$this->getNameDocente($value->getIdDocente()),
                );
        }
        return $list;
    }

    private function getNameCurso($id){
        $em = $this->getDoctrine()->getManager();
        if($data = $em->getRepository('PAGEDemoBundle:DatosCursos')->find($id))
            return $data->getName().' '.$data->getIndice();
        else
            return '';
    }

    private function getNameAsignatura($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->find($id);
        return $data->getName();
    }

    private function getNameDocente($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocentes')->find($id);
        return $data->getName().' '.$data->getPlastname().' '.$data->getMlastname();
    }

    private function getNameAlumno($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->find($id);
        return $data->getName().' '.$data->getPlastname().' '.$data->getMlastname();
    }

    private function getAlumno($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->find($id);
        return $data;
    }

    /**
     * @Route("/calendario_evaluaciones", name="evaluciones_get")
     * @Method("GET")
     */
    public function getEvaluaciones(){
        $id = $this->getUser()->getParent();
        return new Response($this->jsonEvaluaciones($id));
    }

    private function jsonEvaluaciones($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(array('id_user'=>$id));
       
        $json = '[';
        foreach ($data as $key => $value) {
            if($value->getIsActive()){
                $evento = "event-success";
            }
            else{
                $evento = "event-important";
            }
            if($value->getFecha()){
                $time = (date_timestamp_get($value->getFecha())+86400)*1000;
            }
            
            $json .='{"id": "'.$value->getId().'",';
            $json .='"title": "'.$this->getNameCurso($value->getIdCurso()).' - '.$this->getNameAsignatura($value->getIdAsignatura()).
            ' - ('.$this->getNameDocente($value->getIdDocente()).') - '.$value->getTitulo().'",';
            $json .='"url": "'.$this->generateUrl('evaluacion_show',array('id' => $value->getId() )).'",';
            $json .='"class": "'.$evento.'",';
            $json .='"start": "'.$time.'",';
            $json .='"end": "'.$time.'"';
            $json .='},';
        }
        $json = rtrim($json,',');
        $json .=']';
        return $json;
    }


/* POST */

    /**
     * @Route("/create_horario_docente")
     * @Method("POST")
     */
    public function createHorarioDocente(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        try{
            $user = new DatosCalendarioDocentes();
            $id = $this->nuevoIdCD();//id de calendario Docente
            $id_docente = $request->get('id');//id del docente
            $id_user = $request->get('id_user');//id del User

            $user->setId($id);
            $user->setIdUser($id_user);
            $user->setIdDocente($id_docente);
            $user->setIdCurso($request->get('id_curso'));
            $user->setIdAsignatura($request->get('id_asignatura'));
            $user->setDia($request->get('dia'));
            $user->setBloque($request->get('bloque'));


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
     * @Route("/delete_horario_docente")
     * @Method("POST")
     */
    public function deleteHorarioDocente(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        try{
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosCalendarioDocentes')->find($id)){
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

/* FUNCIONES */
    private function nuevoIdCD(){
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $id = '';
        for($i=0; $i<15; $i++){
            $id .= $caracteres[rand(0, strlen($caracteres)-1)];
        }
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('PAGEDemoBundle:DatosCalendarioDocentes')->find($id);

        if ($data){
           $exit = true;
           while($exit){
                $id = '';
                for($i=0; $i<15; $i++){
                    $id .= $caracteres[rand(0, strlen($caracteres)-1)];
                }
                $em = $this->getDoctrine()->getManager();
                $data = $em->getRepository('PAGEDemoBundle:DatosCalendarioDocentes')->find($id);

                if (!$data)
                    $exit = false;
           }
        }
        return $id;
    }
}
