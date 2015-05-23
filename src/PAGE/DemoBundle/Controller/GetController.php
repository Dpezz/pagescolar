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
use PAGE\DemoBundle\Entity\DatosDocentes;
use PAGE\DemoBundle\Entity\DatosAlumnos;
use PAGE\DemoBundle\Entity\DatosApoderados;
use PAGE\DemoBundle\Entity\DatosAsignaturas;
use PAGE\DemoBundle\Entity\DatosCursos;
use PAGE\DemoBundle\Entity\DatosEvaluaciones;

use PAGE\DemoBundle\Repository\Datos;

/**
 * @Route("/profile/get")
 */
class GetController extends Controller
{

/* GET Documentos */

    /**
     * @Route("/documento/{id}")
     * @Method("GET")
     */
    public function getDocumento($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocumentos')->find($id);

        return new JsonResponse(
            array(
                'title' => $data->getTitle(), 
                'description' => $data->getDescription(), 
            )
        );
    }

/* GET Apoderados */

    /**
     * @Route("/apoderado/{id}")
     * @Method("GET")
     */
    public function getApoderado($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosApoderados')->find($id);

        return new JsonResponse(
            array(
                'rut' => $data->getRut(), 
                'name' => $data->getName(), 
                'lastname' => $data->getLastname(), 
                'parentesco' => $data->getParentesco(), 
                'address' => $data->getAddress(), 
                'region' => $data->getRegion(), 
                'comuna' => $data->getComuna(), 
                'email' => $data->getEmail(), 
                'telefono' => $data->getTelefono(), 
                'nivel' => $data->getNivel(), 
                'convive' => $data->getConvive(), 
                'escolaridad' => $data->getEscolaridad()
            )
        );
    }


/* GET Asignaturas */
    
    /**
     * @Route("/asignaturas")
     * @Method("GET")
     */
    public function getAsignaturas(){
        $id = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->findBy(array('id_user'=>$id));

        $list = array();
        foreach ($data as $value) {
            $list[] = array(
                'name' => $value->getName(), 
                'id' => $value->getId() 
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/asignatura/{id}")
     * @Method("GET")
     */
    public function getAsignatura($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAsignaturas')->find($id);

        $active = 0;
        if($data->getIsActive()){
            $active = 1;
        }

        return new JsonResponse(
            array(
                'name' => $data->getName(), 
                'active' => $active, 
            )
        );
    }

    
/* GET Cursos */

    /**
     * @Route("/cursos")
     * @Method("GET")
     */
    public function getCursos(){
        $id = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')->findBy(array('id_user'=>$id));

        $list = array();
        foreach ($data as $value) {
            $list[] = array(
                'name' => $value->getName().' - '.$value->getIndice(), 
                'id' => $value->getId() 
            );
        }
        return new JsonResponse($list);
    }
    
    /**
     * @Route("/curso/{id}")
     * @Method("GET")
     */
    public function getCurso($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosCursos')->find($id);

        $active = 0;
        if($data->getIsActive()){
            $active = 1;
        }

        return new JsonResponse(
            array(
                'name' => $data->getName(), 
                'indice' => $data->getIndice(), 
                'active' => $active
            )
        );
    }


/* GET Evaluaciones */

    /**
     * @Route("/evaluacion/{id}")
     * @Method("GET")
     */
    public function getEvaluacion($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosEvaluaciones')->find($id);

        return new JsonResponse(
            array(
                'docente' => $data->getIdDocente(), 
                'asignatura' => $data->getIdAsignatura(),
                'curso' => $data->getIdCurso(),
                'semestre' => $data->getSemestre(),
                'sistema' => $data->getSistema(),
                'fecha' => $data->getFecha(),
                'momento' => $data->getMomento(),
                'evaluador' => $data->getEvaluador(),
                'evalua' => $data->getEvaluar(),
                'evaluacionD' => $data->getEvaluacionDocente(),
                'finalidad' => $data->getFinalidad(),
                'instrumento' => $data->getInstrumento(),
                'aprendizaje' => $data->getAprendizaje(),
                'titulo' => $data->getTitulo(),
            )
        );
    }


/* GET Docentes */

    /**
     * @Route("/docentes")
     * @Method("GET")
     */
    public function getDocentes(){
        $id = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosDocentes')->findBy(array('id_user'=>$id));

        $list = array();
        foreach ($data as $value) {
            $list[] = array(
                'name' => $value->getName().' '.$value->getPlastname().' '.$value->getMlastname(), 
                'id' => $value->getId() 
            );
        }
        return new JsonResponse($list);
    }


/* GET Alumnos */

    /**
     * @Route("/alumnos")
     * @Method("GET")
     */
    public function getAlumnos(){
        $id = $this->getUser()->getParent();
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:DatosAlumnos')->findBy(array('id_user'=>$id));

        $list = array();
        foreach ($data as $value) {
            $list[] = array(
                'name' => $value->getName().' '.$value->getPlastname().' '.$value->getMlastname(), 
                'id' => $value->getId() 
            );
        }
        return new JsonResponse($list);
    }


/* GET List */

    /**
     * @Route("/parentesco")
     * @Method("GET")
     */
    public function parentescoAction()
    {
        $datos = new Datos();
        $data = $datos->getParentesco();
        $data = explode(',',$data);

        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/prioridad")
     */
    public function prioridadAction()
    {
        $datos = new Datos();
        $data = $datos->getPrioridad();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/escolaridad")
     */
    public function escolaridadAction()
    {
        $datos = new Datos();

        $data = $datos->getEscolaridad();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/cursos_lista")
     */
    public function cursosListAction()
    {
        $datos = new Datos();

        $data = $datos->getCursos();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/indices")
     */
    public function indicesAction()
    {
        $datos = new Datos();

        $data = $datos->getIndices();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/asignaturas_lista")
     */
    public function asignaturasListAction()
    {
        $datos = new Datos();

        $data = $datos->getAsignaturas();
        $data = explode('-',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/sistemas")
     */
    public function sistemasListAction()
    {
        $datos = new Datos();

        $data = $datos->getSistema();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/momentos")
     */
    public function momentosListAction()
    {
        $datos = new Datos();

        $data = $datos->getMomento();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/evaluadores")
     */
    public function evaluadoresListAction()
    {
        $datos = new Datos();

        $data = $datos->getEvaluador();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }
   
    /**
     * @Route("/evaluas")
     */
    public function evaluasListAction()
    {
        $datos = new Datos();

        $data = $datos->getEvalua();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/evaluacionesd")
     */
    public function evaluacionDListAction()
    {
        $datos = new Datos();

        $data = $datos->getEvaluacionD();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/finalidades")
     */
    public function finalidadesListAction()
    {
        $datos = new Datos();

        $data = $datos->getFinalidad();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/instrumentos")
     */
    public function instrumentosListAction()
    {
        $datos = new Datos();

        $data = $datos->getInstrumento();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/aprendizajes")
     */
    public function aprendizajesListAction()
    {
        $datos = new Datos();

        $data = $datos->getAprendizaje();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/regiones")
     */
    public function regionesListAction()
    {
        $datos = new Datos();

        $data = $datos->getRegiones();
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }


    /**
     * @Route("/comunas/{id}")
     */
    public function comunasListAction($id){
        $datos = new Datos();

        $data = $datos->getComunas($id);
        $data = explode(',',$data);
        
        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/motivos")
     * @Method("GET")
     */
    public function motivosAction()
    {
        $datos = new Datos();
        $data = $datos->getMotivos();
        $data = explode(',',$data);

        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/unidades")
     * @Method("GET")
     */
    public function unidadesAction()
    {
        $datos = new Datos();
        $data = $datos->getUnidades();
        $data = explode(',',$data);

        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'name' => $item,
                'id' => $key
            );
        }
        return new JsonResponse($list);
    }

/* GET Planificacion */
    
    /**
     * @Route("/objetivo/{id}")
     * @Method("GET")
     */
    public function getObjetivo($id){
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:BaseCurricular')->find($id);

        return new JsonResponse(
            array(
                'id' => $data->getId(),
                'curso' => $data->getCurso(), 
                'asignatura' => $data->getAsignatura(), 
                'unidad' => $data->getUnidad(), 
                'objetivo' => $data->getObjetivo(), 
                'detalle' => $data->getDetalle(),
            )
        );
    }

    /**
     * @Route("/objetivos/{id}")
     * @Method("GET")
     */
    public function getObjetivos($id){
        $url = explode('_', $id);
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('PAGEDemoBundle:BaseCurricular')->findBy(array('curso'=>$url[0],'asignatura'=>$url[1],'unidad'=>$url[2]));

        $list = array();
        foreach ($data as $key => $item) {
            $list[] = array(
                'id' => $item->getId(),
                'id_obj' => $item->getIdObj(),
                'curso' => $item->getCurso(), 
                'asignatura' => $item->getAsignatura(), 
                'unidad' => $item->getUnidad(), 
                'objetivo' => $item->getObjetivo(), 
                'detalle' => $item->getDetalle(),
                'url' => $item->getUrl(),
            );
        }
        return new JsonResponse($list);
    }

    /**
     * @Route("/objetivos_id/{id}")
     * @Method("GET")
     */
    public function getJsonObjetivosId($id)
    {
        $ids = explode('_', $id);
        $url = "users/".$ids[1]."/planning/".$ids[0].".json";
        $list = array();
        if(file_exists($url)){
            $file = file_get_contents($url);
            $json = json_decode($file,true);
            $list = array();

            foreach ($json['objetivos'] as $key => $value) {
                $list[] = array(
                    'id' => $value['id']
                );
            }
        }
        return new JsonResponse($list);
    }
}
