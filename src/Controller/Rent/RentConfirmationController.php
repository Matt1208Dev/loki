<?php

namespace App\Controller\Rent;

use DateTime;
use App\Entity\Rent;
use App\Entity\RentRow;
use App\Cart\CartService;
use App\Form\CartConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RentConfirmationController extends AbstractController
{
    protected $cartService;
    protected $em;

    public function __construct(CartService $cartService, EntityManagerInterface $em)
    {
        $this->cartService = $cartService;
        $this->em = $em;
    }

    /**
     * @Route("/rent/confirm", name="rent_confirm")
     * @IsGranted("ROLE_ADMIN", message="Vous devez être connecté pour créer une facture")
     */
    public function confirm(Request $request)
    {
        // Lecture des données du formulaire
        $form = $this->createForm(CartConfirmationType::class);

        $form->handleRequest($request);

        // Si le formulaire n'est pas soumis : dégager
        if (!$form->isSubmitted()) {
            // Message Flash et redirection
            $this->addFlash('warning', 'Vous devez remplir le formulaire');

            return $this->redirectToRoute('cart_show');
        }

        // Si l'utilisateur n'est pas authentifié : dégager
        $user = $this->getUser();

        // Si le panier et vide : dégager
        $cartItems = $this->cartService->getDetailedCartItems();

        if(count($cartItems) === 0) {
            // Message Flash et redirection
            $this->addFlash('warning', 'Vous ne pouvez pas valider un panier vide');

            return $this->redirectToRoute('cart_show');
        }

        /** @var Rent */
        $rent = $form->getData();

        $rent->setCreatedAt(new DateTime())
            ->setIsPaid(false)
            ->setOwner($rent->getApartment()->getOwner());
        $this->em->persist($rent);

        $total = 0;
        foreach($this->cartService->getDetailedCartItems() as $cartItem) {
            $rentRow = new RentRow;
            $rentRow->setRent($rent)
                ->setService($cartItem->service)
                ->setServiceLabel($cartItem->service->getLabel())
                ->setQuantity($cartItem->qty)
                ->setPrice($cartItem->service->getPrice())
                ->setTotalRow($cartItem->getTotal());

            $this->em->persist($rentRow);

            $total += $cartItem->getTotal();
        }

        $rent->setTotal($total);

        $this->em->flush();

        $this->cartService->empty();

        $this->addFlash('success', 'La facture a bien été enregistrée');
        return $this->redirectToRoute('rent_list');

    }
}
