<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostImages;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostsController extends AbstractController
{

    #[Route('/api/posts/new_post', name: 'add_post', methods: 'POST')]
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

        // TODO: Реализация загрузки изображений

        return $this->json([
            'message' => 'Пост успешно добавлен',
        ]);
    }

    #[Route('/api/posts/get_all_posts', name: 'get_posts', methods: 'GET')]
    public function get_posts(SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $posts = $entityManager->getRepository(Post::class)->findAll();
        return new Response(
            $serializer->serialize($posts, 'json')
        );
    }

    #[Route('/api/posts/get/{id}', name: 'get_post', methods: 'GET')]
    public function get_post(string $id, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $post = $entityManager->getRepository(Post::class)->findById($id);

        return new Response(
            $serializer->serialize($post, 'json')
        );
    }

    #[Route('/api/posts/get_by_user/', name: 'get_posts_by_user', methods: 'GET')]
    public function get_posts_by_user(SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $post = $entityManager->getRepository(Post::class)->findBy(['author' => $user]);

        return new Response(
            $serializer->serialize($post, 'json')
        );
    }

}
