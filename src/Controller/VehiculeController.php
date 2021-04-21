<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Vehicule;

class VehiculeController extends AbstractController
{
    /**
     * @Route("/vehicule", name="vehicule")
     */
    public function index(): Response
    {
        return $this->render('vehicule/index.html.twig', [
            'controller_name' => 'VehiculeController',
        ]);
    }


    /**
     * @Route("/VehiculeJson/{date}", name="historiqueJSON")
     */
    public function historiqueJSON($date): JsonResponse
    {
        //$idUtilisateur='root';
        $repository= $this->getDoctrine()->getRepository(Vehicule::class);
        $fiche=$repository->findVehiculeDispo($date);
        return new JsonResponse($fiche, Response::HTTP_OK);
    }
}
