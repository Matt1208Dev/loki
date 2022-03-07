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

    public function add(int $id)
    {

        // Récupération du panier dans la session, ou un tableau vide par défaut
        $cart = $this->session->get('cart', []);

        // Si le produit est déja présent, on incrémente sa quantité, sinon on l'intègre
        if (array_key_exists($id, $cart)) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        // Mise à jour de la variable de session 'cart'
        $this->session->set('cart', $cart);
    }

    public function decrement(int $id) {

        $cart = $this->session->get('cart', []);

        if(!array_key_exists($id, $cart)) {
            return;
        }

        if($cart[$id] === 1) {
            $this->remove($id);
            return;
        }

        $cart[$id]--;

        $this->session->set('cart', $cart);
    }

    public function remove(int $id) {

        $cart = $this->session->get('cart', []);

        unset($cart[$id]);

        $this->session->set('cart', $cart);
    }

    public function getTotal() {

        $total = 0;

        foreach($this->session->get('cart', []) as $id => $qty) {
            $service = $this->serviceRepository->find($id);

            $total += $service->getPrice() * $qty;
        }

        return $total;
    }

    public function getDetailedCartItems() : array {
        
        $detailedCart = [];
        
        foreach($this->session->get('cart') as $id => $qty) {
            
            $service = $this->serviceRepository->find($id);
            $detailedCart[] = new CartItem($service, $qty);
        }

        return $detailedCart;
    }
}
