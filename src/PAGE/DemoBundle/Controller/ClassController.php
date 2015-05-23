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

use PAGE\DemoBundle\Entity\DatosAsignaturas;
use PAGE\DemoBundle\Controller\GetController;
use PAGE\DemoBundle\Controller\LoadController;


/**
 * @Route("/profile/asignaturas")
 */
class ClassController extends Controller
{
    
/* Template */

    /**
     * @Route("/", name="asignaturas")
     * @Method("GET")
     * @Template()
     */
    public function asignaturasAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return array(
            'flag'=>$flag,
            'dataA'=> $this->getAsignaturas($this->getUser()->getParent())
        );
    }

    
/* GET */
    public function getAsignaturas($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->findBy(array('id_user'=>$id),array('name'=>'ASC'));
        return $data;
    }


/* POST ASIGNATURA */

    /**
     * @Route("/create")
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
     * @Route("/edit")
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
     * @Route("/delete")
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
}