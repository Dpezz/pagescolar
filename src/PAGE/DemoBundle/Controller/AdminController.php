<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/profile/admin")
 */
class AdminController extends Controller
{

/* Templates */

    /**
     * @Route("/", name="admin_index")
     * @Template()
     */
    public function superadminAction(Request $request){   
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        if($this->get('security.context')->isgranted('ROLE_SUPER_ADMIN'))
            return array('flag'=>$flag,'dataU'=>$this->getUsers());
        else 
            return $this->redirect($this->generateUrl('_demo_signin'));
    }

/* GET */

    public function getUsers(){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:User')->findBy(array('role'=>'ROLE_ADMIN'));
        return $data;
    }

/* POST */

    /**
     * @Route("/update")
     * @Method("POST")
     */
    public function updateAccount(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        try{
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:User')->find($id)){
                $user->setIsActive($request->get('activar'));
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
    public function deleteAccount(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        $exit = false;
        $id = $request->get('id');

        try{
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:User')->find($id)){
                $em->remove($user);
                $em->flush();
                $exit = true;
            }
        }catch(Exception $e){
            $exit= false;
        }
        
        if($exit){
            //eliminar folder
            //eliminar BD tablas
            if($this->deleteDB($id)){
                $request->getSession()->set('flag',1);
                return new Response(1);
            }else{
                $request->getSession()->set('flag',0);
                return new Response(0);
            }
        }
    }

/* funciones */
    private function deleteDB($id){
        try{
            $em = $this->getDoctrine()->getManager();
            
            //delete Institucion
            if($user = $em->getRepository('PAGEDemoBundle:DatosInstitucion')->find($id)){
                $em->remove($user);
            }

            //delete Docentes
            if($user = $em->getRepository('PAGEDemoBundle:DatosDocentes')->findBy(array('id_user'=>$id))){
                foreach ($user as $key => $value) {
                   $em->remove($value);
                }
            }

            //delete Alumnos
            if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id))){
                //delete Apoderados
                foreach ($user as $key => $value) {
                    if($apoderado = $em->getRepository('PAGEDemoBundle:DatosApoderados')->findBy(array('id_user'=>$value->getId()))){
                        foreach ($apoderado as $index => $item) {
                            $em->remove($item);
                        }
                    }
                    $em->remove($value);
                }
            }

            //delete Cursos
            if($user = $em->getRepository('PAGEDemoBundle:DatosCursos')->findBy(array('id_user'=>$id))){
                foreach ($user as $key => $value) {
                   $em->remove($value);
                }
            }

             //delete Asignaturas
            if($user = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->findBy(array('id_user'=>$id))){
                foreach ($user as $key => $value) {
                   $em->remove($value);
                }
            }

            //delete Evaluaciones
            if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(array('id_user'=>$id))){
                foreach ($user as $key => $value) {
                   $em->remove($value);
                }
            }

            //delete Calendario Docentes
            if($user = $em->getRepository('PAGEDemoBundle:DatosCalendarioDocentes')->findBy(array('id_user'=>$id))){
                foreach ($user as $key => $value) {
                   $em->remove($value);
                }
            }

            $url = "users/".$id;

            if(is_dir($url)){
                foreach(scandir($url) as $value){
                    if(is_dir($url.'/'.$value) && strpos($value,'.')===false){
                        foreach (scandir($url.'/'.$value) as $item) {
                            if(is_file($url.'/'.$value.'/'.$item))
                                unlink($url.'/'.$value.'/'.$item);
                        }
                        rmdir($url.'/'.$value);
                    }
                }
                rmdir($url);
                $em->flush();
            }

            return true;
        }catch(Exception $e){
            return false;
        }
        return false;
    }
}
