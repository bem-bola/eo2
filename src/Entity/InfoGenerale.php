<?php

namespace App\Entity;

use App\Repository\InfoGeneraleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InfoGeneraleRepository::class)
 */
class InfoGenerale
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_du_site;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description_3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description_4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sous_titre_site;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDuSite(): ?string
    {
        return $this->nom_du_site;
    }

    public function setNomDuSite(string $nom_du_site): self
    {
        $this->nom_du_site = $nom_du_site;

        return $this;
    }

    public function getDescription1(): ?string
    {
        return $this->description_1;
    }

    public function setDescription1(?string $description_1): self
    {
        $this->description_1 = $description_1;

        return $this;
    }

    public function getDescription2(): ?string
    {
        return $this->description_2;
    }

    public function setDescription2(?string $description_2): self
    {
        $this->description_2 = $description_2;

        return $this;
    }

    public function getDescription3(): ?string
    {
        return $this->description_3;
    }

    public function setDescription3(?string $description_3): self
    {
        $this->description_3 = $description_3;

        return $this;
    }

    public function getDescription4(): ?string
    {
        return $this->description_4;
    }

    public function setDescription4(?string $description_4): self
    {
        $this->description_4 = $description_4;

        return $this;
    }

    public function getSousTitreSite(): ?string
    {
        return $this->sous_titre_site;
    }

    public function setSousTitreSite(?string $sous_titre_site): self
    {
        $this->sous_titre_site = $sous_titre_site;

        return $this;
    }
}
