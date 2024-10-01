<?php

namespace App\Entity;

use App\Repository\TipusPagamentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tipus_pagaments")
 * @ORM\Entity(repositoryClass=TipusPagamentsRepository::class)
 */
class TipusPagaments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_tipus_pagament", type="integer")
     */
    private $idTipusPagament;

    /**
     * @ORM\Column(name="tipus_pagament", type="string", length=100)
     */
    private $tipusPagament;

    public function getIdTipusPagament(): ?int
    {
        return $this->idTipusPagament;
    }

    public function getTipusPagament(): ?string
    {
        return $this->tipusPagament;
    }

    public function setTipusPagament(string $tipusPagament): self
    {
        $this->tipusPagament = $tipusPagament;

        return $this;
    }
}
