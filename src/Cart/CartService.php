<?php

namespace App\Cart;

use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    protected $session;
    protected $serviceRepository;

    public function __construct(SessionInterface $session, ServiceRepository $serviceRepository)
    {
        $this->session = $session;
        $this->serviceRepository = $serviceRepository;
    }

    public function getCart() {
        return $this->session->get('cart', []);
    }

    public function saveCart($cart) {
        return $this->session->set('cart', $cart);
    }

    public function add(int $id)
    {

        // Récupération du panier dans la session, ou un tableau vide par défaut
        $cart = $this->getCart();

        // Si le produit est déja présent, on incrémente sa quantité, sinon on l'intègre
        if (!array_key_exists($id, $cart)) {
            $cart[$id] = 0;
        }
            
        $cart[$id]++;
        

        // Mise à jour de la variable de session 'cart'
        $this->saveCart($cart);
    }

    public function decrement(int $id) {

        $cart = $this->getCart();

        if(!array_key_exists($id, $cart)) {
            return;
        }

        if($cart[$id] === 1) {
            $this->remove($id);
            return;
        }

        $cart[$id]--;

        $this->saveCart($cart);    }

    public function remove(int $id) {

        $cart = $this->getCart();

        unset($cart[$id]);

        $this->saveCart($cart);    }

    public function getTotal() {

        $total = 0;

        foreach($this->getCart() as $id => $qty) {
            $service = $this->serviceRepository->find($id);

            $total += $service->getPrice() * $qty;
        }

        return $total;
    }

    public function getDetailedCartItems() : array {
        
        $detailedCart = [];
        
        foreach($this->getCart() as $id => $qty) {
            
            $service = $this->serviceRepository->find($id);
            $detailedCart[] = new CartItem($service, $qty);
        }

        return $detailedCart;
    }
}
