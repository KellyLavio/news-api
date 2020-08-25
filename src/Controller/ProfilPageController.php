<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilPageController extends AbstractController
{
    /**
     * @Route("/api/profil", name="profil_page", methods={"GET", "POST"})
     */
    public function getProfil()
    {
        $user = $this->getUser();

        if ($user !== null && $user instanceof User) {
            return $this->json([
                'name' => $user->getName(),
                'firstname' => $user->getFirstname(),
                'login' => $user->getLogin(),
                'email' => $user->getEmail()
            ]);
        }
    }
}
