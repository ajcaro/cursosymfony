<?php

namespace App\Controller;



use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\PostType;
use App\Repository\PostRepository;
use App\Entity\Post;
use App\Entity\User;

class PostController extends AbstractController
{


    #[Route('/', name: 'app_post')]
    public function index(PostRepository $postRepository, UserRepository $userRepo, Request    $request): Response
    {
        //    $posts = $postRepository->findAll();
        // $posts = $postRepository->findBy(['id' => 1, 'type' => 'opinion']);
//        $posts = $postRepository->findOneBy(['id' => 1, 'type' => 'opinion']);
//        $customPost = $postRepository->findPost($id);

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()){
            $post->setUser($userRepo->find(1));
            $postRepository->save($post, true);

            return $this->redirectToRoute('app_post');
        }

        return $this->render('post/index.html.twig', [
            'formulario' => $form
        ]);
    }

    #[Route('/insert/post', name: 'insert_post')]
    public function insert(UserRepository $userRepository, PostRepository $postRepository)
    {

        $user = $userRepository->find(1);


        $post = new Post('mi post insertado', 'opinion', 'Hola Mundo', 'mifichero', 'www.url.com');
        $post->setUser($user);
        $postRepository->save($post, true);

        return new Response('Saved new post with id ' . $post->getId());

    }

    #[Route('/update/post', name: 'insert_post')]
    public function update(PostRepository $postRepository)
    {

        $post = $postRepository->find(4);
        $post->setDescription("Este el cuarto POST, UPDATADOO!!");
        $postRepository->save($post, true);

        return new Response('Saved new post with id ' . $post->getId());

    }

    #[Route('/remove/post', name: 'insert_post')]
    public function remove(PostRepository $postRepository)
    {

        $post = $postRepository->find(4);
        $postRepository->remove($post, true);

        return new Response('deleted new post');

    }
}
