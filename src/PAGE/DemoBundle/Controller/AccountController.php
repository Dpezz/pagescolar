<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

use PAGE\DemoBundle\Controller\LoadController;

use PAGE\DemoBundle\Entity\User;

/**
 * @Route("/profile/cuentas")
 */
class AccountController extends Controller
{

/* Template */

    /**
     * @Route("/", name="institucion_cuentas")
     * @Method("GET")
     * @Template()
     */
    public function cuentasAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return array(
            'flag'=>$flag,
            'dataU'=>$this->getUsers($this->getUser()->getParent()),
            );
    }

/* GET */

    public function getUsersEmail($email){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:User')->findBy(array('email'=>$email));
        return $data;
    }

    public function getUsers($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:User')->findBy(array('parent'=>$id),array('role'=>'ASC','username'=>'ASC'));
        return $data;
    }

    public function getDocente($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocentes')->find($id);
        return $data;
    }

    public function getAlumnos($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->find($id);
        return $data;
    }

/* POST */

    /**
     * @Route("/delete")
     * @Method("POST")
     */
    public function deleteCuenta(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        try{
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:User')->find($id)){
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

    /**
     * @Route("/create")
     * @Method("POST")
     */
    public function createCuenta(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        try{
            $id = $request->get('username');
            $rol = $request->get('rol');
            $usuario = null;
            if($rol == "Docente"){
                $usuario = $this->getDocente($id);
            }else{
                $usuario = $this->getAlumnos($id);
            }
            
            if($usuario)
            {
               $em = $this->getDoctrine()->getManager();
               $data = $this->getUsersEmail($usuario->getEmail());//si existe algun email ya registrado

                if(!is_null($usuario->getEmail()) && !empty($usuario->getEmail()) && !$data){
                    $user = new User();
                    $user->setId($usuario->getId());
                    $username = $usuario->getName().' '.$usuario->getPlastname().' '.$usuario->getMlastname();
                    $user->setUsername($username);

                    $email = $usuario->getEmail();
                    $user->setEmail($email);
                    $user->setFono($usuario->getTelefono());
                    $rut = str_replace('.', '', $usuario->getRut());
                    $user->setPassword($rut);

                    $user->setCreateAt(new \DateTime('now'));
                    $user->setIsActive(1);
                    $user->setRole("ROLE_".strtoupper($rol));
                    $user->setParent($this->getUser()->getParent());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    //enviar Email
                    //$this->sendEmail($username,$email,$rut);
                    $request->getSession()->set('flag',1);
                    return new Response(1);
                }else{
                    $request->getSession()->set('flag',20);
                    return new Response(0);
                }
            }else{
                $request->getSession()->set('flag',20);
                return new Response(0);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response(0);
        }
    }

    private function sendEmail($name, $email, $password){
        $message = \Swift_Message::newInstance()
        ->setSubject('Pagescolar - Registrado Exitosamente')
        ->setFrom('contacto@pagescolar.cl')
        ->setTo($email)
        ->setBody(
            $this->renderView(
                'PAGEDemoBundle:Email:email_cuenta.html.twig',
                array('name'=> $name,'email'=>$email,'password'=>$password)
            ),'text/html'
        );
        $this->get('mailer')->send($message);
    }

}
