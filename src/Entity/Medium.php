<?php

// src/Entity/ContactInfos.php

namespace App\Entity;

use App\Repository\MediumRepository;
use App\Upload\PhedUploadable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MediumRepository")
 */
class Medium
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $source;

    /**
     * @ORM\Column(type="string")
     */
    private $thumbnail;

    /**
     *
     * @var string
     */
    private $directoryTarget;

    /**
     * @var integer
     * @ORM\Column(type="string", nullable=true)
     */
    private $apiId;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $mimeType;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $width;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $height;

    private $uploaded;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Show", mappedBy="images")
     */
    private $shows;

    public function __construct()
    {
        $this->shows = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($mediaName)
    {
        $this->source = $mediaName;

        return $this;
    }
    
    public function getDirectoryTarget()
    {
        return $this->directoryTarget;
    }

    public function setDirectoryTarget($directoryTarget)
    {
        $this->directoryTarget = $directoryTarget;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param mixed $thumbnail
     * @return Medium
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
     * @return int
     */
    public function getApiId():? int
    {
        return $this->apiId;
    }

    /**
     * @param int $apiId
     */
    public function setApiId(?int $apiId): void
    {
        $this->apiId = $apiId;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUploaded()
    {
        return $this->uploaded;
    }

    /**
     * @param mixed $uploaded
     */
    public function setUploaded($uploaded): self
    {
        $this->uploaded = $uploaded;
        return $this;
    }

    /**
     * @return Collection|Show[]
     */
    public function getShows(): Collection
    {
        return $this->shows;
    }

    public function addShow(Show $show): self
    {
        if (!$this->shows->contains($show)) {
            $this->shows[] = $show;
            $show->addImage($this);
        }

        return $this;
    }

    public function removeShow(Show $show): self
    {
        if ($this->shows->contains($show)) {
            $this->shows->removeElement($show);
            $show->removeImage($this);
        }

        return $this;
    }
}
