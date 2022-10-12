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
   // public function index(
       // EventoRepository $eventoRepository, 
       // SerializerInterface $serializer): JsonResponse
    //{
      //  $eventos=$eventoRepository->findAll();
       // $result= $serializer->serialize(['eventos'=>$eventos],'json');
       // return JsonResponse::fromJsonString($result);
    //}
    public function index(EventoRepository $eventoRepository): Response
    {
        return $this->render('evento/index.html.twig', [
            'eventos' => $eventoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_evento_new', methods: ['POST'])]
    public function new(Request $request, Evento $eventos, EventoRepository $eventoRepository, SerializerInterface $serializer): JsonResponse
   
    {   $response=new JsonResponse();
        
        $form = $this->createForm(EventoType::class, $eventos);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           try{

                $eventoRepository->save($eventos, true);
                $result= $serializer->serialize(['message'=>"Evento guardado."],'json');
                return $response->fromJsonString($result);

            }catch(Exception $e){
                $result= $serializer->serialize(['message'=>"Datos no válidos."],'json');
                $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                return $response->fromJsonString($result);
            }

        }      

    }

    #[Route('/{id}', name: 'app_evento_show', methods: ['GET'])]
    public function show(Evento $evento): Response
    {
        $response=new JsonResponse();
        return $this->render('evento/show.html.twig', [
            'evento' => $evento,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evento_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evento $eventos, EventoRepository $eventoRepository, SerializerInterface $serializer): JsonResponse
    {
        $response=new JsonResponse();

        $form = $this->createForm(EventoType::class, $eventos);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{

            $eventoRepository->save($eventos, true);
            $result= $serializer->serialize(['message'=>"Evento actualizado"],'json');
            
            return $response->fromJsonString($result);
            
        }catch(Exception $e){
                $result= $serializer->serialize(['message'=>"Datos no validos."],'json');
                $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                
                return $response->fromJsonString($result);
            }
        }
        else{

            $result= $serializer->serialize(['message'=>"Datos invalidos."],'json');
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            return $response->fromJsonString($result);
        }
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