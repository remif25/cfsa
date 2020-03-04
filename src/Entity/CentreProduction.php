<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CentreProductionRepository")
 */
class CentreProduction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cout;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PosteTravail", mappedBy="centreProduction")
     */
    private $pdts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departement", inversedBy="centreproductions", cascade={"detach"})
     */
    private $departement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PosteTravailProto", mappedBy="centreProduction")
     */
    private $pdtsproto;

    public function __construct()
    {
        $this->pdts = new ArrayCollection();
        $this->pdtsproto = new ArrayCollection();
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

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getCout(): ?float
    {
        return $this->cout;
    }

    public function setCout(?float $cout): self
    {
        $this->cout = $cout;

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
            $pdt->setCentreProduction($this);
        }

        return $this;
    }

    public function removePdt(PosteTravail $pdt): self
    {
        if ($this->pdts->contains($pdt)) {
            $this->pdts->removeElement($pdt);
            // set the owning side to null (unless already changed)
            if ($pdt->getCentreProduction() === $this) {
                $pdt->setCentreProduction(null);
            }
        }

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function __toString()
    {
        return $this->reference . ' - ' .$this->designation;
    }

    /**
     * @return Collection|PosteTravailProto[]
     */
    public function getPdtsproto(): Collection
    {
        return $this->pdtsproto;
    }

    public function addPdtsproto(PosteTravailProto $pdtsproto): self
    {
        if (!$this->pdtsproto->contains($pdtsproto)) {
            $this->pdtsproto[] = $pdtsproto;
            $pdtsproto->setCentreProduction($this);
        }

        return $this;
    }

    public function removePdtsproto(PosteTravailProto $pdtsproto): self
    {
        if ($this->pdtsproto->contains($pdtsproto)) {
            $this->pdtsproto->removeElement($pdtsproto);
            // set the owning side to null (unless already changed)
            if ($pdtsproto->getCentreProduction() === $this) {
                $pdtsproto->setCentreProduction(null);
            }
        }

        return $this;
    }
}
