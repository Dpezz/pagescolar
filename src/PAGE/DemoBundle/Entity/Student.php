<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Student
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $area;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commune;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etnia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year_in;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year_end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $health;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $interest;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $record;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="students")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="InStudent", mappedBy="student")
     **/
    private $in_student;

    /**
     * @ORM\OneToOne(targetEntity="InStudentIn", mappedBy="student")
     **/
    private $in_student_in;

    /**
     * @ORM\OneToMany(targetEntity="Agent", mappedBy="student")
     **/
    private $agents;

    /**
     * @ORM\OneToMany(targetEntity="Grade", mappedBy="student")
     **/
    private $grades;

    /**
     * @ORM\OneToMany(targetEntity="InCallRoll", mappedBy="student")
     **/
    private $incallrolls;


    public function __construct()
    {
        $this->createAt = new \DateTime('now');
        $this->isActive = true;
        $this->agents = new ArrayCollection();
        $this->grades = new ArrayCollection();
        $this->incallrolls = new ArrayCollection();
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
     * @return Student
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
     * @return Student
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
     * @return Student
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
     * @return Student
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
     * @return Student
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
     * @return Student
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
     * @return Student
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
     * @return Student
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
     * @return Student
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
     * Set phone
     *
     * @param string $phone
     * @return Student
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
     * @return Student
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
     * Set etnia
     *
     * @param string $etnia
     * @return Student
     */
    public function setEtnia($etnia)
    {
        $this->etnia = $etnia;

        return $this;
    }

    /**
     * Get etnia
     *
     * @return string 
     */
    public function getEtnia()
    {
        return $this->etnia;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Student
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Student
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
     * Set year_in
     *
     * @param integer $yearIn
     * @return Student
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
     * Set year_end
     *
     * @param integer $yearEnd
     * @return Student
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
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return Student
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
     * @return Student
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
     * Set in_student
     *
     * @param \PAGE\DemoBundle\Entity\InStudent $inStudent
     * @return Student
     */
    public function setInStudent(\PAGE\DemoBundle\Entity\InStudent $inStudent = null)
    {
        $this->in_student = $inStudent;

        return $this;
    }

    /**
     * Get in_student
     *
     * @return \PAGE\DemoBundle\Entity\InStudent 
     */
    public function getInStudent()
    {
        return $this->in_student;
    }

    /**
     * Set in_student_in
     *
     * @param \PAGE\DemoBundle\Entity\InStudentIn $inStudentIn
     * @return Student
     */
    public function setInStudentIn(\PAGE\DemoBundle\Entity\InStudentIn $inStudentIn = null)
    {
        $this->in_student_in = $inStudentIn;

        return $this;
    }

    /**
     * Get in_student_in
     *
     * @return \PAGE\DemoBundle\Entity\InStudentIn 
     */
    public function getInStudentIn()
    {
        return $this->in_student_in;
    }

    /**
     * Add agents
     *
     * @param \PAGE\DemoBundle\Entity\Agent $agents
     * @return Student
     */
    public function addAgent(\PAGE\DemoBundle\Entity\Agent $agents)
    {
        $this->agents[] = $agents;

        return $this;
    }

    /**
     * Remove agents
     *
     * @param \PAGE\DemoBundle\Entity\Agent $agents
     */
    public function removeAgent(\PAGE\DemoBundle\Entity\Agent $agents)
    {
        $this->agents->removeElement($agents);
    }

    /**
     * Get agents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAgents()
    {
        return $this->agents;
    }

    /**
     * Add grades
     *
     * @param \PAGE\DemoBundle\Entity\Grade $grades
     * @return Student
     */
    public function addGrade(\PAGE\DemoBundle\Entity\Grade $grades)
    {
        $this->grades[] = $grades;

        return $this;
    }

    /**
     * Remove grades
     *
     * @param \PAGE\DemoBundle\Entity\Grade $grades
     */
    public function removeGrade(\PAGE\DemoBundle\Entity\Grade $grades)
    {
        $this->grades->removeElement($grades);
    }

    /**
     * Get grades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrades()
    {
        return $this->grades;
    }

    /**
     * Add incallrolls
     *
     * @param \PAGE\DemoBundle\Entity\InCallRoll $incallrolls
     * @return Student
     */
    public function addIncallroll(\PAGE\DemoBundle\Entity\InCallRoll $incallrolls)
    {
        $this->incallrolls[] = $incallrolls;

        return $this;
    }

    /**
     * Remove incallrolls
     *
     * @param \PAGE\DemoBundle\Entity\InCallRoll $incallrolls
     */
    public function removeIncallroll(\PAGE\DemoBundle\Entity\InCallRoll $incallrolls)
    {
        $this->incallrolls->removeElement($incallrolls);
    }

    /**
     * Get incallrolls
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIncallrolls()
    {
        return $this->incallrolls;
    }

    /**
     * Set health
     *
     * @param string $health
     * @return Student
     */
    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * Get health
     *
     * @return string 
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Set interest
     *
     * @param string $interest
     * @return Student
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;

        return $this;
    }

    /**
     * Get interest
     *
     * @return string 
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * Set record
     *
     * @param string $record
     * @return Student
     */
    public function setRecord($record)
    {
        $this->record = $record;

        return $this;
    }

    /**
     * Get record
     *
     * @return string 
     */
    public function getRecord()
    {
        return $this->record;
    }
}
