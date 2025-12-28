<?php
require_once __DIR__ . '/../core/Database.php';

class User extends Database {

    public function register($data) {
    $sql = "INSERT INTO users (full_name, email, password, bio, location)
            VALUES (:name, :email, :password, :bio, :location)";
    
    $stmt = $this->connect()->prepare($sql);

    return $stmt->execute([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
        'bio' => $data['bio'] ?? null,
        'location' => $data['location'] ?? null
    ]);
}


    public function findByEmail($email) {
        $stmt = $this->connect()->prepare(
            "SELECT * FROM users WHERE email = :email"
        );
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
