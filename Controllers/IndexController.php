<?php

namespace Shop\Controllers;

use Shop\Views\View;
use Shop\Models\Product;
use Shop\Models\Cart;
use Shop\Models\User;

class IndexController
{

    public function index(): void
    {
        View::render('products', [
            'pageTitle' => 'Products',
            'products' => Product::getAll(),
            'userId' => User::getId()
        ]);
    }

    public function search(): void
    {
        $requestBody = json_decode(file_get_contents('php://input'), true);
        $searchStr = $requestBody['searchStr'];
        $res = null;

        if ($searchStr) {
            $res = Product::searchByName($searchStr);
        } else $res = Product::getAll();


        header('Content-Type: application/json; charset=utf-8');
        http_response_code(200);
        echo json_encode($res);
    }
}