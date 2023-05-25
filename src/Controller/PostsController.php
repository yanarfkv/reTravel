<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    #[Route('/api/posts', name: 'add_post', methods: 'POST')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();
        $decoded = json_decode($request->getContent());

        $post = new Post();
        $date = new \DateTime();
        $user = $this->getUser();
        $post->setAuthor($user);
        $post->setHeader($decoded->header);
        $post->setText($decoded->text);
        $post->setLocation($decoded->location);
        $post->setDate($date);

        $em->persist($post);
        $em->flush();

        return $this->json([
            'message' => 'Пост успешно добавлен',
        ]);
    }
}
