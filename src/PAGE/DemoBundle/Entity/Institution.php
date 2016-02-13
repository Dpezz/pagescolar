<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Institution
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rbd;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $agent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\OneToOne(targetEntity="InInstitution", mappedBy="institution")
     **/
    private $in_institution;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="institution")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    public function __construct()
    {
        $this->createAt = new \DateTime('now');
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rbd
     *
     * @param string $rbd
     * @return Institution
     */
    public function setRbd($rbd)
    {
        $this->rbd = $rbd;

        return $this;
    }

    /**
     * Get rbd
     *
     * @return string 
     */
    public function getRbd()
    {
        return $this->rbd;
    }

    /**
     * Set rut
     *
     * @param string $rut
     * @return Institution
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
     * Set address
     *
     * @param string $address
     * @return Institution
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
     * Set fax
     *
     * @param string $fax
     * @return Institution
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set agent
     *
     * @param string $agent
     * @return Institution
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return string 
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set period
     *
     * @param string $period
     * @return Institution
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return string 
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set mode
     *
     * @param string $mode
     * @return Institution
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return string 
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set regime
     *
     * @param string $regime
     * @return Institution
     */
    public function setRegime($regime)
    {
        $this->regime = $regime;

        return $this;
    }

    /**
     * Get regime
     *
     * @return string 
     */
    public function getRegime()
    {
        return $this->regime;
    }

    /**
     * Set date_start
     *
     * @param \DateTime $dateStart
     * @return Institution
     */
    public function setDateStart($dateStart)
    {
        $this->date_start = $dateStart;

        return $this;
    }

    /**
     * Get date_start
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * Set date_end
     *
     * @param \DateTime $dateEnd
     * @return Institution
     */
    public function setDateEnd($dateEnd)
    {
        $this->date_end = $dateEnd;

        return $this;
    }

    /**
     * Get date_end
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return Institution
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime 
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set in_intitution
     *
     * @param \PAGE\DemoBundle\Entity\InInstitution $inIntitution
     * @return Institution
     */
    public function setInIntitution(\PAGE\DemoBundle\Entity\InInstitution $inIntitution = null)
    {
        $this->in_intitution = $inIntitution;

        return $this;
    }

    /**
     * Get in_intitution
     *
     * @return \PAGE\DemoBundle\Entity\InInstitution 
     */
    public function getInIntitution()
    {
        return $this->in_intitution;
    }

    /**
     * Set in_institution
     *
     * @param \PAGE\DemoBundle\Entity\InInstitution $inInstitution
     * @return Institution
     */
    public function setInInstitution(\PAGE\DemoBundle\Entity\InInstitution $inInstitution = null)
    {
        $this->in_institution = $inInstitution;

        return $this;
    }

    /**
     * Get in_institution
     *
     * @return \PAGE\DemoBundle\Entity\InInstitution 
     */
    public function getInInstitution()
    {
        return $this->in_institution;
    }

    /**
     * Set user
     *
     * @param \PAGE\DemoBundle\Entity\User $user
     * @return Institution
     */
    public function setUser(\PAGE\DemoBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \PAGE\DemoBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
