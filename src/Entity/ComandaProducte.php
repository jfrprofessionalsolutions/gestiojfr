<?php

namespace App\Entity;

use App\Repository\ComandaProducteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comanda_producte")
 * @ORM\Entity(repositoryClass=ComandaProducteRepository::class)
 */
class ComandaProducte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="id_comanda", type="integer")
     */
    private $idComanda;

    /**
     * @ORM\Column(name="id_producte", type="integer")
     */
    private $idProducte;

    /**
     * @ORM\Column(name="unitats", type="integer")
     */
    private $unitats;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdComanda(): ?int
    {
        return $this->idComanda;
    }

    public function setIdComanda(int $idComanda): self
    {
        $this->idComanda = $idComanda;

        return $this;
    }

    public function getIdProducte(): ?int
    {
        return $this->idProducte;
    }

    public function setIdProducte(int $idProducte): self
    {
        $this->idProducte = $idProducte;

        return $this;
    }

    public function getUnitats(): ?int
    {
        return $this->unitats;
    }

    public function setUnitats(int $unitats): self
    {
        $this->unitats = $unitats;

        return $this;
    }
}
