<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Subject
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
     * @ORM\Column(type="datetime")
    */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="subjects")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Test", mappedBy="subject")
     **/
    private $tests;

    /**
     * @ORM\OneToMany(targetEntity="Schedule", mappedBy="subject")
     **/
    private $schedules;

    /**
     * @ORM\OneToMany(targetEntity="InTeacher", mappedBy="subject")
     **/
    private $inteachers;


    public function __construct()
    {
        $this->createAt = new \DateTime('now');
        $this->tests = new ArrayCollection();
        $this->schedules = new ArrayCollection();
        $this->inteachers = new ArrayCollection();
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
     * @return Subject
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
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return Subject
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
     * @return Subject
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
     * @return Subject
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
     * @return Subject
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
     * Add inteachers
     *
     * @param \PAGE\DemoBundle\Entity\InTeacher $inteachers
     * @return Subject
     */
    public function addInteacher(\PAGE\DemoBundle\Entity\InTeacher $inteachers)
    {
        $this->inteachers[] = $inteachers;

        return $this;
    }

    /**
     * Remove inteachers
     *
     * @param \PAGE\DemoBundle\Entity\InTeacher $inteachers
     */
    public function removeInteacher(\PAGE\DemoBundle\Entity\InTeacher $inteachers)
    {
        $this->inteachers->removeElement($inteachers);
    }

    /**
     * Get inteachers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInteachers()
    {
        return $this->inteachers;
    }
}
