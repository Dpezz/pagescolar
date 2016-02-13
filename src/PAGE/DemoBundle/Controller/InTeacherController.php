<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PAGE\DemoBundle\Entity\InTeacher;
use PAGE\DemoBundle\Form\InTeacherType;

/**
 * InTeacher controller.
 *
 * @Route("/profile/inteacher")
 */
class InTeacherController extends Controller
{

    /**
     * Lists all InTeacher entities.
     *
     * @Route("/", name="inteacher")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PAGEDemoBundle:InTeacher')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new InTeacher entity.
     *
     * @Route("/", name="inteacher_create")
     * @Method("POST")
     * @Template("PAGEDemoBundle:InTeacher:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new InTeacher();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inteacher_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a InTeacher entity.
     *
     * @param InTeacher $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(InTeacher $entity)
    {
        $form = $this->createForm(new InTeacherType(), $entity, array(
            'action' => $this->generateUrl('inteacher_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new InTeacher entity.
     *
     * @Route("/new", name="inteacher_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new InTeacher();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a InTeacher entity.
     *
     * @Route("/{id}", name="inteacher_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:InTeacher')->findOneBy(array('teacher_id'=>$id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InTeacher entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing InTeacher entity.
     *
     * @Route("/{id}/edit", name="inteacher_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:InTeacher')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InTeacher entity.');
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
    * Creates a form to edit a InTeacher entity.
    *
    * @param InTeacher $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(InTeacher $entity)
    {
        $form = $this->createForm(new InTeacherType(), $entity, array(
            'action' => $this->generateUrl('inteacher_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing InTeacher entity.
     *
     * @Route("/{id}", name="inteacher_update")
     * @Method("PUT")
     * @Template("PAGEDemoBundle:InTeacher:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:InTeacher')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InTeacher entity/ update.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('inteacher_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a InTeacher entity.
     *
     * @Route("/{id}", name="inteacher_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PAGEDemoBundle:InTeacher')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find InTeacher entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('inteacher'));
    }

    /**
     * Creates a form to delete a InTeacher entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('inteacher_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
