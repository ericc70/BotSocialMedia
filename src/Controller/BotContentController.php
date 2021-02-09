<?php

namespace App\Controller;

use App\Entity\BotContent;
use App\Form\BotContentType;
use App\Form\BotMessageType;
use App\Repository\BotContentRepository;
use App\Service\MastodonApiService;
use App\Service\TwitterApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
     * @Route("/bot/", name="bot_")
     */
class BotContentController extends AbstractController
{
    /**
     * @Route("content", name="content")
     */
    public function index(BotContentRepository $botContent, Request $request,EntityManagerInterface $entityManager ): Response
    {
        $content = new BotContent();
        $form = $this->createForm(BotContentType::class, $content);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($content);
            $entityManager->flush();
            return $this->redirectToRoute('bot_content');
        }
        $random = $botContent->randPost();
        return $this->render('bot_content/index.html.twig', [
            'controller_name' => 'BotContentController',
            'form' => $form->createView(),
            'contents' => $botContent ->findAll(),
            'random' => $random
        ]);
    }

    /**
     *@Route("post", name="post")
     *
     */
    public function postStatus(Request $request, MastodonApiService $servicemamot, TwitterApiService $serviceTwitter){
        $form = $this->createForm(BotMessageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $content = $form->get('message')->getData();
            $check = $form->get('choice_reseau')->getData();
            //
           //si check twitter
           // dd($check);
            foreach ($check as $key => $value){        
                if ($value=='1'){
                    $servicemamot->newPouet(['status'=>$content]);
                }
                if ($value=='2'){
                   $serviceTwitter->post($content);
                }
            }

                
            // si check mamot

           return $this->redirectToRoute("bot_post");
        }

        return $this->render('bot_content/send-post.html.twig', [
            'controller_name' => 'mamot',
            'form' => $form->createView(),
        ]);

    }
   


}
