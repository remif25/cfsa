<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinkRegleOperationRepository")
 */
class LinkRegleOperation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Regle", inversedBy="linkRegleOperations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $regle;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Operation", inversedBy="linkregleoperation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $operation;

    /**
     * @ORM\Column(type="array")
     */
    private $branche = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegle(): ?Regle
    {
        return $this->regle;
    }

    public function setRegle(?Regle $regle): self
    {
        $this->regle = $regle;

        return $this;
    }

    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

    public function setOperation(Operation $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function getBranche(): ?array
    {
        return $this->branche;
    }

    public function setBranche(array $branche): self
    {
        $this->branche = $branche;

        return $this;
    }
}
