<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class InCallRoll
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reason;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="CallRoll", inversedBy="incallrolls")
     * @ORM\JoinColumn(name="callroll_id", referencedColumnName="id")
     **/
    private $callroll;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="incallrolls")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     **/
    private $student;


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
     * Set reason
     *
     * @param string $reason
     * @return InCallRoll
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return InCallRoll
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
     * Set callroll
     *
     * @param \PAGE\DemoBundle\Entity\CallRoll $callroll
     * @return InCallRoll
     */
    public function setCallroll(\PAGE\DemoBundle\Entity\CallRoll $callroll = null)
    {
        $this->callroll = $callroll;

        return $this;
    }

    /**
     * Get callroll
     *
     * @return \PAGE\DemoBundle\Entity\CallRoll 
     */
    public function getCallroll()
    {
        return $this->callroll;
    }

    /**
     * Set student
     *
     * @param \PAGE\DemoBundle\Entity\Student $student
     * @return InCallRoll
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
}
