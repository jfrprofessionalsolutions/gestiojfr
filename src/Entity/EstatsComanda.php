<?php

namespace App\Entity;

use App\Repository\EstatsComandaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estats_comanda")
 * @ORM\Entity(repositoryClass=EstatsComandaRepository::class)
 * 
 */
class EstatsComanda
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_estat_comanda", type="integer")
     */
    private $idEstatComanda;

    /**
     * @ORM\Column(name="estat_comanda", type="string", length=50)
     */
    private $estatComanda;

    public function getIdEstatComanda(): ?int
    {
        return $this->idEstatComanda;
    }

    public function getEstatComanda(): ?string
    {
        return $this->estatComanda;
    }

    public function setEstatComanda(string $estatComanda): self
    {
        $this->estatComanda = $estatComanda;

        return $this;
    }
}
