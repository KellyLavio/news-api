<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;

class CurrentUser
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke()
    {
        return $this->security->getUser();
    }
}