<?php

namespace App\Entity;

use App\Repository\IncidentsRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=IncidentsRepository::class)
 */
class Incidents
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $type;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $technician;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $t_group;

    /**
     * @ORM\Column(type="string", length=100)
     * @assert\NotBlank
     */
    private ?string $title;

    /**
     * @ORM\Column(type="text")
     * @assert\NotBlank
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=50)
     * @assert\NotBlank
     */
    private ?string $nom;

    /**
     * @ORM\Column(type="string", length=20)
     * @assert\NotBlank
     * @assert\Regex(
     *     pattern="/[0-9]{10}/")
     *
     */
    private ?string $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(
     *     message="l'email {{ value }} n'est pas valide"
     * )
     */
    private ?string $email;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Assert\Date
     */
    private DateTimeImmutable $date_create;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date
     */
    private DateTimeInterface $date_modif;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $date_import;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $state;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $priority;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $criticality;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $category;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $techread;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $disable;

    /**
     * @ORM\ManyToOne(targetEntity=Tplaces::class, inversedBy="incidents")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Tplaces $places;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTechnician(): ?int
    {
        return $this->technician;
    }

    public function setTechnician(int $technician): self
    {
        $this->technician = $technician;

        return $this;
    }

    public function getTGroup(): ?int
    {
        return $this->t_group;
    }

    public function setTGroup(int $t_group): self
    {
        $this->t_group = $t_group;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getUse(): ?string
    {
        return $this->use;
    }

    public function setUse(string $use): self
    {
        $this->use = $use;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeImmutable
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeImmutable $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getDateModif(): ?\DateTimeInterface
    {
        return $this->date_modif;
    }

    public function setDateModif(\DateTimeInterface $date_modif): self
    {
        $this->date_modif = $date_modif;

        return $this;
    }

    public function getDateImport(): ?\DateTimeInterface
    {
        return $this->date_import;
    }

    public function setDateImport(?\DateTimeInterface $date_import): self
    {
        $this->date_import = $date_import;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getCriticality(): ?int
    {
        return $this->criticality;
    }

    public function setCriticality(int $criticality): self
    {
        $this->criticality = $criticality;

        return $this;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(int $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTechread(): ?int
    {
        return $this->techread;
    }

    public function setTechread(int $techread): self
    {
        $this->techread = $techread;

        return $this;
    }

    public function getDisable(): ?int
    {
        return $this->disable;
    }

    public function setDisable(int $disable): self
    {
        $this->disable = $disable;

        return $this;
    }


    public function getPlaces(): ?Tplaces
    {
        return $this->places;
    }

    public function setPlaces(?Tplaces $places): self
    {
        $this->places = $places;

        return $this;
    }
}
