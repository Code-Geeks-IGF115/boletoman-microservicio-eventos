<<<<<<< HEAD
<?php

namespace App\Controller;

use App\Entity\SalaDeEventos;
use App\Form\SalaDeEventosType;
use App\Repository\SalaDeEventosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\{Response, JsonResponse};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Exception;

#[Route('/sala/de/eventos')]
class SalaDeEventosController extends AbstractController
{
    
    /** Tarea: Función verSalasDeEventos
    * Nombre: Roman Mauricio Hernández Beltrán
    * Carnet: HB21009
    * Fecha de Revisión: 10/10/2022
    * Fecha de Aprobación: 10/10/2022
    * Revisión: Andrea Melissa Monterrosa Morales
    */
    #[Route('/', name: 'app_sala_de_eventos_index', methods: ['GET'])]
    public function index(SalaDeEventosRepository $salaDeEventosRepository, 
    SerializerInterface $serializer): JsonResponse
    {
        $salaDeEvento=$salaDeEventosRepository->findAll();
        $result = $serializer->serialize(['salas'=>$salaDeEvento],'json');
        return JsonResponse::fromJsonString($result);
    }

     /** Tarea: Función crearSalaDeEventos
     * Nombre: Carlos Josué Argueta Alvarado
     * Carnet: AA20099
     * Estado: Aprobado
     * Fecha de Revisión: 10/10/2022
     * Fecha de Aprobación: 10/10/2022
     * Revisión: Andrea Melissa Monterrosa Morales
     */
    #[Route('/new', name: 'app_sala_de_eventos_new', methods: ['POST'])]
    public function new(Request $request, 
    SalaDeEventosRepository $salaDeEventosRepository,
    SerializerInterface $serializer): JsonResponse
    {  
        $response=new JsonResponse();
        $salaDeEvento = new SalaDeEventos();
        $form = $this->createForm(SalaDeEventosType::class, $salaDeEvento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

                $salaDeEventosRepository->save($salaDeEvento, true);//para guardar en base de datos
                $result= $serializer->serialize(['message'=>"Sala de Eventos Guardada."],'json');
                return $response->fromJsonString($result);         
        }       
        else{
            $result= $serializer->serialize(['message'=>"Datos no válidos."],'json');
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            
        } 
        return $response->fromJsonString($result);
    }  
    

    /** Tarea: Función verSalaDeEventos
     * Nombre: Carlos Josué Argueta Alvarado
     * Carnet: AA20099
     * Nombre: Roman Mauricio Hernández Beltrán
     * Carnet: HB21009
     * Estado: Aprobado
     * Fecha de Revisión: 10/10/2022
     * Fecha de Aprobación: 10/10/2022
     * Revisión: Andrea Melissa Monterrosa Morales
     */
    #[Route('/{id}', name: 'app_sala_de_eventos_show', methods: ['GET'])]
    public function show(SalaDeEventos $salaDeEvento = null,SerializerInterface $serializer): JsonResponse
    {
        $response=new JsonResponse();
        if(empty($salaDeEvento)){
            $result= $serializer->serialize(['message'=>"No se encontró sala de evento"],'json');
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        else{
            $result = $serializer->serialize(['salaDeEvento'=>$salaDeEvento],'json');
        } 
        return $response->fromJsonString($result);
    }
    
    
    /** Tarea: Función editarSalaDeEventos
     * Nombre: Carlos Josué Argueta Alvarado
     * Carnet: AA20099
     * Estado: Aprobado
     * Fecha de Aprobación: 11/10/2022
     * fecha de ultima modificacion : 11/10/2022
     * Fecha de Revisión: 10/10/2022
     * Revisión: Andrea Melissa Monterrosa Morales
     */
    #[Route('/{id}/edit', name: 'app_sala_de_eventos_edit', methods: ['POST'])]
    public function edit(Request $request, SalaDeEventos $salaDeEvento = null, 
    SalaDeEventosRepository $salaDeEventosRepository, SerializerInterface $serializer): JsonResponse
    {
        $response=new JsonResponse();
        if(empty($salaDeEvento)){
            $result= $serializer->serialize(['message'=>"Sala de eventos no existe."],'json');
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);  
        }
        else{
            $form = $this->createForm(SalaDeEventosType::class, $salaDeEvento);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $salaDeEventosRepository->save($salaDeEvento, true);
                $result= $serializer->serialize(['message'=>"Sala de Eventos se modificó con exito."],'json');
            }
            else{
                $result= $serializer->serialize(['message'=>"Datos no válidos."],'json');
                $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);  
            }
        } 
        return $response->fromJsonString($result);
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
=======
<?php

namespace App\Controller;

use App\Entity\SalaDeEventos;
use App\Form\SalaDeEventosType;
use App\Repository\SalaDeEventosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\{Response, JsonResponse};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Exception;

#[Route('/sala/de/eventos')]
class SalaDeEventosController extends AbstractController
{
    
    /** Tarea: Función verSalasDeEventos
    * Nombre: Roman Mauricio Hernández Beltrán
    * Carnet: HB21009
    * Fecha de Revisión: 10/10/2022
    * Fecha de Aprobación: 10/10/2022
    * Revisión: Andrea Melissa Monterrosa Morales
    */
    #[Route('/', name: 'app_sala_de_eventos_index', methods: ['GET'])]
    public function index(SalaDeEventosRepository $salaDeEventosRepository, 
    SerializerInterface $serializer): JsonResponse
    {
        $salaDeEvento=$salaDeEventosRepository->findAll();
        $result = $serializer->serialize(['salas'=>$salaDeEvento],'json');
        return JsonResponse::fromJsonString($result);
    }

     /** Tarea: Función crearSalaDeEventos
     * Nombre: Carlos Josué Argueta Alvarado
     * Carnet: AA20099
     * Estado: Aprobado
     * Fecha de Revisión: 10/10/2022
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

    /** Tarea: Función verSalaDeEventos
     * Nombre: Carlos Josué Argueta Alvarado
     * Carnet: AA20099
     * Nombre: Roman Mauricio Hernández Beltrán
     * Carnet: HB21009
     * Estado: Aprobado
     * ultima modificacion: 12/10/2022
     * Fecha de Revisión: 10/10/2022
     * Fecha de Aprobación: 10/10/2022
     * Revisión: Andrea Melissa Monterrosa Morales
     */
    ##[Route('/{id}', name: 'app_sala_de_eventos_show', methods: ['GET'])]
    public function show(SalaDeEventos $salaDeEvento = null,SerializerInterface $serializer): JsonResponse
    {
        $response=new JsonResponse();
        if(empty($salaDeEvento)){
            $result= $serializer->serialize(['message'=>"No se encontró sala de evento"],'json');
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        else{
            $result = $serializer->serialize(['salaDeEvento'=>$salaDeEvento],'json');
        } 
        return $response->fromJsonString($result);
    }
    
    
    /** Tarea: Función crearSalaDeEventos
     * Nombre: Carlos Josué Argueta Alvarado
     * Carnet: AA20099
     * Estado: En Reparación
     * Fecha de Aprobación: 
     * Fecha de Revisión: 10/10/2022
     * Revisión: Andrea Melissa Monterrosa Morales
     */
    #[Route('/{id}/edit', name: 'app_sala_de_eventos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SalaDeEventos $salaDeEvento, SalaDeEventosRepository $salaDeEventosRepository, SerializerInterface $serializer): Response
    {
        $response=new JsonResponse();
        // $salaDeEvento = new SalaDeEventos();
        $form = $this->createForm(SalaDeEventosType::class, $salaDeEvento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
            $salaDeEventosRepository->save($salaDeEvento, true);
            return $this->redirectToRoute('app_sala_de_eventos_index', [], Response::HTTP_SEE_OTHER);
            $result= $serializer->serialize(['message'=>"Sala de Eventos sobreescrita."],'json');
            return $response->fromJsonString($result);
            }catch(Exception $e){
                $result= $serializer->serialize(['message'=>"Datos no válidos."],'json');
                $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                return $response->fromJsonString($result);
            }

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
>>>>>>> ac4ef31894f8fcd2bdf0e8b5893a8fc0d3fb3064
