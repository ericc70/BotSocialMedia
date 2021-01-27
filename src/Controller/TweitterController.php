<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Service\TwitterApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function post(Request $request): Response

    {
         
        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $content= $form->get('message')->getData();
           $this->tweet->post($content);
        }

        return $this->render('tweitter/post.html.twig', [
            'controller_name' => 'TweitterController',
            'form' => $form->createView(),
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
