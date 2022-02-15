<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service/list", name="service_list")
     */
    public function list(ServiceRepository $serviceRepository, UrlGeneratorInterface $urlGenerator): Response
    {
        $services = $serviceRepository->findBy([], ['label' => 'ASC']);

        return $this->render('service/list.html.twig', [
            'urlGenerator' => $urlGenerator,
            'services' => $services
        ]);
    }

    /**
     * @Route("/service/{id}/edit", name="service_edit")
     */
    public function edit() {

    }

    /**
     * @Route("/service/create", name="service_create")
     */
    public function create() {
        
    }
}
