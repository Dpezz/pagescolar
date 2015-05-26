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
 * @Route("/print")
 */
class PrintController extends Controller
{
    
/* Template */

    /**
     * @Route("/alumno/{id}", name="print_alumno")
     */
    public function alumnoAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->find($id);

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $pdf = $this->render('PAGEDemoBundle:Print:alumno.pdf.twig', array('data'=>$data), $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response(
            $content, 200, 
            array('content-type' => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="'.$data->getName().'.pdf"'));
    }

    /**
     * @Route("/docente/{id}", name="print_docente")
     */
    public function docenteAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocentes')->find($id);

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $pdf = $this->render('PAGEDemoBundle:Print:docente.pdf.twig', array('data'=>$data), $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response(
            $content, 200, 
            array('content-type' => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="'.$data->getName().'.pdf"'));
    }

   
}