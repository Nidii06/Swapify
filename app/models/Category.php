<?php
require_once __DIR__ . '/../core/BaseModel.php';

class Category extends BaseModel
{
    public function getAll(): array
    {
        return $this->fetchAll(
            "SELECT id, name FROM categories ORDER BY name"
        );
    }

    public function findById(int $id): ?array
    {
        return $this->fetchOne(
            "SELECT * FROM categories WHERE id = :id",
            ['id' => $id]
        );
    }
}

