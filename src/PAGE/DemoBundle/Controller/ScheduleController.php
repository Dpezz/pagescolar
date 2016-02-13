<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PAGE\DemoBundle\Entity\Schedule;
use PAGE\DemoBundle\Form\ScheduleType;

/**
 * Schedule controller.
 *
 * @Route("/profile/docentes")
 */
class ScheduleController extends Controller
{

    /**
     * Lists all Schedule entities.
     *
     * @Route("/{id_teacher}/schedule/", name="schedule")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($id_teacher)
    {
        $em = $this->getDoctrine()->getManager();
        $teacher = $em->getRepository('PAGEDemoBundle:Teacher')->find($id_teacher);
        $entities = $teacher->getSchedules();

        return array(
            'entities' => $entities, 'teacher'=> $teacher
        );
    }

    /**
     * Creates a new Schedule entity.
     *
     * @Route("/{id_teacher}/schedule/", name="schedule_create")
     * @Method("POST")
     * @Template("PAGEDemoBundle:Schedule:new.html.twig")
     */
    public function createAction(Request $request,$id_teacher)
    {
        $em = $this->getDoctrine()->getManager();
        $teacher = $em->getRepository('PAGEDemoBundle:Teacher')->find($id_teacher);

        $entity = new Schedule();
        $form = $this->createCreateForm($entity,$id_teacher);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('schedule', array('id_teacher' => $entity->getTeacher()->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'teacher' => $teacher,
        );
    }

    /**
     * Creates a form to create a Schedule entity.
     *
     * @param Schedule $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Schedule $entity, $id_teacher)
    {
        $form = $this->createForm(new ScheduleType(), $entity, array(
            'action' => $this->generateUrl('schedule_create',array('id_teacher'=>$id_teacher)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Schedule entity.
     *
     * @Route("/{id_teacher}/schedule/new", name="schedule_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id_teacher)
    {
        $em = $this->getDoctrine()->getManager();
        $teacher = $em->getRepository('PAGEDemoBundle:Teacher')->find($id_teacher);

        $entity = new Schedule();
        $form   = $this->createCreateForm($entity, $id_teacher);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'teacher' => $teacher,
        );
    }

    /**
     * Finds and displays a Schedule entity.
     *
     * @Route("/{id_teacher}/schedule/{id}", name="schedule_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id_teacher, $id)
    {
        /*
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PAGEDemoBundle:Schedule')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Schedule entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        */

        return $this->redirect($this->generateUrl('schedule_edit',array('id_teacher'=>$id_teacher, 'id'=>$id)));
    }

    /**
     * Displays a form to edit an existing Schedule entity.
     *
     * @Route("/{id_teacher}/schedule/{id}/edit", name="schedule_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id_teacher, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PAGEDemoBundle:Schedule')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Schedule entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id_teacher, $id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Schedule entity.
    *
    * @param Schedule $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Schedule $entity)
    {
        $form = $this->createForm(new ScheduleType(), $entity, array(
            'action' => $this->generateUrl('schedule_update', array('id_teacher' => $entity->getTeacher()->getId(), 'id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Schedule entity.
     *
     * @Route("/{id_teacher}/schedule/{id}", name="schedule_update")
     * @Method("PUT")
     * @Template("PAGEDemoBundle:Schedule:edit.html.twig")
     */
    public function updateAction(Request $request, $id_teacher, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('PAGEDemoBundle:Schedule')->find($id); 

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Schedule entity.');
        }

        $deleteForm = $this->createDeleteForm($id_teacher, $id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('schedule_edit', array('id_teacher' => $id_teacher, 'id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Schedule entity.
     *
     * @Route("/{id_teacher}/schedule/{id}", name="schedule_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id_teacher, $id)
    {
        $form = $this->createDeleteForm($id_teacher, $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PAGEDemoBundle:Schedule')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Schedule entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('schedule',array('id_teacher'=>$id_teacher)));
    }

    /**
     * Creates a form to delete a Schedule entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id_teacher,$id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('schedule_delete', array('id_teacher' => $id_teacher, 'id' => $id )))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
