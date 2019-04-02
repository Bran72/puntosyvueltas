<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    private $Photos;

    /**
     * @ORM\Column(type="integer")
     */
    private $Prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Fil;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Surmesure;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gamme", inversedBy="products")
     */
    private $gamme;

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

    public function getPhotos(): ?string
    {
        return $this->Photos;
    }

    public function setPhotos(string $Photos): self
    {
        $this->Photos = $Photos;
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
}
