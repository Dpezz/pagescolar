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
        );
    }
    /**
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

        $entity = $em->getRepository('PAGEDemoBundle:CallRoll')->find($id);

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

        $form->add('submit', 'submit', array('label' => 'Update'));

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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:CallRoll')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CallRoll entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('callroll_edit', array('id' => $id)));
        }

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

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PAGEDemoBundle:CallRoll')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CallRoll entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

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
    }
}
