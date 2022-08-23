<?php

namespace Shop\Models;

use DateTime;

class CartProduct extends Product
{
    public float $totalPrice;
    public int $quantityBuyed;
    public DateTime $createdAt;
    private static $cartTableName = 'carts';
    private static $productTableName = 'products';


    public function __construct(
        string $id,
        string $title,
        float $price,
        int $amount,
        int $quantityBuyed,
        Category $category,
        string $image,
        string $description,
        string $createdAt

    ) {
        parent::__construct($id, $title, $price, $amount, $category, $image, $description);
        $this->quantityBuyed = $quantityBuyed;
        $this->totalPrice = $quantityBuyed * $price;
        $this->createdAt = new DateTime($createdAt);
    }

    public static function getAllByUserId(string $userId): array | null
    {
        $stmt = Db::getInstance()->getConnection()->prepare(
            "
            SELECT
                p.id,
                p.amount,
                p.title,
                p.price,
                p.category_id,
                p.image,
                p.description,
                c.amount as quantityBuyed,
                c.created_at
            FROM " . self::$cartTableName . " c 
	        INNER JOIN " . self::$productTableName . " p ON c.product_id = p.id 
	        WHERE c.user_id =:id
            "
        );
        $stmt->execute(['id' => $userId]);
        $cartItems = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];

        if (empty($cartItems)) return null;

        foreach ($cartItems as $cartItem) {
            $result[] = new CartProduct(
                $cartItem['id'],
                $cartItem['title'],
                $cartItem['price'],
                $cartItem['amount'],
                $cartItem['quantityBuyed'],
                Category::getById($cartItem['category_id']),
                $cartItem['image'],
                $cartItem['description'],
                $cartItem['created_at'],
            );
        }

        return $result;
    }
}