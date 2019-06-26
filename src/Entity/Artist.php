<?php

namespace App\Entity;

use App\Validator\ArtistName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtistRepository")
 * @UniqueEntity("pseudonym",message="Ce pseudonyme existe déjà !!")
 * @ArtistName()
 */
class Artist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Medium", cascade={"persist", "remove"})
     */
    private $photo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $pseudonym;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Show", mappedBy="actors")
     */
    private $showsAsActor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Show", mappedBy="author")
     */
    private $showsAsAuthor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Show", mappedBy="director")
     */
    private $showsAsDirector;


    public function __construct()
    {
        $this->showsAsActor = new ArrayCollection();
        $this->showsAsAuthor = new ArrayCollection();
        $this->showsAsDirector = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhoto(): ?Medium
    {
        return $this->photo;
    }

    public function setPhoto(?Medium $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPseudonym(): ?string
    {
        return $this->pseudonym;
    }

    public function setPseudonym(?string $pseudonym): self
    {
        $this->pseudonym = $pseudonym;

        return $this;
    }

    /**
     * @return Collection|Show[]
     */
    public function getShowsAsActor(): Collection
    {
        return $this->showsAsActor;
    }

    public function addShowsAsActor(Show $showsAsActor): self
    {
        if (!$this->showsAsActor->contains($showsAsActor)) {
            $this->showsAsActor[] = $showsAsActor;
            $showsAsActor->addActor($this);
        }

        return $this;
    }

    public function removeShowsAsActor(Show $showsAsActor): self
    {
        if ($this->showsAsActor->contains($showsAsActor)) {
            $this->showsAsActor->removeElement($showsAsActor);
            $showsAsActor->removeActor($this);
        }

        return $this;
    }

    /**
     * @return Collection|Show[]
     */
    public function getShowsAsAuthor(): Collection
    {
        return $this->showsAsAuthor;
    }

    public function addShowsAsAuthor(Show $showsAsAuthor): self
    {
        if (!$this->showsAsAuthor->contains($showsAsAuthor)) {
            $this->showsAsAuthor[] = $showsAsAuthor;
            $showsAsAuthor->setAuthor($this);
        }

        return $this;
    }

    public function removeShowsAsAuthor(Show $showsAsAuthor): self
    {
        if ($this->showsAsAuthor->contains($showsAsAuthor)) {
            $this->showsAsAuthor->removeElement($showsAsAuthor);
            // set the owning side to null (unless already changed)
            if ($showsAsAuthor->getAuthor() === $this) {
                $showsAsAuthor->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Show[]
     */
    public function getShowsAsDirector(): Collection
    {
        return $this->showsAsDirector;
    }

    public function addShowsAsDirector(Show $showsAsDirector): self
    {
        if (!$this->showsAsDirector->contains($showsAsDirector)) {
            $this->showsAsDirector[] = $showsAsDirector;
            $showsAsDirector->setDirector($this);
        }

        return $this;
    }

    public function removeShowsAsDirector(Show $showsAsDirector): self
    {
        if ($this->showsAsDirector->contains($showsAsDirector)) {
            $this->showsAsDirector->removeElement($showsAsDirector);
            // set the owning side to null (unless already changed)
            if ($showsAsDirector->getDirector() === $this) {
                $showsAsDirector->setDirector(null);
            }
        }

        return $this;
    }

}
