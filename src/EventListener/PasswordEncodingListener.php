<?php

namespace App\EventListener;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use ApiPlatform\Core\EventListener\WriteListener;
use Symfony\Component\EventDispatcher\LegacyEventProxy;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

//use Symfony\Component\Security\Core\User\User;

/**
 * @group userCreate $password
 */
class PasswordEncodingListener {

    public function preWrite() {
        
        $defaultEncoder = new MessageDigestPasswordEncoder('sha512',true,5000);
        $password ='';
        $eventListener = KernelEvents::VIEW => ['password', EventPriorities::PRE_WRITE];
        if ()
        return [
            // KernelEvents::VIEW => ['password', EventPriorities::PRE_WRITE],
            // KernelEvents::VIEW => ['password', EventPriorities::POST_WRITE]
        ];
    }

    // public function EncodePassword(ViewEvent $event): void {
    //     $password = $event->getControllerResult();
    //     $method = $event->getRequest()->getMethod();
    // }
    public function encodingPassword(ViewEvent $defaultEncoder) {
    
        $defaultEncoder = new MessageDigestPasswordEncoder('sha512',true, 5000);

        return 

    }


    

}



