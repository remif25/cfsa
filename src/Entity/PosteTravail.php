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
     * @ORM\OneToMany(targetEntity="App\Entity\ActivitePosteTravail", mappedBy="posteTravail", cascade={"persist", "remove"})
     */
    private $activitePosteTravails;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $naturePdt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tempsReglage;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tempsMO;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tempsMA;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $acheminement;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantite;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $unite;

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
    public function getActivites(): Collection
    {
        $activites = new ArrayCollection();
        foreach ($this->getActivitePosteTravails() as $activitePosteTravail) {
            $activites->add($activitePosteTravail->getActivite());
        }

        return $activites;
    }
    

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

    public function getTempsReglage(): ?float
    {
        return $this->tempsReglage;
    }

    public function setTempsReglage(?float $tempsReglage): self
    {
        $this->tempsReglage = $tempsReglage;

        return $this;
    }

    public function getTempsMO(): ?float
    {
        return $this->tempsMO;
    }

    public function setTempsMO(?float $tempsMO): self
    {
        $this->tempsMO = $tempsMO;

        return $this;
    }

    public function getTempsMA(): ?float
    {
        return $this->tempsMA;
    }

    public function setTempsMA(?float $tempsMA): self
    {
        $this->tempsMA = $tempsMA;

        return $this;
    }

    public function getAcheminement(): ?float
    {
        return $this->acheminement;
    }

    public function setAcheminement(?float $acheminement): self
    {
        $this->acheminement = $acheminement;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(?float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(?string $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function numberOfActvitePostTravail() {
        
    }
}
