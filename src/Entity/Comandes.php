<?php

namespace App\Entity;

use App\Repository\ComandesRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="comandes")
 * @ORM\Entity(repositoryClass=ComandesRepository::class)
 */
class Comandes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_comanda", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idComanda;

    /**
     * @var int
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     */
    private $idClient;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_comanda", type="string", length=100, nullable=false)
     */
    private $nomComanda;

    /**
     * @var string
     *
     * @ORM\Column(name="total_comanda", type="decimal", precision=6, scale=2, nullable=false)
     */
    private $totalComanda;

    /**
     * @var int
     *
     * @ORM\Column(name="id_estat", type="integer", nullable=false)
     */
    private $idEstat;

    /**
     * @ORM\Column(name="data_creacio", type="datetime", nullable=true)
     */
    private $dataCreacio;

    /**
     * @ORM\Column(name="data_modificacio", type="datetime", nullable=true)
     */
    private $dataModificacio;

    public function getIdComanda(): ?int
    {
        return $this->idComanda;
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

    public function getNomComanda(): ?string
    {
        return $this->nomComanda;
    }

    public function setNomComanda(string $nomComanda): self
    {
        $this->nomComanda = $nomComanda;

        return $this;
    }

    public function getTotalComanda(): ?string
    {
        return $this->totalComanda;
    }

    public function setTotalComanda(string $totalComanda): self
    {
        $this->totalComanda = $totalComanda;

        return $this;
    }

    public function getIdEstat(): ?int
    {
        return $this->idEstat;
    }

    public function setIdEstat(int $idEstat): self
    {
        $this->idEstat = $idEstat;

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
