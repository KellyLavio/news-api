<?php

namespace App\EventSubscriber;

use App\Entity\FavoriteSources;
use App\Entity\Source;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class FavoritesSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $source = $args->getObject();

        if ($source instanceof Source) {
            $favoriteSource = new FavoriteSources;
            $favoriteSource->setSource($source);
            $em = $args->getObjectManager();
            $em->persist($favoriteSource);
        }
    }
}

