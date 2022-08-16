<?php

namespace Shop\Models;

class Cart
{
    private static $tableName = 'carts';

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