<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProcessusEnveloppeGammeEnveloppeRepository")
 */
class ProcessusEnveloppeGammeEnveloppe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GammeEnveloppe", inversedBy="processusEnveloppeGammeEnveloppes")
     */
    private $gammeEnveloppe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProcessusEnveloppe", inversedBy="processusEnveloppeGammeEnveloppes")
     */
    private $processusEnveloppe;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProcessusEnveloppe(): ?ProcessusEnveloppe
    {
        return $this->processusEnveloppe;
    }

    public function setProcessusEnveloppe(?ProcessusEnveloppe $processusEnveloppe): self
    {
        $this->processusEnveloppe = $processusEnveloppe;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
