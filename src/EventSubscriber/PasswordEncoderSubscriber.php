<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoderSubscriber implements EventSubscriber
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $user = $args->getObject();

        if ($user instanceof User) {

            $user->setPassword($this->encoder->encodePassword(
                $user,
                $user->getPassword()
            ));
            // $object->setPassword(new Password($this->encoder->encodePassword()));
        }
    }
}
