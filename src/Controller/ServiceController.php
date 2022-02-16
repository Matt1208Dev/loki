<?php

namespace App\Controller;

use App\Form\ConfirmType;
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
        $services = $serviceRepository->findBy(['retired' => false], ['label' => 'ASC']);

        return $this->render('service/list.html.twig', [
            'urlGenerator' => $urlGenerator,
            'services' => $services
        ]);
    }

    /**
     * @Route("/service/{id}/edit", name="service_edit")
     */
    public function edit($id, ServiceRepository $serviceRepository, Request $request, UrlGeneratorInterface $urlGenerator, EntityManagerInterface $em)
    {

        $service = $serviceRepository->find($id);

        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em->persist($data);
            $em->flush();

            return $this->render('shared/success.html.twig', [
                'urlGenerator' => $urlGenerator,
                'message' => 'Le service a été modifié.',
                'route' => 'service_list'
            ]);
        }

        $formView = $form->createView();

        return $this->render('service/edit.html.twig', [
            'service' => $service,
            'urlGenerator' => $urlGenerator,
            'formView' => $formView
        ]);
    }

    /**
     * @Route("/service/create", name="service_create")
     */
    public function create(UrlGeneratorInterface $urlGenerator, Request $request, EntityManagerInterface $em)
    {

        $form = $this->createForm(ServiceType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

    /**
     * @Route("/service/{id}/retire", name="service_retire")
     */
    public function retire($id, ServiceRepository $serviceRepository, Request $request, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator)
    {

        $service = $serviceRepository->find($id);

        $form = $this->createForm(ConfirmType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $retire = $form->getData();

            if ($retire['confirm'] === true) {
                $service->setRetired(true);
                $em->flush();

                return $this->render('shared/success.html.twig', [
                    'urlGenerator' => $urlGenerator,
                    'message' => 'Le service a été archivé',
                    'route' => 'service_list'
                ]);
            }
        }

        $formView = $form->createView();

        return $this->render('service/retire.html.twig', [
            'urlGenerator' => $urlGenerator,
            'service' => $service,
            'formView' => $formView
        ]);
    }
}
