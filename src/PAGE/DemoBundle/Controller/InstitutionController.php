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

/**
 * @Route("/profile/institucion")
 */
class InstitutionController extends Controller
{

/* Template */
    /**
     * @Route("/perfil", name="institucion_perfil")
     * @Method("GET")
     * @Template()
     */
    public function perfilAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return array(
            'flag'=>$flag,
            'dataI'=>$this->getInstitucion($this->getUser()->getId()),
            'image'=>$this->getImage($this->getUser()->getId()),
        );
    }

    /**
     * @Route("/unidad", name="institucion_unidad")
     * @Method("GET")
     * @Template()
     */
    public function unidadAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return array(
            'flag'=>$flag,
            'dataI'=>$this->getInstitucion($this->getUser()->getId()),
            'listaJ' => $this->getListJornada(),
            'listaM' => $this->getListModalidad(),
            'listaR' => $this->getListRegimen()
        );
    }

    /**
     * @Route("/imagen", name="institucion_imagen")
     * @Method("GET")
     * @Template()
     */
    public function imagenAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return array(
            'flag'=>$flag,
            'image'=>$this->getImage($this->getUser()->getId()),
            'dataI'=>$this->getInstitucion($this->getUser()->getId()),
        );
    }


/* GET */

    private function getInstitucion($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosInstitucion')->find($id);
        return $data;
    }

    private function getImage($id){
        $id_user = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
        if(file_exists('users/'.$id_user.'/images/'.$id))
            return true;
        return false;
    }

    private function getListJornada(){
        $load = new LoadController();
        return $load->jornadaAction();
    }

    private function getListModalidad(){
        $load = new LoadController();
        return $load->modalidadAction();
    }

    private function getListRegimen(){
        $load = new LoadController();
        return $load->regimenAction();
    }


/* POST */
    /**
     * @Route("/perfil/edit",name="institucion_edit")
     * @Method("POST")
     */
    public function editInstitucionPerfil(Request $request){
        try{
            $id = $this->getUser() -> getId();
            $em = $this->getDoctrine()->getManager();
            if($dInstitucion = $em->getRepository('PAGEDemoBundle:DatosInstitucion')->find($id))
            {
                $dInstitucion->setRbd($request->get("rbd"));
                $dInstitucion->setRut($request->get("rut"));
                $dInstitucion->setAddress($request->get("address"));
                $dInstitucion->setFax($request->get("fax"));
                $dInstitucion->setRep($request->get("rep"));
                $em->flush();
                $request->getSession()->set('flag',1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('institucion_perfil'));
    }

    /**
     * @Route("/unidad/edit", name="unidad_edit")
     * @Method("POST")
     */
    public function editInstitucionUnidad(Request $request){
        try{
            $id = $this->getUser()->getId();
            $em = $this->getDoctrine()->getManager();
            if($dInstitucion = $em->getRepository('PAGEDemoBundle:DatosInstitucion')->find($id))
            {
                $dInstitucion->setJornada($request->get("jornada"));
                $dInstitucion->setModalidad($request->get("modalidad"));
                $dInstitucion->setRegimen($request->get("regimen"));

                //Agregar fecha
                if( !empty($request->get('finicio'))){
                    $fecha = str_replace('/', '-', $request->get('finicio'));
                    $fecha = new \DateTime($fecha);
                    $dInstitucion->setFechaInicio($fecha);
                }

                //Agregar fecha
                if( !empty($request->get('ffin'))){
                    $fecha = str_replace('/', '-', $request->get('ffin'));
                    $fecha = new \DateTime($fecha);
                    $dInstitucion->setFechaFin($fecha);
                }
                $em->flush();
                $request->getSession()->set('flag',1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('institucion_unidad'));
    }

    /**
    * @Route("/imagen/edit", name="institucion_imagen_edit")
    */
    public function editImagenAction(Request $request){
        $id = $this->getUser()->getId();
        try{
            $id_user = $this->getUser()->getParent();
            $file = $request->files->get('file');

            if (($file instanceof UploadedFile) && ($file->getError() == '0')) {

                if (($file->getSize() < 200000000)) {
                    $name = $file->getClientOriginalName();
                    $ext = $file->guessExtension();
                    $type = $file->getMimeType();
                    $size = $file->getClientSize();

                    $valid_filetypes = array('jpg', 'jpeg','png');
                    if (in_array($ext, $valid_filetypes)) {

                        if($file->isValid()){

                            $upload = $file->move('users/'.$id_user.'/images/',$id);
                            $request->getSession()->set('flag',1);
                            //update BD USER
                            $em = $this->getDoctrine()->getManager();
                            if($user = $em->getRepository('PAGEDemoBundle:User')->find($id)){
                                $user ->setUrl($id);
                                $em->flush();
                                $request->getSession()->set('flag',1);
                            }
                        }
                    } else {
                        //type no corresponde
                        $request->getSession()->set('flag',0);
                    }
                } else {
                    //Size muy grande
                    $request->getSession()->set('flag',0);
                }
            } else {
                //Error de file error (0)
                 $request->getSession()->set('flag',0);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return $this->redirect($this->generateUrl('institucion_imagen',array('id'=>$id)));
    }

    /**
    * @Route("/imagen/delete", name="institucion_imagen_delete")
    */
    public function deleteImagen(Request $request){
        try{
            $id = $this->getUser()->getId();
            $id_user = $this->getUser()->getParent();

            $url = 'users/'.$id_user.'/images/'.$id;

            if (file_exists($url))
            {
                unlink($url);
                $em = $this->getDoctrine()->getManager();
                if($user = $em->getRepository('PAGEDemoBundle:User')->find($id))
                    $user ->setUrl(null);
                    $em->flush();
            }
            $request->getSession()->set('flag',1);
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return $this->redirect($this->generateUrl('institucion_imagen',array('id' => $id )));
    }
}