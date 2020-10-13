<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDateTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationLimitDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $registrationMaxNb;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $eventInfos;

    /**
     * @ORM\ManyToOne(targetEntity=Spot::class, inversedBy="events", cascade={"persist"})
     */
    private $spot;

    /**
     * @ORM\ManyToOne(targetEntity=State::class, inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $campus;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=Registration::class, mappedBy="event")
     */
    private $registrations;

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
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

    public function getStartDateTime(): ?\DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(\DateTimeInterface $startDateTime): self
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getRegistrationLimitDate(): ?\DateTimeInterface
    {
        return $this->registrationLimitDate;
    }

    public function setRegistrationLimitDate(\DateTimeInterface $registrationLimitDate): self
    {
        $this->registrationLimitDate = $registrationLimitDate;

        return $this;
    }

    public function getRegistrationMaxNb(): ?int
    {
        return $this->registrationMaxNb;
    }

    public function setRegistrationMaxNb(int $registrationMaxNb): self
    {
        $this->registrationMaxNb = $registrationMaxNb;

        return $this;
    }

    public function getEventInfos(): ?string
    {
        return $this->eventInfos;
    }

    public function setEventInfos(?string $eventInfos): self
    {
        $this->eventInfos = $eventInfos;

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

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

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
            $registration->setEvent($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): self
    {
        if ($this->registrations->contains($registration)) {
            $this->registrations->removeElement($registration);
            // set the owning side to null (unless already changed)
            if ($registration->getEvent() === $this) {
                $registration->setEvent(null);
            }
        }

        return $this;
    }



}
