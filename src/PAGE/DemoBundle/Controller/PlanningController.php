<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
 * @Route("/profile")
 */
class PlanningController extends Controller
{
/* Template */

    /**
     * @Route("/planificar/{id}", name="planificar")
     * @Method("GET")
     * @Template()
     */
    public function planificarAction(Request $request, $id)
    {
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
            $request->getSession()->set('flag',-1);

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        if($this->getUser()->getRole() == 'ROLE_DOCENTE')
            $id = $this->getUser()->getId();

        return array(
            'flag'=>$flag,
            'dataD'=>$this->getDocente($id),
        );
    }

    /**
     * @Route("/planificacion/{id}", name="planificacion")
     * @Method("GET")
     * @Template()
     */
    public function planificacionAction(Request $request, $id)
    {
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
            $request->getSession()->set('flag',-1);

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        if($this->getUser()->getRole() == 'ROLE_DOCENTE')
            $id = $this->getUser()->getId();

        return array(
            'flag'=>$flag,
            'dataD'=>$this->getDocente($id),
            'dataP'=>$this->getJsonPlanificacion($id,$this->getUser()->getParent()),
            'dataO'=>$this->getJsonObjetivos($id,$this->getUser()->getParent()),
        );
    }

/* GET */
    public function getDocente($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocentes')
        ->find($id);
        return $data;
    }

    public function getBaseCurricular(){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:BaseCurricular')->findAll();
        return $data;
    }

/* POST */

    /**
     * @Route("/planificar/edit/{id}",name="planificar_edit")
     * @Method("POST")
     */
    public function editPlanificar(Request $request, $id)
    {
        try{
            $cadena = '';
            foreach ($request->get('obj') as $value) {
                $cadena .=$value.'-';
            }
            //return new Response($cadena);
            $this->newJsonPlanificacion($id, $this->getUser()->getParent(),$request->get('obj'));
            $request->getSession()->set('flag',1);
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('planificar', array('id'=>$id)));
    }

    /**
     * @Route("/objetivo/edit")
     */
    public function editObjetivo(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        try{
            $id = $request->get('id');//id del objetivo
            $id_user = $request->get('id_user');//id de la institucion
            $id_docente = $request->get('id_docente');//id del docente
            $progress = $request->get('progress');
            $motivo = $request->get('motivo');
            $recurso = $request->get('recurso');
            
            $this->getEditJsonPlanificacion($id,$id_user,$id_docente,$progress,$motivo,$recurso);
            
            $request->getSession()->set('flag',1);
            return new Response(1);

        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response(0);
        }
    }

    /**
     * @Route("/objetivo/delete")
     */
    public function deleteObjetivo(Request $request){
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        try{
            $id = $request->get('id');//id del objetivo
            $id_user = $request->get('id_user');//id de la institucion
            $id_docente = $request->get('id_docente');//id del docente
            
            
            $this->deleteJsonObjetivo($id,$id_user,$id_docente);
            
            $request->getSession()->set('flag',1);
            return new Response(1);

        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response(0);
        }
    }


/* Funciones */
    private function newJsonPlanificacion($id,$id_user,$obj)
    {
        #create folder and file json
        if(!file_exists("users/".$id_user."/keys")){
            mkdir("users/".$id_user.'/keys',0755);
        }

        $url = "users/".$id_user."/planning/".$id.".json";
        $item = array();
        $em = $this->getDoctrine()->getManager();
        foreach ($obj as $key => $value) {
            if($user = $em->getRepository('PAGEDemoBundle:BaseCurricular')->find($value))
            {
               $item[] = array(
                'id'=>$user->getId(),
                'id_obj'=>$user->getIdObj(),
                'curso'=>$user->getCurso(),
                'asignatura'=>$user->getAsignatura(),
                'unidad'=>$user->getUnidad(),
                'objetivo'=>$user->getObjetivo(),
                'detalle'=>$user->getDetalle(),
                'progress'=>0,
                'motivo'=>'',
                'recurso'=>0
                ); 
            } 
        }
        if(!file_exists($url)){
            $json = json_encode(array('id'=>$id,'year'=>date('Y'),'objetivos'=>$item));
            $fh = fopen($url, 'w');
            fwrite($fh, $json);
            fclose($fh);
        }else{
            $file = file_get_contents($url);
            $json = json_decode($file,true);
            $objetivos = $json['objetivos'];
            $idObj = array();
            foreach ($objetivos as $key => $value) {
                $idObj[] = $value['id'];
            }
            foreach ($obj as $key => $value) {
                if(!in_array($value, $idObj)){
                    if($user = $em->getRepository('PAGEDemoBundle:BaseCurricular')->find($value))
                    {
                        $json['objetivos'][count($json['objetivos'])] = array(
                        'id'=>$user->getId(),
                        'id_obj'=>$user->getIdObj(),
                        'curso'=>$user->getCurso(),
                        'asignatura'=>$user->getAsignatura(),
                        'unidad'=>$user->getUnidad(),
                        'objetivo'=>$user->getObjetivo(),
                        'detalle'=>$user->getDetalle(),
                        'progress'=>0,
                        'motivo'=>'',
                        'recurso'=>0
                        ); 
                    }
                }
            }
            $json = json_encode($json,true);
            file_put_contents($url, $json);
        } 
    }

    private function getJsonPlanificacion($id,$id_user)
    {
        $url = "users/".$id_user."/planning/".$id.".json";

        if(file_exists($url)){
            $file = file_get_contents($url);
            $json = json_decode($file,true);

            $objetivos = $json['objetivos'];
            $item = array();
            foreach ($objetivos as $key => $value) {
                $item[] = $value['id'];   
            }
            
            $string_cursos = '';
            $string_asignaturas = '';
            $string_objetivos = '';
            $string_unidades = '';
            $obj = array();
            foreach ($item as $key => $value) {

                $em = $this->getDoctrine()->getManager();
                if($user = $em->getRepository('PAGEDemoBundle:BaseCurricular')->find($value))
                {
                    if(strpos($string_cursos, $user->getCurso()) === false){
                        $string_cursos .= $user->getCurso().';';
                    }

                    if(strpos($string_asignaturas, $user->getAsignatura())  === false){
                        $string_asignaturas .= $user->getAsignatura().';';
                    }

                    if(strpos($string_unidades, $user->getUnidad())  === false){
                        $string_unidades .= $user->getUnidad().';';
                    }

                    if(strpos($string_objetivos, $user->getObjetivo())  === false){
                        $string_objetivos .= $user->getObjetivo().';';
                    }

                    $obj[] = array('id'=>$user->getId(),'curso'=>$user->getCurso(),
                        'asignatura'=>$user->getAsignatura(),'unidad'=>$user->getUnidad(),
                        'objetivo'=>$user->getObjetivo());
                }
            }
            $string_cursos = rtrim($string_cursos,';');
            $string_asignaturas = rtrim($string_asignaturas,';');
            $string_unidades = rtrim($string_unidades,';');
            $string_objetivos = rtrim($string_objetivos,';');
        }
        return array(
            'cursos'=>explode(';',$string_cursos),
            'asignaturas'=>explode(';',$string_asignaturas),
            'unidades'=>explode(';', $string_unidades),
            'objetivos'=>explode(';', $string_objetivos),
            'items'=>$obj
        );
    }

    private function getJsonObjetivos($id,$id_user)
    {
        $url = "users/".$id_user."/planning/".$id.".json";

        if(file_exists($url)){
            $file = file_get_contents($url);
            $json = json_decode($file,true);

            $objetivos = $json['objetivos'];
            
            return $objetivos;
        }
        return null;
    }


    private function getEditJsonPlanificacion($id,$id_user,$id_docente,$progress,$motivo,$recurso)
    {
        $url = "users/".$id_user."/planning/".$id_docente.".json";
        
        if(file_exists($url)){
            $file = file_get_contents($url);
            $json = json_decode($file,true);

            foreach ($json['objetivos'] as $key => $value) {
                if($value['id'] == $id ){
                    $json['objetivos'][$key]['progress'] = $progress;
                    $json['objetivos'][$key]['motivo'] = $motivo;
                    $json['objetivos'][$key]['recurso'] = $recurso;
                }
            }

            $json = json_encode($json,true);
            file_put_contents($url, $json);
        } 
    }

    private function deleteJsonObjetivo($id,$id_user,$id_docente)
    {
        $url = "users/".$id_user."/planning/".$id_docente.".json";

        if(file_exists($url)){
            $file = file_get_contents($url);
            $json = json_decode($file,true);

            foreach($json['objetivos'] as $key => $value){
                if($value['id'] == $id ){
                    unset($json['objetivos'][$key]);
                }
            }
            $json = json_encode($json,true);
            file_put_contents($url, $json);
        }
    }
}