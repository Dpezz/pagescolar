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

use PAGE\DemoBundle\Controller\LoadController;

/**
 * @Route("/profile/estadisticas")
 */
class StadisticController extends Controller
{
    
/* Template */

    /**
     * @Route("/docentes", name="estadisticas_docentes")
     * @Template()
     */
    public function docentesAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $asignaturas = $em->createQuery('SELECT d.name, count(u.asignatura) as num
            FROM PAGEDemoBundle:DatosDocentes u INNER JOIN PAGEDemoBundle:DatosAsignaturas d 
            WHERE d.id = u.asignatura and u.id_user = d.id_user and u.id_user = :user group by d.id')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $sexos = $em->createQuery('SELECT u.sexo as name, count(u.sexo) as num
            FROM PAGEDemoBundle:DatosDocentes u where u.id_user =:user
            group by u.sexo')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $years = $em->createQuery('SELECT u.ingreso as name, count(u.ingreso) as num
            FROM PAGEDemoBundle:DatosDocentes u where u.id_user =:user
            group by u.ingreso')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $funciones = $em->createQuery('SELECT u.funcion as name, count(u.funcion) as num
            FROM PAGEDemoBundle:DatosDocentes u where u.id_user =:user
            group by u.funcion')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $niveles = $em->createQuery('SELECT u.nivel as name, count(u.nivel) as num
            FROM PAGEDemoBundle:DatosDocentes u where u.id_user =:user
            group by u.nivel')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $docentes = $em->createQuery('SELECT count(u.id) as num
            FROM PAGEDemoBundle:DatosDocentes u where u.id_user =:user')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getSingleResult();

        return array(
            "asignaturas"=>$asignaturas,
            "sexos"=>$sexos,
            "years"=>$years,
            "funciones"=>$funciones,
            "niveles"=>$niveles,
            "docentes"=>$docentes,
        );
    }

    /**
     * @Route("/alumnos", name="estadisticas_alumnos")
     * @Template()
     */
    public function alumnosAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $cursos = $em->createQuery('SELECT d.name, count(u.curso) as num
            FROM PAGEDemoBundle:DatosAlumnos u INNER JOIN PAGEDemoBundle:DatosCursos d 
            WHERE d.id = u.curso and d.id_user = u.id_user and u.id_user = :user group by d.id')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $sexos = $em->createQuery('SELECT u.sexo as name, count(u.sexo) as num
            FROM PAGEDemoBundle:DatosAlumnos u where u.id_user = :user
            group by u.sexo')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $years = $em->createQuery('SELECT u.ingreso as name, count(u.ingreso) as num
            FROM PAGEDemoBundle:DatosAlumnos u where u.id_user = :user
            group by u.ingreso')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $etnias = $em->createQuery('SELECT u.etnia as name, count(u.etnia) as num
            FROM PAGEDemoBundle:DatosAlumnos u where u.id_user = :user
            group by u.etnia')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $load = new LoadController();
        $programas = array();
        $listaProgramas = explode(',', $load->programasAction() );
        foreach ($listaProgramas as $key => $value) {
            $num = $em->createQuery('SELECT count(u.programas) as num
            FROM PAGEDemoBundle:DatosAlumnos u WHERE u.id_user = :user and u.programas LIKE :name')
            ->setParameter('user',($this->getUser()->getParent()))
            ->setParameter('name', '%'.($key+1).'%')
            ->getArrayResult();
            $programas[] = array('name'=>$value,'num'=>$num[0]['num']);
        }

        $basicas = array();
        $listaBasicas = explode(',', $load->basicoAction() );
        foreach ($listaBasicas as $key => $value) {
            $num = $em->createQuery('SELECT count(u.nbasica) as num
            FROM PAGEDemoBundle:DatosAlumnos u WHERE u.id_user = :user and u.nbasica LIKE :name')
            ->setParameter('user',($this->getUser()->getParent()))
            ->setParameter('name', '%'.($key+1).'%')
            ->getArrayResult();
            $basicas[] = array('name'=>$value,'num'=>$num[0]['num']);
        }

        $reforzamientos = array();
        $listaReforzamiento = explode(',', $load->reforzamientoAction() );
        foreach ($listaReforzamiento as $key => $value) {
            $num = $em->createQuery('SELECT count(u.nreforzamiento) as num
            FROM PAGEDemoBundle:DatosAlumnos u WHERE u.id_user = :user and u.nreforzamiento LIKE :name')
            ->setParameter('user',($this->getUser()->getParent()))
            ->setParameter('name', '%'.($key+1).'%')
            ->getArrayResult();
            $reforzamientos[] = array('name'=>$value,'num'=>$num[0]['num']);
        }

        $talleres = array();
        $listaTalleres = explode(',', $load->tallerAction() );
        foreach ($listaTalleres as $key => $value) {
            $num = $em->createQuery('SELECT count(u.ntaller) as num
            FROM PAGEDemoBundle:DatosAlumnos u WHERE u.id_user = :user and u.ntaller LIKE :name')
            ->setParameter('user',($this->getUser()->getParent()))
            ->setParameter('name', '%'.($key+1).'%')
            ->getArrayResult();
            $talleres[] = array('name'=>$value,'num'=>$num[0]['num']);
        }

        $alumnos = $em->createQuery('SELECT count(u.id) as num
            FROM PAGEDemoBundle:DatosAlumnos u where u.id_user = :user ')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getSingleResult();

        return array(
            "cursos"=>$cursos,
            "sexos"=>$sexos,
            "years"=>$years,
            "etnias"=>$etnias,
            "programas"=>$programas,
            "basicas"=>$basicas,
            "reforzamientos"=>$reforzamientos,
            "talleres"=>$talleres,
            "alumnos"=>$alumnos,
        );
    }

    /**
     * @Route("/apoderados", name="estadisticas_apoderados")
     * @Template()
     */
    public function apoderadosAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $alumnos = $em->createQuery('SELECT d.curso as id, count(u.id_user) as num
            FROM PAGEDemoBundle:DatosApoderados u INNER JOIN PAGEDemoBundle:DatosAlumnos d 
            WHERE d.id = u.id_user and d.id_user =:user group by d.curso')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $parentescos = $em->createQuery('SELECT u.parentesco as name, count(u.parentesco) as num
            FROM PAGEDemoBundle:DatosApoderados u INNER JOIN PAGEDemoBundle:DatosAlumnos d
            WHERE d.id = u.id_user and d.id_user =:user group by u.parentesco')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $conviven = $em->createQuery('SELECT u.convive as name, count(u.convive) as num
            FROM PAGEDemoBundle:DatosApoderados u INNER JOIN PAGEDemoBundle:DatosAlumnos d
            WHERE d.id = u.id_user and d.id_user =:user
            group by u.convive')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $escolaridades = $em->createQuery('SELECT u.escolaridad as name, count(u.escolaridad) as num
            FROM PAGEDemoBundle:DatosApoderados u INNER JOIN PAGEDemoBundle:DatosAlumnos d
            WHERE d.id = u.id_user and d.id_user =:user
            group by u.escolaridad')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $cursos = $em->createQuery('SELECT u.id, u.name 
            FROM PAGEDemoBundle:DatosCursos u ')
        ->getArrayResult();

        $apoderados = $em->createQuery('SELECT count(u.id) as num
            FROM PAGEDemoBundle:DatosApoderados u INNER JOIN PAGEDemoBundle:DatosAlumnos d
            WHERE d.id = u.id_user and d.id_user =:user')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getSingleResult();
        //return new Response(print_r($cursos));
        return array(
            "alumnos"=>$alumnos,
            "parentescos"=>$parentescos,
            "conviven"=>$conviven,
            "escolaridades"=>$escolaridades,
            "cursos"=>$cursos,
            "apoderados"=>$apoderados,
        );
    }

    /**
     * @Route("/evaluaciones", name="estadisticas_evaluaciones")
     * @Template()
     */
    public function evaluacionesAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $asignaturas = $em->createQuery('SELECT d.name as name, count(u.id_asignatura) as num
            FROM PAGEDemoBundle:DatosEvaluaciones u INNER JOIN PAGEDemoBundle:DatosAsignaturas d 
            WHERE d.id = u.id_asignatura and u.id_user = d.id_user and u.id_user = :user group by u.id_asignatura')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $momentos = $em->createQuery('SELECT u.momento as name, count(u.momento) as num
            FROM PAGEDemoBundle:DatosEvaluaciones u where u.id_user = :user
            group by u.momento')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $sistemas = $em->createQuery('SELECT u.sistema as name, count(u.sistema) as num
            FROM PAGEDemoBundle:DatosEvaluaciones u where u.id_user = :user
            group by u.sistema')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $evaluadores = $em->createQuery('SELECT u.evaluador as name, count(u.evaluador) as num
            FROM PAGEDemoBundle:DatosEvaluaciones u where u.id_user = :user
            group by u.evaluador')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $evaluar = $em->createQuery('SELECT u.evaluar as name, count(u.evaluar) as num
            FROM PAGEDemoBundle:DatosEvaluaciones u where u.id_user = :user
            group by u.evaluar')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $evaluaciones = $em->createQuery('SELECT u.evaluacion_docente as name, count(u.evaluacion_docente) as num
            FROM PAGEDemoBundle:DatosEvaluaciones u where u.id_user = :user
            group by u.evaluacion_docente')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $finalidades = $em->createQuery('SELECT u.finalidad as name, count(u.finalidad) as num
            FROM PAGEDemoBundle:DatosEvaluaciones u where u.id_user = :user
            group by u.finalidad')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $instrumentos = $em->createQuery('SELECT u.instrumento as name, count(u.instrumento) as num
            FROM PAGEDemoBundle:DatosEvaluaciones u where u.id_user = :user
            group by u.instrumento')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $aprendizajes = $em->createQuery('SELECT u.aprendizaje as name, count(u.aprendizaje) as num
            FROM PAGEDemoBundle:DatosEvaluaciones u where u.id_user = :user
            group by u.aprendizaje')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getArrayResult();

        $test = $em->createQuery('SELECT count(u.id) as num
            FROM PAGEDemoBundle:DatosEvaluaciones u where u.id_user = :user')
        ->setParameter('user',($this->getUser()->getParent()))
        ->getSingleResult();

        return array(
            "asignaturas"=>$asignaturas,
            "momentos"=>$momentos,
            "sistemas"=>$sistemas,
            "evaluadores"=>$evaluadores,
            "evaluar"=>$evaluar,
            "evaluaciones"=>$evaluaciones,
            "finalidades"=>$finalidades,
            "instrumentos"=>$instrumentos,
            "aprendizajes"=>$aprendizajes,
            "test"=>$test,
        );
    }


/* GET DOCENTES */

	/**
     * @Route("/sexo_docentes")
     * @Method("GET")
     */
    public function getSexoDocentes(){
    	$load = new LoadController();
    	$item = explode(',', $load->sexoAction());
    	$json = array();
    	$id = $this->getUser()->getParent();

    	foreach ($item as $key => $value) {
        	$em = $this->getDoctrine()->getManager();
        	if($user = $em->getRepository('PAGEDemoBundle:DatosDocentes')->findBy(array('id_user'=>$id,'sexo'=>$value)))
        		$json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

	/**
     * @Route("/funcion_docentes")
     * @Method("GET")
     */
    public function getFuncionDocentes(){
    	$load = new LoadController();
    	$item = explode(',', $load->funcionAction());
    	$json = array();
    	$id = $this->getUser()->getParent();

    	foreach ($item as $key => $value) {
        	$em = $this->getDoctrine()->getManager();
        	if($user = $em->getRepository('PAGEDemoBundle:DatosDocentes')->findBy(array('id_user'=>$id,'funcion'=>$value)))
        		$json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

	/**
     * @Route("/nivel_docentes")
     * @Method("GET")
     */
    public function getNivelDocentes(){
    	$load = new LoadController();
    	$item = explode(',', $load->nivelAction());
    	$json = array();
    	$id = $this->getUser()->getParent();

    	foreach ($item as $key => $value) {
        	$em = $this->getDoctrine()->getManager();
        	if($user = $em->getRepository('PAGEDemoBundle:DatosDocentes')->findBy(array('id_user'=>$id,'nivel'=>$value)))
        		$json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/asignaturas_docentes")
     * @Method("GET")
     */
    public function getAsignaturasDocentes(){
        $load = new LoadController();
        $json = array();
        $id = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
            if($item = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->findBy(array('id_user'=>$id)))
                foreach ($item as $key => $value) {
                    if($user = $em->getRepository('PAGEDemoBundle:DatosDocentes')->findBy(array('id_user'=>$id,'asignatura'=>$value->getId())))
                        $json[] = array('name'=>$value->getName(),'data'=>count($user));
                }
        return new JsonResponse($json);
    }

    /**
     * @Route("/ingreso_docentes")
     * @Method("GET")
     */
    public function getIngresoDocentes(){
        $load = new LoadController();
        $json = array();
        $años = array();
        $id = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
            if($item = $em->getRepository('PAGEDemoBundle:DatosDocentes')->findBy(array('id_user'=>$id)))
                foreach ($item as $key => $value) {
                    if($user = $em->getRepository('PAGEDemoBundle:DatosDocentes')->findBy(array('id_user'=>$id,'ingreso'=>$value->getIngreso())))
                        if(! in_array($value->getIngreso(), $años))
                            $json[] = array('name'=>$value->getIngreso(),'data'=>count($user));
                            $años[] = $value->getIngreso();
                }
        sort($json);
        return new JsonResponse($json);
    }


/* GET ALUMNOS */

    /**
     * @Route("/sexo_alumnos")
     * @Method("GET")
     */
    public function getSexoAlumnos(){
        $load = new LoadController();
        $item = explode(',', $load->sexoAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id,'sexo'=>$value)))
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/etnia_alumnos")
     * @Method("GET")
     */
    public function getEtniaAlumnos(){
        $load = new LoadController();
        $item = explode(',', $load->etniaAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id,'etnia'=>$value)))
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/programas_alumnos")
     * @Method("GET")
     */
    public function getProgramasAlumnos(){
        $load = new LoadController();
        $item = explode(',', $load->programasAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            $user = $em
            ->createQuery(
                'SELECT i.id FROM PAGEDemoBundle:DatosAlumnos i 
                where i.programas Like :search'
                )
            ->setParameter('search', '%'.($key+1).'%')
            ->getArrayResult();

            if($user)
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/basico_alumnos")
     * @Method("GET")
     */
    public function getBasicoAlumnos(){
        $load = new LoadController();
        $item = explode(',', $load->basicoAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            $user = $em
            ->createQuery(
                'SELECT i.id FROM PAGEDemoBundle:DatosAlumnos i 
                where i.nbasica Like :search'
                )
            ->setParameter('search', '%'.($key+1).'%')
            ->getArrayResult();

            if($user)
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/reforzamiento_alumnos")
     * @Method("GET")
     */
    public function getReforzamientoAlumnos(){
        $load = new LoadController();
        $item = explode(',', $load->reforzamientoAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            $user = $em
            ->createQuery(
                'SELECT i.id FROM PAGEDemoBundle:DatosAlumnos i 
                where i.nreforzamiento Like :search'
                )
            ->setParameter('search', '%'.($key+1).'%')
            ->getArrayResult();

            if($user)
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/taller_alumnos")
     * @Method("GET")
     */
    public function getTallerAlumnos(){
        $load = new LoadController();
        $item = explode(',', $load->tallerAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            $user = $em
            ->createQuery(
                'SELECT i.id FROM PAGEDemoBundle:DatosAlumnos i 
                where i.ntaller Like :search'
                )
            ->setParameter('search', '%'.($key+1).'%')
            ->getArrayResult();

            if($user)
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/cursos_alumnos")
     * @Method("GET")
     */
    public function getCursosAlumnos(){
        $load = new LoadController();
        $json = array();
        $id = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
            if($item = $em->getRepository('PAGEDemoBundle:DatosCursos')->findBy(array('id_user'=>$id)))
                foreach ($item as $key => $value) {
                    if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id,'curso'=>$value->getId())))
                        $json[] = array('name'=>$value->getName().' '.$value->getIndice(),'data'=>count($user));
                }
        return new JsonResponse($json);
    }

    /**
     * @Route("/ingreso_alumnos")
     * @Method("GET")
     */
    public function getIngresoAlumnos(){
        $load = new LoadController();
        $json = array();
        $años = array();
        $id = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
            if($item = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id)))
                foreach ($item as $key => $value) {
                    if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id,'ingreso'=>$value->getIngreso())))
                        if(! in_array($value->getIngreso(), $años))
                            $json[] = array('name'=>$value->getIngreso(),'data'=>count($user));
                            $años[] = $value->getIngreso();
                }
        sort($json);
        return new JsonResponse($json);
    }


/* GET APODERADOS */

     /**
     * @Route("/parentesco_apoderados")
     * @Method("GET")
     */
    public function getParentescoApoderados(){
        $load = new LoadController();
        $item = explode(',', $load->parentescoAction());
        $json = array();
        $id = $this->getUser()->getParent();

        $em = $this->getDoctrine()->getManager();

        foreach ($item as $key => $value) {
            if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id)))
                $cantidad = 0;
                foreach ($user as $index => $valor) {
                    if($apoderados = $em->getRepository('PAGEDemoBundle:DatosApoderados')->findBy(array('id_user'=>$valor->getId(),'parentesco'=>$value)))
                        $cantidad += count($apoderados);
                }
                $json[] = array('name'=>$value,'data'=> $cantidad);
        }
        return new JsonResponse($json);
    }

     /**
     * @Route("/convive_apoderados")
     * @Method("GET")
     */
    public function getConviveApoderados(){
        $load = new LoadController();
        $item = array('Si'=>true,'No'=>false);
        $json = array();
        $id = $this->getUser()->getParent();

        $em = $this->getDoctrine()->getManager();
        foreach ($item as $key => $value) {
            if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id)))
                $cantidad = 0;
                foreach ($user as $index => $valor) {
                    if($apoderados = $em->getRepository('PAGEDemoBundle:DatosApoderados')->findBy(array('id_user'=>$valor->getId(),'convive'=>$value)))
                        $cantidad += count($apoderados);
                }
                $json[] = array('name'=>$key,'data'=>$cantidad);
        }
        return new JsonResponse($json);
    }

     /**
     * @Route("/escolaridad_apoderados")
     * @Method("GET")
     */
    public function getEscolaridadApoderados(){
        $load = new LoadController();
        $item = explode(',', $load->escolaridadAction());
        $json = array();
        $id = $this->getUser()->getParent();

        $em = $this->getDoctrine()->getManager();
        foreach ($item as $key => $value) {
            if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id)))
                $cantidad = 0;
                foreach ($user as $index => $valor) {
                    if($apoderados = $em->getRepository('PAGEDemoBundle:DatosApoderados')->findBy(array('id_user'=>$valor->getId(),'escolaridad'=>$value)))
                        $cantidad += count($apoderados);
                }
                $json[] = array('name'=>$value,'data'=>$cantidad);
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/cursos_apoderados")
     * @Method("GET")
     */
    public function getCursosApoderados(){
        $load = new LoadController();
        $json = array();
        $id = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
        if($item = $em->getRepository('PAGEDemoBundle:DatosCursos')->findBy(array('id_user'=>$id)))
            foreach ($item as $key => $value) {
                $cantidad = 0;
                if($user = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id,'curso'=>$value->getId())))
                    $cantidad = 0;
                    foreach ($user as $index => $valor) {
                        if($apoderados = $em->getRepository('PAGEDemoBundle:DatosApoderados')->findBy(array('id_user'=>$valor->getId())))
                            $cantidad += count($apoderados);
                    }
                    $json[] = array('name'=>$value->getName().' '.$value->getIndice(),'data'=> $cantidad );
            }
        return new JsonResponse($json);
    }


/* Evaluaciones */

    /**
     * @Route("/regimen_institucion")
     * @Method("GET")
     */
    public function getRegimenInstitucion(){
        $id = $this->getUser()->getParent();
        $regimen = null;

        $em = $this->getDoctrine()->getManager();
        if($item = $em->getRepository('PAGEDemoBundle:DatosInstitucion')->find($id)){
            $value = $item->getRegimen();
            if( $value == "Semestral"){
                $regimen = '1 semestre,2 semestre';
            }elseif($value == "Trimestral"){
                $regimen = '1 trimestre,2 trimestre,3 trimestre';
            }
        }
        return new Response($regimen);
    }

    /**
     * @Route("/evaluaciones_asignaturas")
     * @Method("GET")
     */
    public function getEvaluaciones(){
        $json = array();
        $id = $this->getUser()->getParent();
        $regimen = null;
        $em = $this->getDoctrine()->getManager();
        if($item = $em->getRepository('PAGEDemoBundle:DatosInstitucion')->find($id)){
            if($item->getRegimen() == "Semestral"){
                $regimen = array('1 semestre','2 semestre');
            }elseif($item->getRegimen() == "Trimestral"){
                $regimen = array('1 trimestre','2 trimestre','3 trimestre');
            }
        }

        if($item = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->findBy(array('id_user'=>$id)))
        foreach ($item as $key => $value) {
            foreach ($regimen as $index => $valor) {
                if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(array('id_user'=>$id,'id_asignatura'=>$value->getId(),'semestre'=>$valor)))
                    $json[] = array('name'=>$value->getName(),'data'=>count($user),'semestre'=>$valor);
            }
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/sistema_evaluaciones")
     * @Method("GET")
     */
    public function getSistemaEvaluaciones(){
        $load = new LoadController();
        $item = explode(',', $load->sistemaAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(array('id_user'=>$id,'sistema'=>$value)))
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/momento_evaluaciones")
     * @Method("GET")
     */
    public function getMomentoEvaluaciones(){
        $load = new LoadController();
        $item = explode(',', $load->momentoAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(array('id_user'=>$id,'momento'=>$value)))
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/tipo_evaluaciones")
     * @Method("GET")
     */
    public function getTipoEvaluaciones(){
        $load = new LoadController();
        $item = explode(',', $load->evaluadorAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(array('id_user'=>$id,'evaluador'=>$value)))
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/evalua_evaluaciones")
     * @Method("GET")
     */
    public function getEvaluaEvaluaciones(){
        $load = new LoadController();
        $item = explode(',', $load->evaluaAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(array('id_user'=>$id,'evaluar'=>$value)))
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/evaluacion_docente")
     * @Method("GET")
     */
    public function getEvaluacionDEvaluaciones(){
        $load = new LoadController();
        $item = explode(',', $load->evaluacionDAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(array('id_user'=>$id,'evaluacion_docente'=>$value)))
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/finalidad_evaluaciones")
     * @Method("GET")
     */
    public function getFinalidadEvaluaciones(){
        $load = new LoadController();
        $item = explode(',', $load->finalidadAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(array('id_user'=>$id,'finalidad'=>$value)))
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/instrumentos_evaluaciones")
     * @Method("GET")
     */
    public function getInstrumentosEvaluaciones(){
        $load = new LoadController();
        $item = explode(',', $load->instrumentoAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(array('id_user'=>$id,'instrumento'=>$value)))
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

    /**
     * @Route("/aprendizaje_evaluaciones")
     * @Method("GET")
     */
    public function getAprendizajeEvaluaciones(){
        $load = new LoadController();
        $item = explode(',', $load->aprendizajeAction());
        $json = array();
        $id = $this->getUser()->getParent();

        foreach ($item as $key => $value) {
            $em = $this->getDoctrine()->getManager();
            if($user = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->findBy(array('id_user'=>$id,'aprendizaje'=>$value)))
                $json[] = array('name'=>$value,'data'=>count($user));
        }
        return new JsonResponse($json);
    }

}