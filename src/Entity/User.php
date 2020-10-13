<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=230)
     */
    private $emailAdress;

    /**
     * @ORM\Column(type="boolean")
     */
    private $administrator;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $campus;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="owner", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $ownedEvents;

    /**
     * @ORM\OneToOne(targetEntity=Registration::class, mappedBy="participant", cascade={"persist", "remove"})
     */
    private $registration;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        //TODO changer la méthode par défaut qui remonte automatiquement le ROLE_USER
       /* $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);*/
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmailAdress(): ?string
    {
        return $this->emailAdress;
    }

    public function setEmailAdress(string $emailAdress): self
    {
        $this->emailAdress = $emailAdress;

        return $this;
    }

    public function getAdministrator(): ?bool
    {
        return $this->administrator;
    }

    public function setAdministrator(bool $administrator): self
    {
        $this->administrator = $administrator;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getSpot(): ?Spot
    {
        return $this->spot;
    }

    public function setSpot(?Spot $spot): self
    {
        $this->spot = $spot;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getOwnedEvents(): Collection
    {
        return $this->ownedEvents;
    }

    public function addOwnedEvent(Event $event): self
    {
        if (!$this->ownedEvents->contains($event)) {
            $this->ownedEvents[] = $event;
            $event->setUser($this);
        }

        return $this;
    }

    public function removeOwnedEvent(Event $event): self
    {
        if ($this->ownedEvents->contains($event)) {
            $this->ownedEvents->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getUser() === $this) {
                $event->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getParticipatedEvents(): Collection
    {
        return $this->participatedEvents;
    }

    public function addParticipatedEvent(Event $participatedEvent): self
    {
        if (!$this->participatedEvents->contains($participatedEvent)) {
            $this->participatedEvents[] = $participatedEvent;
            $participatedEvent->addParticipant($this);
        }

        return $this;
    }

    public function removeParticipatedEvent(Event $participatedEvent): self
    {
        if ($this->participatedEvents->contains($participatedEvent)) {
            $this->participatedEvents->removeElement($participatedEvent);
            $participatedEvent->removeParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection|Registration[]
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): self
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations[] = $registration;
            $registration->addParticipant($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): self
    {
        if ($this->registrations->contains($registration)) {
            $this->registrations->removeElement($registration);
            $registration->removeParticipant($this);
        }

        return $this;
    }

    public function getRegistration(): ?Registration
    {
        return $this->registration;
    }

    public function setRegistration(Registration $registration): self
    {
        $this->registration = $registration;

        // set the owning side of the relation if necessary
        if ($registration->getParticipant() !== $this) {
            $registration->setParticipant($this);
        }

        return $this;
    }
}
