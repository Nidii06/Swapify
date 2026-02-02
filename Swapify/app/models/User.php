<?php
require_once __DIR__ . '/../core/BaseModel.php';

class User extends BaseModel
{
    public function register(array $data): bool
    {
        $sql = "INSERT INTO users (full_name, email, password, bio, location)
                VALUES (:name, :email, :password, :bio, :location)";
        
        return $this->execute($sql, [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'bio' => $data['bio'] ?? null,
            'location' => $data['location'] ?? null
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        return $this->fetchOne(
            "SELECT * FROM users WHERE email = :email",
            ['email' => $email]
        );
    }

    public function findById(int $id): ?array
    {
        return $this->fetchOne(
            "SELECT * FROM users WHERE id = :id",
            ['id' => $id]
        );
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE users SET 
                full_name = :name,
                email = :email,
                bio = :bio,
                location = :location
                WHERE id = :id";
        
        return $this->execute($sql, [
            'name' => $data['name'],
            'email' => $data['email'],
            'bio' => $data['bio'] ?? null,
            'location' => $data['location'] ?? null,
            'id' => $id
        ]);
    }

    public function findByName(string $name): ?array
    {
        return $this->fetchOne(
            "SELECT * FROM users WHERE full_name LIKE :name LIMIT 1",
            ['name' => "%$name%"]
        );
    }

    public function getFeaturedUsers(): array
    {
        return $this->fetchAll(
            "SELECT * FROM users WHERE full_name IN ('Anid', 'Blert', 'Anid Bojaj', 'Blert') OR full_name LIKE '%Anid%' OR full_name LIKE '%Blert%' LIMIT 2"
        );
    }

    public function findAll(): array
    {
        return $this->fetchAll(
            "SELECT id, full_name, email, location, created_at FROM users ORDER BY created_at DESC"
        );
    }

    public function delete(int $id): bool
    {
        return $this->execute(
            "DELETE FROM users WHERE id = :id",
            ['id' => $id]
        );
    }
}
