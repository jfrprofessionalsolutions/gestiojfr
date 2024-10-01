<?php

namespace App\Entity;

use App\Repository\PressupostosRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="pressupostos")
 * @ORM\Entity(repositoryClass=PressupostosRepository::class)
 */
class Pressupostos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_pressupost", type="integer")
     */
    private $idPressupost;

    /**
     * @ORM\Column(name="id_client", type="integer")
     */
    private $idClient;

    /**
     * @ORM\Column(name="pressupost", type="string", length=150)
     */
    private $pressupost;

    /**
     * @ORM\Column(name="total_pressupost", type="decimal", precision=6, scale=2)
     */
    private $totalPressupost;

    /**
     * @ORM\Column(name="id_estat", type="integer")
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

    public function getIdPressupost(): ?int
    {
        return $this->idPressupost;
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

    public function getPressupost(): ?string
    {
        return $this->pressupost;
    }

    public function setPressupost(string $pressupost): self
    {
        $this->pressupost = $pressupost;

        return $this;
    }

    public function getTotalPressupost(): ?string
    {
        return $this->totalPressupost;
    }

    public function setTotalPressupost(string $totalPressupost): self
    {
        $this->totalPressupost = $totalPressupost;

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