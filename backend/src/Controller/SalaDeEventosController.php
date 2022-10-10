<?php

namespace App\Controller;

use App\Entity\SalaDeEventos;
use App\Form\SalaDeEventosType;
use App\Repository\SalaDeEventosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\{Response,JsonResponse};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Exception;

#[Route('/sala/de/eventos')]
class SalaDeEventosController extends AbstractController
{
    #[Route('/', name: 'app_sala_de_eventos_index', methods: ['GET'])]
    public function index(SalaDeEventosRepository $salaDeEventosRepository): Response
    {
        return $this->render('sala_de_eventos/index.html.twig', [
            'sala_de_eventos' => $salaDeEventosRepository->findAll(),
        ]);
    }

    /**
     * Tarea: Función crearSalaDeEventos
     * Nombre: Carlos Josué Argueta Alvarado
     * Carnet: AA20099
     * Fecha de Aprobación: 10/10/2022
     * Revisión: Andrea Melissa Monterrosa Morales
     */
    #[Route('/new', name: 'app_sala_de_eventos_new', methods: ['POST'])]
    public function new(Request $request, 
    SalaDeEventosRepository $salaDeEventosRepository,
    SerializerInterface $serializer): JsonResponse
    {   $response=new JsonResponse();
        $salaDeEvento = new SalaDeEventos();
        $form = $this->createForm(SalaDeEventosType::class, $salaDeEvento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{

                $salaDeEventosRepository->save($salaDeEvento, true);//para guardar en base de datos
                $result= $serializer->serialize(['message'=>"Sala de Eventos Guardada."],'json');
                return $response->fromJsonString($result);

            }catch(Exception $e){
                $result= $serializer->serialize(['message'=>"Datos no válidos."],'json');
                $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                return $response->fromJsonString($result);
            }

        }      

    }

    #[Route('/{id}', name: 'app_sala_de_eventos_show', methods: ['GET'])]
    public function show(SalaDeEventos $salaDeEvento): Response
    {
        
        return $this->render('sala_de_eventos/show.html.twig', [
            'sala_de_evento' => $salaDeEvento,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sala_de_eventos_edit', methods: ['GET','POST'])]
    public function edit(Request $request, SalaDeEventos $salaDeEvento, SalaDeEventosRepository $salaDeEventosRepository, SerializerInterface $serializer): JsonResponse
    {
        $response=new JsonResponse();
        //$salaDeEvento = new SalaDeEventos();

        $form = $this->createForm(SalaDeEventosType::class, $salaDeEvento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $salaDeEventosRepository->save($salaDeEvento, true);
            
            $result= $serializer->serialize(['message'=>"Sala de Eventos sobreescrita."],'json');
            return $response->fromJsonString($result);
            
        }
        else{
            $result= $serializer->serialize(['message'=>"Datos no válidos."],'json');
                $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                return $response->fromJsonString($result);
        }
        else{

            $result= $serializer->serialize(['message'=>"Datos no válidos."],'json');
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            return $response->fromJsonString($result);
        }

        /*return $this->renderForm('sala_de_eventos/edit.html.twig', [
            'sala_de_evento' => $salaDeEvento,
            'form' => $form,
        ]);*/
    }

    #[Route('/{id}', name: 'app_sala_de_eventos_delete', methods: ['POST'])]
    public function delete(Request $request, SalaDeEventos $salaDeEvento, SalaDeEventosRepository $salaDeEventosRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salaDeEvento->getId(), $request->request->get('_token'))) {
            $salaDeEventosRepository->remove($salaDeEvento, true);
        }

        return $this->redirectToRoute('app_sala_de_eventos_index', [], Response::HTTP_SEE_OTHER);
    }
}
