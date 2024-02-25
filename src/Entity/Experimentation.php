<?php

namespace App\Entity;

use App\Repository\ExperimentationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperimentationRepository::class)]
class Experimentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $num_exp = null;

    #[ORM\Column(length: 50)]
    private ?string $type_exp = null;

    #[ORM\Column(length: 50)]
    private ?string $site_essai = null;

    #[ORM\Column(length: 25)]
    private ?string $syst_essai = null;

    #[ORM\Column(length: 25)]
    private ?string $lot_cell = null;

    #[ORM\Column(length: 25)]
    private ?string $passage = null;

    #[ORM\Column(length: 50)]
    private ?string $stress = null;

    #[ORM\Column(length: 25)]
    private ?string $temps_traitement = null;

    #[ORM\Column(length: 25)]
    private ?string $gene = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prot_analyse = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $gene_corr = null;

    #[ORM\Column(length: 50)]
    private ?string $projet = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $nom_item = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom_comm = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $ref_produit = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $pourcentage_produit = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $genre = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $espece = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $fold_change = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $augm_dim = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $notation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prot_corr = null;

    #[ORM\ManyToOne(inversedBy: 'experimentations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DataSource $source = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $num_item = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $type_echantillon = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $nom_rec_dev = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumExp(): ?string
    {
        return $this->num_exp;
    }

    public function setNumExp(string $num_exp): static
    {
        $this->num_exp = $num_exp;

        return $this;
    }

    public function getTypeExp(): ?string
    {
        return $this->type_exp;
    }

    public function setTypeExp(string $type_exp): static
    {
        $this->type_exp = $type_exp;

        return $this;
    }

    public function getSiteEssai(): ?string
    {
        return $this->site_essai;
    }

    public function setSiteEssai(string $site_essai): static
    {
        $this->site_essai = $site_essai;

        return $this;
    }

    public function getSystEssai(): ?string
    {
        return $this->syst_essai;
    }

    public function setSystEssai(string $syst_essai): static
    {
        $this->syst_essai = $syst_essai;

        return $this;
    }

    public function getLotCell(): ?string
    {
        return $this->lot_cell;
    }

    public function setLotCell(string $lot_cell): static
    {
        $this->lot_cell = $lot_cell;

        return $this;
    }

    public function getPassage(): ?string
    {
        return $this->passage;
    }

    public function setPassage(string $passage): static
    {
        $this->passage = $passage;

        return $this;
    }

    public function getStress(): ?string
    {
        return $this->stress;
    }

    public function setStress(string $stress): static
    {
        $this->stress = $stress;

        return $this;
    }

    public function getTempsTraitement(): ?string
    {
        return $this->temps_traitement;
    }

    public function setTempsTraitement(string $temps_traitement): static
    {
        $this->temps_traitement = $temps_traitement;

        return $this;
    }

    public function getGene(): ?string
    {
        return $this->gene;
    }

    public function setGene(string $gene): static
    {
        $this->gene = $gene;

        return $this;
    }

    public function getProtAnalyse(): ?string
    {
        return $this->prot_analyse;
    }

    public function setProtAnalyse(?string $prot_analyse): static
    {
        $this->prot_analyse = $prot_analyse;

        return $this;
    }

    public function getGeneCorr(): ?string
    {
        return $this->gene_corr;
    }

    public function setGeneCorr(?string $gene_corr): static
    {
        $this->gene_corr = $gene_corr;

        return $this;
    }

    public function getProjet(): ?string
    {
        return $this->projet;
    }

    public function setProjet(string $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    public function getNomItem(): ?string
    {
        return $this->nom_item;
    }

    public function setNomItem(?string $nom_item): static
    {
        $this->nom_item = $nom_item;

        return $this;
    }

    public function getNomComm(): ?string
    {
        return $this->nom_comm;
    }

    public function setNomComm(?string $nom_comm): static
    {
        $this->nom_comm = $nom_comm;

        return $this;
    }

    public function getRefProduit(): ?string
    {
        return $this->ref_produit;
    }

    public function setRefProduit(?string $ref_produit): static
    {
        $this->ref_produit = $ref_produit;

        return $this;
    }

    public function getPourcentageProduit(): ?string
    {
        return $this->pourcentage_produit;
    }

    public function setPourcentageProduit(?string $pourcentage_produit): static
    {
        $this->pourcentage_produit = $pourcentage_produit;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(?string $espece): static
    {
        $this->espece = $espece;

        return $this;
    }

    public function getFoldChange(): ?string
    {
        return $this->fold_change;
    }

    public function setFoldChange(?string $fold_change): static
    {
        $this->fold_change = $fold_change;

        return $this;
    }

    public function getAugmDim(): ?string
    {
        return $this->augm_dim;
    }

    public function setAugmDim(?string $augm_dim): static
    {
        $this->augm_dim = $augm_dim;

        return $this;
    }

    public function getNotation(): ?string
    {
        return $this->notation;
    }

    public function setNotation(?string $notation): static
    {
        $this->notation = $notation;

        return $this;
    }

    public function getProtCorr(): ?string
    {
        return $this->prot_corr;
    }

    public function setProtCorr(?string $prot_corr): static
    {
        $this->prot_corr = $prot_corr;

        return $this;
    }

    public function getSource(): ?DataSource
    {
        return $this->source;
    }

    public function setSource(?DataSource $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getNumItem(): ?string
    {
        return $this->num_item;
    }

    public function setNumItem(?string $num_item): static
    {
        $this->num_item = $num_item;

        return $this;
    }

    public function getTypeEchantillon(): ?string
    {
        return $this->type_echantillon;
    }

    public function setTypeEchantillon(?string $type_echantillon): static
    {
        $this->type_echantillon = $type_echantillon;

        return $this;
    }

    public function getNomRecDev(): ?string
    {
        return $this->nom_rec_dev;
    }

    public function setNomRecDev(?string $nom_rec_dev): static
    {
        $this->nom_rec_dev = $nom_rec_dev;

        return $this;
    }
}
