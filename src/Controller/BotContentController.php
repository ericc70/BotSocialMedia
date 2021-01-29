<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BotContentController extends AbstractController
{
    /**
     * @Route("/bot/content", name="bot_content")
     */
    public function index(): Response
    {
        return $this->render('bot_content/index.html.twig', [
            'controller_name' => 'BotContentController',
        ]);
    }

    public function getAll():Response
    {
         return $this->render('bot_content/list.html.twig', [
            'controller_name' => 'BotContentController',
        ]);
    }
}
