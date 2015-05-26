<?php

namespace PAGE\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/profile/print")
 */
class PrintController extends Controller
{
    
/* Template */

    /**
     * @Route("/alumno/{id}", name="print_alumno")
     */
    public function alumnoAction(Request $request,$id){
        $data = $this->getAlumno($this->getUser()->getParent(),$id);

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $pdf = $this->render('PAGEDemoBundle:Print:alumno.pdf.twig',
        array('data'=>$data,'curso'=>$this->getNameCurso($this->getUser()->getParent(),$data->getCurso())),
        $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response(
            $content, 200, 
            array('content-type' => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="'.$data->getName().' '.$data->getPlastname().' '.$data->getMlastname().'.pdf"'));
    }

    /**
     * @Route("/alumnos/{id}", defaults={"id"=-1},name="print_alumnos")
     */
    public function alumnosAction(Request $request,$id){
        $id_user = $this->getUser()->getParent();
        $curso = $this->getNameCurso($id_user,$id);

        if($id == -1){
            $curso = '';
            $data = $this->getAlumnos($id_user);
        }
        else
            $data = $this->getAlumnosCurso($id_user,$id);

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $pdf = $this->render('PAGEDemoBundle:Print:alumnos.pdf.twig',
            array('data'=>$data,'curso'=>$curso), $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response(
            $content, 200, 
            array('content-type' => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="alumnos_'.$curso.'.pdf"'));
    }

    /**
     * @Route("/docente/{id}",name="print_docente")
     */
    public function docenteAction(Request $request,$id){
        $data = $this->getDocente($this->getUser()->getParent(),$id);

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $pdf = $this->render('PAGEDemoBundle:Print:docente.pdf.twig',
        array('data'=>$data,'asignatura'=>$this->getNameAsignatura($this->getUser()->getParent(),$data->getAsignatura())),
        $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response(
            $content, 200, 
            array('content-type' => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="'.$data->getName().' '.$data->getPlastname().' '.$data->getMlastname().'.pdf"'));
    }

    /**
     * @Route("/docentes/{id}", defaults={"id"=-1}, name="print_docentes")
     */
    public function docentesAction(Request $request,$id){
        $id_user = $this->getUser()->getParent();
        $curso = $this->getNameCurso($id_user,$id);

        if($id == -1){
            $curso = '';
            $data = $this->getDocentes($id_user);
        }
        else
            $data = $this->getDocentesCurso($id_user,$id);

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $pdf = $this->render('PAGEDemoBundle:Print:docentes.pdf.twig',
            array('data'=>$data,'curso'=>$curso), $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response(
            $content, 200, 
            array('content-type' => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="docentes_'.$curso.'.pdf"'));
    }

    /**
     * @Route("/institucion",name="print_institucion")
     */
    public function institucionAction(Request $request){
        $data = $this->getInstitucion($this->getUser()->getParent());
        $user = $this->getUsuario($this->getUser()->getParent());

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $pdf = $this->render('PAGEDemoBundle:Print:institucion.pdf.twig',
        array('data'=>$data,'user'=>$user), $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response(
            $content, 200, 
            array('content-type' => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="'.$user->getUsername().'.pdf"'));
    }

/* GET */
    
    private function getDocentes($id_user){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocentes')
        ->findBy(array('id_user'=>$id_user),array('plastname'=>'ASC'));
        return $data;
    }

    private function getDocentesCurso($id_user,$id){
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

    private function getDocente($id_user,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocentes')
        ->findOneBy(array('id_user'=>$id_user,'id'=>$id));
        return $data;
    }

    private function getAlumnos($id_user){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')
        ->findBy(array('id_user'=>$id_user),array('plastname'=>'ASC'));
        return $data;
    }

    private function getAlumnosCurso($id_user,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')
        ->findBy(array('id_user'=>$id_user,'curso'=>$id),array('plastname'=>'ASC'));
        return $data;
    }

    private function getAlumno($id_user,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')
        ->findOneBy(array('id_user'=>$id_user,'id'=>$id));
        return $data;
    }

    private function getInstitucion($id_user){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosInstitucion')
        ->findOneBy(array('id'=>$id_user));
        return $data;
    }

    private function getUsuario($id_user){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:User')
        ->findOneBy(array('id'=>$id_user));
        return $data;
    }

    private function getNameCurso($id_user,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')
        ->findOneBy(array('id_user'=>$id_user,'id'=>$id));
        return $data->getName().' '.$data->getIndice();
    }

    private function getNameAsignatura($id_user,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')
        ->findOneBy(array('id_user'=>$id_user,'id'=>$id));
        return $data->getName();
    }
   
}