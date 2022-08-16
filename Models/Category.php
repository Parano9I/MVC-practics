<?php

namespace Shop\Models;

class Category
{
    public string $id;
    public string $name;
    private static $tableName = 'categories';

    public function __construct(
        string $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    public static function getById(string $categoryId): Category | bool
    {
        $stmt = Db::getInstance()->getConnection()->prepare(
            "SELECT * FROM " . self::$tableName . " WHERE id = :id"
        );
        $stmt->execute(['id' => $categoryId]);
        $category = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (empty($category)) return false;

        return new Category(
            $category['id'],
            $category['name']
        );
    }
}
