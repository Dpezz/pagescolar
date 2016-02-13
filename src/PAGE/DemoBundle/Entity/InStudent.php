<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class InStudent
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="instudents")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     **/
    private $level;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $origin;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $documents;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $programs;

    /**
     * @ORM\OneToOne(targetEntity="Student", inversedBy="in_student")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     **/
    private $student;


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
     * Set origin
     *
     * @param string $origin
     * @return InStudent
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return string 
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    
    /**
     * Set record
     *
     * @param string $record
     * @return InStudent
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



    /**
     * Set student
     *
     * @param \PAGE\DemoBundle\Entity\Student $student
     * @return InStudent
     */
    public function setStudent(\PAGE\DemoBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \PAGE\DemoBundle\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }


    /**
     * Set level
     *
     * @param \PAGE\DemoBundle\Entity\Level $level
     * @return InStudent
     */
    public function setLevel(\PAGE\DemoBundle\Entity\Level $level = null)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \PAGE\DemoBundle\Entity\Level 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set documents
     *
     * @param array $documents
     * @return InStudent
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;

        return $this;
    }

    /**
     * Get documents
     *
     * @return array 
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Set programs
     *
     * @param array $programs
     * @return InStudent
     */
    public function setPrograms($programs)
    {
        $this->programs = $programs;

        return $this;
    }

    /**
     * Get programs
     *
     * @return array 
     */
    public function getPrograms()
    {
        return $this->programs;
    }
}
