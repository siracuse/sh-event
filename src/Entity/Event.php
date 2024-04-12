<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[Vich\Uploadable]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

//    propriété correspondant au nom de l'image
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;
//    propriété correspondant a la data de l'image
    #[Vich\UploadableField(mapping: 'events', fileNameProperty: 'picture')]
    #[Assert\Image()]
    private ?File $imageFile = null;

//    propriete permettant de soumettre une image si aucun autre champ n'est renseigné, lors d'une édition par exemple
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeEvent $type_event = null;

    /**
     * @var Collection<int, TakePart>
     */
    #[ORM\OneToMany(targetEntity: TakePart::class, mappedBy: 'event')]
    private Collection $takeParts;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $organiser = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function __construct()
    {
        $this->takeParts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getTypeEvent(): ?TypeEvent
    {
        return $this->type_event;
    }

    public function setTypeEvent(?TypeEvent $type_event): static
    {
        $this->type_event = $type_event;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): static
    {
        $this->imageFile = $imageFile;

        if(null != $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return Collection<int, TakePart>
     */
    public function getTakeParts(): Collection
    {
        return $this->takeParts;
    }

    public function addTakePart(TakePart $takePart): static
    {
        if (!$this->takeParts->contains($takePart)) {
            $this->takeParts->add($takePart);
            $takePart->setEvent($this);
        }

        return $this;
    }

    public function removeTakePart(TakePart $takePart): static
    {
        if ($this->takeParts->removeElement($takePart)) {
            // set the owning side to null (unless already changed)
            if ($takePart->getEvent() === $this) {
                $takePart->setEvent(null);
            }
        }

        return $this;
    }

    public function getOrganiser(): ?user
    {
        return $this->organiser;
    }

    public function setOrganiser(?user $organiser): static
    {
        $this->organiser = $organiser;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

}
