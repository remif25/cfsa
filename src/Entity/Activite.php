<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActiviteRepository")
 */
class Activite
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
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Operation", mappedBy="activite", orphanRemoval=true)
     */
    private $operations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PosteTravail", inversedBy="activites")
     */
    private $pdts;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
        $this->pdts = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

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
            $operation->setActivite($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getActivite() === $this) {
                $operation->setActivite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PosteTravail[]
     */
    public function getPdts(): Collection
    {
        return $this->pdts;
    }

    public function addPdt(PosteTravail $pdt): self
    {
        if (!$this->pdts->contains($pdt)) {
            $this->pdts[] = $pdt;
        }

        return $this;
    }

    public function removePdt(PosteTravail $pdt): self
    {
        if ($this->pdts->contains($pdt)) {
            $this->pdts->removeElement($pdt);
        }

        return $this;
    }


    public function __toString() {
        return $this->reference . ' - ' . $this->description;
    }
}
