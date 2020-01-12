<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartementRepository")
 */
class Departement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=24)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CentreProduction", mappedBy="departement")
     */
    private $centreproductions;

    public function __construct()
    {
        $this->centreproductions = new ArrayCollection();
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

    /**
     * @return Collection|CentreProduction[]
     */
    public function getCentreproductions(): Collection
    {
        return $this->centreproductions;
    }

    public function addCentreproduction(CentreProduction $centreproduction): self
    {
        if (!$this->centreproductions->contains($centreproduction)) {
            $this->centreproductions[] = $centreproduction;
            $centreproduction->setDepartement($this);
        }

        return $this;
    }

    public function removeCentreproduction(CentreProduction $centreproduction): self
    {
        if ($this->centreproductions->contains($centreproduction)) {
            $this->centreproductions->removeElement($centreproduction);
            // set the owning side to null (unless already changed)
            if ($centreproduction->getDepartement() === $this) {
                $centreproduction->setDepartement(null);
            }
        }

        return $this;
    }
}
