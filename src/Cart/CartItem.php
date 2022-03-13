<?php

namespace App\Cart;

use App\Entity\Service;

class CartItem {

    public $service;
    public $qty;

    public function __construct(Service $service, $qty)
    {
        $this->service = $service;
        $this->qty = $qty;
    }

    public function getTotal() {
        return $this->service->getPrice() * $this->qty;
    }
}