<?php

namespace App\Entity;

use App\Repository\ValorisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ValorisationRepository::class)
 */
class Valorisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $soldeinitial;

    /**
     * @ORM\Column(type="float")
     */
    private $soldeofday;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="user")
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSoldeinitial(): ?float
    {
        return $this->soldeinitial;
    }

    public function setSoldeinitial(float $soldeinitial): self
    {
        $this->soldeinitial = $soldeinitial;

        return $this;
    }

    public function getSoldeofday(): ?float
    {
        return $this->soldeofday;
    }

    public function setSoldeofday(float $soldeofday): self
    {
        $this->soldeofday = $soldeofday;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
