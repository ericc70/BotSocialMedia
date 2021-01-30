<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Service\TwitterApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwitterController extends AbstractController
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
        return $this->render('twitter/index.html.twig', [
            'controller_name' => 'twitterController',
        ]);
    }
    
    /**
     * @Route("/twitter/new", name="twitterPost")
     */
    public function post(Request $request): Response

    {
         
        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $content= $form->get('message')->getData();
           $this->tweet->post($content);
           $form = $this->createForm(MessageType::class);
              }

        return $this->render('twitter/post.html.twig', [
            'controller_name' => 'twitterController',
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/twitter/my-tweets", name="twitter-mes-tweets" )
    */
    public function getall(): Response
    {
        // dd($tweet->getAlllTweet());
        return $this->render('twitter/list.html.twig', [
           "tweets" =>$this->tweet->getUserTweet(),
           "titleController" =>"Mes tweets"
        ]);
    }


        /**
    * @Route("/twitter/timeline", name="twitter-timeline" )
    */
    public function getTimeline(): Response
    {
        // dd($tweet->getAlllTweet());
        return $this->render('twitter/list.html.twig', [
           "tweets" =>$this->tweet->getUserTweet(),
           "titleController" =>"Timeline"
        ]);
    }

     /**
     * @Route("/twitter/t/{idTweet}", name="twitterOne")
     */
    public function getOne( int $idTweet): Response
    {
            return $this->render('twitter/views.html.twig', [
           "tweet" =>$this->tweet->getTweet($idTweet)
        ]);
    }

     /**
     * @Route("/twitter/r/{idTweet}", name="twitterGetRetweet")
     */
    public function getRetweets( int $idTweet): Response
    {
            return $this->render('twitter/views.html.twig', [
           "tweet" =>$this->tweet->getRetweets($idTweet)
        ]);
    }

        /**
     * @Route("/twitter/mention", name="twitteMntions")
     */
    public function mention(): Response
    {
        return $this->render('twitter/list.html.twig', [
            "tweets" =>$this->tweet->getMention(),
            "titleController" =>"Mentions"
         ]);
    }

    

    /**
     * @Route("/twitter/dm", name="twitterGetDm")
     */
    public function getDirectMessage(): Response
    {   
        
        return $this->render('twitter/dm-list.html.twig', [
            "titleController" =>"List des direct message",
            "tweets" =>$this->tweet->getDirectMessage()
        ]);
    }
  
    /**
     * @Route("/twitter/dm/new", name="twitterPostDm")
     */
    public function PostDirectMessage(): Response
    {

        $message="dur dur la vie de devleloopeur";
        $idUser="716615506669789187";
        $this->tweet->postDirectMessage("$message", "$idUser");
        return $this->render('twitter/index.html.twig', [
            'controller_name' => 'twitterController',
        ]);
    }
    /**
     * @Route("/twitter/del/dm/{id}", name="twitterDelDm")
     */
    public function DelDirectMessage(int $id, string $route="twitterGetDm"): Response
    {
                
        $this->tweet->deleteDirectMessage($id);
        return $this->redirectToRoute($route);
     
    }


    /**
     * @Route("/twitter/welcom-message/new", name="twitterPostWelcomeMessage")
     */
    public function newWelcomeMessage(): Response
    {
//formulaire
        $name="teste lol";
        // $idUser="13539855021778493454";
        $message="Si tu le reves, tu peux le faire !";
        $this->tweet->newWelcomeMessage($name,$message);
        return $this->render('twitter/index.html.twig', [
            'controller_name' => 'twitterController',
        ]);
    }
        /**
     * @Route("/twitter/welcom-message", name="twitterWelcomeMessag")
     */
    public function getWelcomeMessage()
    {
        
        
        $this->tweet->getMessagetWelcomeMessage();
        return $this->render('twitter/index.html.twig', [
            'controller_name' => 'twitterController',
        ]);
    }


}
