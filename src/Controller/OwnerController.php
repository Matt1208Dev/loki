<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OwnerController extends AbstractController
{
    /**
     * @Route("/owner/create", name="owner_create")
     */
    public function index(): Response
    {
        return $this->render('owner/create.html.twig', [
            'controller_name' => 'OwnerController',
        ]);
    }
}
