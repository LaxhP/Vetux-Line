<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=VehiculeRepository::class)
 */
class Vehicule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modele;

    /**
     * @ORM\Column(type="integer")
     */
    private $annee;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="vehicule")
     */
    private $client;


    public function __construct()
    {
        $this->client = new ArrayCollection();
    }

    /**
     * @return Collection|Client[]
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", inversedBy="vehicule")
     * @ORM\JoinColumn(nullable=true)
     */
    private Marque $marque;

    /**
     * @return Marque
     */
    public function getMarque(): Marque
    {
        return $this->marque;
    }

    /**
     * @param Marque $marque
     */
    public function setMarque(Marque $marque): void
    {
        $this->marque = $marque;
    }

}
