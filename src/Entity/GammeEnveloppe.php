<?php

namespace App\Entity;

/*ini_set('xdebug.var_display_max_depth', '13');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');*/

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\AbstractType;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GammeEnveloppeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("reference")
 */
class GammeEnveloppe
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gamme", mappedBy="gammeEnveloppe")
     */
    private $gammes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Operation", mappedBy="gammeEnveloppe")
     * @ORM\OrderBy({"numero" = "ASC"})
     */
    private $operations;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $reference;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reponse", mappedBy="gammeEnveloppe")
     */
    private $reponses;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->gammes = new ArrayCollection();
        $this->operations = new ArrayCollection();
        $this->reponses = new ArrayCollection();
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

    /**
     * @return Collection|Gamme[]
     */
    public function getGammes(): Collection
    {
        return $this->gammes;
    }

    public function addGamme(Gamme $gamme): self
    {
        if (!$this->gammes->contains($gamme)) {
            $this->gammes[] = $gamme;
            $gamme->setGammeEnveloppe($this);
        }

        return $this;
    }

    public function removeGamme(Gamme $gamme): self
    {
        if ($this->gammes->contains($gamme)) {
            $this->gammes->removeElement($gamme);
            // set the owning side to null (unless already changed)
            if ($gamme->getGammeEnveloppe() === $this) {
                $gamme->setGammeEnveloppe(null);
            }
        }

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
            $operation->setGammeEnveloppe($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getGammeEnveloppe() === $this) {
                $operation->setGammeEnveloppe(null);
            }
        }

        return $this;
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

    public function __toString() {
        return $this->reference . ' - ' . $this->nom;
    }

    /**
     * @return Collection|Reponse[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setGammeEnveloppe($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->contains($reponse)) {
            $this->reponses->removeElement($reponse);
            // set the owning side to null (unless already changed)
            if ($reponse->getGammeEnveloppe() === $this) {
                $reponse->setGammeEnveloppe(null);
            }
        }

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
     * @ORM\PreUpdate
     */
    public function updateSlug()
    {
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($this->reference);
    }

    public function getBranchesByRules() {
        $unique_regle_id = array();
        $regles = array();
        foreach($this->operations as $operation) {
            if ($operation->getLinkregleoperation()) {
                $regle = $operation->getLinkregleoperation()->getRegle();
                $branches = $operation->getLinkregleoperation()->getBranche();

                if (array_key_exists($regle->getId(), $regles)) {
                    foreach ($branches as $branche) {
                        if (!in_array($branche, $regles[$regle->getId()]))
                            $regles[$regle->getId()][] = $branche;
                    }

                } else {
                    $regles[$regle->getId()] = $branches;
                }

                if (!in_array($regle->getId(), $unique_regle_id))
                    $unique_regle_id[] = $regle->getId();

                if (!in_array(0, $regles[$regle->getId()]))
                    $regles[$regle->getId()][] = '0';
            }
        }
        return $regles;
    }

    public function createConfiguration() {
        $regles = $this->getBranchesByRules();

        foreach($this->operations as $operation) {
            if ($operation->getLinkregleoperation()) {
                $branches = array();
                $regle_id = $operation->getLinkregleoperation()->getRegle()->getId();
                $regle = $regles[$regle_id];

                foreach ($regle as $branche) {
                    if(in_array($branche, $operation->getLinkregleoperation()->getBranche()))
                        $branches[$branche] = true;
                    else
                        $branches[$branche] = false;
                }
                ksort($branches);

                //$operation->getLinkregleoperation()->setBranche($branches);
                $this->configurations[$regle_id][] = $operation;
                $this->configurations[$regle_id][count($this->configurations[$regle_id]) - 1]->getLinkregleoperation()->setBranche($branches);

            }
        }
    }
}
