<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UpdateFavoriteFormType;
use App\Form\UpdateFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilPageController extends AbstractController
{
    /**
     * @Route("/api/profil", name="profil_page")
     */
    public function getProfil()
    {
        $user = $this->getUser();

        if ($user !== null && $user instanceof User) {
            return $this->json([
                'name' => $user->getName(),
                'firstname' => $user->getFirstname(),
                'login' => $user->getLogin(),
                'email' => $user->getEmail(),
                'favorites' => $user->getFavorites()
            ]);
        } else {
            return "Une erreur est survenue.";
        }
    }

    /**
     * @Route("api/updateProfil", name="update_profil")
     */
    public function updateProfil(Request $request, EntityManagerInterface $entity)
    {
        $user = $this->getUser();
        $content = json_decode($request->getContent(), true);

        if ($user !== null && $user instanceof User) {
            $form = $this->createForm(UpdateFormType::class, $user);
            $form->submit($content, false);
            if ($form->isValid()) {
                $entity->flush();
            } else {
                return new Response("Une erreur est survenue.");
            }

            return new Response("Vos informations ont été modifiées.");
        } else {
            return new Response("Une erreur est survenue.");
        }
    }

    /**
     * @Route("api/updateFavorites", name="update_favorites")
     */
    public function updateFavorites(Request $request, EntityManagerInterface $entity)
    {
        $user = $this->getUser();
        $content = json_decode($request->getContent(), true);

        foreach ($content['favorites'] as $favoris) {
             if ($user !== null && $user instanceof User) {
            $form = $this->createForm(UpdateFavoriteFormType::class, $user);
            $form->submit($favoris, false);
            
            if ($form->isValid()) {
                $entity-flush();
            } else {
                return new Response("Une erreur est survenue.");
            }
            return new Response("Vos informations ont été modifiées.");
        } else {
            return new Response("Une erreur est survenue.");
        }
        }

       
    }
}
