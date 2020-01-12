<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinkRegleOperationRepository")
 */
class LinkRegleOperation implements JsonSerializable
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
     * @ORM\OneToOne(targetEntity="App\Entity\Operation", inversedBy="linkregleoperation")
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

    public function removeRegle(): self
    {
        $this->regle = null;

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

    public function pushBranche($branche, $bool): self
    {
        $this->branche[$branche] =  $bool;

        return $this;
    }

    public function __toString()
    {
        return $this->regle . " - " . $this->operation;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'regle' => $this->getRegle(),
            'branches' => $this->getBranche(),
/*            'operation' => $this->getOperation()*/
        ];
    }
}
