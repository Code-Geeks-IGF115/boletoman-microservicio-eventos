<?php

namespace App\Controller;

use App\Entity\Celda;
use App\Form\CeldaType;
use App\Repository\CeldaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[Route('/celda')]
class CeldaController extends AbstractController
{
    #[Route('/', name: 'app_celda_index', methods: ['GET'])]
    public function index(CeldaRepository $celdaRepository): Response
    {
        return $this->render('celda/index.html.twig', [
            'celdas' => $celdaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_celda_new', methods: ['POST'])]
    public function new(Request $request, CeldaRepository $celdaRepository, 
    SerializerInterface $serializer): Response
    {
        $response = new JsonResponse();
        $celda = new Celda();
        
        $form = $this->createForm(CeldaType::class, $celda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $celdaRepository->save($celda, true);
            //$result = $serializer-> serialize(['message' => "celda guardada con exito"], 'json');
            return $this->redirectToRoute('app_celda_index', [], Response::HTTP_SEE_OTHER);
        }
        //else{
        //    $result = $serializer->serialize(['message'=>"datos no validos"], 'json');
        //}
        return $this->renderForm('celda/new.html.twig', [
            'celda' => $celda,
            'form' => $form,
        ]);
        //return $response->fromJsonString($result);
    }

    #[Route('/{id}', name: 'app_celda_show', methods: ['GET'])]
    public function show(Celda $celda): Response
    {
        return $this->render('celda/show.html.twig', [
            'celda' => $celda,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_celda_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Celda $celda, CeldaRepository $celdaRepository): Response
    {
        $form = $this->createForm(CeldaType::class, $celda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $celdaRepository->save($celda, true);

            return $this->redirectToRoute('app_celda_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('celda/edit.html.twig', [
            'celda' => $celda,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_celda_delete', methods: ['POST'])]
    public function delete(Request $request, Celda $celda, CeldaRepository $celdaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$celda->getId(), $request->request->get('_token'))) {
            $celdaRepository->remove($celda, true);
        }

        return $this->redirectToRoute('app_celda_index', [], Response::HTTP_SEE_OTHER);
    }
}
