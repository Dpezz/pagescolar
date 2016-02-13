<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PAGE\DemoBundle\Entity\InInstitution;
use PAGE\DemoBundle\Form\InInstitutionType;

/**
 * InInstitution controller.
 *
 * @Route("/profile/ininstitution")
 */
class InInstitutionController extends Controller
{

    /**
     * Lists all InInstitution entities.
     *
     * @Route("/", name="ininstitution")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PAGEDemoBundle:InInstitution')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new InInstitution entity.
     *
     * @Route("/", name="ininstitution_create")
     * @Method("POST")
     * @Template("PAGEDemoBundle:InInstitution:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new InInstitution();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ininstitution_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a InInstitution entity.
     *
     * @param InInstitution $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(InInstitution $entity)
    {
        $form = $this->createForm(new InInstitutionType(), $entity, array(
            'action' => $this->generateUrl('ininstitution_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new InInstitution entity.
     *
     * @Route("/new", name="ininstitution_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new InInstitution();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a InInstitution entity.
     *
     * @Route("/{id}", name="ininstitution_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:InInstitution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InInstitution entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing InInstitution entity.
     *
     * @Route("/{id}/edit", name="ininstitution_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:InInstitution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InInstitution entity.');
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
    * Creates a form to edit a InInstitution entity.
    *
    * @param InInstitution $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(InInstitution $entity)
    {
        $form = $this->createForm(new InInstitutionType(), $entity, array(
            'action' => $this->generateUrl('ininstitution_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing InInstitution entity.
     *
     * @Route("/{id}", name="ininstitution_update")
     * @Method("PUT")
     * @Template("PAGEDemoBundle:InInstitution:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:InInstitution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InInstitution entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ininstitution_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a InInstitution entity.
     *
     * @Route("/{id}", name="ininstitution_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PAGEDemoBundle:InInstitution')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find InInstitution entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ininstitution'));
    }

    /**
     * Creates a form to delete a InInstitution entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ininstitution_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
