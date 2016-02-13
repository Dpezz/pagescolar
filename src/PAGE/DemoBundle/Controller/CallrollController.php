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
class CallrollController extends Controller
{

/* Template */

    /**
    * @Route("/asistencias", name="asistencias")
    * @Method("GET")
    * @Template()
    */
    public function asistenciasAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id_user = $this->getUser()->getParent();
        $id_curso = $this->getCursos($id_user)[0]->getId();//Id del Curso

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
    * @Route("/asistencias/curso/{id}", name="asistencias_curso")
    * @Method("GET")
    */
    public function asistenciasCursoAction(Request $request,$id){
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

        return $this->render('PAGEDemoBundle:Callroll:asistencias.html.twig',array (
            'flag'=>$flag,
            'curso'=>$this->getNameCurso($id_curso),
            'dataC'=>$this->getCursos($id_user),
            'dataA'=>$this->getAlumnosCurso($id_user,$id_curso),
            'dataAS'=>$this->getJsonAsistencia($id_curso,$id_user),
            'dias'=>intval($dias->format('%a'))
        ));
    }

    /**
    * @Route("/asistencias/alumno/{id}", name="asistencias_alumno")
    * @Method("GET")
    * @Template()
    */
    public function asistenciasAlumnoAction(Request $request,$id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id_user = $this->getUser()->getParent();
        $id_curso = $this->getAlumno($id_user,$id)->getCurso();//Id del Curso

        //Obtener la fecha de hoy y de inicio de clases
        $hoy = new \DateTime('now');
        $user = $this->getInstitucion($id_user);
        if(!is_null($user->getFechaInicio()) && !empty($user->getFechaInicio()))
            $inicio = $user->getFechaInicio();
        else
            $inicio = new \DateTime(date('Y').'-03-01');

        $dias = $inicio->diff($hoy);

        return $this->render('PAGEDemoBundle:Callroll:asistencias.html.twig', array (
            'flag'=>$flag,
            'curso'=>$this->getNameCurso($id_curso),
            'dataC'=>$this->getCursos($id_user),
            'dataA'=>$this->getAlumnoCurso($id_user,$id_curso,$id),
            'dataAS'=>$this->getJsonAsistencia($id_curso,$id_user),
            'dias'=>intval($dias->format('%a'))
        ));
    }

    /**
    * @Route("/asistencias/filter", name="asistencias_filter")
    * @Method("POST")
    */
    public function asistenciasFilterAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id_user = $this->getUser()->getParent();
        $id_curso = $request->get('curso');//Id del Curso

        //Obtener la fecha de hoy y de inicio de clases
        $hoy = new \DateTime('now');
        $user = $this->getInstitucion($id_user);
        if(!is_null($user->getFechaInicio()) && !empty($user->getFechaInicio()))
            $inicio = $user->getFechaInicio();
        else
            $inicio = new \DateTime(date('Y').'-03-01');

        $dias = $inicio->diff($hoy);

        return $this->render('PAGEDemoBundle:Callroll:asistencias.html.twig',array (
            'flag'=>$flag,
            'curso'=>$this->getNameCurso($id_curso),
            'dataC'=>$this->getCursos($id_user),
            'dataA'=>$this->getAlumnosCurso($id_user,$id_curso),
            'dataAS'=>$this->getJsonAsistencia($id_curso,$id_user),
            'dias'=>intval($dias->format('%a'))

        ));
    }

    /**
    * @Route("/asistencia/{id}", name="asistencia")
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

    public function getCuentas($email){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:User')->findOneBy(array('email' => $email));
        return $data;
    }

    public function getCursos($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')->findBy(array('id_user'=>$id));
        return $data;
    }

    public function getAlumno($id_user,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findOneBy(array('id_user'=>$id_user,'id'=>$id));
        return $data;
    }

    public function getAlumnosCurso($id,$id_curso){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id,'curso'=>$id_curso));
        return $data;
    }

    public function getAlumnoCurso($id_user,$id_curso,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id_user,'curso'=>$id_curso,'id'=>$id));
        return $data;
    }

    private function getNameCurso($id){
        $em = $this->getDoctrine()->getManager();
        if($data = $em->getRepository('PAGEDemoBundle:DatosCursos')->find($id))
            return $data->getName().' '.$data->getIndice();

        return null;
    }

/* POST ASISTENCIA */
    /**
     * @Route("/asistencia/create/{id}", name="asistencia_create")
     * @Method("POST")
     */
    public function createAsistencia(Request $request, $id){
            $id_curso = $id;
            //$id_curso = 'kMrJ4FeG8KOvwM7';
            $fecha = str_replace('/', '-',$request->query->get('fecha'));
            //$fecha = '18/03/2015';
            $id_user = $this->getUser()->getParent();

            try{
                $file = file_get_contents("users/".$id_user."/callroll/".$id_curso.".json");
                $json = json_decode($file,true);

                $ausentes = array();
                $data = $this->getAlumnosCurso($id_user,$id_curso);

                foreach ($data as $key => $value) {
                    if($request->get('presente_'.$value->getId()) != 1){
                        $ausentes[] = array('id'=>$value->getId(),'motivo'=>$request->get('motivo_'.$value->getId()));
                        //Verifi if exist acount
                        if($this->getCuentas($value->getEmail())){
                          //enviar email
                          $this->sendEmail($value->getName().' '.$value->getPlastname(),$value->getEmail(),$fecha,$request->get('motivo_'.$value->getId()));
                        }
                    }
                }

                $array = array('fecha'=>$fecha,'ausentes'=>$ausentes);
                $json['asistencia'][count($json['asistencia'])] = $array;

                $json = json_encode($json,true);
                file_put_contents("users/".$id_user."/callroll/".$id_curso.".json", $json);
                $request->getSession()->set('flag',1);

            }catch(Exception $e){
                $exit = false;
                $request->getSession()->set('flag',0);
            }
            return new RedirectResponse($this->generateUrl('asistencia',array('id'=>$id_curso,'fecha'=>$fecha)));
    }

    /**
     * @Route("/asistencia/edit/{id}", name="asistencia_edit")
     * @Method("POST")
     */
    public function editAsistencia(Request $request, $id){
            $id_curso = $id;
            //$id_curso = 'kMrJ4FeG8KOvwM7';
            $fecha = str_replace('/', '-',$request->query->get('fecha'));
            //$fecha = '18/03/2015';
            $id_user = $this->getUser()->getParent();

            try{
                $file = file_get_contents("users/".$id_user."/callroll/".$id_curso.".json");
                $json = json_decode($file,true);

                $ausentes = array();
                $data = $this->getAlumnosCurso($id_user,$id_curso);

                foreach ($data as $key => $value) {
                    if($request->get('presente_'.$value->getId()) != 1){
                        $ausentes[] = array('id'=>$value->getId(),'motivo'=>$request->get('motivo_'.$value->getId()));
                        //Verifi if exist acount
                        if($this->getCuentas($value->getEmail())){
                          //enviar email
                          $this->sendEmail($value->getName().' '.$value->getPlastname(),$value->getEmail(),$fecha, $request->get('motivo_'.$value->getId()));
                        }
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
                file_put_contents("users/".$id_user."/callroll/".$id_curso.".json", $json);
                $request->getSession()->set('flag',1);

            }catch(Exception $e){
                $exit = false;
                $request->getSession()->set('flag',0);
            }
            return new RedirectResponse($this->generateUrl('asistencia',array('id'=>$id_curso,'fecha'=>$fecha)));
    }

/* FUNCIONES */

    private function newJsonAsistencia($id,$id_user){

        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')->find($id);

        $json = json_encode(array('id'=>$data->getId(),'year'=>date('Y'),'asistencia'=>array()));

        $fh = fopen("users/".$id_user."/callroll/".$id.".json", 'w');
        fwrite($fh, $json);
        fclose($fh);
    }

    private function jsonAsistenciaFecha($id,$id_user,$fecha){

        $file = file_get_contents("users/".$id_user."/callroll/".$id.".json");
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

        $file = file_get_contents("users/".$id_user."/callroll/".$id.".json");
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

    private function deleteJsonAsistencia($id){
        if(file_exists("users/".$this->getUser()->getParent()."/callroll/".$id.".json")){
            unLink("users/".$this->getUser()->getParent()."/callroll/".$id.".json");
        }
    }

    private function getJsonAsistencia($id,$id_user){

        $fh = file_get_contents("users/".$id_user."/callroll/".$id.".json");
        return json_decode($fh,true);
    }

    private function sendEmail($name, $email, $fecha, $motivo){
        $message = \Swift_Message::newInstance()
        ->setSubject('Pagescolar - Asistencia a Clases')
        ->setFrom('contacto@pagescolar.cl')
        ->setTo($email)
        ->setBody(
            $this->renderView(
                'PAGEDemoBundle:Email:email_asistencia.html.twig',
                array('name'=> $name,'email'=>$email, 'fecha'=>$fecha, 'motivo'=>$motivo)
            ),'text/html'
        );
        $this->get('mailer')->send($message);
    }
}
