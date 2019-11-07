<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $short;

    /**
     * @ORM\Column(type="string", length=2045)
     */
    private $q_long;

    /**
     * @ORM\Column(type="text")
     */
    private $information;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_parent_reponse;


    public function __construct()
    {
        $this->reponses = new ArrayCollection();
        $this->reponse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShort(): ?string
    {
        return $this->short;
    }

    public function setShort(string $short): self
    {
        $this->short = $short;

        return $this;
    }

    public function getQLong(): ?string
    {
        return $this->q_long;
    }

    public function setQLong(string $q_long): self
    {
        $this->q_long = $q_long;

        return $this;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(string $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function getIdParentReponse(): ?int
    {
        return $this->id_parent_reponse;
    }

    public function setIdParentReponse(int $id_parent_reponse): self
    {
        $this->id_parent_reponse = $id_parent_reponse;

        return $this;
    }
    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'short' => $this->getShort(),
            'q_long' => $this->getQLong(),
            'information' => $this->getInformation(),
            'id_parent_reponse' => $this->getIdParentReponse()
        ];
    }


}
