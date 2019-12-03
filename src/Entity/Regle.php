<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegleRepository")
 */
class Regle
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
    private $question;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $aide;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LinkRegleOperation", mappedBy="regle", orphanRemoval=true)
     */
    private $linkRegleOperations;

    public function __construct()
    {
        $this->linkRegleOperations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAide(): ?string
    {
        return $this->aide;
    }

    public function setAide(?string $aide): self
    {
        $this->aide = $aide;

        return $this;
    }

    /**
     * @return Collection|LinkRegleOperation[]
     */
    public function getLinkRegleOperations(): Collection
    {
        return $this->linkRegleOperations;
    }

    public function addLinkRegleOperation(LinkRegleOperation $linkRegleOperation): self
    {
        if (!$this->linkRegleOperations->contains($linkRegleOperation)) {
            $this->linkRegleOperations[] = $linkRegleOperation;
            $linkRegleOperation->setRegle($this);
        }

        return $this;
    }

    public function removeLinkRegleOperation(LinkRegleOperation $linkRegleOperation): self
    {
        if ($this->linkRegleOperations->contains($linkRegleOperation)) {
            $this->linkRegleOperations->removeElement($linkRegleOperation);
            // set the owning side to null (unless already changed)
            if ($linkRegleOperation->getRegle() === $this) {
                $linkRegleOperation->setRegle(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string)$this->question;
    }
}
