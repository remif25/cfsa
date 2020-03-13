<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProcessusEnveloppeRepository")
 */
class ProcessusEnveloppe
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProcessusEnveloppeGammeEnveloppe", mappedBy="processusEnveloppe")
     */
    private $processusEnveloppeGammeEnveloppes;

    public function __construct()
    {
        $this->processusEnveloppeGammeEnveloppes = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|ProcessusEnveloppeGammeEnveloppe[]
     */
    public function getProcessusEnveloppeGammeEnveloppes(): Collection
    {
        return $this->processusEnveloppeGammeEnveloppes;
    }

    public function addProcessusEnveloppeGammeEnveloppe(ProcessusEnveloppeGammeEnveloppe $processusEnveloppeGammeEnveloppe): self
    {
        if (!$this->processusEnveloppeGammeEnveloppes->contains($processusEnveloppeGammeEnveloppe)) {
            $this->processusEnveloppeGammeEnveloppes[] = $processusEnveloppeGammeEnveloppe;
            $processusEnveloppeGammeEnveloppe->setProcessusEnveloppe($this);
        }

        return $this;
    }

    public function removeProcessusEnveloppeGammeEnveloppe(ProcessusEnveloppeGammeEnveloppe $processusEnveloppeGammeEnveloppe): self
    {
        if ($this->processusEnveloppeGammeEnveloppes->contains($processusEnveloppeGammeEnveloppe)) {
            $this->processusEnveloppeGammeEnveloppes->removeElement($processusEnveloppeGammeEnveloppe);
            // set the owning side to null (unless already changed)
            if ($processusEnveloppeGammeEnveloppe->getProcessusEnveloppe() === $this) {
                $processusEnveloppeGammeEnveloppe->setProcessusEnveloppe(null);
            }
        }

        return $this;
    }
}
