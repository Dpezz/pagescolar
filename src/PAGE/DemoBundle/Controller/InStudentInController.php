<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PAGE\DemoBundle\Entity\InStudentIn;
use PAGE\DemoBundle\Form\InStudentInType;

/**
 * InStudentIn controller.
 *
 * @Route("/profile/instudentin")
 */
class InStudentInController extends Controller
{

    /**
     * Lists all InStudentIn entities.
     *
     * @Route("/", name="instudentin")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PAGEDemoBundle:InStudentIn')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new InStudentIn entity.
     *
     * @Route("/", name="instudentin_create")
     * @Method("POST")
     * @Template("PAGEDemoBundle:InStudentIn:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new InStudentIn();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('instudentin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a InStudentIn entity.
     *
     * @param InStudentIn $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(InStudentIn $entity)
    {
        $form = $this->createForm(new InStudentInType(), $entity, array(
            'action' => $this->generateUrl('instudentin_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new InStudentIn entity.
     *
     * @Route("/new", name="instudentin_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new InStudentIn();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a InStudentIn entity.
     *
     * @Route("/{id}", name="instudentin_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:InStudentIn')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InStudentIn entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing InStudentIn entity.
     *
     * @Route("/{id}/edit", name="instudentin_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:InStudentIn')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InStudentIn entity.');
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
    * Creates a form to edit a InStudentIn entity.
    *
    * @param InStudentIn $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(InStudentIn $entity)
    {
        $form = $this->createForm(new InStudentInType(), $entity, array(
            'action' => $this->generateUrl('instudentin_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing InStudentIn entity.
     *
     * @Route("/{id}", name="instudentin_update")
     * @Method("PUT")
     * @Template("PAGEDemoBundle:InStudentIn:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:InStudentIn')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InStudentIn entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('instudentin_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a InStudentIn entity.
     *
     * @Route("/{id}", name="instudentin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PAGEDemoBundle:InStudentIn')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find InStudentIn entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('instudentin'));
    }

    /**
     * Creates a form to delete a InStudentIn entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('instudentin_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
