<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Form\EventoType;
use App\Repository\EventoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\{Response, JsonResponse};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Exception;

#[Route('/evento')]
class EventoController extends AbstractController
{
    #[Route('/', name: 'app_evento_index', methods: ['GET'])]
   public function index(
    EventoRepository $eventoRepository, 
     SerializerInterface $serializer): JsonResponse
    {
        $eventos=$eventoRepository->findAll();
     $result= $serializer->serialize(['eventos'=>$eventos],'json');
       return JsonResponse::fromJsonString($result);
    }
    

    #[Route('/new', name: 'app_evento_new', methods: ['GET','POST'])]
    public function new(Request $request, 
    EventoRepository $eventoRepository, 
    SerializerInterface $serializer): JsonResponse
   {   
        $response=new JsonResponse();
        $eventos = new Evento();
        $form = $this->createForm(EventoType::class, $eventos);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $eventoRepository->save($eventos, true);
            $result= $serializer->serialize(['message'=>"Evento guardado."],'json');
                
        }
        else{
            $result= $serializer->serialize(['message'=>"Datos no válidos."],'json');
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                
        }
        return $response->fromJsonString($result);
    }      


    #[Route('/{id}', name: 'app_evento_show', methods: ['GET'])]
    public function show(Evento $eventos = null,SerializerInterface $serializer): JsonResponse
    {
        $response=new JsonResponse();
        if(empty($eventos)){
            $result= $serializer->serialize(['message'=>"No se encontró el evento solicitado"],'json');
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        else{
            $result = $serializer->serialize(['eventos'=>$eventos],'json');
        } 
        return $response->fromJsonString($result);   
    }

    #[Route('/{id}/edit', name: 'app_evento_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evento $eventos = null, 
    EventoRepository $eventoRepository, SerializerInterface $serializer): JsonResponse
    {
        $response=new JsonResponse();
        if(empty($eventos)){
            $result= $serializer->serialize(['message'=>"El evento no exite."],'json');
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);  
        }
        else{
            $form = $this->createForm(EventoType::class, $eventos);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $eventoRepository->save($eventos, true);
                $result= $serializer->serialize(['message'=>"El evento se ha modificado."],'json');
            }
            else{
                $result= $serializer->serialize(['message'=>"Datos no válidos."],'json');
                $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);  
            }
        } 
        return $response->fromJsonString($result);
    }

    #[Route('/{id}', name: 'app_evento_delete', methods: ['POST'])]
    public function delete(Request $request, Evento $evento, EventoRepository $eventoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evento->getId(), $request->request->get('_token'))) {
            $eventoRepository->remove($evento, true);
        }

        return $this->redirectToRoute('app_evento_index', [], Response::HTTP_SEE_OTHER);
    }

    
}