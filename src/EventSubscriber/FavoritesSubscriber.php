<?php

namespace App\EventSubscriber;

use App\Entity\Category;
use App\Entity\FavoriteCategories;
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
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $data = $args->getObject();

        if ($data instanceof Source) {
            $favoriteSource = new FavoriteSources();
            $data->setFavorite($favoriteSource);
        }

        if ($data instanceof Category) {
            $favoriteCategory = new FavoriteCategories();
            $data->setFavorite($favoriteCategory);
        }
    }
}

