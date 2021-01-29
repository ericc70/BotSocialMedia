<?php

namespace App\Command;

use DateTime;
use App\Entity\LogBotPost;
use App\Service\TwitterApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BotPostCommand extends Command
{
    protected static $defaultName = 'bot:post';

    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager, TwitterApiService $twitterApiService)
    {
        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;
        $this->twitterApiService = $twitterApiService;
        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Post des tweets')
      
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
       

        $em = $this->entityManager;
        
                      // A. Access repositories
        $repo = $em->getRepository("App:BotContent");
        // B. doctrine
            //count le nbre entree
            
        $reponse = $repo->randPost();
            //suprresion
         $idpost =$reponse['id'];
        $textPost = $reponse['texte'];
       // on post le tweet
     
       $this->twitterApiService->post($textPost);
     
        // //Log connection
        // $action ="Supression des mails reçus";
        $rep = $repo->findOneBy(['id' => $idpost]);
        dump($rep);
        $log = new LogBotPost;
        $log->setTexte($rep);
        // $log->setOperation($action);
        $log->setTimestamp(new DateTime());

        $em->persist($log);
                
        $em->flush();



        return Command::SUCCESS;
    }
}
