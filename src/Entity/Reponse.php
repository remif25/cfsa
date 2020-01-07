<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReponseRepository")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
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
     * @Vich\UploadableField(mapping="reponse_images", fileNameProperty="img")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GammeEnveloppe", inversedBy="reponses")
     */
    private $gammeEnveloppe;

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
        $ge = "";

        if ($this->getGammeEnveloppe())
            $ge = $this->getGammeEnveloppe()->getSlug();

        return [
            'id' => $this->getId(),
            'short' => $this->getShort(),
            'information' => $this->getInformation(),
            'id_parent_question' => $this->getIdParentquestion(),
            'img' => $this->getImg(),
            'url' => $this->getUrl(),
            'key' => $this->getId(),
            'title' => $this->getShort(),
            'icon' => "fas fa-comment-dots",
            'gammeEnveloppe' => $ge
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
        return $this->img;
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


    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->setUpdated(new \DateTime('now'));
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }


    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    public function __toString()
    {
        return (string)$this->short;
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
}
