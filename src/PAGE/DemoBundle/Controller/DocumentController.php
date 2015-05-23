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
use PAGE\DemoBundle\Entity\DatosDocumentos;
/**
 * @Route("/profile/documentos")
 */
class DocumentController extends Controller
{

/* Template */
   
    /**
     * @Route("/institucion", name="documentos_institucion")
     * @Method("GET")
     * @Template()
     */
    public function documentosAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $id = $this->getUser()->getParent();
        return array(
            'flag'=>$flag,
            'dataD'=>$this->getDocumentos($id),
            );
    }


    /**
     * @Route("/pie", name="documentos_pie")
     * @Method("GET")
     * @Template()
     */
    public function pieAction(Request $request){
        return array('folder'=>$this->getDirectory());
    }

/* GET */
    private function getDocumentos($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocumentos')->findBy(array('id_user'=>$id),array('title'=>'DESC'));
        return $data;
    }

    private function getDirectory(){
        $url = 'PIE';
        $directorios = array();
        if(is_dir($url)){
           
            foreach(scandir($url) as $value){
                if(is_dir($url.'/'.$value) && strpos($value,'.')===false){
                    $files = array();
                    foreach (scandir($url.'/'.$value) as $item) {
                        if(is_file($url.'/'.$value.'/'.$item))
                            $files[] = $item;
                    }
                    $directorios[] = array('folder'=>$value,'files'=>$files);
                }
            }
        } 
        return $directorios;
    }

/* POST */

    /**
     * @Route("/upload", name="institucion_upload")
     * @Method("POST")
     */
    public function uploadAction(Request $request){
        try{
            $id_user = $this->getUser()->getParent();
            $file = $request->files->get('file');

            if (($file instanceof UploadedFile) && ($file->getError() == '0'))
            {
                if ($file->getSize() < 2000000)
                {
                    $name = $file->getClientOriginalName();
                    $ext = $file->guessExtension();
                    $type = $file->getMimeType();
                    $size = $file->getClientSize();
                    $id = $this->nuevoIdFile();
                    $title = $request->get('title');

                    if($file->isValid()){
                        $upload = $file->move('users/'.$id_user.'/documents',$id.'.'.$ext);
                        $user = new DatosDocumentos();
                        $user->setId($id)
                        ->setIdUser($id_user)
                        ->setTitle($title)
                        ->setDescription($request->get('description'))
                        ->setType($type)
                        ->setExtension($ext)
                        ->setSize($size)
                        ->setCreateAt(new \DateTime('now'));
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($user);
                        $em->flush();
                        $request->getSession()->set('flag',1);
                    }else{
                        $request->getSession()->set('flag',0);
                    }
                }else{
                    $request->getSession()->set('flag',0);
                }
            } else {
                //Error de file error (0)
                 $request->getSession()->set('flag',0);
            }
        }catch(Exception $e){
           $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('documentos_institucion'));
    }

    /**
     * @Route("/download/{id}", name="institucion_download")
     * @Method("GET")
     */
    public function downloadAction(Request $request,$id){
        $id_user = $this->getUser()->getParent();

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('PAGEDemoBundle:DatosDocumentos')->findOneBy(array('id'=>$id,'id_user'=>$id_user));
            
            $path = $this->get('kernel')->getRootDir(). '/../web/users/'.$id_user.'/documents/'.$id.'.'.$user->getExtension();
            $path = preg_replace("/app..../i", "", $path);

            $content = file_get_contents($path,true);

            $response = new Response();

            $response->headers->set('Content-Type', 'application/'.$user->getType());
            $response->headers->set('Content-Disposition', 'attachment;filename='.$user->getTitle().'.'.$user->getExtension());

            $response->setContent($content);
            return $response;
    }

    /**
     * @Route("/edit")
     * @Method("POST")
     */
    public function editDocumento(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        try{
            $id = $request->get('id');
            $id_user = $this->getUser()->getParent();

            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosDocumentos')
                ->findOneBy(array('id'=>$id,'id_user'=>$id_user))){
                $user->setTitle($request->get('title'));
                $user->setDescription($request->get('description'));

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
    public function deleteDocumento(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        try{
            $id = $request->get('id');
            $id_user = $this->getUser()->getParent();
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosDocumentos')->findOneBy(array('id'=>$id,'id_user'=>$id_user))){
                $em->remove($user);
                $em->flush();
                unlink('users/'.$id_user.'/documents/'.$user->getId().'.'.$user->getExtension());

                $request->getSession()->set('flag',1);
                return new Response(1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response(0);
        }
    }

    /**
     * @Route("/download_pie", name="pie_download")
     * @Method("GET")
     */
    public function downloadPieAction(Request $request){
        $folder = $request->query->get('folder');
        $file = $request->query->get('file');
       
        $path = $this->get('kernel')->getRootDir(). '/../web/PIE/'.$folder.'/'.$file;
        $path = preg_replace("/app..../i", "", $path);

        $content = file_get_contents($path,true);

        $response = new Response();
        $ext = explode('.', $file);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment;filename='.$file);

        $response->setContent($content);
        return $response;
    }


/* FUNCIONES*/
    private function nuevoIdFile(){
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $id = '';
        for($i=0; $i<15; $i++){
            $id .= $caracteres[rand(0, strlen($caracteres)-1)];
        }
        $em = $this->getDoctrine()->getManager();

        $item = $em->getRepository('PAGEDemoBundle:DatosDocumentos')->find($id);

        if ($item){
           $exit = true;
           while($exit){
                $id = '';
                for($i=0; $i<15; $i++){
                    $id .= $caracteres[rand(0, strlen($caracteres)-1)];
                }
                $em = $this->getDoctrine()->getManager();
                $item = $em->getRepository('PAGEDemoBundle:DatosDocumentos')->find($id);

                if (!$item)
                    $exit = false;
           }
        }
        return $id;
    }
}
