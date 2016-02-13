<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Schedule
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $day;

    /**
     * @ORM\Column(type="integer")
     */
    private $block;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="schedules")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id")
     **/
    private $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="schedules")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     **/
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="schedules")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     **/
    private $subject;


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
     * Set day
     *
     * @param string $day
     * @return Schedule
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return string 
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set block
     *
     * @param integer $block
     * @return Schedule
     */
    public function setBlock($block)
    {
        $this->block = $block;

        return $this;
    }

    /**
     * Get block
     *
     * @return integer 
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return Schedule
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
     * Set teacher
     *
     * @param \PAGE\DemoBundle\Entity\Teacher $teacher
     * @return Schedule
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
     * Set level
     *
     * @param \PAGE\DemoBundle\Entity\Level $level
     * @return Schedule
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
     * Set subject
     *
     * @param \PAGE\DemoBundle\Entity\Subject $subject
     * @return Schedule
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
