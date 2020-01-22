<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("post:read")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups("post:read")
     */
    private $roles = ['ROLE_CLIENT'];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups("post:read")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     */
    private $adress;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Availability", mappedBy="doctor")
     * @Groups("post:read")
     */
    private $availabilities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="client")
     * @Groups("post:read")
     */
    private $reservationsClient;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="doctor")
     * @Groups("post:read")
     */
    private $reservationsDoctor;

    public function __construct()
    {
        $this->availabilities = new ArrayCollection();
        $this->reservationsClient = new ArrayCollection();
        $this->reservationsDoctor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = '';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * @return Collection|Availability[]
     */
    public function getAvailabilities(): Collection
    {
        return $this->availabilities;
    }

    public function addAvailability(Availability $availability): self
    {
        if (!$this->availabilities->contains($availability)) {
            $this->availabilities[] = $availability;
            $availability->setDoctor($this);
        }

        return $this;
    }

    public function removeAvailability(Availability $availability): self
    {
        if ($this->availabilities->contains($availability)) {
            $this->availabilities->removeElement($availability);
            // set the owning side to null (unless already changed)
            if ($availability->getDoctor() === $this) {
                $availability->setDoctor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservationsClient(): Collection
    {
        return $this->reservationsClient;
    }

    public function addReservationsClient(Reservation $reservationsClient): self
    {
        if (!$this->reservationsClient->contains($reservationsClient)) {
            $this->reservationsClient[] = $reservationsClient;
            $reservationsClient->setClient($this);
        }

        return $this;
    }

    public function removeReservationsClient(Reservation $reservationsClient): self
    {
        if ($this->reservationsClient->contains($reservationsClient)) {
            $this->reservationsClient->removeElement($reservationsClient);
            // set the owning side to null (unless already changed)
            if ($reservationsClient->getClient() === $this) {
                $reservationsClient->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservationsDoctor(): Collection
    {
        return $this->reservationsDoctor;
    }

    public function addReservationsDoctor(Reservation $reservationsDoctor): self
    {
        if (!$this->reservationsDoctor->contains($reservationsDoctor)) {
            $this->reservationsDoctor[] = $reservationsDoctor;
            $reservationsDoctor->setDoctor($this);
        }

        return $this;
    }

    public function removeReservationsDoctor(Reservation $reservationsDoctor): self
    {
        if ($this->reservationsDoctor->contains($reservationsDoctor)) {
            $this->reservationsDoctor->removeElement($reservationsDoctor);
            // set the owning side to null (unless already changed)
            if ($reservationsDoctor->getDoctor() === $this) {
                $reservationsDoctor->setDoctor(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->fullname;
    }
}
