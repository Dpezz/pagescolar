<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Teacher
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $rut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mlastname;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $sex;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    private $area;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commune;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year_end;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year_in;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="teachers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="InTeacher", mappedBy="teacher")
     **/
    private $in_teacher;

     /**
     * @ORM\OneToMany(targetEntity="Test", mappedBy="teacher")
     **/
    private $tests;

    /**
     * @ORM\OneToMany(targetEntity="Schedule", mappedBy="teacher")
     **/
    private $schedules;


    public function __construct()
    {
        $this->createAt = new \DateTime('now');
        $this->isActive = true;
        $this->tests = new ArrayCollection();
        $this->schedules = new ArrayCollection();
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
     * Set rut
     *
     * @param string $rut
     * @return Teacher
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
     * @return Teacher
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
     * Set lastname
     *
     * @param string $lastname
     * @return Teacher
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set mlastname
     *
     * @param string $mlastname
     * @return Teacher
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
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return Teacher
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return Teacher
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string 
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Teacher
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
     * Set area
     *
     * @param string $area
     * @return Teacher
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set commune
     *
     * @param string $commune
     * @return Teacher
     */
    public function setCommune($commune)
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * Get commune
     *
     * @return string 
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Teacher
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Teacher
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Teacher
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
     * @return Teacher
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
     * Set year_end
     *
     * @param integer $yearEnd
     * @return Teacher
     */
    public function setYearEnd($yearEnd)
    {
        $this->year_end = $yearEnd;

        return $this;
    }

    /**
     * Get year_end
     *
     * @return integer 
     */
    public function getYearEnd()
    {
        return $this->year_end;
    }

    /**
     * Set year_in
     *
     * @param integer $yearIn
     * @return Teacher
     */
    public function setYearIn($yearIn)
    {
        $this->year_in = $yearIn;

        return $this;
    }

    /**
     * Get year_in
     *
     * @return integer 
     */
    public function getYearIn()
    {
        return $this->year_in;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return Teacher
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
     * Set user
     *
     * @param \PAGE\DemoBundle\Entity\User $user
     * @return Teacher
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

    /**
     * Set in_teacher
     *
     * @param \PAGE\DemoBundle\Entity\InTeacher $inTeacher
     * @return Teacher
     */
    public function setInTeacher(\PAGE\DemoBundle\Entity\InTeacher $inTeacher = null)
    {
        $this->in_teacher = $inTeacher;

        return $this;
    }

    /**
     * Get in_teacher
     *
     * @return \PAGE\DemoBundle\Entity\InTeacher 
     */
    public function getInTeacher()
    {
        return $this->in_teacher;
    }

    /**
     * Add tests
     *
     * @param \PAGE\DemoBundle\Entity\Test $tests
     * @return Teacher
     */
    public function addTest(\PAGE\DemoBundle\Entity\Test $tests)
    {
        $this->tests[] = $tests;

        return $this;
    }

    /**
     * Remove tests
     *
     * @param \PAGE\DemoBundle\Entity\Test $tests
     */
    public function removeTest(\PAGE\DemoBundle\Entity\Test $tests)
    {
        $this->tests->removeElement($tests);
    }

    /**
     * Get tests
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * Add schedules
     *
     * @param \PAGE\DemoBundle\Entity\Schedule $schedules
     * @return Teacher
     */
    public function addSchedule(\PAGE\DemoBundle\Entity\Schedule $schedules)
    {
        $this->schedules[] = $schedules;

        return $this;
    }

    /**
     * Remove schedules
     *
     * @param \PAGE\DemoBundle\Entity\Schedule $schedules
     */
    public function removeSchedule(\PAGE\DemoBundle\Entity\Schedule $schedules)
    {
        $this->schedules->removeElement($schedules);
    }

    /**
     * Get schedules
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchedules()
    {
        return $this->schedules;
    }
}
