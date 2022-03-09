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
    protected $serviceRepository;
    protected $cartService;

    public function __construct(ServiceRepository $serviceRepository, CartService $cartService)
    {
        $this->serviceRepository = $serviceRepository;
        $this->cartService = $cartService;
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add", requirements={"id":"\d+"})
     */
    public function add($id, Request $request)
    {
        // Est-ce que le produit existe ?
        $service = $this->serviceRepository->find($id);

        if (!$service) {
            throw new NotFoundHttpException("Le service $id n'existe pas");
        }

        $this->cartService->add($id);

        $this->addFlash('success', "Service ajouté");

        if ($request->query->get('returnToCart')) {
            return $this->redirectToRoute('cart_show');
        }

        return $this->redirectToRoute('service_list');
    }

    /**
     * @Route("/cart/decrement/{id}", name="cart_decrement", requirements={"id":"\d+"})
     */
    public function decrement(int $id)
    {

        // Est-ce que le produit existe ?
        $service = $this->serviceRepository->find($id);

        if (!$service) {
            throw new NotFoundHttpException("Le service $id n'existe pas");
        }

        $this->cartService->decrement($id);

        $this->addFlash('success', "La quantité du service a été réduite");

        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/cart/delete/{id}", name="cart_delete", requirements={"id":"\d+"})
     */
    public function delete($id)
    {

        $service = $this->serviceRepository->find($id);

        if (!$service) {
            throw $this->createNotFoundException("Le produit $id n'existe pas.");
        }

        $this->cartService->remove($id);

        $this->addFlash("success", "Le service a bien été retiré du panier");

        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/cart/", name="cart_show")
     */
    public function show()
    {
        $detailedCart = $this->cartService->getDetailedCartItems();

        $total = $this->cartService->getTotal();

        return $this->render('cart/index.html.twig', [
            'items' => $detailedCart,
            'total' => $total
        ]);
    }
}
