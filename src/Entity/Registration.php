<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegistrationRepository::class)
 */
class Registration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    /**
     * @ORM\OneToOne(targetEntity=Event::class, inversedBy="registration", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="registration", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $participant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getParticipant(): ?User
    {
        return $this->participant;
    }

    public function setParticipant(User $participant): self
    {
        $this->participant = $participant;

        return $this;
    }
}
