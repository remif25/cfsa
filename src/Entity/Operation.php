<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperationRepository")
 */
class Operation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gamme", inversedBy="operations")
     */
    private $gamme;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\LinkRegleOperation", mappedBy="operation", cascade={"persist", "remove"})
     */
    private $linkregleoperation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PosteTravail", inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pdt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activite", inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GammeEnveloppe", inversedBy="operations")
     */
    private $gammeEnveloppe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

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

    public function addGamme(Gamme $gamme): self
    {
        if (!$this->gammes->contains($gamme)) {
            $this->gammes[] = $gamme;
            $gamme->setOperation($this);
        }

        return $this;
    }

    public function removeGamme(Gamme $gamme): self
    {
        if ($this->gammes->contains($gamme)) {
            $this->gammes->removeElement($gamme);
            // set the owning side to null (unless already changed)
            if ($gamme->getOperation() === $this) {
                $gamme->setOperation(null);
            }
        }

        return $this;
    }

    public function getGamme(): ?Gamme
    {
        return $this->gamme;
    }

    public function setGamme(?Gamme $gamme): self
    {
        $this->gamme = $gamme;

        return $this;
    }

    public function getLinkRegleOperation(): ?LinkRegleOperation
    {
        return $this->linkregleoperation;
    }

    public function setLinkRegleOperation(LinkRegleOperation $linkregleoperation): self
    {
        $this->linkregleoperation = $linkregleoperation;

        // set the owning side of the relation if necessary
        if ($linkregleoperation->getOperation() !== $this) {
            $linkregleoperation->setOperation($this);
        }

        return $this;
    }

    public function getPdt(): ?PosteTravail
    {
        return $this->pdt;
    }

    public function setPdt(?PosteTravail $pdt): self
    {
        $this->pdt = $pdt;

        return $this;
    }

    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): self
    {
        $this->activite = $activite;

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
        return $this->numero . ' - ' . $this->pdt . ' - ' .  $this->activite . ' - ' . $this->description;
    }

}
