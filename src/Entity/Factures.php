<?php

namespace App\Entity;

use App\Repository\FacturesRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="factures")
 * @ORM\Entity(repositoryClass=FacturesRepository::class)
 */
class Factures
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_factura", type="integer")
     */
    private $idFactura;

    /**
     * @ORM\Column(name="factura", type="string", length=100)
     */
    private $factura;

    /**
     * @ORM\Column(name="id_client", type="integer")
     */
    private $idClient;

    /**
     * @ORM\Column(name="id_comanda", type="integer")
     */
    private $idComanda;
    
    /**
     * @ORM\Column(name="data_creacio", type="datetime", nullable=true)
     */
    private $dataCreacio;

    /**
     * @ORM\Column(name="data_modificacio", type="datetime", nullable=true)
     */
    private $dataModificacio;

    public function getIdFactura(): ?int
    {
        return $this->idFactura;
    }

    public function getFactura(): ?string
    {
        return $this->factura;
    }

    public function setFactura(string $factura): self
    {
        $this->factura = $factura;

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

    public function getIdComanda(): ?int
    {
        return $this->idComanda;
    }

    public function setIdComanda(int $idComanda): self
    {
        $this->idComanda = $idComanda;

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

