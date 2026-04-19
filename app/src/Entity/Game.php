<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'L\'identifiant RAWG est obligatoire.')]
    #[Assert\Positive(message: 'L\'identifiant RAWG doit être positif.')]
    private ?int $rawgId = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le titre est obligatoire.')]
    #[Assert\Length(
    max: 255,
    maxMessage: 'Le titre ne peut pas dépasser {{ limit }} caractères.'
)]
    private ?string $title = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $backgroundImage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $released = null;

    #[ORM\Column(nullable: true)]
    private ?int $playtime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $platforms = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
    max: 5000,
    maxMessage: 'Le synopsis ne peut pas dépasser {{ limit }} caractères.'
    )]
    private ?string $overview = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
    max: 2000,
    maxMessage: 'Votre description ne peut pas dépasser {{ limit }} caractères.'
    )]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isPlayed = null;

    #[ORM\ManyToOne]
    private ?Genre $genre = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(
    min: 1,
    max: 10,
    notInRangeMessage: 'La note doit être entre {{ min }} et {{ max }}.'
)]
    private ?int $rating = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $trailerUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtubeUrl = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRawgId(): ?int
    {
        return $this->rawgId;
    }

    public function setRawgId(int $rawgId): static
    {
        $this->rawgId = $rawgId;

        return $this;
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

    public function getBackgroundImage(): ?string
    {
        return $this->backgroundImage;
    }

    public function setBackgroundImage(?string $backgroundImage): static
    {
        $this->backgroundImage = $backgroundImage;

        return $this;
    }

    public function getReleased(): ?\DateTime
    {
        return $this->released;
    }

    public function setReleased(?\DateTime $released): static
    {
        $this->released = $released;

        return $this;
    }

    public function getPlaytime(): ?int
    {
        return $this->playtime;
    }

    public function setPlaytime(?int $playtime): static
    {
        $this->playtime = $playtime;

        return $this;
    }

    public function getPlatforms(): ?string
    {
        return $this->platforms;
    }

    public function setPlatforms(?string $platforms): static
    {
        $this->platforms = $platforms;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): static
    {
        $this->overview = $overview;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isPlayed(): ?bool
    {
        return $this->isPlayed;
    }

    public function setIsPlayed(bool $isPlayed): static
    {
        $this->isPlayed = $isPlayed;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getTrailerUrl(): ?string
    {
        return $this->trailerUrl;
    }

    public function setTrailerUrl(?string $trailerUrl): static
    {
        $this->trailerUrl = $trailerUrl;

        return $this;
    }

    public function getYoutubeUrl(): ?string
    {
        return $this->youtubeUrl;
    }

    public function setYoutubeUrl(?string $youtubeUrl): static
    {
        $this->youtubeUrl = $youtubeUrl;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
