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
     * @Route("/twitter", name="twitter")
     */
    public function index(): Response
    {
        return $this->render('tweitter/index.html.twig', [
            'controller_name' => 'TweitterController',
        ]);
    }
    
    /**
     * @Route("/twitter-post", name="twitterPost")
     */
    public function post(Request $request): Response

    {
         
        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $content= $form->get('message')->getData();
           $this->tweet->post($content);
           unset($form);        }

        return $this->render('tweitter/post.html.twig', [
            'controller_name' => 'TweitterController',
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/twitter-mes-tweets", name="twitter-mes-tweets" )
    */
    public function getall(): Response
    {
        // dd($tweet->getAlllTweet());
        return $this->render('tweitter/list.html.twig', [
           "tweets" =>$this->tweet->getUserTweet(),
           "titleController" =>"Mes tweets"
        ]);
    }


        /**
    * @Route("/twitter-timeline", name="twitter-timeline" )
    */
    public function getTimeline(): Response
    {
        // dd($tweet->getAlllTweet());
        return $this->render('tweitter/list.html.twig', [
           "tweets" =>$this->tweet->getUserTweet(),
           "titleController" =>"Timeline"
        ]);
    }

     /**
     * @Route("/twitter-one/{idTweet}", name="twitterOne")
     */
    public function getOne( int $idTweet): Response
    {
            return $this->render('tweitter/views.html.twig', [
           "tweet" =>$this->tweet->getTweet($idTweet)
        ]);
    }

     /**
     * @Route("/twitter-get-retweets/{idTweet}", name="twitterGetRetweet")
     */
    public function getRetweets( int $idTweet): Response
    {
            return $this->render('tweitter/views.html.twig', [
           "tweet" =>$this->tweet->getRetweets($idTweet)
        ]);
    }

        /**
     * @Route("/twitter-mention", name="twitteMntions")
     */
    public function mention(): Response
    {
        return $this->render('tweitter/list.html.twig', [
            "tweets" =>$this->tweet->getMention(),
            "titleController" =>"Mentions"
         ]);
    }

    

    /**
     * @Route("/twitter-get-dm", name="twitterGetDm")
     */
    public function getDirectMessage(): Response
    {$this->tweet->getDirectMessage();
        return $this->render('tweitter/dm-list.html.twig', [
            'controller_name' => 'TweitterController',
        ]);
    }
    /**
     * @Route("/twitter-post-dmw", name="twitterPostDmWelcome")
     */
    public function newDirectMessageW(): Response
    {

        $message="sdqsdqsdqs sdqsdqsdsd";
        // $idUser="13539855021778493454";
        $idUser="716615506669789187";
        $this->tweet->newDirectMessageW("$message", "$idUser");
        return $this->render('tweitter/index.html.twig', [
            'controller_name' => 'TweitterController',
        ]);
    }
    /**
     * @Route("/twitter-post-dm", name="twitterPostDm")
     */
    public function PostDirectMessage(): Response
    {

        $message="dur dur la vie de devleloopeur";
        $idUser="716615506669789187";
        $this->tweet->postDirectMessage("$message", "$idUser");
        return $this->render('tweitter/index.html.twig', [
            'controller_name' => 'TweitterController',
        ]);
    }
    /**
     * @Route("/twitter-del-dm", name="twitterDelDm")
     */
    public function DelDirectMessage(int $id, string $route="twitterGetDm"): Response
    {
                
        $this->tweet->deleteDirectMessage($id);
        return $this->redirectToRoute($route);
     
    }


    
}
