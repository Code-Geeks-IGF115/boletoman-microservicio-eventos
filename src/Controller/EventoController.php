<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Entity\Frecuencia;
use App\Form\EventoType;
use App\Repository\CategoriaEventoRepository;
use App\Repository\EventoRepository;
use App\Repository\FrecuenciaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\{Response, JsonResponse};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use App\Service\ResponseHelper;
use Exception;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Psr\Log\LoggerInterface;

#[Route('/evento')]
class EventoController extends AbstractController
{
    private ResponseHelper $responseHelper;
    private LoggerInterface $logger;

    public function __construct(ResponseHelper $responseHelper, LoggerInterface $logger)
    {
        $this->responseHelper=$responseHelper;
        $this->logger=$logger;
    }

    #[Route('/', name: 'app_evento_index', methods: ['GET'])]
    public function index(
        Request $request, 
        EventoRepository $eventoRepository,
        CategoriaEventoRepository $categoriaEventoRepository
    ): JsonResponse
    {
        $categoriaId=$request->query->get('categoria', null);
        //si no se agrega categoria, entonces recupera todos los eventos
        if(!$categoriaId){
            $eventos=$eventoRepository->findAll();
        }else{
            $categoria=$categoriaEventoRepository->find(intval($categoriaId));
            $eventos=$categoria->getEventos();
        }
        return $this->responseHelper->responseDatos(['eventos'=>$eventos],['ver_evento']);
    }
    

    #[Route('/new', name: 'app_evento_new', methods: ['POST'])]
    public function new(Request $request, 
    EventoRepository $eventoRepository,
    FrecuenciaRepository $frecuenciaRepository): JsonResponse
   {   
        // recuperando frecuencias   
        $parametros=$parametros=$request->toArray(); 
        $request->request->replace(["evento"=>$parametros]);
        
        $frecuencias=array();
        $frecuencias[]=($parametros['lunes']===true)? true:false;
        $frecuencias[]=($parametros['martes']===true)? true:false;
        $frecuencias[]=($parametros['miercoles']===true)? true:false;
        $frecuencias[]=($parametros['jueves']===true)? true:false;
        $frecuencias[]=($parametros['viernes']===true)? true:false;
        $frecuencias[]=($parametros['sabado']===true)? true:false;
        $frecuencias[]=($parametros['domingo']===true)? true:false;
        
        try{
            $eventoX = new Evento();
            $form = $this->createForm(EventoType::class, $eventoX);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $eventoRepository->save($eventoX, true);
                // creando frecuencias
                // nota: los dias inician en 1
                foreach ($frecuencias as $dia => $isChecked) {
                    $frecuencia=new Frecuencia();
                    $frecuencia->setDia(++$dia);
                    $frecuencia->setChecked($isChecked);
                    $frecuencia->setEvento($eventoX);
                    $frecuenciaRepository->save($frecuencia,true);
                }
                $result= $this->responseHelper->responseDatos(['message'=>"Evento guardado.",'id'=>$eventoX->getId()]);
                
            }else{
                // var_dump($frecuencias);
                $result= $this->responseHelper->responseDatos($form->getErrors(true));
            }
        }catch(Exception $e){
            $result= $this->responseHelper->responseMessage($e->getMessage());
        }
        return $result;
    }      


    #[Route('/{id}', name: 'app_evento_show', methods: ['GET'])]
    public function show(Evento $evento = null): JsonResponse
    {
        if(empty($evento)){
            $result= $this->responseHelper->responseMessage("No se encontró el evento solicitado.");
        }
        else{
            $result = $this->responseHelper->responseDatos(['evento'=>$evento],['ver_evento']);
        } 
        return $result;   
    }

    #[Route('/{id}/sala/de/eventos', name: 'app_evento_unir', methods: ['POST', 'GET'])]
    public function unir(Evento $evento = null, Request $request, 
    EventoRepository $eventoRepository, $id): JsonResponse
    {
        $parametros=$request->toArray(); 
        $idSalaDeEventos = $parametros['salaDeEventosId'];
        
        if(empty($evento)){
            $result= $this->responseHelper->responseMessage("No se encontró el evento solicitado.");
        }
        else{
            $evento->setSalaDeEventosID((int)$idSalaDeEventos);
            $eventoRepository->save($evento, true);
            $result = $this->responseHelper->responseDatos("los datos se han guardado");
        } 
        //$result = $this->responseHelper->responseDatos($parametros);
        return $result;   
    }

    #[Route('/{id}/edit', name: 'app_evento_edit', methods: ['POST'])]
    public function edit(Request $request, Evento $evento = null, 
    EventoRepository $eventoRepository, SerializerInterface $serializer): JsonResponse
    {
        if(empty($evento)){
            $result= $this->responseHelper->responseMessage("No se encontró el evento solicitado."); 
        }
        else{
            $form = $this->createForm(EventoType::class, $evento);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $eventoRepository->save($evento, true);
                $result= $this->responseHelper->responseMessage("El evento se ha modificado.");
            }
            else{
                $result= $this->responseHelper->responseDatosNoValidos();  
            }
        } 
        return $result;
    }

    #[Route('/{id}', name: 'app_evento_delete', methods: ['POST'])]
    public function delete(Request $request, Evento $evento= null, EventoRepository $eventoRepository): Response
    {
        if(empty($evento)){
            $result= $this->responseHelper->responseMessage("No se encontró el evento solicitado."); 
        }else{
            $eventoRepository->remove($evento, true);
        }        

        return $this->responseHelper->responseMessage("Evento eliminado.");
    }
}