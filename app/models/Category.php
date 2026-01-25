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

    public function add(array $data): bool
    {
        return $this->execute(
            "INSERT INTO categories (name) VALUES (:name)",
            ['name' => $data['name']]
        );
    }

    public function update(int $id, array $data): bool
    {
        return $this->execute(
            "UPDATE categories SET name = :name WHERE id = :id",
            ['name' => $data['name'], 'id' => $id]
        );
    }

    public function delete(int $id): bool
    {
        return $this->execute(
            "DELETE FROM categories WHERE id = :id",
            ['id' => $id]
        );
    }
}
