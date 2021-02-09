<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UserCompteController extends AbstractController
{
    /**
     * @Route("/user/compte/", name="user_compte")
     */
    public function index(Request $request, EntityManagerInterface $em, ParameterBagInterface $getParams, UserPasswordEncoderInterface $passwordEncoder):Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $passSecuParam = $getParams->get('PASS_SECURITY');
            $passSecuForm = sha1($form->get('pass_security')->getData());
            //     //on verifie le pass security

            if ($passSecuForm != $passSecuParam) {
                throw new HttpException(403, "Bad key security.");
            }

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                    
                )
            );
        //    $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('user_compte/index.html.twig', [
            'controller_name' => 'UserCompteController',
            'form' => $form->createView()
        ]);
    }
}
