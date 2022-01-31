<?php

namespace App\Controller;

use App\Repository\OwnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/owner/{id}", name="owner_show")
     */
    public function show($id, OwnerRepository $ownerRepository)
    {
        $owner = $ownerRepository->findOneBy([
            'id' => $id
        ]);

        if (!$owner) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }

        return $this->render('owner/show.html.twig', [
            'owner' => $owner
        ]);
    }
}
