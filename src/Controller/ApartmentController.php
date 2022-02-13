<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Form\ApartmentType;
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
            'apartments' => $apartments,
            'urlGenerator' => $urlGenerator
        ]);
    }

    /**
     * @Route("/apartment/create", name="apartment_create")
     */
    public function create(UrlGeneratorInterface $urlGenerator): Response
    {
        $form = $this->createForm(ApartmentType::class);

        $formView = $form->createView();

        return $this->render('apartment/create.html.twig', [
            'formView' => $formView,
            'urlGenerator' => $urlGenerator
        ]);
    }
}
