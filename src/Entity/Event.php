<?php

namespace App\Entity;

use App\Repository\EventRepository;
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

    public function getId(): ?int
    {
        return $this->id;
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
}
