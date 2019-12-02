<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Request;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReponseRepository")
 */
class Reponse implements JsonSerializable
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $information;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_parent_question;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $url;


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

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(?string $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function getIdParentQuestion(): ?int
    {
        return $this->id_parent_question;
    }

    public function setIdParentQuestion(?int $id_parent_question): self
    {
        $this->id_parent_question = $id_parent_question;

        return $this;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'short' => $this->getShort(),
            'information' => $this->getInformation(),
            'id_parent_question' => $this->getIdParentquestion(),
            'img' => $this->getImg(),
            'url' => $this->getUrl(),
            'key' => $this->getId(),
            'title' => $this->getShort(),
            'icon' => "fab fa-sticker-mule"
        ];
    }


    public function jsonSerializeForFancytree() {
        return "{" .
            'key : ' . $this->getId() . ',' .
            'title : ' . $this->getShort() . ',' .
        "}";
    }

    public function getImg(): ?string
    {
        return 'https://naviquiz.repliqa.fr/img/r/' . $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }




}
