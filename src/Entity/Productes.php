<?php

namespace App\Entity;

use App\Repository\ProductesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="productes")
 * @ORM\Entity(repositoryClass=ProductesRepository::class)
 */
class Productes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_producte", type="integer")
     */
    private $idProducte;

    /**
     * @ORM\Column(name="producte", type="string", length=100)
     */
    private $producte;

    /**
     * @ORM\Column(name="preu", type="decimal", precision=6, scale=2)
     */
    private $preu;

    public function getIdProducte(): ?int
    {
        return $this->idProducte;
    }

    public function getProducte(): ?string
    {
        return $this->producte;
    }

    public function setProducte(string $producte): self
    {
        $this->producte = $producte;

        return $this;
    }

    public function getPreu(): ?string
    {
        return $this->preu;
    }

    public function setPreu(string $preu): self
    {
        $this->preu = $preu;

        return $this;
    }
}
