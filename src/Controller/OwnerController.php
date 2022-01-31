<?php

namespace App\Controller;

use App\Repository\OwnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OwnerController extends AbstractController
{
    /**
     * @Route("/owner/create", name="owner_create")
     */
    public function create(): Response
    {
        return $this->render('owner/create.html.twig', [
            'controller_name' => 'OwnerController',
        ]);
    }

    /**
     * @Route("/owner", name="owner_list")
     */
    public function list(OwnerRepository $ownerRepository, UrlGeneratorInterface $urlGenerator)
    {
        $owners = $ownerRepository->findBy( [], ['lastName' => 'ASC'], null);

        if (!$owners) {
            throw $this->createNotFoundException("Aucune donnée à afficher");
        }

        return $this->render('owner/list.html.twig', [
            'owners' => $owners,
            'urlGenerator' => $urlGenerator
        ]);
    }

    /**
     * @Route("/owner/{id}", name="owner_show")
     */
    public function show($id, OwnerRepository $ownerRepository, UrlGeneratorInterface $urlGenerator)
    {
        $owner = $ownerRepository->findOneBy([
            'id' => $id
        ]);

        if (!$owner) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }

        return $this->render('owner/show.html.twig', [
            'owner' => $owner,
            'urlGenerator' => $urlGenerator
        ]);
    }
}
