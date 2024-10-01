<?php

namespace App\Entity;

use App\Repository\EstatsPressupostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estats_pressupost")
 * @ORM\Entity(repositoryClass=EstatsPressupostRepository::class)
 */
class EstatsPressupost
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_estat_pressupost", type="integer")
     */
    private $idEstatPressupost;


    /**
     * @ORM\Column(name="estat_pressupost", type="string", length=50)
     */
    private $estatPressupost;

    public function getIdEstatPressupost(): ?int
    {
        return $this->idEstatPressupost;
    }

    public function getEstatPressupost(): ?string
    {
        return $this->estatPressupost;
    }

    public function setEstatPressupost(string $estatPressupost): self
    {
        $this->estatPressupost = $estatPressupost;

        return $this;
    }
}
