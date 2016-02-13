<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class InTeacher
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" = ""})
     */
    private $team;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" = ""})
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" = ""})
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="inteachers")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     **/
    private $subject;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" = ""})
     */
    private $certificate;

    /**
     * @ORM\OneToOne(targetEntity="Teacher", inversedBy="in_teacher")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id")
     **/
    private $teacher;


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
     * Set team
     *
     * @param string $team
     * @return InTeacher
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return string 
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return InTeacher
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set level
     *
     * @param string $level
     * @return InTeacher
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set certificate
     *
     * @param string $certificate
     * @return InTeacher
     */
    public function setCertificate($certificate)
    {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * Get certificate
     *
     * @return string 
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * Set teacher
     *
     * @param \PAGE\DemoBundle\Entity\Teacher $teacher
     * @return InTeacher
     */
    public function setTeacher(\PAGE\DemoBundle\Entity\Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \PAGE\DemoBundle\Entity\Teacher 
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set subject
     *
     * @param \PAGE\DemoBundle\Entity\Subject $subject
     * @return InTeacher
     */
    public function setSubject(\PAGE\DemoBundle\Entity\Subject $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \PAGE\DemoBundle\Entity\Subject 
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
