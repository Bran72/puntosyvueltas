<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Fil;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Surmesure;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gamme", inversedBy="products")
     */
    private $gamme;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $Photos = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dimensions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $taille_fils;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getFil(): ?string
    {
        return $this->Fil;
    }

    public function setFil(string $Fil): self
    {
        $this->Fil = $Fil;

        return $this;
    }

    public function getSurmesure(): ?bool
    {
        return $this->Surmesure;
    }

    public function setSurmesure(bool $Surmesure): self
    {
        $this->Surmesure = $Surmesure;

        return $this;
    }

    public function getGamme(): ?Gamme
    {
        return $this->gamme;
    }

    public function setGamme(?Gamme $gamme): self
    {
        $this->gamme = $gamme;

        return $this;
    }

    public function getPhotos(): ?array
    {
        return $this->Photos;
    }

    public function setPhotos(array $Photos): self
    {
        $this->Photos = $Photos;

        return $this;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(?string $dimensions): self
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getTailleFils(): ?string
    {
        return $this->taille_fils;
    }

    public function setTailleFils(?string $taille_fils): self
    {
        $this->taille_fils = $taille_fils;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
