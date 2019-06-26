<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 20/03/19
 * Time: 22:06
 */

namespace App\EventSubscriber;


use App\Entity\Medium;
use App\Service\MediaManager;
use App\Service\PhedManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediumListener
{

    /**
     * @var PhedManager
     */
    private $phedManager;

    /**
     * @var MediaManager
     */
    private $mediaManager;

    /**
     * MediumListener constructor.
     * @param PhedManager $phedManager
     * @param MediaManager $mediaManager
     */
    public function __construct(PhedManager $phedManager, MediaManager $mediaManager)
    {
        $this->phedManager = $phedManager;
        $this->mediaManager = $mediaManager;
    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        $this->preSave($event);
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $this->preSave($event);
    }

    public function preSave(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if (!($entity instanceof Medium)) {
            return;
        }

        if (!$entity->getSource() && !$entity->getUploaded()) {
            return;
        }

        if ( ! $entity->getSource() && $entity->getUploaded() instanceof UploadedFile) {
            $result = $this->phedManager->sendUploadedFile($entity->getUploaded(), $entity->getDirectoryTarget());
            $entity->setSource($result->data->url);
            $entity->setApiId($result->data->id);
            $entity->setMimeType($result->data->type ?? null);
        }

        $entity->setThumbnail($this->mediaManager->createThumbnailForMedium($entity));
    }
}