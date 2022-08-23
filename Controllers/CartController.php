<?php

namespace Shop\Controllers;

use Shop\Views\View;
use Shop\Models\User;
use Shop\Models\Cart;
use Shop\Models\CartProduct;

class CartController
{

    public function index(): void
    {
        $userId = User::getId();

        View::render('cart', [
            'pageTitle' => 'Cart',
            'cartItems' => CartProduct::getAllByUserId($userId)
        ]);
    }

    public function removeProduct(): void
    {
        if (!empty($_POST)) {
            Cart::removeProduct(
                User::getId(),
                $_POST['productId']
            );
            header('Location: /cart');
        }
    }

    public function addProduct(): void
    {
        if (!empty($_POST)) {
            Cart::addProduct(
                User::getId(),
                $_POST['productId'],
                $_POST['amount']
            );
            header('Location: /');
        }
    }
}
