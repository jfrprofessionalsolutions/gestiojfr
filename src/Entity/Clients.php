<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="clients")
 * @ORM\Entity(repositoryClass=ClientsRepository::class)
 */
class Clients
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $idClient;

    /**
     * @ORM\Column(name="nom", type="string", length=100)
     */
    public $nom;

    /**
     * @ORM\Column(name="adreca", type="string", length=200)
     */
    public $adreca;

    /**
     * @ORM\Column(name="cp", type="string", length=10)
     */
    public $cp;

    /**
     * @ORM\Column(name="poblacio", type="string", length=100)
     */
    public $poblacio;

    /**
     * @ORM\Column(name="provincia", type="string", length=100)
     */
    public $provincia;

    /**
     * @ORM\Column(name="pais", type="string", length=100)
     */
    public $pais;

    
    public function getIdClient(): ?int
    {
        return $this->idClient;
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

    public function getAdreca(): ?string
    {
        return $this->adreca;
    }

    public function setAdreca(string $adreca): self
    {
        $this->adreca = $adreca;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getPoblacio(): ?string
    {
        return $this->poblacio;
    }

    public function setPoblacio(string $poblacio): self
    {
        $this->poblacio = $poblacio;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(string $pais): self
    {
        $this->pais = $pais;

        return $this;
    }
}
