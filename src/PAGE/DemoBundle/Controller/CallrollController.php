<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PAGE\DemoBundle\Entity\CallRoll;
use PAGE\DemoBundle\Form\CallRollType;

/**
 * CallRoll controller.
 *
 * @Route("/profile/callroll")
 */
class CallRollController extends Controller
{
<<<<<<< HEAD

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

=======

    /**
     * Lists all CallRoll entities.
     *
     * @Route("/", name="callroll")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PAGEDemoBundle:CallRoll')->findAll();

        return array(
            'entities' => $entities,
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2
        );
    }
    /**
<<<<<<< HEAD
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

=======
     * Creates a new CallRoll entity.
     *
     * @Route("/", name="callroll_create")
     * @Method("POST")
     * @Template("PAGEDemoBundle:CallRoll:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CallRoll();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('callroll_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CallRoll entity.
     *
     * @param CallRoll $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CallRoll $entity)
    {
        $form = $this->createForm(new CallRollType(), $entity, array(
            'action' => $this->generateUrl('callroll_create'),
            'method' => 'POST',
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CallRoll entity.
     *
     * @Route("/new", name="callroll_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CallRoll();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CallRoll entity.
     *
     * @Route("/{id}", name="callroll_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

<<<<<<< HEAD
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
=======
        $entity = $em->getRepository('PAGEDemoBundle:CallRoll')->find($id);
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CallRoll entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CallRoll entity.
     *
     * @Route("/{id}/edit", name="callroll_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:CallRoll')->find($id);

<<<<<<< HEAD
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
=======
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CallRoll entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a CallRoll entity.
    *
    * @param CallRoll $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CallRoll $entity)
    {
        $form = $this->createForm(new CallRollType(), $entity, array(
            'action' => $this->generateUrl('callroll_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2

        $form->add('submit', 'submit', array('label' => 'Update'));

<<<<<<< HEAD
    private function newJsonAsistencia($id,$id_user){

=======
        return $form;
    }
    /**
     * Edits an existing CallRoll entity.
     *
     * @Route("/{id}", name="callroll_update")
     * @Method("PUT")
     * @Template("PAGEDemoBundle:CallRoll:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:CallRoll')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CallRoll entity.');
        }

<<<<<<< HEAD
    private function jsonAsistenciaFecha($id,$id_user,$fecha){

        $file = file_get_contents("users/".$id_user."/callroll/".$id.".json");
        $json = json_decode($file,true);
=======
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('callroll_edit', array('id' => $id)));
        }

<<<<<<< HEAD
    private function jsonAsistenciaFechaExist($id,$id_user,$fecha){

        $file = file_get_contents("users/".$id_user."/callroll/".$id.".json");
        $json = json_decode($file,true);
=======
        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CallRoll entity.
     *
     * @Route("/{id}", name="callroll_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PAGEDemoBundle:CallRoll')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CallRoll entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

<<<<<<< HEAD
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
=======
        return $this->redirect($this->generateUrl('callroll'));
    }

    /**
     * Creates a form to delete a CallRoll entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('callroll_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2
    }
}
