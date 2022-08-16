<?php

namespace Shop\Controllers;

use Shop\Views\View;
use Shop\Models\Product;
use Shop\Models\Cart;
use Shop\Models\User;

class ProductsController
{

    public function index()
    {
        View::render('products', [
            'pageTitle' => 'Products',
            'products' => Product::getAll(),
            'isAddedProduct' => fn ($productId, $userId) => Cart::isAddedProduct($productId, $userId),
            'userId' => User::getId()
        ]);
    }
}