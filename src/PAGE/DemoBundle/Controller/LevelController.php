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

use PAGE\DemoBundle\Entity\DatosCursos;
use PAGE\DemoBundle\Controller\GetController;
use PAGE\DemoBundle\Controller\LoadController;

/**
 * @Route("/profile/cursos")
 */
class LevelController extends Controller
{
    
/* Template */

    /**
     * @Route("/", name="cursos")
     * @Method("GET")
     * @Template()
     */
    public function cursosAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return array(
            'flag'=>$flag,
            'dataC'=>$this->getCursos($this->getUser()->getParent())
        );
    }

/* GET */

    public function getCursos($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')->findBy(array('id_user'=>$id),array('name'=>'ASC'));
        return $data;
    }

/* POST CURSO */
    /**
     * @Route("/create")
     * @Method("POST")
     */
    public function createCurso(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        try{
            $user = new DatosCursos();
            $id = $this->nuevoIdCurso();//id de la Curso
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
     * @Route("/edit")
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
     * @Route("/delete")
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

/* FUNCIONES */
    private function nuevoIdCurso(){
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

    private function newJsonAsistencia($id,$id_user){
        
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')->find($id);

        $json = json_encode(array('id'=>$data->getId(),'year'=>date('Y'),'asistencia'=>array()));

        $fh = fopen("users/".$id_user."/pullroll/".$id.".json", 'w');
        fwrite($fh, $json);
        fclose($fh);
    }

    private function deleteJsonAsistencia($id){
        if(file_exists("users/".$this->getUser()->getParent()."/pullroll/".$id.".json")){
            unLink("users/".$this->getUser()->getParent()."/pullroll/".$id.".json");
        }
    }
}