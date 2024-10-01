<?php

namespace App\Entity;

use App\Repository\PressupostProducteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pressupost_producte")
 * @ORM\Entity(repositoryClass=PressupostProducteRepository::class)
 */
class PressupostProducte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="id_pressupost", type="integer")
     */
    private $idPressupost;

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

    public function getIdPressupost(): ?int
    {
        return $this->idPressupost;
    }

    public function setIdPressupost(int $idPressupost): self
    {
        $this->idPressupost = $idPressupost;

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
