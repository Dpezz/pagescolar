<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaseCurricular
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class BaseCurricular
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="id_obj", type="string", length=30)
     */
    private $id_obj;

    /**
     * @var string
     *
     * @ORM\Column(name="curso", type="string", length=255)
     */
    private $curso;

    /**
     * @var string
     *
     * @ORM\Column(name="asignatura", type="string", length=255)
     */
    private $asignatura;

    /**
     * @var string
     *
     * @ORM\Column(name="unidad", type="string", length=255)
     */
    private $unidad;

    /**
     * @var string
     *
     * @ORM\Column(name="objetivo", type="string", length=255)
     */
    private $objetivo;

    /**
     * @var string
     *
     * @ORM\Column(name="detalle", type="text")
     */
    private $detalle;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * Set id
     *
     * @param string $id
     * @return BaseCurricular
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
     * Set curso
     *
     * @param string $curso
     * @return BaseCurricular
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return string 
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Set asignatura
     *
     * @param string $asignatura
     * @return BaseCurricular
     */
    public function setAsignatura($asignatura)
    {
        $this->asignatura = $asignatura;

        return $this;
    }

    /**
     * Get asignatura
     *
     * @return string 
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Set unidad
     *
     * @param string $unidad
     * @return BaseCurricular
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return string 
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Set objetivo
     *
     * @param string $objetivo
     * @return BaseCurricular
     */
    public function setObjetivo($objetivo)
    {
        $this->objetivo = $objetivo;

        return $this;
    }

    /**
     * Get objetivo
     *
     * @return string 
     */
    public function getObjetivo()
    {
        return $this->objetivo;
    }

    /**
     * Set detalle
     *
     * @param string $detalle
     * @return BaseCurricular
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * Get detalle
     *
     * @return string 
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return BaseCurricular
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set id_obj
     *
     * @param string $idObj
     * @return BaseCurricular
     */
    public function setIdObj($idObj)
    {
        $this->id_obj = $idObj;

        return $this;
    }

    /**
     * Get id_obj
     *
     * @return string 
     */
    public function getIdObj()
    {
        return $this->id_obj;
    }
}
