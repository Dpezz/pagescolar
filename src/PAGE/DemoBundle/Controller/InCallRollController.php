<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PAGE\DemoBundle\Entity\InCallRoll;
use PAGE\DemoBundle\Form\InCallRollType;

/**
 * InCallRoll controller.
 *
 * @Route("/profile/incallroll")
 */
class InCallRollController extends Controller
{

    /**
     * Lists all InCallRoll entities.
     *
     * @Route("/", name="incallroll")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PAGEDemoBundle:InCallRoll')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new InCallRoll entity.
     *
     * @Route("/", name="incallroll_create")
     * @Method("POST")
     * @Template("PAGEDemoBundle:InCallRoll:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new InCallRoll();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('incallroll_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a InCallRoll entity.
     *
     * @param InCallRoll $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(InCallRoll $entity)
    {
        $form = $this->createForm(new InCallRollType(), $entity, array(
            'action' => $this->generateUrl('incallroll_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new InCallRoll entity.
     *
     * @Route("/new", name="incallroll_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new InCallRoll();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a InCallRoll entity.
     *
     * @Route("/{id}", name="incallroll_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:InCallRoll')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InCallRoll entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing InCallRoll entity.
     *
     * @Route("/{id}/edit", name="incallroll_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:InCallRoll')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InCallRoll entity.');
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
    * Creates a form to edit a InCallRoll entity.
    *
    * @param InCallRoll $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(InCallRoll $entity)
    {
        $form = $this->createForm(new InCallRollType(), $entity, array(
            'action' => $this->generateUrl('incallroll_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing InCallRoll entity.
     *
     * @Route("/{id}", name="incallroll_update")
     * @Method("PUT")
     * @Template("PAGEDemoBundle:InCallRoll:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:InCallRoll')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InCallRoll entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('incallroll_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a InCallRoll entity.
     *
     * @Route("/{id}", name="incallroll_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PAGEDemoBundle:InCallRoll')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find InCallRoll entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('incallroll'));
    }

    /**
     * Creates a form to delete a InCallRoll entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('incallroll_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
