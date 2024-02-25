<?php

namespace App\Entity;

use App\Repository\DataSourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataSourceRepository::class)]
class DataSource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'dataSources')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $uploader = null;

    #[ORM\OneToMany(targetEntity: Experimentation::class, mappedBy: 'source', orphanRemoval: true)]
    private Collection $experimentations;

    public function __construct()
    {
        $this->experimentations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUploader(): ?User
    {
        return $this->uploader;
    }

    public function setUploader(?User $uploader): static
    {
        $this->uploader = $uploader;

        return $this;
    }

    /**
     * @return Collection<int, Experimentation>
     */
    public function getExperimentations(): Collection
    {
        return $this->experimentations;
    }

    public function addExperimentation(Experimentation $experimentation): static
    {
        if (!$this->experimentations->contains($experimentation)) {
            $this->experimentations->add($experimentation);
            $experimentation->setSource($this);
        }

        return $this;
    }

    public function removeExperimentation(Experimentation $experimentation): static
    {
        if ($this->experimentations->removeElement($experimentation)) {
            // set the owning side to null (unless already changed)
            if ($experimentation->getSource() === $this) {
                $experimentation->setSource(null);
            }
        }

        return $this;
    }

}
