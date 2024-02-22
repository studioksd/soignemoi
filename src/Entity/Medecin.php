<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $specialite = null;

    #[ORM\Column(length: 255)]
    private ?string $matricule = null;

    #[ORM\OneToMany(targetEntity: Sejour::class, mappedBy: 'medecin')]
    private Collection $sejours;

    #[ORM\OneToMany(targetEntity: Prescription::class, mappedBy: 'medecin')]
    private Collection $prescriptions;

    #[ORM\OneToMany(targetEntity: AvisMedecin::class, mappedBy: 'medecin')]
    private Collection $avisMedecins;

    public function __construct()
    {
        $this->sejours = new ArrayCollection();
        $this->prescriptions = new ArrayCollection();
        $this->avisMedecins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * @return Collection<int, Sejour>
     */
    public function getSejours(): Collection
    {
        return $this->sejours;
    }

    public function addSejour(Sejour $sejour): static
    {
        if (!$this->sejours->contains($sejour)) {
            $this->sejours->add($sejour);
            $sejour->setMedecin($this);
        }

        return $this;
    }

    public function removeSejour(Sejour $sejour): static
    {
        if ($this->sejours->removeElement($sejour)) {
            // set the owning side to null (unless already changed)
            if ($sejour->getMedecin() === $this) {
                $sejour->setMedecin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Prescription>
     */
    public function getPrescriptions(): Collection
    {
        return $this->prescriptions;
    }

    public function addPrescription(Prescription $prescription): static
    {
        if (!$this->prescriptions->contains($prescription)) {
            $this->prescriptions->add($prescription);
            $prescription->setMedecin($this);
        }

        return $this;
    }

    public function removePrescription(Prescription $prescription): static
    {
        if ($this->prescriptions->removeElement($prescription)) {
            // set the owning side to null (unless already changed)
            if ($prescription->getMedecin() === $this) {
                $prescription->setMedecin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AvisMedecin>
     */
    public function getAvisMedecins(): Collection
    {
        return $this->avisMedecins;
    }

    public function addAvisMedecin(AvisMedecin $avisMedecin): static
    {
        if (!$this->avisMedecins->contains($avisMedecin)) {
            $this->avisMedecins->add($avisMedecin);
            $avisMedecin->setMedecin($this);
        }

        return $this;
    }

    public function removeAvisMedecin(AvisMedecin $avisMedecin): static
    {
        if ($this->avisMedecins->removeElement($avisMedecin)) {
            // set the owning side to null (unless already changed)
            if ($avisMedecin->getMedecin() === $this) {
                $avisMedecin->setMedecin(null);
            }
        }

        return $this;
    }
}
