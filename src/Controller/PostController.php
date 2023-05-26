<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\PostRepository;
use App\Entity\Post;

class PostController extends AbstractController
{


    #[Route('/post/{id}', name: 'app_post')]
    public function index(PostRepository $postRepository, int $id): Response
    {
    //    $posts = $postRepository->findAll();
        // $posts = $postRepository->findBy(['id' => 1, 'type' => 'opinion']);
        $posts = $postRepository->findOneBy(['id' => 1, 'type' => 'opinion']);
    
        return $this->render('post/index.html.twig', [
           'posts' => $posts,
        ]);
    }
}
