<?php

namespace App\Entity;

use App\Repository\FormesPagamentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="formes_pagament")
 * @ORM\Entity(repositoryClass=FormesPagamentRepository::class)
 */
class FormesPagament
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_forma_pagament", type="integer")
     */
    private $idFormaPagament;


    /**
     * @ORM\Column(name="forma_pagament", type="string", length=100)
     */
    private $formaPagament;

    public function getIdFormaPagament(): ?int
    {
        return $this->idFormaPagament;
    }

    public function getFormaPagament(): ?string
    {
        return $this->formaPagament;
    }

    public function setFormaPagament(string $formaPagament): self
    {
        $this->formaPagament = $formaPagament;

        return $this;
    }
}
