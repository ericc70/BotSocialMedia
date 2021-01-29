<?php

namespace App\Controller;

use App\Entity\BotContent;
use App\Form\BotContentType;
use App\Repository\BotContentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BotContentController extends AbstractController
{
    /**
     * @Route("/bot/content", name="bot_content")
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

        return $this->render('bot_content/index.html.twig', [
            'controller_name' => 'BotContentController',
            'form' => $form->createView(),
            'contents' => $botContent ->findAll()
        ]);
    }

   


}
