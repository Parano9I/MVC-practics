<?php

namespace Shop\Models;

class Product
{
    public string $id;
    public string $title;
    public float $price;
    public int $amount;
    public Category $category;
    public string $image;
    public string $description;
    public bool $isAddedToCart;
    private static $tableName = 'products';

    public function __construct(
        string $id,
        string $title,
        float $price,
        int $amount,
        Category $category,
        string $image,
        string $description,
        bool $isAddedToCart
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->amount = $amount;
        $this->category = $category;
        $this->image = $image;
        $this->description = $description;
        $this->isAddedToCart = $isAddedToCart;
    }

    public static function getAll(): array
    {
        $stmt = Db::getInstance()->getConnection()->query('SELECT * FROM ' . self::$tableName);
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];

        foreach ($products as $product) {
            $result[] = new Product(
                $product['id'],
                $product['title'],
                $product['price'],
                $product['amount'],
                Category::getById($product['category_id']),
                $product['image'],
                $product['description'],
                Cart::isAddedProduct(
                    $product['id'],
                    User::getId()
                )
            );
        }

        return $result;
    }

    public static function getById(string $productId): Product | null
    {
        $stmt = Db::getInstance()->getConnection()->prepare(
            "SELECT * FROM " . self::$tableName . " WHERE id = :id"
        );
        $stmt->execute(['id' => $productId]);
        $product = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (empty($product)) return null;

        return new Product(
            $product['id'],
            $product['title'],
            $product['price'],
            $product['amount'],
            Category::getById($product['category_id']),
            $product['image'],
            $product['description'],
            Cart::isAddedProduct(
                $product['id'],
                User::getId()
            )
        );
    }

    public static function searchByName(string $searchStr)
    {
        $stmt = Db::getInstance()->getConnection()->query(
            "SELECT * FROM " . self::$tableName . " WHERE title LIKE CONCAT('%', '{$searchStr}', '%')"
        );
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];

        foreach ($products as $product) {
            $result[] = new Product(
                $product['id'],
                $product['title'],
                $product['price'],
                $product['amount'],
                Category::getById($product['category_id']),
                $product['image'],
                $product['description'],
                Cart::isAddedProduct(
                    $product['id'],
                    User::getId()
                )
            );
        }

        return $result;
    }
}