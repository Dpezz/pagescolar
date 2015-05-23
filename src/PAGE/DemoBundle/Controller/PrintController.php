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

use PAGE\DemoBundle\Entity\User;
use PAGE\DemoBundle\Entity\DatosInstitucion;
use PAGE\DemoBundle\Entity\DatosAsignaturas;
use PAGE\DemoBundle\Entity\DatosCursos;
use PAGE\DemoBundle\Entity\DatosEvaluaciones;
use PAGE\DemoBundle\Entity\DatosDocentes;
use PAGE\DemoBundle\Entity\DatosAlumnos;


/**
 * @Route("/print")
 */
class PrintController extends Controller
{
    
/* Template */

    /**
     * @Route("/docentes", name="_print_docentes")
     * @Template()
     */
    public function docentesAction(Request $request){    

        return array();
    }

    /**
     * @Route("/get-docentes", name="_print_get_docentes")
     */
    public function printDocentes(Request $request){
  
        $pageUrl = $this->generateUrl('_print_docentes', array(), true);   

        return new Response(
            $this->get('knp_snappy.pdf')->getOutput($pageUrl, 
                array()),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="Estadisticas_Docentes.pdf"'
            )
        );
    }

   
}