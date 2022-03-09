<?php

namespace App\Controller\Rent;

use App\Repository\RentRepository;
use Twig\Environment;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RentListController extends AbstractController {

    protected $security;
    protected $twig;
    protected $rentRepository;
    protected $urlGenerator;

    public function __construct(Security $security, Environment $twig, RentRepository $rentRepository, UrlGeneratorInterface $urlGenerator)
    {
        $this->security = $security;
        $this->twig = $twig;
        $this->rentRepository = $rentRepository;
        $this->urlGenerator = $urlGenerator;
    }

    /** 
     * @Route("/rent", name="rent_index")
     */
    public function index() {

        $user = $this->security->getUser();

        if(!$user) {
            throw new AccessDeniedException("Vous devez être connecté pour accéder à cette page");
        }

        $rentRows = $this->rentRepository->findBy([], ['createdAt' => 'DESC']);

        $html = $this->twig->render('rent/index.html.twig', [
            'rents' => $rentRows,
            'urlGenerator' => $this->urlGenerator
        ]);

        return new Response($html);
    }

    /**
     * @Route("/rent/{id}", name="rent_show", requirements={"id":"\d+"})
     */
    public function show($id) {
        dd("Ca fonctionne !");
    }
}