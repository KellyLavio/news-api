<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Component\getSubscribedEvents;


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
      // $object->setPassword(new EncodedPassword());
        $object->setPassword($this->encoder->encodePassword());
    //   $object->setPassword(new Password($this->encoder->encodePassword()))
    }
  }
}