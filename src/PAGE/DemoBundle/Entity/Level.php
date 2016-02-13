<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Level
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
    private $name;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="levels")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Test", mappedBy="level")
     **/
    private $tests;

    /**
     * @ORM\OneToMany(targetEntity="Schedule", mappedBy="level")
     **/
    private $schedules;

    /**
     * @ORM\OneToMany(targetEntity="CallRoll", mappedBy="level")
     **/
    private $callrolls;

    /**
     * @ORM\OneToMany(targetEntity="InStudent", mappedBy="level")
     **/
    private $instudents;


    public function __construct()
    {
        $this->createAt = new \DateTime('now');
        $this->tests = new ArrayCollection();
        $this->schedules = new ArrayCollection();
        $this->callrolls = new ArrayCollection();
        $this->instudents = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Level
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
     * Set position
     *
     * @param string $position
     * @return Level
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return Level
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
     * @return Level
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
     * Add tests
     *
     * @param \PAGE\DemoBundle\Entity\Test $tests
     * @return Level
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
     * @return Level
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

    /**
     * Add callrolls
     *
     * @param \PAGE\DemoBundle\Entity\CallRoll $callrolls
     * @return Level
     */
    public function addCallroll(\PAGE\DemoBundle\Entity\CallRoll $callrolls)
    {
        $this->callrolls[] = $callrolls;

        return $this;
    }

    /**
     * Remove callrolls
     *
     * @param \PAGE\DemoBundle\Entity\CallRoll $callrolls
     */
    public function removeCallroll(\PAGE\DemoBundle\Entity\CallRoll $callrolls)
    {
        $this->callrolls->removeElement($callrolls);
    }

    /**
     * Get callrolls
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCallrolls()
    {
        return $this->callrolls;
    }

    /**
     * Add instudents
     *
     * @param \PAGE\DemoBundle\Entity\InStudent $instudents
     * @return Level
     */
    public function addInstudent(\PAGE\DemoBundle\Entity\InStudent $instudents)
    {
        $this->instudents[] = $instudents;

        return $this;
    }

    /**
     * Remove instudents
     *
     * @param \PAGE\DemoBundle\Entity\InStudent $instudents
     */
    public function removeInstudent(\PAGE\DemoBundle\Entity\InStudent $instudents)
    {
        $this->instudents->removeElement($instudents);
    }

    /**
     * Get instudents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInstudents()
    {
        return $this->instudents;
    }
}
