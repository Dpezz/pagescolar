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
use PAGE\DemoBundle\Entity\DatosDocentes;

/**
 * @Route("/profile")
 */
class TeacherController extends Controller
{
/* Template */

    /**
     * @Route("/docentes/new", name="docente_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request)
    {
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
            $request->getSession()->set('flag',-1);

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $load = new LoadController();
        
        return array(
            'flag'=>$flag,
            'image'=>false,
            'dataD'=>null,
            'listaS'=>$load->SexoAction(),
            'listaR'=>$load->regionAction(),
            'listaP'=>$load->paisAction()
        );
    }
    
    /**
     * @Route("/docentes/{id}", defaults={"id" = -1}, name="docentes")
     * @Method("GET")
     * @Template()
     */
    public function docentesAction(Request $request,$id)
    {
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
            $request->getSession()->set('flag',-1);

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return array(
            'flag'=>$flag,
            'dataD'=>$this->getDocentes($this->getUser()->getParent()),
            'dataA'=>$this->getAsignaturas($this->getUser()->getParent()),
            'name_curso'=>'',
            'curso'=>null,
        );
    }

    /**
     * @Route("/docentes/curso/{id}", defaults={"id" = -1}, name="docentes_curso")
     * @Method("GET")
     * @Template()
     */
    public function docentesCursoAction(Request $request,$id)
    {
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
            $request->getSession()->set('flag',-1);

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return $this->render('PAGEDemoBundle:Teacher:docentes.html.twig', array(
            'flag'=>$flag,
            'dataD'=>$this->getDocentesCurso($this->getUser()->getParent(),$id),
            'dataA'=>$this->getAsignaturas($this->getUser()->getParent()),
            'name_curso'=>$this->getNameCurso($this->getUser()->getParent(),$id),
            'curso'=>$id,
        ));
    }


    /**
     * @Route("/docentes/perfil/{id}", name="docente_perfil_show")
     * @Method("GET")
     * @Template()
     */
    public function perfilAction(Request $request, $id)
    {
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
            $request->getSession()->set('flag',-1);

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $load = new LoadController();

        if($this->getUser()->getRole() == 'ROLE_DOCENTE')
            $id = $this->getUser()->getId();

        return array(
            'flag'=>$flag,
            'image'=>$this->getImage($id),
            'dataD'=>$this->getDocente($id),
            'listaS'=>$load->sexoAction(),
            'listaR'=>$load->regionAction(),
            'listaP'=>$load->paisAction()
        );
    }

    /**
     * @Route("/docentes/academico/{id}", name="docente_academico_show")
     * @Method("GET")
     * @Template()
     */
    public function academicoAction(Request $request, $id)
    {
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
            $request->getSession()->set('flag',-1);

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        $load = new LoadController();

        if($this->getUser()->getRole() == 'ROLE_DOCENTE')
            $id = $this->getUser()->getId();

        return array(
            'flag'=>$flag,
            'dataD'=>$this->getDocente($id),
            'dataA'=>$this->getAsignaturas($this->getUser()->getParent()),
            'listaG'=>$load->grupoAction(),
            'listaN'=>$load->nivelAction(),
            'listaF'=>$load->funcionAction()
        );
    }

    /**
     * @Route("/docentes/imagen/{id}", name="docente_imagen_show")
     * @Method("GET")
     * @Template()
     */
    public function imagenAction(Request $request, $id)
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
            'image'=>$this->getImage($id),
            'dataD'=>$this->getDocente($id),
        );
    }

/* GET */

    public function getDocentes($id)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocentes')
        ->findBy(array('id_user'=>$id),array('plastname' => 'ASC'));
        return $data;
    }

    public function getDocente($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocentes')
        ->find($id);
        return $data;
    }

    public function getDocentesCurso($id_user,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->createQuery('SELECT  p
            FROM PAGEDemoBundle:DatosCalendarioDocentes u
            JOIN PAGEDemoBundle:DatosDocentes p
            WHERE u.id_user=:user and u.id_curso = :curso and p.id = u.id_docente')
        ->setParameter('user', $id_user)
        ->setParameter('curso', $id)
        ->getResult();
        return $data;
    }


    public function getAsignaturas($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')
        ->findBy(array('id_user'=>$id));
        return $data;
    }

    private function getImage($id){
        $id_user = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
        if(file_exists('users/'.$id_user.'/images/'.$id))
            return true;
        return false;
    }

    public function getNameCurso($id_user,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')
        ->findOneBy(array('id_user'=>$id_user,'id'=>$id));
        return $data;
    }


/* POST */
    /**
     * @Route("/docente/create",name="docente_create")
     * @Method("POST")
     */
    public function createDocente(Request $request)
    {
        try{
            $user = new DatosDocentes();
            $id_user = $this->getUser()->getId();
            $id = $this->nuevoId();

            $user->setId($id);
            $user->setIdUser($id_user);

            $user->setRut($request->get('rut'));
            $user->setName($request->get('name'));
            $user->setPlastname($request->get('plastname'));
            $user->setMlastname($request->get('mlastname'));

            //Agregar fecha
            if( !empty($request->get('fnacimiento'))){
                $fecha = str_replace('/', '-', $request->get('fnacimiento'));
                $fecha = new \DateTime($fecha);
                $user->setFechaNacimiento($fecha);
            }
            
            $user->setSexo($request->get('sexo'));
            $user->setAddress($request->get('address'));
            $user->setRegion($request->get('region'));
            $user->setComuna($request->get('comuna'));
            $user->setPais($request->get('pais'));

            $user->setTelefono($request->get('telefono'));
            $user->setEmail($request->get('email'));

            $user->setIngreso( date('Y'));//Año actual

            $user->setIsActive(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->set('flag',1);
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse(
            $this->generateUrl('perfil_show', array('id'=>$id))
            );
    }

    /**
     * @Route("/docente/perfil/edit/{id}",name="docente_perfil_edit")
     * @Method("POST")
     */
    public function editDocente(Request $request, $id)
    {
        try{
            //$id = $request->query->get('id');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosDocentes')->find($id))
            {
                $user->setRut($request->get('rut'));
                $user->setName($request->get('name'));
                $user->setPlastname($request->get('plastname'));
                $user->setMlastname($request->get('mlastname'));

                //Agregar fecha
                if( !empty($request->get('fnacimiento'))){
                    $fecha = str_replace('/', '-', $request->get('fnacimiento'));
                    $fecha = new \DateTime($fecha);
                    $user->setFechaNacimiento($fecha);
                }
                
                $user->setSexo($request->get('sexo'));
                $user->setAddress($request->get('address'));
                $user->setRegion($request->get('region'));
                $user->setComuna($request->get('comuna'));
                $user->setPais($request->get('pais'));

                $user->setTelefono($request->get('telefono'));
                $user->setEmail($request->get('email'));

                $em->flush();
                $request->getSession()->set('flag',1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('docente_perfil_show', array('id'=>$id)));
    }

    /**
     * @Route("/docente/academico/edit/{id}",name="docente_academico_edit")
     * @Method("POST")
     */
    public function editAcademico(Request $request, $id)
    {
        try{
            //$id = $request->query->get('id');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosDocentes')->find($id))
            {
                $user->setGrupo($request->get('grupo'));
                $user->setFuncion($request->get('funcion'));
                $user->setAsignatura($request->get('asignatura'));
                $user->setNivel($request->get('nivel'));
                $user->setTitulo($request->get('titulo'));
                $user->setIngreso($request->get('ingreso'));

                $em->flush();
                $request->getSession()->set('flag',1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('docente_academico_show', array('id'=>$id)));
    }

    /**
     * @Route("/docente/delete")
     * @Method("POST")
     */
    public function deleteDocente(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        try{
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosDocentes')->find($id))
            {
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
     * @Route("/docente/imagen/edit/{id}", name="docente_imagen_edit")
     * @Method("POST")
     */
    public function editImagenAction(Request $request,$id)
    {
        //$id = $request->get('id');
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
        return $this->redirect($this->generateUrl('docente_imagen_show',array('id'=>$id)));
    }

    /**
     * @Route("/docente/imagen/delete/{id}", name="docente_imagen_delete")
     */
    public function deleteImagen(Request $request, $id)
    {
        try{
            //$id = $request->query->get('id');
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
        return $this->redirect($this->generateUrl('docente_imagen_show',array('id' => $id )));
    }


/* Funciones */
    private function nuevoId()
    {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $id = '';
        for($i=0; $i<15; $i++){
            $id .= $caracteres[rand(0, strlen($caracteres)-1)];
        }
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('PAGEDemoBundle:User')->find($id);
        $docentes = $em->getRepository('PAGEDemoBundle:DatosDocentes')->find($id);
        $alumnos = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->find($id);

        if ($user || $docentes || $alumnos){
           $exit = true;
           while($exit){
                $id = '';
                for($i=0; $i<15; $i++){
                    $id .= $caracteres[rand(0, strlen($caracteres)-1)];
                }
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository('PAGEDemoBundle:User')->find($id);
                $docentes = $em->getRepository('PAGEDemoBundle:DatosDocentes')->find($id);
                $alumnos = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->find($id);

                if (!$user && !$docentes && !$alumnos)
                    $exit = false;
           }
        }
        return $id;
    }

}