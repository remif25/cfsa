<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GammeRepository")
 */
class Gamme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Operation", mappedBy="gamme")
     */
    private $operations;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $classification;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GammeEnveloppe", inversedBy="gammes")
     */
    private $gammeEnveloppe;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    /**
     * @return Collection|Operation[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations[] = $operation;
            $operation->setGamme($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getGamme() === $this) {
                $operation->setGamme(null);
            }
        }

        return $this;
    }

    public function getClassification(): ?string
    {
        return $this->classification;
    }

    public function setClassification(?string $classification): self
    {
        $this->classification = $classification;

        return $this;
    }

    public function getGammeEnveloppe(): ?GammeEnveloppe
    {
        return $this->gammeEnveloppe;
    }

    public function setGammeEnveloppe(?GammeEnveloppe $gammeEnveloppe): self
    {
        $this->gammeEnveloppe = $gammeEnveloppe;

        return $this;
    }

    public function __toString() {
        return (string)$this->nom;
    }
}
