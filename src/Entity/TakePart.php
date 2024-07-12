<?php

namespace App\Entity;

use App\Repository\TakePartRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TakePartRepository::class)]
class TakePart
{

//    #[ORM\GeneratedValue]
//    #[ORM\Column]
//    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $registration_status = null;

    #[ORM\ManyToOne(inversedBy: 'takeParts')]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\Id]
    private ?Event $event = null;

    #[ORM\ManyToOne(inversedBy: 'takeParts')]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\Id]
    private ?User $user = null;

//    public function getId(): ?int
//    {
//        return $this->id;
//    }

    public function getRegistrationStatus(): ?string
    {
        return $this->registration_status;
    }

    public function setRegistrationStatus(string $registration_status): static
    {
        $this->registration_status = $registration_status;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }
}
