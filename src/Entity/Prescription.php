<?php

namespace App\Entity;

use App\Repository\PrescriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrescriptionRepository::class)]
class Prescription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'prescriptions')]
    private ?Medecin $medecin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'prescriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $patient = null;

    #[ORM\Column(nullable: true)]
    private ?array $medicaments = null;

    #[ORM\OneToOne(inversedBy: 'prescription', cascade: ['persist', 'remove'])]
    private ?AvisMedecin $avis_medecin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): static
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getPatient(): ?Utilisateur
    {
        return $this->patient;
    }

    public function setPatient(?Utilisateur $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getMedicaments(): ?array
    {
        return $this->medicaments;
    }

    public function setMedicaments(?array $medicaments): static
    {
        $this->medicaments = $medicaments;

        return $this;
    }

    public function getAvisMedecin(): ?AvisMedecin
    {
        return $this->avis_medecin;
    }

    public function setAvisMedecin(?AvisMedecin $avis_medecin): static
    {
        $this->avis_medecin = $avis_medecin;

        return $this;
    }

}
