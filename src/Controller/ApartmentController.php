<?php

namespace App\Controller;

use App\Repository\ApartmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ApartmentController extends AbstractController
{
    /**
     * @Route("/apartment/list", name="apartment_list")
     */
    public function list(ApartmentRepository $apartmentRepository, UrlGeneratorInterface $urlGenerator): Response
    {
        $apartments = $apartmentRepository->findAll([], ['owner' => 'ASC'], null);
 
        return $this->render('apartment/list.html.twig', [
            'controller_name' => 'ApartmentController',
            'apartments' => $apartments,
            'urlGenerator' => $urlGenerator
        ]);
    }

    /**
     * @Route("/apartment", name="apartment_create")
     */
    public function create(): Response
    {
        return $this->render('apartment/index.html.twig', [
            'controller_name' => 'ApartmentController',
        ]);
    }
}
