<?php

namespace App\Entity;

use App\Repository\CryptoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CryptoRepository::class)
 */
class Crypto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idmarketcoin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="smallint")
     */
    private $isactive;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $symbol;

    /**
     * @ORM\OneToMany (targetEntity=Transaction::class, mappedBy="crypto")
     */
    private $transaction;

    /**
     * @ORM\OneToOne(targetEntity=CryptoInfo::class, inversedBy="crypto", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cryptoinfo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdmarketcoin(): ?int
    {
        return $this->idmarketcoin;
    }

    public function setIdmarketcoin(int $idmarketcoin): self
    {
        $this->idmarketcoin = $idmarketcoin;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsactive(): ?int
    {
        return $this->isactive;
    }

    public function setIsactive(int $isactive): self
    {
        $this->isactive = $isactive;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(Transaction $transaction): self
    {
        // set the owning side of the relation if necessary
        if ($transaction->getCrypto() !== $this) {
            $transaction->setCrypto($this);
        }

        $this->transaction = $transaction;

        return $this;
    }

    public function getCryptoinfo(): ?CryptoInfo
    {
        return $this->cryptoinfo;
    }

    public function setCryptoinfo(CryptoInfo $cryptoinfo): self
    {
        $this->cryptoinfo = $cryptoinfo;

        return $this;
    }
}
