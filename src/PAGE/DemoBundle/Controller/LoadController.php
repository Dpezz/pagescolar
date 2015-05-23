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
use PAGE\DemoBundle\Repository\Datos;

/**
 * @Route("/profile/load")
 */
class LoadController extends Controller
{
    /**
     * @Route("/pais", name="_load_pais")
     */
    public function paisAction()
    {
        $datos = new Datos();
        return $datos->getPais();
    }

	/**
     * @Route("/region", name="_load_region")
     */
    public function regionAction()
    {
        $datos = new Datos();
        return $datos->getRegiones();
    }

    /**
     * @Route("/comuna", name="_load_comuna")
     */
    public function comunaAction(Request $request)
    {
        $datos = new Datos();
        $region = $request->get('region');
        return new Response($datos->getComunas($region));
    }

    /**
     * @Route("/sexo", name="_load_sexo")
     */
    public function sexoAction()
    {
        $datos = new Datos();
        return $datos->getSexo();
    }

    /**
     * @Route("/jornada", name="_load_jornada")
     */
    public function jornadaAction()
    {
        $datos = new Datos();
        return $datos->getJornada();
    }

    /**
     * @Route("/modalidad", name="_load_modalidad")
     */
    public function modalidadAction()
    {
        $datos = new Datos();
        return $datos->getModalidad();
    }

    /**
     * @Route("/regimen", name="_load_regimen")
     */
    public function regimenAction()
    {
        $datos = new Datos();
        return $datos->getRegimen();
    }

    /**
     * @Route("/grupo", name="_load_grupo")
     */
    public function grupoAction()
    {
        $datos = new Datos();
        return $datos->getGrupo();
    }
    
    /**
     * @Route("/funcion", name="_load_funcion")
     */
    public function funcionAction()
    {
        $datos = new Datos();
        return $datos->getFuncion();
    }

    /**
     * @Route("/nivel", name="_load_nivel")
     */
    public function nivelAction()
    {
        $datos = new Datos();
        return $datos->getNivel();
    }

    /**
     * @Route("/etnia", name="_load_etnia")
     */
    public function etniaAction()
    {
        $datos = new Datos();
        return $datos->getEtnia();
    }

    /**
     * @Route("/documentos", name="_load_documentos")
     */
    public function documentosAction()
    {
        $datos = new Datos();
        return $datos->getDocumentos();
    }

    /**
     * @Route("/programas", name="_load_programas")
     */
    public function programasAction()
    {
        $datos = new Datos();
        return $datos->getProgramas();
    }

    /**
     * @Route("/parentesco", name="_load_parentesco")
     */
    public function parentescoAction()
    {
        $datos = new Datos();
        return $datos->getParentesco();
    }

    /**
     * @Route("/prioridad", name="_load_prioridad")
     */
    public function prioridadAction()
    {
        $datos = new Datos();
        return $datos->getPrioridad();
    }

    /**
     * @Route("/escolaridad", name="_load_escolaridad")
     */
    public function escolaridadAction()
    {
        $datos = new Datos();
        return $datos->getEscolaridad();
    }

    /**
     * @Route("/basico", name="_load_basico")
     */
    public function basicoAction()
    {
        $datos = new Datos();
        return $datos->getBasico();
    }

    /**
     * @Route("/reforzamiento", name="_load_reforzamiento")
     */
    public function reforzamientoAction()
    {
        $datos = new Datos();
        return $datos->getReforzamiento();
    }

    /**
     * @Route("/taller", name="_load_taller")
     */
    public function tallerAction()
    {
        $datos = new Datos();
        return $datos->getTaller();
    }

    /**
     * @Route("/cursos", name="_load_cursos")
     */
    public function cursosAction()
    {
        $datos = new Datos();
        return $datos->getCursos();
    }

    /**
     * @Route("/indices", name="_load_indices")
     */
    public function indicesAction()
    {
        $datos = new Datos();
        return $datos->getIndices();
    }

    /**
     * @Route("/asignaturas", name="_load_asignaturas")
     */
    public function asignaturasAction()
    {
        $datos = new Datos();
        return $datos->getAsignaturas();
    }

    /**
     * @Route("/moment", name="_load_momento")
     */
    public function momentoAction()
    {
        $datos = new Datos();
        return $datos->getMomento();
    }

    /**
     * @Route("/sistema", name="_load_sistema")
     */
    public function sistemaAction()
    {
        $datos = new Datos();
        return $datos->getSistema();
    }

    /**
     * @Route("/evaluador", name="_load_evaluador")
     */
    public function evaluadorAction()
    {
        $datos = new Datos();
        return $datos->getEvaluador();
    }

    /**
     * @Route("/evalua", name="_load_evalua")
     */
    public function evaluaAction()
    {
        $datos = new Datos();
        return $datos->getEvalua();
    }

    /**
     * @Route("/evaluacionD", name="_load_evaluacionD")
     */
    public function evaluacionDAction()
    {
        $datos = new Datos();
        return $datos->getEvaluacionD();
    }

    /**
     * @Route("/finalidad", name="_load_finalidad")
     */
    public function finalidadAction()
    {
        $datos = new Datos();
        return $datos->getFinalidad();
    }

    /**
     * @Route("/instrumento", name="_load_instrumento")
     */
    public function instrumentoAction()
    {
        $datos = new Datos();
        return $datos->getInstrumento();
    }

    /**
     * @Route("/aprendizaje", name="_load_aprendizaje")
     */
    public function aprendizajeAction()
    {
        $datos = new Datos();
        return $datos->getAprendizaje();
    }

    /**
     * @Route("/unidades", name="_load_unidades")
     */
    public function unidadesAction()
    {
        $datos = new Datos();
        return $datos->getUnidades();
    }

    /**
     * @Route("/objetivos", name="_load_objetivos")
     */
    public function objetivosAction()
    {
        $datos = new Datos();
        return $datos->getObjetivos();
    }

}