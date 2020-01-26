<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 * @ApiResource(
 *  normalizationContext={
 *      "groups"={"reservations_read"}
 *  }
 * )
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"reservations_read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reservationsClient")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"reservations_read"})
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reservationsDoctor")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"reservations_read"})
     */
    private $doctor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDoctor(): ?User
    {
        return $this->doctor;
    }

    public function setDoctor(?User $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }
}
