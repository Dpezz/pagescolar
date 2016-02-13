<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PAGE\DemoBundle\Entity\Level;
use PAGE\DemoBundle\Form\LevelType;

/**
 * Level controller.
 *
 * @Route("/profile/level")
 */
class LevelController extends Controller
{
<<<<<<< HEAD

/* Template */
=======
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2

    /**
     * Lists all Level entities.
     *
     * @Route("/", name="level")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $this->getUser()->getLevels();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Level entity.
     *
     * @Route("/", name="level_create")
     * @Method("POST")
     * @Template("PAGEDemoBundle:Level:new.html.twig")
     */
<<<<<<< HEAD
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
=======
    public function createAction(Request $request)
    {
        $entity = new Level();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$entity->setUser($this->getUser());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('level_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Level entity.
     *
     * @param Level $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
<<<<<<< HEAD
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
=======
    private function createCreateForm(Level $entity)
    {
        $form = $this->createForm(new LevelType(), $entity, array(
            'action' => $this->generateUrl('level_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2
    }

    /**
     * Displays a form to create a new Level entity.
     *
     * @Route("/new", name="level_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Level();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Level entity.
     *
     * @Route("/{id}", name="level_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:Level')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Level entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Level entity.
     *
     * @Route("/{id}/edit", name="level_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:Level')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Level entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

<<<<<<< HEAD
    private function newJsonAsistencia($id,$id_user){

=======
    /**
    * Creates a form to edit a Level entity.
    *
    * @param Level $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Level $entity)
    {
        $form = $this->createForm(new LevelType(), $entity, array(
            'action' => $this->generateUrl('level_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Level entity.
     *
     * @Route("/{id}", name="level_update")
     * @Method("PUT")
     * @Template("PAGEDemoBundle:Level:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:Level')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Level entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

<<<<<<< HEAD
        $fh = fopen("users/".$id_user."/callroll/".$id.".json", 'w');
        fwrite($fh, $json);
        fclose($fh);
=======
        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('level_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
>>>>>>> 2f06cc7cc7aeba5f53e0bf62a1d0b5f14af225f2
    }

    /**
     * Deletes a Level entity.
     *
     * @Route("/{id}", name="level_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PAGEDemoBundle:Level')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Level entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('level'));
    }

    /**
     * Creates a form to delete a Level entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('level_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
