<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", unique="true")
     */
    private $id;

    /**
     * @ORM\Column(type="uuid", unique="true")
     */
    private $uuid;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $originalprice;

    /**
     * @ORM\ManyToOne(targetEntity=Crypto::class, inversedBy="transaction", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $crypto;

    /**
     * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="transactions", cascade={"persist", "remove"})
     */
    private $wallet;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="user")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    public function getId(): ?Int
    {
        return $this->id;
    }

    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOriginalprice(): ?string
    {
        return $this->originalprice;
    }

    public function setOriginalprice(string $originalprice): self
    {
        $this->originalprice = $originalprice;

        return $this;
    }

    public function getCrypto(): ?Crypto
    {
        return $this->crypto;
    }

    public function setCrypto(Crypto $crypto): self
    {
        $this->crypto = $crypto;

        return $this;
    }

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    public function setWallet(?Wallet $wallet): self
    {
        $this->wallet = $wallet;

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
