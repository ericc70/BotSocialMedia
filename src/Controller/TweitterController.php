<?php

namespace App\Controller;

use App\Service\TwitterApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TweitterController extends AbstractController
{
   protected $tweet;

   public function __construct(TwitterApiService $tweet)
   {
       $this->tweet = $tweet;
   }
   
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
    public function post(): Response

    {
         $this->tweet->post("test message via my application");

        return $this->render('tweitter/index.html.twig', [
            'controller_name' => 'TweitterController',
        ]);
    }

    /**
    * @Route("/twitter-all", name="twitterAll")
    */
    public function getall(): Response
    {
        // dd($tweet->getAlllTweet());
        return $this->render('tweitter/list.html.twig', [
           "tweets" =>$this->tweet->getAlllTweet()
        ]);
    }

     /**
     * @Route("/twitter-one/{idTweet}", name="twitterone")
     */
    public function getOne( int $idTweet): Response
    {
            return $this->render('tweitter/views.html.twig', [
           "tweet" =>$this->tweet->getTweet($idTweet)
        ]);
    }

     /**
     * @Route("/twitter-get-retweets/{idTweet}", name="re-twitterone")
     */
    public function getRetweets( int $idTweet): Response
    {
            return $this->render('tweitter/views.html.twig', [
           "tweet" =>$this->tweet->getRetweets($idTweet)
        ]);
    }

}
