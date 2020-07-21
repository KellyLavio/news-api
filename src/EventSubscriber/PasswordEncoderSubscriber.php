<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class PasswordEncoderSubscriber implements EventSubscriber
{
  public function getSubscribedEvents()
  {
    return [
      Events::prePersist
    ];
  }

  public function prePersist(LifecycleEventArgs $args)
  {
    $object = $args->getObject();

    if ($object instanceof User) {
      $object->setPassword(new PASSWORD_BCRYPT());
    }
  }
}