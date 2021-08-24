<?php

namespace App\Entity;

use App\Repository\OrganizationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrganizationsRepository::class)
 */
class Organizations
{


    public function __construct()
    {
        $this->userName = new ArrayCollection();
        $this->userRole = new ArrayCollection();
    }

    /* public function __toString(){
          return $this->name;
      }*/

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $userRole;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $userPassword;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserRole()
    {
        return $this->userRole;
    }

    public function setUserRole($userRole): self
    {
        $this->userRole = $userRole;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->userPassword;
    }

    public function setUserPassword(?string $userPassword): self
    {
        $this->userPassword = $userPassword;

        return $this;
    }


}