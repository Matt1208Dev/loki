<?php

namespace App\Controller\Rent;

use Twig\Environment;
use App\Repository\RentRepository;
use App\Repository\RentRowRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RentListController extends AbstractController
{

    protected $rentRepository;
    protected $rentRowRepository;
    protected $urlGenerator;

    public function __construct(RentRepository $rentRepository, RentRowRepository $rentRowRepository, UrlGeneratorInterface $urlGenerator)
    {
        $this->rentRepository = $rentRepository;
        $this->rentRowRepository = $rentRowRepository;
        $this->urlGenerator = $urlGenerator;
    }

    /** 
     * @Route("/rent", name="rent_list")
     * @IsGranted("ROLE_USER", message="Vous devez être connecté pour à la liste des locations")
     */
    public function index()
    {

        /** @var User */
        $user = $this->getUser();

        $rentRows = $this->rentRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('rent/index.html.twig', [
            'rents' => $rentRows,
            'urlGenerator' => $this->urlGenerator
        ]);
    }

    /**
     * @Route("/rent/{id}", name="rent_show", requirements={"id":"\d+"})
     * @IsGranted("ROLE_USER", message="Vous devez être connecté pour accder à cette page")
     */
    public function show(int $id)
    {
        $rentItems = $this->rentRowRepository->findBy(["rent" => $id]);

        $total = 0;

        foreach($rentItems as $item) {
            $total += $item->getPrice() * $item->getQuantity();
        }

        return $this->render('rent/show.html.twig', [
            'items' => $rentItems,
            'total' => $total,
            'urlGenerator' => $this->urlGenerator
        ]);
    }
}
