<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Form\WelcomMessageType;
use App\Service\TwitterApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
            'myAccount' => $this->tweet->myAccount()
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
            $content = $form->get('message')->getData();
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
            "tweets" => $this->tweet->getUserTweet(),
            "titleController" => "Mes tweets",
            'myAccount' => $this->tweet->myAccount()
        ]);
    }


    /**
     * @Route("/twitter/timeline", name="twitter-timeline" )
     */
    public function getTimeline(): Response
    {
        // dd($tweet->getAlllTweet());
        return $this->render('twitter/list.html.twig', [
            "tweets" => $this->tweet->getUserTweet(),
            "titleController" => "Timeline",
            'myAccount' => $this->tweet->myAccount()
        ]);
    }

    /**
     * @Route("/twitter/t/{idTweet}", name="twitterOne")
     */
    public function getOne(int $idTweet): Response
    {
        return $this->render('twitter/views.html.twig', [
            "tweet" => $this->tweet->getTweet($idTweet)
        ]);
    }

    /**
     * @Route("/twitter/r/{idTweet}", name="twitterGetRetweet")
     */
    public function getRetweets(int $idTweet): Response
    {
        return $this->render('twitter/views.html.twig', [
            "tweet" => $this->tweet->getRetweets($idTweet)
        ]);
    }

    /**
     * @Route("/twitter/mention", name="twitteMntions")
     */
    public function mention(): Response
    {
        return $this->render('twitter/list.html.twig', [
            "tweets" => $this->tweet->getMention(),
            "titleController" => "Mentions",
            'myAccount' => $this->tweet->myAccount()
        ]);
    }



    /**
     * @Route("/twitter/dm", name="twitterGetDm")
     */
    public function getDirectMessage(): Response
    {

        return $this->render('twitter/dm-list.html.twig', [
            "titleController" => "List des direct message",
            "tweets" => $this->tweet->getDirectMessage(),
            'myAccount' => $this->tweet->myAccount()
        ]);
    }

    /**
     * @Route("/twitter/dm/new", name="twitterPostDm")
     */
    public function PostDirectMessage(): Response
    {
        //$idUser  -> get account
        // $message get request
      

        $this->tweet->postDirectMessage("$message", "$idUser");
        return $this->render('twitter/index.html.twig', [
            'controller_name' => 'twitterController',
        ]);
    }
    /**
     * @Route("/twitter/del/dm/{id}", name="twitterDelDm")
     */
    public function DelDirectMessage(int $id, string $route = "twitterGetDm"): Response
    {

        $this->tweet->deleteDirectMessage($id);
        return $this->redirectToRoute($route);
    }

/*---
    Welcome message
*/

    /**
     * @Route("/twitter/welcom-message", name="twitterWelcomeMessag")
     *
     */
    public function WelcomeMessage(Request $request): Response
    {
        //formulaire de creation
        //formulaire
        $form = $this->createForm(WelcomMessageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                
            $message = $form->get('message')->getData();
            $name = $form->get('name')->getData();
                 
            $this->tweet->newWelcomeMessage($name, $message);
            return $this->redirectToRoute('twitterWelcomeMessag');
        }


        return $this->render('twitter/welcome-message.html.twig', [
            'controller_name' => 'twitterController',
            'Wmess' => $this->tweet->getMessagetWelcomeMessage(),
            'WMessrule' => $this->tweet->getMessagetWelcomeMessageRules(),
            'form' => $form->createView(),
        ]);
    }

// /**
//  * @Route("/twitter/welcom-message/{id}", name="twitterWelcomeMessageEdit", requirements={"id" = "\d+"} )
//  */
//     public function editWelcomeMessage(){

//         $this->tweet->putWelcomeMessage("ne sont pas oublier non il ne faut pas", 1356263792292851719);

//     }

    /**
     * @Route("/twitter/welcom-message/rules/new/{id}", name="twitterWelcomeMessagRulesAdd"  ,   requirements={"id" = "\d+"} )
     */
    public function rulesWelcomeMessage($id)
    {

        $this->tweet->rulesWelcomeMessage($id);
        return $this->redirectToRoute('twitterWelcomeMessag');
    }
    /**
     * @Route("/twitter/welcom-message/rules/delete/{id}", name="twitterWelcomeMessagRulesDelete" ,   requirements={"id" = "\d+"}  )
     */

     public function deleteWelcomeMessageRules($id, Request $request, CsrfTokenManagerInterface $csrfTokenManager){

        $submittedToken = new CsrfToken('delete_welcomeMessageRules', $request->query->get('token'));
        if (!$csrfTokenManager->isTokenValid($submittedToken)) {

            return $this->redirectToRoute('denied');
        }

        $this->tweet->deleteWelcomeMessageRules($id);
        return $this->redirectToRoute('twitterWelcomeMessag');
    }
     

  /**
     * @Route("/twitter/welcom-message/delete/{id}", name="twitterWelcomeMessageDelete" ,   requirements={"id" = "\d+"}  )
     */

    public function deleteWelcomeMessage($id, Request $request, CsrfTokenManagerInterface $csrfTokenManager): Response
    {

        //token
        $submittedToken = new CsrfToken('delete_welcomeMessage', $request->query->get('token'));
        if (!$csrfTokenManager->isTokenValid($submittedToken)) {

            return $this->redirectToRoute('denied');
        }

        $this->tweet->deleteWelcomeMessage($id);
        return $this->redirectToRoute('twitterWelcomeMessag');
    }

    public function showUsers($id){

    
        return $this->render('twitter/showUsers.html.twig', [
           
            'TWuser' => $this->tweet->showUsers($id)
           
          
        ]);
    }
}
