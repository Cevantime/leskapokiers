<?php

// src/Service/FileUploader.php

namespace App\Service;

use App\Entity\Medium;
use App\Entity\Video;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaManager
{

    /**
     * @var PhedManager
     */
    private $phedManager;


    public function __construct(PhedManager $phedManager)
    {
        $this->phedManager = $phedManager;
    }

    public function createThumbnailForMedium(Medium $medium)
    {
        return $this->createImageThumbnail($medium);
    }


    public function createImageThumbnail(Medium $medium)
    {
        $source = $medium->getSource();
        $size = getimagesize($source);
        $medium->setWidth($size[0]);
        $medium->setHeight($size[1]);
        return $medium->getSource();
    }

}
