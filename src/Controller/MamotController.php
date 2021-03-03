<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Service\MastodonApiService;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

/**
 * @Route("/mamot/", name="mamot-")
 */

class MamotController extends AbstractController
{
    protected $mamot;

    public function __construct(MastodonApiService $mamot)
    {
        $this->mamot = $mamot;
    }

    /**
     * @Route("", name="index")
     *
     * @return response
     */
    public function index()
    {
        return $this->render('mamot/index.html.twig', [

            'myAccount' => $this->mamot->getAccount(),
        ]);
    }

    /**
     * @Route("timeline", name="timeline")
     *
     * @return response
     */
    public function getPublicTimeline(Request $request, $local = false): Response
    {
        $local = ($request->query->get('local') == 1) ? true : false;

        $homeTimeline = ($request->query->get('home') == 1) ? true : false;
        if ($homeTimeline == true) {
            $pouets = $this->mamot->getHomeTimeline();
        } else {
            $pouets = $this->mamot->getPublicTimeline([
                'local' => $local

            ]);
        }

        return $this->render('mamot/list.html.twig', [
            'titleController' => 'Timeline',
            'pouets' => $pouets,
            'myAccount' => $this->mamot->getAccount(),
        ]);
    }



    /**
     * @Route("/search", name="search")
     */
    public function search(): Response
    {
        $this->mamot->serach(['q' => 'medium']);
        return $this->render('mamot/search.html.twig', [
            'controller_name' => 'MamotController',
        ]);
    }

    /**
     * @Route("status", name="status")
     */
    public function postStatus(Request $request): response
    {

        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $content = $form->get('message')->getData();
            //
            $this->mamot->newPouet(['status' => $content]);
            $form = $this->createForm(MessageType::class);
        }

        return $this->render('mamot/post.html.twig', [
            'controller_name' => 'mamot',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Voir un staus en detail
     * @Route("pouet/v/{id}", name="pouet-id")
     */
    public function getPouetId(int $id): Response
    {
        return $this->render('mamot/shows.html.twig', [
            'controller_name' => 'mamot',
            'pouet' => $this->mamot->getPouetId($id),
        ]);
    }

    /**
     * @Route("pouet/del/{id}", name="del-pouet-id" , requirements={"id" = "\d+"} )
     */
    public function deletePouet(int $id, Request $request, CsrfTokenManagerInterface $csrfTokenManager): Response
    {

          //token
          $submittedToken = new CsrfToken('delete_pouett', $request->query->get('token'));
          if (!$csrfTokenManager->isTokenValid($submittedToken)) {
  
              return $this->redirectToRoute('denied');
          }
         
        $this->mamot->deletePouet($id);
        return $this->redirectToRoute("mamot-timeline");
    }

    /**
     * Voir un staus en detail
     * @Route("conversation", name="conversation" )
     */
    public function getShowConversation()
    {
        
        return $this->render('mamot/conversation.html.twig', [
            'controller_name' => 'mamot',
            'conversations' => $this->mamot->getShowConversation(),
        ]);
    }
    
    /**
     * return les notifications
     * @Route("notification", name="notification" )
     */
    public function getNotifications()
    {
      
        return $this->render('mamot/notification.html.twig', [
            'controller_name' => 'mamot',
            'notifications' => $this->mamot->getNotifications(),
        ]);
    }

    /**
     * @Route("conversation/del/{id}", name="del-conversation-id" , requirements={"id" = "\d+"} )
     */
    public function delConversation(int $id, Request $request, CsrfTokenManagerInterface $csrfTokenManager): Response
    {

             //token
             $submittedToken = new CsrfToken('delete_conversation', $request->query->get('token'));
             if (!$csrfTokenManager->isTokenValid($submittedToken)) {
     
                 return $this->redirectToRoute('denied');
             }
            
           $this->mamot->delConverstation($id);
           return $this->redirectToRoute("mamot-conversation");
    }

    /**
     * Voir un staus en detail
     * @Route("pouet/f/{id}", name="pouet-f-id")
     */
    public function getPouetFil(int $id): Response
    {

        $filArray = [];
        $fil = $this->mamot->getPouetId($id);
        array_push($filArray, $fil);
        loop:
        if ($fil['in_reply_to_id'] != null) {

            $fil = $this->mamot->getPouetId($fil['in_reply_to_id']);
            array_push($filArray, $fil);
            goto loop;
        }

        return $this->render('mamot/fils.html.twig', [
            'controller_name' => 'mamot',
            'pouets' => $filArray

        ]);
    }
}
