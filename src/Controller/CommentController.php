<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/api/comment", name="comment")
     */
    public function addComment(Request $request, EntityManagerInterface $entity)
    {
        $user = $this->getUser();
        $content = json_decode($request->getContent(),true);

        if ($user !== null && $user instanceof User) {
            $form = $this->createForm(CommentType::class, $user);
            $form->submit($content,false);

            if ($form->isValid()) {
                $entity->flush();
            }

            return new Response("OK");
        } else {
            return "Une erreur est survenue";
        }
    }
}
