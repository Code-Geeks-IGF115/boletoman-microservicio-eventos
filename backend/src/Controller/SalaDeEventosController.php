<?php

namespace App\Controller;

use App\Entity\SalaDeEventos;
use App\Form\SalaDeEventosType;
use App\Repository\SalaDeEventosRepository;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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

    #[Route('/new', name: 'app_sala_de_eventos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SalaDeEventosRepository $salaDeEventosRepository): Response
    {
        $salaDeEvento = new SalaDeEventos();
        $form = $this->createForm(SalaDeEventosType::class, $salaDeEvento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $salaDeEventosRepository->save($salaDeEvento, true);

            return $this->redirectToRoute('app_sala_de_eventos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sala_de_eventos/new.html.twig', [
            'sala_de_evento' => $salaDeEvento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sala_de_eventos_show', methods: ['GET'])]
    public function show(SalaDeEventos $salaDeEvento): Response
    {
        return $this->render('sala_de_eventos/show.html.twig', [
            'sala_de_evento' => $salaDeEvento,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sala_de_eventos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SalaDeEventos $salaDeEvento, SalaDeEventosRepository $salaDeEventosRepository): Response
    {
        $form = $this->createForm(SalaDeEventosType::class, $salaDeEvento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $salaDeEventosRepository->save($salaDeEvento, true);

            return $this->redirectToRoute('app_sala_de_eventos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sala_de_eventos/edit.html.twig', [
            'sala_de_evento' => $salaDeEvento,
            'form' => $form,
        ]);
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
