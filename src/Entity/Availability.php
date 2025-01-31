<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={
 *      "groups"={"availabilities_read"}
 *  }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AvailabilityRepository")
 */
class Availability
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("posta:read")
     * @Groups({"availabilities_read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="availabilities")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id")
     * @Groups("posta:read")
     * @Groups({"availabilities_read"})
     */
    private $doctor;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("posta:read")
     * @Groups({"availabilities_read"})
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function __toString()
    {
        return $this->getDoctor();
    }

    public function toArray()
     {
       return [
            'id' => $this->getId(),
            'date' => $this->date,
            'doctor' => $this->doctor
        ];
    }
}
