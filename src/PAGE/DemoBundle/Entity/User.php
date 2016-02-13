<?php

namespace PAGE\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PAGE\DemoBundle\Entity\UserRepository")
 */
class User implements UserInterface, \Serializable
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" = "ROLE_ADMIN"})
     */
    private $role;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     **/
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Level", mappedBy="user")
     **/
    private $levels;

    /**
     * @ORM\OneToMany(targetEntity="Subject", mappedBy="user")
     **/
    private $subjects;

    /**
     * @ORM\OneToMany(targetEntity="Teacher", mappedBy="user")
     **/
    private $teachers;

    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="user")
     **/
    private $students;

    /**
     * @ORM\OneToMany(targetEntity="Test", mappedBy="user")
     **/
    private $tests;

     /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="user")
     **/
    private $documents;

    /**
     * @ORM\OneToOne(targetEntity="Institution", mappedBy="user")
     **/
    private $institution;

    public function __construct()
    {
        $this->role = "ROLE_ADMIN";
        $this->isActive = false;
        $this->updateAt = new \DateTime('now');

        $this->levels = new ArrayCollection();
        $this->subjects = new ArrayCollection();
        $this->teachers = new ArrayCollection();
        $this->students = new ArrayCollection();
        $this->tests = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    /**
     * Set id
     *
     * @param string $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = password_hash( $password, PASSWORD_BCRYPT);
        return $this;
    }

    /**
     * Get password
     * @inheritDoc
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
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
     * Set phone
     *
     * @param string $phone
     * @return User
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
     * Set role
     *
     * @param string $role
     * @return User
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
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
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return User
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
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return User
     */
    public function setUpdateAt($updateAt)
    {   
        if (is_null($updateAt))
            $this->updateAt = new \DateTime('now');
        else
            $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime 
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }


    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array($this->role);
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }


    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * Set user
     *
     * @param \PAGE\DemoBundle\Entity\User $user
     * @return User
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
     * Add levels
     *
     * @param \PAGE\DemoBundle\Entity\Level $levels
     * @return User
     */
    public function addLevel(\PAGE\DemoBundle\Entity\Level $levels)
    {
        $this->levels[] = $levels;

        return $this;
    }

    /**
     * Remove levels
     *
     * @param \PAGE\DemoBundle\Entity\Level $levels
     */
    public function removeLevel(\PAGE\DemoBundle\Entity\Level $levels)
    {
        $this->levels->removeElement($levels);
    }

    /**
     * Get levels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * Add subjects
     *
     * @param \PAGE\DemoBundle\Entity\Subject $subjects
     * @return User
     */
    public function addSubject(\PAGE\DemoBundle\Entity\Subject $subjects)
    {
        $this->subjects[] = $subjects;

        return $this;
    }

    /**
     * Remove subjects
     *
     * @param \PAGE\DemoBundle\Entity\Subject $subjects
     */
    public function removeSubject(\PAGE\DemoBundle\Entity\Subject $subjects)
    {
        $this->subjects->removeElement($subjects);
    }

    /**
     * Get subjects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * Add teachers
     *
     * @param \PAGE\DemoBundle\Entity\Teacher $teachers
     * @return User
     */
    public function addTeacher(\PAGE\DemoBundle\Entity\Teacher $teachers)
    {
        $this->teachers[] = $teachers;

        return $this;
    }

    /**
     * Remove teachers
     *
     * @param \PAGE\DemoBundle\Entity\Teacher $teachers
     */
    public function removeTeacher(\PAGE\DemoBundle\Entity\Teacher $teachers)
    {
        $this->teachers->removeElement($teachers);
    }

    /**
     * Get teachers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeachers()
    {
        return $this->teachers;
    }

    /**
     * Add students
     *
     * @param \PAGE\DemoBundle\Entity\Student $students
     * @return User
     */
    public function addStudent(\PAGE\DemoBundle\Entity\Student $students)
    {
        $this->students[] = $students;

        return $this;
    }

    /**
     * Remove students
     *
     * @param \PAGE\DemoBundle\Entity\Student $students
     */
    public function removeStudent(\PAGE\DemoBundle\Entity\Student $students)
    {
        $this->students->removeElement($students);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Add tests
     *
     * @param \PAGE\DemoBundle\Entity\Test $tests
     * @return User
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
     * Add documents
     *
     * @param \PAGE\DemoBundle\Entity\Document $documents
     * @return User
     */
    public function addDocument(\PAGE\DemoBundle\Entity\Document $documents)
    {
        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \PAGE\DemoBundle\Entity\Document $documents
     */
    public function removeDocument(\PAGE\DemoBundle\Entity\Document $documents)
    {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Set institution
     *
     * @param \PAGE\DemoBundle\Entity\Institution $institution
     * @return User
     */
    public function setInstitution(\PAGE\DemoBundle\Entity\Institution $institution = null)
    {
        $this->institution = $institution;

        return $this;
    }

    /**
     * Get institution
     *
     * @return \PAGE\DemoBundle\Entity\Institution 
     */
    public function getInstitution()
    {
        return $this->institution;
    }
}
