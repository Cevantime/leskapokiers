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
class ArtistCollectionTransformer implements DataTransformerInterface
{
    private $artistRepo;
    
    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepo = $artistRepository;
    }

    public function reverseTransform($artistPseudonym)
    {
        $artistsExploded = array_unique(explode(',', $artistPseudonym));
        $artistPseudonym = new ArrayCollection();
        foreach ($artistsExploded as $artistEl) {
            $artistEl = trim($artistEl);
            if( ! $artistEl) {
                break;
            }
            $artist = $this->artistRepo->getCorrespondingArtist($artistEl);
            $artistPseudonym->add($artist);
        }
        return $artistPseudonym;
    }

    public function transform($tags)
    {
        return implode(',', array_map(function($tag) {
            return $tag->getPseudonym();
        }, $tags->toArray()));
    }

}
