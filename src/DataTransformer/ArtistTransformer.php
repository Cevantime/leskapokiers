<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DataTransformer;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Description of TagTransformer
 *
 * @author cevantime
 */
class ArtistTransformer implements DataTransformerInterface
{
    private $artistRepo;

    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepo = $artistRepository;
    }

    public function reverseTransform($artistPseudonym)
    {
        $artistPseudonym = trim($artistPseudonym);
        if (!$artistPseudonym) {
            return null;
        }
        $artist = $this->artistRepo->getCorrespondingArtist($artistPseudonym);

        return $artist;
    }

    public function transform($artist)
    {
        if(!$artist) {
            return null;
        }
        return $artist->getPseudonym();
    }

}
