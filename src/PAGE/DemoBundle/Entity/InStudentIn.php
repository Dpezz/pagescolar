<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class InStudentIn
{  
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $basic;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $studio;


    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $know;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $other;

    /**
     * @ORM\OneToOne(targetEntity="Student", inversedBy="in_student_in")
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
     * Set student
     *
     * @param \PAGE\DemoBundle\Entity\Student $student
     * @return InStudentIn
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
     * Set other
     *
     * @param string $other
     * @return InStudentIn
     */
    public function setOther($other)
    {
        $this->other = $other;

        return $this;
    }

    /**
     * Get other
     *
     * @return string 
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * Set basic
     *
     * @param array $basic
     * @return InStudentIn
     */
    public function setBasic($basic)
    {
        $this->basic = $basic;

        return $this;
    }

    /**
     * Get basic
     *
     * @return array 
     */
    public function getBasic()
    {
        return $this->basic;
    }

    /**
     * Set studio
     *
     * @param array $studio
     * @return InStudentIn
     */
    public function setStudio($studio)
    {
        $this->studio = $studio;

        return $this;
    }

    /**
     * Get studio
     *
     * @return array 
     */
    public function getStudio()
    {
        return $this->studio;
    }

    /**
     * Set know
     *
     * @param array $know
     * @return InStudentIn
     */
    public function setKnow($know)
    {
        $this->know = $know;

        return $this;
    }

    /**
     * Get know
     *
     * @return array 
     */
    public function getKnow()
    {
        return $this->know;
    }
}
