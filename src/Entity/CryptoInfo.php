<?php

namespace App\Entity;

use App\Repository\CryptoInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CryptoInfoRepository::class)
 */
class CryptoInfo
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
     * @ORM\OneToOne(targetEntity=Crypto::class, mappedBy="cryptoinfo", cascade={"persist", "remove"})
     */
    private $crypto;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

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

    public function getCrypto(): ?Crypto
    {
        return $this->crypto;
    }

    public function setCrypto(Crypto $crypto): self
    {
        // set the owning side of the relation if necessary
        if ($crypto->getCryptoinfo() !== $this) {
            $crypto->setCryptoinfo($this);
        }

        $this->crypto = $crypto;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }
}
