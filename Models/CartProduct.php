<?php

namespace Shop\Models;

use DateTime;

class CartProduct
{
    public string $userId;
    public string $productId;
    public int $amount;
    public DateTime $createdAt;
    public Product $product;
    public float $totalPrice;
    private static $tableName = 'carts';

    public function __construct(
        string $userId,
        string $productId,
        int $amount,
        string $createdAt,
        Product $product
    ) {
        $this->userId = $userId;
        $this->productId = $productId;
        $this->amount = $amount;
        $this->createdAt = new DateTime($createdAt);
        $this->product = $product;
        $this->totalPrice = $product->price * $amount;
    }

    public static function getAllByUserId(string $userId): array | bool
    {
        $stmt = Db::getInstance()->getConnection()->prepare(
            "SELECT * FROM " . self::$tableName . " WHERE user_id =:id"
        );
        $stmt->execute(['id' => $userId]);
        $cartItems = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];

        if (empty($cartItems)) return false;

        foreach ($cartItems as $cartItem) {
            $result[] = new CartProduct(
                $cartItem['user_id'],
                $cartItem['product_id'],
                $cartItem['amount'],
                $cartItem['created_at'],
                Product::getById(
                    $cartItem['product_id']
                )
            );
        }

        return $result;
    }
}