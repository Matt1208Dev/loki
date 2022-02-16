<?php

namespace App\Controller;

use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function create(UrlGeneratorInterface $urlGenerator, Request $request, EntityManagerInterface $em) {

        $form = $this->createForm(ServiceType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em->persist($data);
            $em->flush();

            return $this->render('shared/success.html.twig', [
                'urlGenerator' => $urlGenerator,
                'message' => 'Le service a été ajouté.',
                'route' => 'service_list'
            ]);
        }

        $formView = $form->createView();

        return $this->render('service/create.html.twig', [
            'urlGenerator' => $urlGenerator,
            'formView' => $formView
        ]);
    }
}
