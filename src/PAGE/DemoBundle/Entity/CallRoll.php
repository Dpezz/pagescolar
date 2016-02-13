<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class CallRoll
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="callrolls")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     **/
    private $level;

    /**
     * @ORM\OneToMany(targetEntity="InCallRoll", mappedBy="callroll")
     **/
    private $incallrolls;


    public function __construct()
    {
        $this->createAt = new \DateTime('now');
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
     * Set date
     *
     * @param \DateTime $date
     * @return CallRoll
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
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return CallRoll
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
     * Set level
     *
     * @param \PAGE\DemoBundle\Entity\Level $level
     * @return CallRoll
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
     * Add incallrolls
     *
     * @param \PAGE\DemoBundle\Entity\InCallRoll $incallrolls
     * @return CallRoll
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
}
