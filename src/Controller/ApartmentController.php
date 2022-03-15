<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Form\ConfirmType;
use App\Form\ApartmentType;
use App\Repository\ApartmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApartmentController extends AbstractController
{
    /**
     * @Route("/apartment/list", name="apartment_list")
     */
    public function list(ApartmentRepository $apartmentRepository, UrlGeneratorInterface $urlGenerator): Response
    {
        $apartments = $apartmentRepository->findBy(['retired' => false], ['owner' => 'ASC'], null);

        if(!$apartments) {
            return $this->render('apartment/no_data.html.twig', [
                'urlGenerator' => $urlGenerator
            ]); 
        }

        return $this->render('apartment/list.html.twig', [
            'apartments' => $apartments,
            'urlGenerator' => $urlGenerator
        ]);
    }

    /**
     * @Route("/apartment/create", name="apartment_create")
     */
    public function create(UrlGeneratorInterface $urlGenerator, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ApartmentType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $apartment = $form->getData();
            $apartment->setCreatedAt(new \DateTime());
            $em->persist($apartment);
            $em->flush();

            return $this->render('shared/success.html.twig', [
                'message' => "L'appartement a été ajouté.",
                'urlGenerator' => $urlGenerator,
                'route' => 'apartment_list'
            ]);
        }

        $formView = $form->createView();

        return $this->render('apartment/create.html.twig', [
            'formView' => $formView,
            'urlGenerator' => $urlGenerator
        ]);
    }

    /**
     * @Route("/apartment/{id}/edit", name="apartment_edit")
     */
    public function edit($id, ApartmentRepository $apartmentRepository, UrlGeneratorInterface $urlGenerator, Request $request, EntityManagerInterface $em): Response
    {
        $apartment = $apartmentRepository->find($id);

        $form = $this->createForm(ApartmentType::class, $apartment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apartment = $form->getData();
            $em->flush();

            return $this->render('shared/success.html.twig', [
                'message' => "Les informations de l'appartement ont été mises à jour.",
                'urlGenerator' => $urlGenerator,
                'route' => 'apartment_list'
            ]);
        }

        $formView = $form->createView();

        return $this->render('apartment/edit.html.twig', [
            'apartment' => $apartment,
            'formView' => $formView,
            'urlGenerator' => $urlGenerator
        ]);
    }

    /**
     * @Route("/apartment/{id}/retire", name="apartment_retire")
     */
    public function retire($id, ApartmentRepository $apartmentRepository, UrlGeneratorInterface $urlGenerator, Request $request, EntityManagerInterface $em)
    {
        $apartment = $apartmentRepository->find($id);

        $form = $this->createForm(ConfirmType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $retired = $form->getData();

            if ($retired['confirm'] === true) {
                $apartment->setRetired(true);
                $em->flush();

                return $this->render('shared/success.html.twig', [
                    'message' => "L'appartement a bien été archivé.",
                    'urlGenerator' => $urlGenerator,
                    'route' => 'apartment_list'
                ]);
            }
        }

        $formView = $form->createView();

        return $this->render('apartment/retire.html.twig', [
            'formView' => $formView,
            'urlGenerator' => $urlGenerator,
            'apartment' => $apartment
        ]);
    }
}
