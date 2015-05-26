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
use PAGE\DemoBundle\Entity\DatosAlumnos;

/**
 * @Route("/profile")
 */
class StudentController extends Controller
{
/* Template */

    /**
     * @Route("/alumnos/new", name="alumno_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        if($this->getUser()->getRole() == 'ROLE_ALUMNO')
            $id = $this->getUser()->getId();
        
        return array(
            'flag'=>$flag,
            'image'=>false,
            'dataA'=>null,
            'listaS'=>$this->getListSexo(),
            'listaE'=>$this->getListEtnia(),
            'listaR'=>$this->getListRegion(),
            'listaP'=>$this->getListPais(),
            'curso'=>null,
        );
    }

    /**
     * @Route("/alumnos/{id}", defaults={"id" = -1}, name="alumnos")
     * @Method("GET")
     * @Template()
     */
    public function alumnosAction(Request $request,$id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return array(
            'flag'=>$flag,
            'dataA'=>$this->getAlumnos($this->getUser()->getParent(),$id),
            'dataC'=>$this->getCursos($this->getUser()->getParent()),
            'curso'=>$id,
        );
    }

    /**
     * @Route("/alumnos/perfil/{id}", name="alumno_perfil_show")
     * @Method("GET")
     * @Template()
     */
    public function perfilAction(Request $request, $id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        if($this->getUser()->getRole() == 'ROLE_ALUMNO')
            $id = $this->getUser()->getId();
        
        return array(
            'flag'=>$flag,
            'image'=>$this->getImage($id),
            'dataA'=>$this->getAlumno($id),
            'listaS'=>$this->getListSexo(),
            'listaE'=>$this->getListEtnia(),
            'listaR'=>$this->getListRegion(),
            'listaP'=>$this->getListPais(),
        );
    }

    /**
     * @Route("/alumnos/academico/{id}", name="alumno_academico_show")
     * @Method("GET")
     * @Template()
     */
    public function academicoAction(Request $request, $id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return array(
            'flag'=>$flag,
            'dataA'=>$this->getAlumno($id),
            'dataC'=>$this->getCursos($this->getUser()->getParent()),
            'listaD'=>$this->getListDocumentos(),
            'listaP'=>$this->getListProgramas(),
        );
    }

    /**
     * @Route("/alumnos/apoderados/{id}", name="alumno_apoderados_show")
     * @Method("GET")
     * @Template()
     */
    public function apoderadosAction(Request $request, $id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return array(
            'flag'=>$flag,
            'dataA'=>$this->getAlumno($id),
            'dataApo'=>$this->getApoderados($id)
        );

    }

    /**
     * @Route("/alumnos/necesidades/{id}", name="alumno_necesidades_show")
     * @Method("GET")
     * @Template()
     */
    public function necesidadesAction(Request $request, $id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return array(
            'flag'=>$flag,
            'dataA'=>$this->getAlumno($id),
            'listaB'=>$this->getListBasico(),
            'listaR'=>$this->getListReforzamiento(),
            'listaT'=>$this->getListTaller()
        );
    }

    /**
     * @Route("/alumnos/imagen/{id}", name="alumno_imagen_show")
     * @Method("GET")
     * @Template()
     */
    public function imagenAction(Request $request, $id){
        //Asignar el FLAG
        if(!$request->getSession()->get('flag'))
        {$request->getSession()->set('flag',-1);}

        $flag = $request->getSession()->get('flag');
        $request->getSession()->set('flag',-1);

        return array(
            'flag'=>$flag,
            'image'=>$this->getImage($id),
            'dataA'=>$this->getAlumno($id),
        );
    }

/* GET */

    private function getAlumnos($id_user,$id){
        $em = $this->getDoctrine()->getManager();
        if($id != -1)
            $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id_user,'curso'=>$id),array('curso'=>'ASC','plastname'=>'ASC'));
        else 
            $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id_user),array('curso'=>'ASC','plastname'=>'ASC'));
        return $data;
    }

    private function getAlumno($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->find($id);
        return $data;
    }

    private function getApoderados($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosApoderados')->findBy(array('id_user'=>$id));
        return $data;
    }

    private function getCursos($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')->findBy(array('id_user'=>$id));
        return $data;
    }

    private function getUsuario($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:User')->find($id);
        return $data;
    }

    private function getImage($id){
        $id_user = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
        if(file_exists('users/'.$id_user.'/images/'.$id))
            return true;
        return false;
    }

    private function getListSexo(){
        $load = new LoadController();
        return $load->sexoAction();
    }

    private function getListEtnia(){
        $load = new LoadController();
        return $load->etniaAction();
    }

    private function getListRegion(){
        $load = new LoadController();
        return $load->regionAction();
    }

    private function getListPais(){
        $load = new LoadController();
        return $load->paisAction();
    }

    private function getListDocumentos(){
        $load = new LoadController();
        return $load->documentosAction();
    }

    private function getListProgramas(){
        $load = new LoadController();
        return $load->programasAction();
    }

    private function getListBasico(){
        $load = new LoadController();
        return $load->basicoAction();
    }

    private function getListReforzamiento(){
        $load = new LoadController();
        return $load->reforzamientoAction();
    }

    private function getListTaller(){
        $load = new LoadController();
        return $load->tallerAction();
    }

/* POST */
    /**
     * @Route("/alumno/create",name="alumno_create")
     * @Method("POST")
     */
    public function createAlumno(Request $request)
    {
        try{
            $user = new DatosAlumnos();
            $id = $this->nuevoId();
            $id_user = $this->getUser()->getId();

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

            $user->setEtnia($request->get('etnia'));
            $user->setSalud($request->get('salud'));
            $user->setInteres($request->get('interes'));
            $user->setAntecedentes($request->get('antecedentes'));

            $user->setIngreso( date('Y'));//Año actual
            $user->setIsActive(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->set('flag',1);
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('alumno_perfil_show', array('id'=>$id)));
    }

    /**
     * @Route("/alumno/perfil/edit/{id}",name="alumno_perfil_edit")
     * @Method("POST")
     */
    public function editPerfil(Request $request, $id)
    {
        try{
            //$id = $request->query->get('id');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->find($id))
            {
                $user->setRut($request->get('rut'));
                $user->setName($request->get('name'));
                $user->setPlastname($request->get('plastname'));
                $user->setMlastname($request->get('mlastname'));

                if($data = $em->getRepository('PAGEDemoBundle:User')->find($id))
                {
                    $data->setUsername($request->get('name').' '.$request->get('plastname').' '.$request->get('mlastname'));
                    $data->setEmail($request->get('email'));
                }

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

                $user->setTelefono($request->get('telefono'));
                $user->setEmail($request->get('email'));

                $user->setEtnia($request->get('etnia'));
                $user->setPais($request->get('pais'));
                $user->setSalud($request->get('salud'));
                $user->setInteres($request->get('interes'));
                $user->setAntecedentes($request->get('antecedentes'));

                $em->flush();
                $request->getSession()->set('flag',1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('alumno_perfil_show', array('id'=>$id)));
    }

    /**
     * @Route("/alumno/academico/edit/{id}",name="alumno_academico_edit")
     * @Method("POST")
     */
    public function editAcademico(Request $request, $id)
    {
        try{
            //$id = $request->query->get('id');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->find($id))
            {
                $user->setCurso($request->get('curso'));
                $user->setProcedencia($request->get('procedencia'));
                if(!is_null($request->get('ingreso')))
                    $user->setIngreso( $request->get('ingreso'));//Año actual
                else $user->setIngreso( date('Y'));//Año actual

                
                if(! is_null($request->get('programa'))){
                    $cadena = '';
                    $programas = array("p1","p2","p3","p4");
                    foreach ($request->get('programa') as $value) {
                        $cadena .=$programas[intval($value)-1];
                    }
                    $user->setProgramas($cadena);
                }else{
                    $user->setProgramas('');
                }

                if(! is_null($request->get('documento'))){
                    $cadena = '';
                    $documento = array("d1","d2","d3","d4","d5");
                    foreach ($request->get('documento') as $value) {
                        $cadena .=$documento[intval($value)-1];
                    }
                    $user->setDocumentacion($cadena);
                }else{
                    $user->setDocumentacion('');
                }

                $em->flush();
                $request->getSession()->set('flag',1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('alumno_academico_show', array('id'=>$id)));
    }

    /**
     * @Route("/alumno/necesidades/edit/{id}",name="alumno_necesidades_edit")
     * @Method("POST")
     */
    public function editNecesidades(Request $request, $id)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->find($id))
            {
                $user->setNotra($request->get('otra'));


                if(! is_null($request->get('basica'))){
                    $cadena = '';
                    $lista = array("b1","b2","b3","b4","b5","b6","b7");
                    foreach ($request->get('basica') as $value) {
                        $cadena .=$lista[intval($value)-1];
                    }
                    $user->setNbasica($cadena);
                }else{
                    $user->setNbasica('');
                }

                if(! is_null($request->get('reforzamiento'))){
                    $cadena = '';
                    $lista = array("r1","r2","r3","r4","r5","r6");
                    foreach ($request->get('reforzamiento') as $value) {
                        $cadena .=$lista[intval($value)-1];
                    }
                    $user->setNreforzamiento($cadena);
                }else{
                    $user->setNreforzamiento('');
                }

                if(! is_null($request->get('taller'))){
                    $cadena = '';
                    $lista = array("t1","t2","t3","t4","t5","t6","t7");
                    foreach ($request->get('taller') as $value) {
                        $cadena .=$lista[intval($value)-1];
                    }
                    $user->setNtaller($cadena);
                }else{
                    $user->setNtaller('');
                }

                $em->flush();
                $request->getSession()->set('flag',1);
            }
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
        }
        return new RedirectResponse($this->generateUrl('alumno_necesidades_show', array('id'=>$id)));
    }

    /**
     * @Route("/alumno/delete")
     * @Method("POST")
     */
    public function deleteAlumno(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        try{
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->find($id)){

                if($item = $em->getRepository('PAGEDemoBundle:DatosApoderados')->findBy(array('id_user' => $id))){
                    foreach ($item as $value) {
                        $em->remove($value);
                        $em->flush();
                    }
                }
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
     * @Route("/apoderado/create")
     * @Method("POST")
     */
    public function createApoderado(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        try{
            $user = new DatosApoderados();
            $id = $this->nuevoIdApoderado();//id del apoderado
            $id_user = $request->get('id');//id del alumno

            $user->setId($id);
            $user->setIdUser($id_user);

            $user->setParentesco($request->get('parentesco'));
            $user->setRut($request->get('rut'));
            $user->setName($request->get('name'));
            $user->setLastname($request->get('lastname'));

            $user->setAddress($request->get('address'));
            $user->setRegion($request->get('region'));
            $user->setComuna($request->get('comuna'));

            $user->setTelefono($request->get('telefono'));
            $user->setEmail($request->get('email'));

            $user->setNivel($request->get('nivel'));
            $user->setConvive($request->get('convive'));
            $user->setEscolaridad($request->get('escolaridad'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->set('flag',1);
            return new Response(1);
            //return new RedirectResponse($this->generateUrl('_docencia_docente', array('id'=>$id)));
        }catch(Exception $e){
            $request->getSession()->set('flag',0);
            return new Response(0);
        }
    }

    /**
     * @Route("/apoderado/edit")
     * @Method("POST")
     */
    public function editApoderado(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        
        try{
            $id = $request->get('id');//id del apoderado
            $em = $this->getDoctrine()->getManager();
            
            if($user = $em->getRepository('PAGEDemoBundle:DatosApoderados')->find($id)){
                $user->setParentesco($request->get('parentesco'));
                $user->setRut($request->get('rut'));
                $user->setName($request->get('name'));
                $user->setLastname($request->get('lastname'));

                $user->setAddress($request->get('address'));
                $user->setRegion($request->get('region'));
                $user->setComuna($request->get('comuna'));

                $user->setTelefono($request->get('telefono'));
                $user->setEmail($request->get('email'));

                $user->setNivel($request->get('nivel'));
                $user->setConvive($request->get('convive'));
                $user->setEscolaridad($request->get('escolaridad'));    

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
     * @Route("/apoderado/delete")
     * @Method("POST")
     */
    public function deleteApoderado(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        try{
            $id = $request->get('id');//id del apoderado
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosApoderados')->find($id)){
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
    * @Route("/alumno/imagen/edit/{id}", name="alumno_imagen_edit")
    */
    public function editImagenAction(Request $request, $id)
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
        return $this->redirect($this->generateUrl('alumno_imagen_show',array('id'=>$id)));
    }

    /**
    * @Route("/alumno/imagen/delete/{id}", name="alumno_imagen_delete")
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
        return $this->redirect($this->generateUrl('alumno_imagen_show',array('id' => $id )));
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
    private function nuevoIdApoderado()
    {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $id = '';
        for($i=0; $i<15; $i++){
            $id .= $caracteres[rand(0, strlen($caracteres)-1)];
        }
        $em = $this->getDoctrine()->getManager();

        $apoderado = $em->getRepository('PAGEDemoBundle:DatosApoderados')->find($id);

        if ($apoderado){
           $exit = true;
           while($exit){
                $id = '';
                for($i=0; $i<15; $i++){
                    $id .= $caracteres[rand(0, strlen($caracteres)-1)];
                }
                $em = $this->getDoctrine()->getManager();
                $apoderado = $em->getRepository('PAGEDemoBundle:DatosApoderados')->find($id);

                if (!$apoderado)
                    $exit = false;
           }
        }
        return $id;
    }
}