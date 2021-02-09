<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Service\MastodonApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


    /**
     * @Route("/mamot/", name="mamot-")
     */

class MamotController extends AbstractController
{
   protected $mamot;
   
   public function __construct(MastodonApiService $mamot){
       $this->mamot = $mamot;
    }
/**
 * @Route("timeline", name="timeline")
 *
 * @return response
 */
    public function getPublicTimeline()
    {
        return $this->render('mamot/list.html.twig', [
            'titleController' => 'Timeline',
            'pouets' => $this->mamot->getPublicTimeline(),
             'myAccount' => $this->mamot->getAccount(),
        ]);
    }
  
  /**
 * @Route("timeline-home", name="timeline-home")
 *
 * @return response
 */
    public function getHomeTimeline()
    {
        return $this->render('mamot/list.html.twig', [
            'titleController' => 'Home Timeline',
            'pouets' => $this->mamot->getHomeTimeline(),
            'myAccount' => $this->mamot->getAccount(),
        ]);
    }
  
  
    /**
     * @Route("/search", name="search")
     */
    public function search(): Response
    {
        $this->mamot->serach(['q'=>'medium']);
        return $this->render('mamot/search.html.twig', [
            'controller_name' => 'MamotController',
        ]);
    }
    
     /**
     * @Route("status", name="status")
     */
    public function postStatus(Request $request):response{

      $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $content = $form->get('message')->getData();
           //
            $this->mamot->newPouet(['status'=>$content]);
            $form = $this->createForm(MessageType::class);
        }

        return $this->render('mamot/post.html.twig', [
            'controller_name' => 'mamot',
            'form' => $form->createView(),
        ]);


        }

     /**
     * @Route("pouet/v/{id}", name="pouet-id")
     */
        public function getPouetId(int $id):Response{
            return $this->render('mamot/shows.html.twig', [
                'controller_name' => 'mamot',
                'pouet' => $this->mamot->getPouetId($id),
            ]);
    
        }

     /**
     * @Route("pouet/del/{id}", name="del-pouet-id")
     */
        public function deletePouet(int $id):Response{
       
            $this->mamot->deletePouet($id);
            return $this->redirectToRoute("mamot-timeline-home");     
    
        }

}
