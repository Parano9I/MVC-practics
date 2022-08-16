<?php

namespace Shop\Models;

use DateTime;

class Cart
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
            $result[] = new Cart(
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

    public static function removeProduct(string $userId, string $productId): void
    {
        $stmt = Db::getInstance()->getConnection()->prepare(
            'DELETE FROM ' .  self::$tableName . ' WHERE product_id = :productId AND user_id = :userId'
        );
        $stmt->execute([
            "userId" => $userId,
            "productId" => $productId
        ]);
    }

    public static function addProduct(string $userId, string $productId, int $amount): void
    {
        $stmt = Db::getInstance()->getConnection()->prepare(
            "INSERT INTO carts (product_id, user_id, amount) 
                VALUES (:product_id, :user_id, :amount)"
        );
        $stmt->execute([
            "product_id" => $productId,
            "user_id" => $userId,
            "amount" => $amount
        ]);
    }

    public static function isAddedProduct(string $productId, string $userId): bool
    {
        $stmt = Db::getInstance()->getConnection()->prepare(
            'SELECT product_id FROM ' .  self::$tableName . ' WHERE product_id = :productId AND user_id = :userId'
        );
        $stmt->execute([
            "userId" => $userId,
            "productId" => $productId
        ]);
        $productId = $stmt->fetch(\PDO::FETCH_ASSOC);

        return !empty($productId);
    }
}