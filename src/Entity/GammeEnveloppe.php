<?php

namespace App\Entity;

/*ini_set('xdebug.var_display_max_depth', '13');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');*/

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GammeEnveloppeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("reference")
 */
class GammeEnveloppe implements JsonSerializable
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Regle", mappedBy="ge")
     */
    private $regles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProcessusEnveloppeGammeEnveloppe", mappedBy="gammeEnveloppe")
     */
    private $processusEnveloppeGammeEnveloppes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\History", mappedBy="gammeEnveloppe", orphanRemoval=true)
     */
    private $histories;

    public function __construct()
    {
        $this->gammes = new ArrayCollection();
        $this->operations = new ArrayCollection();
        $this->reponses = new ArrayCollection();
        $this->regles = new ArrayCollection();
        $this->processusEnveloppeGammeEnveloppes = new ArrayCollection();
        $this->histories = new ArrayCollection();
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

    /**
     * @return Operation[]
     */
    public function getOperationsSerialize()
    {
        foreach ($this->operations as $operation){
            $jsonOp = json_encode($operation);
            if ($jsonOp)
                $operations[] = $operation;
        }
        return $operations;
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
     * @ORM\PrePersist
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

    public function createConfiguration()
    {
        $regles = $this->getBranchesByRules();

        $this->configurations = array();

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
                $this->configurations[$regle_id]['regle'] = $operation->getLinkregleoperation()->getRegle();
                $this->configurations[$regle_id][] = $operation;
                $this->configurations[$regle_id][count($this->configurations[$regle_id]) - 2]->getLinkregleoperation()->setBranche($branches);
            }
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'reference' => $this->getReference(),
            'nom' => $this->getNom(),
            'operations' => $this->getOperationsSerialize(),
            'configurations' => isset($this->configurations) ? $this->configurations : null
        ];
    }

    /**
     * @return Collection|Regle[]
     */
    public function getRegles(): Collection
    {
        return $this->regles;
    }

    public function addRegle(Regle $regle): self
    {
        if (!$this->regles->contains($regle)) {
            $this->regles[] = $regle;
            $regle->setGe($this);
        }

        return $this;
    }

    public function removeRegle(Regle $regle): self
    {
        if ($this->regles->contains($regle)) {
            $this->regles->removeElement($regle);
            // set the owning side to null (unless already changed)
            if ($regle->getGe() === $this) {
                $regle->setGe(null);
            }
        }

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
            $processusEnveloppeGammeEnveloppe->setGammeEnveloppe($this);
        }

        return $this;
    }

    public function removeProcessusEnveloppeGammeEnveloppe(ProcessusEnveloppeGammeEnveloppe $processusEnveloppeGammeEnveloppe): self
    {
        if ($this->processusEnveloppeGammeEnveloppes->contains($processusEnveloppeGammeEnveloppe)) {
            $this->processusEnveloppeGammeEnveloppes->removeElement($processusEnveloppeGammeEnveloppe);
            // set the owning side to null (unless already changed)
            if ($processusEnveloppeGammeEnveloppe->getGammeEnveloppe() === $this) {
                $processusEnveloppeGammeEnveloppe->setGammeEnveloppe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|History[]
     */
    public function getHistories(): Collection
    {
        return $this->histories;
    }

    public function addHistory(History $history): self
    {
        if (!$this->histories->contains($history)) {
            $this->histories[] = $history;
            $history->setGammeEnveloppe($this);
        }

        return $this;
    }

    public function removeHistory(History $history): self
    {
        if ($this->histories->contains($history)) {
            $this->histories->removeElement($history);
            // set the owning side to null (unless already changed)
            if ($history->getGammeEnveloppe() === $this) {
                $history->setGammeEnveloppe(null);
            }
        }

        return $this;
    }
}
