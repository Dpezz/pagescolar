<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Test
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
    private $period;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $system;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_score;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $moment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $evaluator;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $assess;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value_teacher;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $finality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $instrument;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $learning;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tests")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="tests")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id")
     **/
    private $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="tests")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     **/
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="tests")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     **/
    private $subject;

    /**
     * @ORM\OneToMany(targetEntity="Grade", mappedBy="test")
     **/
    private $grades;

    public function __construct()
    {
        $this->createAt = new \DateTime('now');
        $this->grades = new ArrayCollection();
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
     * Set period
     *
     * @param string $period
     * @return Test
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
     * Set title
     *
     * @param string $title
     * @return Test
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set system
     *
     * @param string $system
     * @return Test
     */
    public function setSystem($system)
    {
        $this->system = $system;

        return $this;
    }

    /**
     * Get system
     *
     * @return string 
     */
    public function getSystem()
    {
        return $this->system;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Test
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date_score
     *
     * @param \DateTime $dateScore
     * @return Test
     */
    public function setDateScore($dateScore)
    {
        $this->date_score = $dateScore;

        return $this;
    }

    /**
     * Get date_score
     *
     * @return \DateTime 
     */
    public function getDateScore()
    {
        return $this->date_score;
    }

    /**
     * Set moment
     *
     * @param string $moment
     * @return Test
     */
    public function setMoment($moment)
    {
        $this->moment = $moment;

        return $this;
    }

    /**
     * Get moment
     *
     * @return string 
     */
    public function getMoment()
    {
        return $this->moment;
    }

    /**
     * Set evaluator
     *
     * @param string $evaluator
     * @return Test
     */
    public function setEvaluator($evaluator)
    {
        $this->evaluator = $evaluator;

        return $this;
    }

    /**
     * Get evaluator
     *
     * @return string 
     */
    public function getEvaluator()
    {
        return $this->evaluator;
    }

    /**
     * Set value_teacher
     *
     * @param string $valueTeacher
     * @return Test
     */
    public function setValueTeacher($valueTeacher)
    {
        $this->value_teacher = $valueTeacher;

        return $this;
    }

    /**
     * Get value_teacher
     *
     * @return string 
     */
    public function getValueTeacher()
    {
        return $this->value_teacher;
    }

    /**
     * Set finality
     *
     * @param string $finality
     * @return Test
     */
    public function setFinality($finality)
    {
        $this->finality = $finality;

        return $this;
    }

    /**
     * Get finality
     *
     * @return string 
     */
    public function getFinality()
    {
        return $this->finality;
    }

    /**
     * Set instrument
     *
     * @param string $instrument
     * @return Test
     */
    public function setInstrument($instrument)
    {
        $this->instrument = $instrument;

        return $this;
    }

    /**
     * Get instrument
     *
     * @return string 
     */
    public function getInstrument()
    {
        return $this->instrument;
    }

    /**
     * Set learning
     *
     * @param string $learning
     * @return Test
     */
    public function setLearning($learning)
    {
        $this->learning = $learning;

        return $this;
    }

    /**
     * Get learning
     *
     * @return string 
     */
    public function getLearning()
    {
        return $this->learning;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return Test
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
     * @return Test
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
     * Set teacher
     *
     * @param \PAGE\DemoBundle\Entity\Teacher $teacher
     * @return Test
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
     * Set levels
     *
     * @param \PAGE\DemoBundle\Entity\Level $levels
     * @return Test
     */
    public function setLevels(\PAGE\DemoBundle\Entity\Level $levels = null)
    {
        $this->levels = $levels;

        return $this;
    }

    /**
     * Get levels
     *
     * @return \PAGE\DemoBundle\Entity\Level 
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * Set subjects
     *
     * @param \PAGE\DemoBundle\Entity\Subject $subjects
     * @return Test
     */
    public function setSubjects(\PAGE\DemoBundle\Entity\Subject $subjects = null)
    {
        $this->subjects = $subjects;

        return $this;
    }

    /**
     * Get subjects
     *
     * @return \PAGE\DemoBundle\Entity\Subject 
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * Set level
     *
     * @param \PAGE\DemoBundle\Entity\Level $level
     * @return Test
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
     * @return Test
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

    /**
     * Add grades
     *
     * @param \PAGE\DemoBundle\Entity\Grade $grades
     * @return Test
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
     * Set assess
     *
     * @param string $assess
     * @return Test
     */
    public function setAssess($assess)
    {
        $this->assess = $assess;

        return $this;
    }

    /**
     * Get assess
     *
     * @return string 
     */
    public function getAssess()
    {
        return $this->assess;
    }
}
