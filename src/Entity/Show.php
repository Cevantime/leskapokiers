<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShowRepository")
 * @ORM\Table(name="spectacles")
 */
class Show
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $creationDate;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Medium", inversedBy="shows", cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $summary;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Medium", cascade={"persist", "remove"})
     */
    private $presskit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tape;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $critics;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $rewards;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Medium", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bigImage;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Medium", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $smallImage;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Artist", inversedBy="showsAsActor", cascade={"persist"})
     * @ORM\JoinTable(name="show_actor")
     */
    private $actors;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artist", inversedBy="showsAsAuthor", cascade={"persist"})
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artist", inversedBy="showsAsDirector", cascade={"persist"})
     */
    private $director;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->actors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(?\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return Collection|Medium[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Medium $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
        }

        return $this;
    }

    public function removeImage(Medium $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getPresskit(): ?Medium
    {
        return $this->presskit;
    }

    public function setPresskit(?Medium $presskit): self
    {
        $this->presskit = $presskit;

        return $this;
    }

    public function getTape(): ?string
    {
        return $this->tape;
    }

    public function setTape(?string $tape): self
    {
        $this->tape = $tape;

        return $this;
    }

    public function getCritics(): ?string
    {
        return $this->critics;
    }

    public function setCritics(?string $critics): self
    {
        $this->critics = $critics;

        return $this;
    }

    public function getRewards(): ?string
    {
        return $this->rewards;
    }

    public function setRewards(?string $rewards): self
    {
        $this->rewards = $rewards;

        return $this;
    }

    public function getBigImage(): ?Medium
    {
        return $this->bigImage;
    }

    public function setBigImage(Medium $bigImage): self
    {
        $this->bigImage = $bigImage;

        return $this;
    }

    public function getSmallImage(): ?Medium
    {
        return $this->smallImage;
    }

    public function setSmallImage(Medium $smallImage): self
    {
        $this->smallImage = $smallImage;

        return $this;
    }

    /**
     * @return Collection|Artist[]
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Artist $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors[] = $actor;
        }

        return $this;
    }

    public function removeActor(Artist $actor): self
    {
        if ($this->actors->contains($actor)) {
            $this->actors->removeElement($actor);
        }

        return $this;
    }

    public function getAuthor(): ?Artist
    {
        return $this->author;
    }

    public function setAuthor(?Artist $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDirector(): ?Artist
    {
        return $this->director;
    }

    public function setDirector(?Artist $director): self
    {
        $this->director = $director;

        return $this;
    }
}
