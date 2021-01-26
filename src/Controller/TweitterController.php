<?php

namespace App\Controller;

use App\Service\TwitterApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TweitterController extends AbstractController
{
    /**
     * @Route("/tweitter", name="tweitter")
     */
    public function index(): Response
    {
        return $this->render('tweitter/index.html.twig', [
            'controller_name' => 'TweitterController',
        ]);
    }
    /**
     * @Route("/twitter-post", name="tweitterPost")
     */
    public function post(TwitterApiService $tweet): Response

    {
         $tweet->post("test message via my application");

        return $this->render('tweitter/index.html.twig', [
            'controller_name' => 'TweitterController',
        ]);
    }

       /**
     * @Route("/twitter-all", name="twitterAll")
     */
    public function getall(TwitterApiService $tweet): Response

    {
        // dd($tweet->getAlllTweet());

        return $this->render('tweitter/list.html.twig', [
           "tweets" =>$tweet->getAlllTweet()
        ]);
    }
       /**
     * @Route("/twitter-one/{idTweet}", name="twitterone")
     */
    public function getOne(TwitterApiService $tweet, int $idTweet): Response

    {
      
        

        return $this->render('tweitter/list.html.twig', [
           "tweets" =>$tweet->getTweet($idTweet)
        ]);
    }
}
