<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * DatosDocentes
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class DatosDocentes
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
     * @ORM\Column(name="rut", type="string", length=20,nullable=true)
     */
    private $rut;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255,nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="plastname", type="string", length=255,nullable=true)
     */
    private $plastname;

    /**
     * @var string
     *
     * @ORM\Column(name="mlastname", type="string", length=255,nullable=true)
     */
    private $mlastname;

    /**
     * @var datetime
     *
     * @ORM\Column(name="fecha_nacimiento", type="datetime", nullable=true)
     */
    private $fecha_nacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", length=20, nullable=true)
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="comuna", type="string", length=255, nullable=true)
     */
    private $comuna;

    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string", length=255, nullable=true)
     */
    private $pais;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @var integer
     *
     * @ORM\Column(name="retiro", type="integer", nullable=true)
     */
    private $retiro;


    /**
     * @var integer
     *
     * @ORM\Column(name="ingreso", type="integer", nullable=true)
     */
    private $ingreso;

    /**
     * @var string
     *
     * @ORM\Column(name="grupo", type="string", length=255, nullable=true)
     */
    private $grupo;

    /**
     * @var string
     *
     * @ORM\Column(name="funcion", type="string", length=255, nullable=true)
     */
    private $funcion;

    /**
     * @var string
     *
     * @ORM\Column(name="nivel", type="string", length=255, nullable=true)
     */
    private $nivel;

    /**
     * @var string
     *
     * @ORM\Column(name="asignatura", type="string", length=255, nullable=true)
     */
    private $asignatura;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255, nullable=true)
     */
    private $titulo;

    /**
     * Set id
     *
     * @param string $id
     * @return DatosDocentes
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
     * @return DatosDocentes
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
     * Set rut
     *
     * @param string $rut
     * @return DatosDocentes
     */
    public function setRut($rut)
    {
        $this->rut = $rut;

        return $this;
    }

    /**
     * Get rut
     *
     * @return string 
     */
    public function getRut()
    {
        return $this->rut;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return DatosDocentes
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
     * Set plastname
     *
     * @param string $plastname
     * @return DatosDocentes
     */
    public function setPlastname($plastname)
    {
        $this->plastname = $plastname;

        return $this;
    }

    /**
     * Get plastname
     *
     * @return string 
     */
    public function getPlastname()
    {
        return $this->plastname;
    }

    /**
     * Set mlastname
     *
     * @param string $mlastname
     * @return DatosDocentes
     */
    public function setMlastname($mlastname)
    {
        $this->mlastname = $mlastname;

        return $this;
    }

    /**
     * Get mlastname
     *
     * @return string 
     */
    public function getMlastname()
    {
        return $this->mlastname;
    }

    /**
     * Set fecha_nacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return DatosDocentes
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fecha_nacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fecha_nacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fecha_nacimiento;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return DatosDocentes
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return DatosDocentes
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return DatosDocentes
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set comuna
     *
     * @param string $comuna
     * @return DatosDocentes
     */
    public function setComuna($comuna)
    {
        $this->comuna = $comuna;

        return $this;
    }

    /**
     * Get comuna
     *
     * @return string 
     */
    public function getComuna()
    {
        return $this->comuna;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return DatosDocentes
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return DatosDocentes
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return DatosDocentes
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
     * Set retiro
     *
     * @param integer $retiro
     * @return DatosDocentes
     */
    public function setRetiro($retiro)
    {
        $this->retiro = $retiro;

        return $this;
    }

    /**
     * Get retiro
     *
     * @return integer 
     */
    public function getRetiro()
    {
        return $this->retiro;
    }

    /**
     * Set ingreso
     *
     * @param integer $ingreso
     * @return DatosDocentes
     */
    public function setIngreso($ingreso)
    {
        $this->ingreso = $ingreso;

        return $this;
    }

    /**
     * Get ingreso
     *
     * @return integer 
     */
    public function getIngreso()
    {
        return $this->ingreso;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     * @return DatosDocentes
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return string 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set funcion
     *
     * @param string $funcion
     * @return DatosDocentes
     */
    public function setFuncion($funcion)
    {
        $this->funcion = $funcion;

        return $this;
    }

    /**
     * Get funcion
     *
     * @return string 
     */
    public function getFuncion()
    {
        return $this->funcion;
    }

    /**
     * Set nivel
     *
     * @param string $nivel
     * @return DatosDocentes
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return string 
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set asignatura
     *
     * @param string $asignatura
     * @return DatosDocentes
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
     * Set titulo
     *
     * @param string $titulo
     * @return DatosDocentes
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

    /**
     * Set pais
     *
     * @param string $pais
     * @return DatosDocentes
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string 
     */
    public function getPais()
    {
        return $this->pais;
    }
}
