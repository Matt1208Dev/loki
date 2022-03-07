<?php

namespace App\Controller;

use App\Cart\CartService;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart/add/{id}", name="cart_add", requirements={"id":"\d+"})
     */
    public function add($id, ServiceRepository $serviceRepository, CartService $cartService, Request $request)
    {
        // Est-ce que le produit existe ?
        $service = $serviceRepository->find($id);

        if (!$service) {
            throw new NotFoundHttpException("Le service $id n'existe pas");
        }

        $cartService->add($id);

        $this->addFlash('success', "Service ajouté");

        if($request->query->get('returnToCart')) {
            return $this->redirectToRoute('cart_show');
        }

        return $this->redirectToRoute('service_list');
    }

    /**
     * @Route("/cart/decrement/{id}", name="cart_decrement", requirements={"id":"\d+"})
     */
    public function decrement(int $id, ServiceRepository $serviceRepository, CartService $cartService) {
        
        // Est-ce que le produit existe ?
        $service = $serviceRepository->find($id);

        if (!$service) {
            throw new NotFoundHttpException("Le service $id n'existe pas");
        }

        $cartService->decrement($id);

        $this->addFlash('success', "La quantité du service a été réduite");

        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/cart/delete/{id}", name="cart_delete", requirements={"id":"\d+"})
     */
    public function delete($id, ServiceRepository $serviceRepository, CartService $cartService) {

        $service = $serviceRepository->find($id);

        if(!$service) {
            throw $this->createNotFoundException("Le produit $id n'existe pas.");
        }

        $cartService->remove($id);

        $this->addFlash("success", "Le service a bien été retiré du panier");

        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/cart/", name="cart_show")
     */
    public function show(CartService $cartService)
    {
        $detailedCart = $cartService->getDetailedCartItems();

        $total = $cartService->getTotal();

        return $this->render('cart/index.html.twig', [
            'items' => $detailedCart,
            'total' => $total
        ]);
    }
}
