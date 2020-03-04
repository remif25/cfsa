<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PosteTravailRepository")
 */
class PosteTravail implements JsonSerializable
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
     * @ORM\OneToMany(targetEntity="App\Entity\Operation", mappedBy="pdt", orphanRemoval=true)
     */
    private $operations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CentreProduction", inversedBy="pdts")
     */
    private $centreProduction;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PosteTravailProto", mappedBy="pdt")
     */
    private $posteTravailProto;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActivitePosteTravail", mappedBy="pdt", cascade={"persist", "remove"})
     */
    private $activitePosteTravails;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $naturePdt;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
        $this->activites = new ArrayCollection();
        $this->activitePosteTravails = new ArrayCollection();
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
            $operation->setPdt($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getPdt() === $this) {
                $operation->setPdt(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Activite[]
     */
    /*public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites[] = $activite;
            $activite->addPdt($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): self
    {
        if ($this->activites->contains($activite)) {
            $this->activites->removeElement($activite);
            $activite->removePdt($this);
        }

        return $this;
    }*/

    public function __toString() {
        return $this->reference . ' - ' . $this->description;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'reference' => $this->getReference(),
            'description' => $this->getDescription(),
            'text' => $this->__toString()
        ];
    }

    public function getCentreProduction(): ?CentreProduction
    {
        return $this->centreProduction;
    }

    public function setCentreProduction(?CentreProduction $centreProduction): self
    {
        $this->centreProduction = $centreProduction;

        return $this;
    }

    public function getPosteTravailProto(): ?PosteTravailProto
    {
        return $this->posteTravailProto;
    }

    public function setPosteTravailProto(?PosteTravailProto $posteTravailProto): self
    {
        $this->posteTravailProto = $posteTravailProto;

        // set (or unset) the owning side of the relation if necessary
        $newPdt = null === $posteTravailProto ? null : $this;
        if ($posteTravailProto->getPdt() !== $newPdt) {
            $posteTravailProto->setPdt($newPdt);
        }

        return $this;
    }

    /**
     * @return Collection|ActivitePosteTravail[]
     */
    public function getActivitePosteTravails(): Collection
    {
        return $this->activitePosteTravails;
    }

    public function addActivitePosteTravail(ActivitePosteTravail $activitePosteTravail): self
    {
        if (!$this->activitePosteTravails->contains($activitePosteTravail)) {
            $this->activitePosteTravails[] = $activitePosteTravail;
            $activitePosteTravail->setPdt($this);
        }

        return $this;
    }

    public function removeActivitePosteTravail(ActivitePosteTravail $activitePosteTravail): self
    {
        if ($this->activitePosteTravails->contains($activitePosteTravail)) {
            $this->activitePosteTravails->removeElement($activitePosteTravail);
            // set the owning side to null (unless already changed)
            if ($activitePosteTravail->getPdt() === $this) {
                $activitePosteTravail->setPdt(null);
            }
        }

        return $this;
    }

    public function getNaturePdt(): ?string
    {
        return $this->naturePdt;
    }

    public function setNaturePdt(?string $naturePdt): self
    {
        $this->naturePdt = $naturePdt;

        return $this;
    }
}
