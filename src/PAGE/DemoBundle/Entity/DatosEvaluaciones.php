<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * DatosEvaluaciones
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class DatosEvaluaciones
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=25)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="id_user", type="string", length=25)
     */
    private $id_user;

    /**
     * @var string
     *
     * @ORM\Column(name="id_docente", type="string", length=25)
     */
    private $id_docente;

    /**
     * @var string
     *
     * @ORM\Column(name="id_asignatura", type="string", length=25)
     */
    private $id_asignatura;

    /**
     * @var string
     *
     * @ORM\Column(name="id_curso", type="string", length=25)
     */
    private $id_curso;

    /**
     * @var string
     *
     * @ORM\Column(name="semestre", type="string", length=255,nullable=true)
     */
    private $semestre;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255,nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="sistema", type="string", length=255,nullable=true)
     */
    private $sistema;

    /**
     * @var datetime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var datetime
     *
     * @ORM\Column(name="fecha_notas", type="datetime", nullable=true)
     */
    private $fecha_notas;

    /**
     * @var string
     *
     * @ORM\Column(name="momento", type="string", length=255,nullable=true)
     */
    private $momento;

    /**
     * @var string
     *
     * @ORM\Column(name="evaluador", type="string", length=255,nullable=true)
     */
    private $evaluador;

        /**
     * @var string
     *
     * @ORM\Column(name="evaluar", type="string", length=255,nullable=true)
     */
    private $evaluar;

        /**
     * @var string
     *
     * @ORM\Column(name="evaluacion_docente", type="string", length=255,nullable=true)
     */
    private $evaluacion_docente;

    /**
     * @var string
     *
     * @ORM\Column(name="finalidad", type="string", length=255,nullable=true)
     */
    private $finalidad;

    /**
     * @var string
     *
     * @ORM\Column(name="instrumento", type="string", length=255,nullable=true)
     */
    private $instrumento;

    /**
     * @var string
     *
     * @ORM\Column(name="aprendizaje", type="string", length=255,nullable=true)
     */
    private $aprendizaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * Set id
     *
     * @param string $id
     * @return DatosEvaluaciones
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id_user
     *
     * @param string $idUser
     * @return DatosEvaluaciones
     */
    public function setIdUser($idUser)
    {
        $this->id_user = $idUser;

        return $this;
    }

    /**
     * Get id_user
     *
     * @return string 
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * Set id_docente
     *
     * @param string $idDocente
     * @return DatosEvaluaciones
     */
    public function setIdDocente($idDocente)
    {
        $this->id_docente = $idDocente;

        return $this;
    }

    /**
     * Get id_docente
     *
     * @return string 
     */
    public function getIdDocente()
    {
        return $this->id_docente;
    }

    /**
     * Set id_asignatura
     *
     * @param string $idAsignatura
     * @return DatosEvaluaciones
     */
    public function setIdAsignatura($idAsignatura)
    {
        $this->id_asignatura = $idAsignatura;

        return $this;
    }

    /**
     * Get id_asignatura
     *
     * @return string 
     */
    public function getIdAsignatura()
    {
        return $this->id_asignatura;
    }

    /**
     * Set id_curso
     *
     * @param string $idCurso
     * @return DatosEvaluaciones
     */
    public function setIdCurso($idCurso)
    {
        $this->id_curso = $idCurso;

        return $this;
    }

    /**
     * Get id_curso
     *
     * @return string 
     */
    public function getIdCurso()
    {
        return $this->id_curso;
    }

    /**
     * Set semestre
     *
     * @param string $semestre
     * @return DatosEvaluaciones
     */
    public function setSemestre($semestre)
    {
        $this->semestre = $semestre;

        return $this;
    }

    /**
     * Get semestre
     *
     * @return string 
     */
    public function getSemestre()
    {
        return $this->semestre;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return DatosEvaluaciones
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set momento
     *
     * @param string $momento
     * @return DatosEvaluaciones
     */
    public function setMomento($momento)
    {
        $this->momento = $momento;

        return $this;
    }

    /**
     * Get momento
     *
     * @return string 
     */
    public function getMomento()
    {
        return $this->momento;
    }

    /**
     * Set evaluador
     *
     * @param string $evaluador
     * @return DatosEvaluaciones
     */
    public function setEvaluador($evaluador)
    {
        $this->evaluador = $evaluador;

        return $this;
    }

    /**
     * Get evaluador
     *
     * @return string 
     */
    public function getEvaluador()
    {
        return $this->evaluador;
    }

    /**
     * Set evaluar
     *
     * @param string $evaluar
     * @return DatosEvaluaciones
     */
    public function setEvaluar($evaluar)
    {
        $this->evaluar = $evaluar;

        return $this;
    }

    /**
     * Get evaluar
     *
     * @return string 
     */
    public function getEvaluar()
    {
        return $this->evaluar;
    }

    /**
     * Set evaluacion_docente
     *
     * @param string $evaluacionDocente
     * @return DatosEvaluaciones
     */
    public function setEvaluacionDocente($evaluacionDocente)
    {
        $this->evaluacion_docente = $evaluacionDocente;

        return $this;
    }

    /**
     * Get evaluacion_docente
     *
     * @return string 
     */
    public function getEvaluacionDocente()
    {
        return $this->evaluacion_docente;
    }

    /**
     * Set finalidad
     *
     * @param string $finalidad
     * @return DatosEvaluaciones
     */
    public function setFinalidad($finalidad)
    {
        $this->finalidad = $finalidad;

        return $this;
    }

    /**
     * Get finalidad
     *
     * @return string 
     */
    public function getFinalidad()
    {
        return $this->finalidad;
    }

    /**
     * Set instrumento
     *
     * @param string $instrumento
     * @return DatosEvaluaciones
     */
    public function setInstrumento($instrumento)
    {
        $this->instrumento = $instrumento;

        return $this;
    }

    /**
     * Get instrumento
     *
     * @return string 
     */
    public function getInstrumento()
    {
        return $this->instrumento;
    }

    /**
     * Set aprendizaje
     *
     * @param string $aprendizaje
     * @return DatosEvaluaciones
     */
    public function setAprendizaje($aprendizaje)
    {
        $this->aprendizaje = $aprendizaje;

        return $this;
    }

    /**
     * Get aprendizaje
     *
     * @return string 
     */
    public function getAprendizaje()
    {
        return $this->aprendizaje;
    }

    /**
     * Set sistema
     *
     * @param string $sistema
     * @return DatosEvaluaciones
     */
    public function setSistema($sistema)
    {
        $this->sistema = $sistema;

        return $this;
    }

    /**
     * Get sistema
     *
     * @return string 
     */
    public function getSistema()
    {
        return $this->sistema;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return DatosEvaluaciones
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set fecha_notas
     *
     * @param \DateTime $fechaNotas
     * @return DatosEvaluaciones
     */
    public function setFechaNotas($fechaNotas)
    {
        $this->fecha_notas = $fechaNotas;

        return $this;
    }

    /**
     * Get fecha_notas
     *
     * @return \DateTime 
     */
    public function getFechaNotas()
    {
        return $this->fecha_notas;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return DatosEvaluaciones
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }
}
