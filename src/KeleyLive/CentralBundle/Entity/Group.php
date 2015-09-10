<?php

namespace KeleyLive\CentralBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 *
 * @ORM\Table(name="user_group")
 * @ORM\Entity
 */
class Group
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups", cascade={"all"})
     **/
    private $users;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @return Group
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
     * Add users
     *
     * @param \KeleyLive\CentralBundle\Entity\User $users
     * @return Group
     */
    public function addUser(\KeleyLive\CentralBundle\Entity\User $user)
    {
        $user->addGroup($this);
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \KeleyLive\CentralBundle\Entity\User $users
     */
    public function removeUser(\KeleyLive\CentralBundle\Entity\User $user)
    {
        $user->removeGroup($this);
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}
