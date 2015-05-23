<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * DatosCursos
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class DatosCursos
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
     * @ORM\Column(name="name", type="string", length=255,nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="indice", type="string", length=25,nullable=true)
     */
    private $indice;

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
     * @return DatosCursos
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
     * @return DatosCursos
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
     * Set name
     *
     * @param string $name
     * @return DatosCursos
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return DatosCursos
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
     * Set indice
     *
     * @param string $indice
     * @return DatosCursos
     */
    public function setIndice($indice)
    {
        $this->indice = $indice;

        return $this;
    }

    /**
     * Get indice
     *
     * @return string 
     */
    public function getIndice()
    {
        return $this->indice;
    }
}
