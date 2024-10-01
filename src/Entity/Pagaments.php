<?php

namespace App\Entity;

use App\Repository\PagamentsRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="pagaments")
 * @ORM\Entity(repositoryClass=PagamentsRepository::class)
 */
class Pagaments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_pagament", type="integer")
     */
    private $idPagament;

    /**
     * @ORM\Column(name="id_comanda", type="integer")
     */
    private $idComanda;

    /**
     * @ORM\Column(name="id_client", type="integer")
     */
    private $idClient;

    /**
     * @ORM\Column(name="id_forma_pagament", type="integer")
     */
    private $idFormaPagament;

    /**
     * @ORM\Column(name="id_tipus_pagament", type="integer")
     */
    private $idTipusPagament;

    /**
     * @ORM\Column(name="id_factura", type="integer")
     */
    private $idFactura;

    /**
     * @ORM\Column(name="pagament", type="string", length=100)
     */
    private $pagament;

    /**
     * @ORM\Column(name="pagat", type="decimal", precision=6, scale=2, nullable=false)
     */
    private $pagat;

    /**
     * @ORM\Column(name="data_creacio", type="datetime", nullable=true)
     */
    private $dataCreacio;

    /**
     * @ORM\Column(name="data_modificacio", type="datetime", nullable=true)
     */
    private $dataModificacio;

    public function getIdPagament(): ?int
    {
        return $this->idPagament;
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

    public function getIdClient(): ?int
    {
        return $this->idClient;
    }

    public function setIdClient(int $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getIdFormaPagament(): ?int
    {
        return $this->idFormaPagament;
    }

    public function setIdFormaPagament(int $idFormaPagament): self
    {
        $this->idFormaPagament = $idFormaPagament;

        return $this;
    }

    public function getIdTipusPagament(): ?int
    {
        return $this->idTipusPagament;
    }

    public function setIdTipusPagament(int $idTipusPagament): self
    {
        $this->idTipusPagament = $idTipusPagament;

        return $this;
    }

    public function getIdFactura(): ?int
    {
        return $this->idFactura;
    }

    public function setIdFactura(int $idFactura): self
    {
        $this->idFactura = $idFactura;

        return $this;
    }

    public function getPagament(): ?string
    {
        return $this->pagament;
    }

    public function setPagament(string $pagament): self
    {
        $this->pagament = $pagament;

        return $this;
    }

    public function getPagat(): ?string
    {
        return $this->pagat;
    }

    public function setPagat(string $pagat): self
    {
        $this->pagat = $pagat;

        return $this;
    }

    public function getDataCreacio(): ?\DateTimeInterface
    {
        return $this->dataCreacio;
    }

    public function setDataCreacio(?\DateTimeInterface $dataCreacio): self
    {
        $this->dataCreacio = $dataCreacio;

        return $this;
    }

    public function getDataModificacio(): ?\DateTimeInterface
    {
        return $this->dataModificacio;
    }

    public function setDataModificacio(?\DateTimeInterface $dataModificacio): self
    {
        $this->dataModificacio = $dataModificacio;

        return $this;
    }
}