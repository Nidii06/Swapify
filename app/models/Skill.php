<?php
require_once __DIR__ . '/../core/Database.php';

class Skill extends Database {

    public function add($data, $userId) {
        $sql = "INSERT INTO skills 
            (user_id, category_id, title, description, level, teaching_method, location, status)
            VALUES 
            (:user_id, :category_id, :title, :description, :level, :teaching_method, :location, :status)";

        $stmt = $this->connect()->prepare($sql);

        return $stmt->execute([
            'user_id' => $userId,
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'level' => $data['level'],
            'teaching_method' => $data['teaching_method'],
            'location' => $data['location'],
            'status' => 'active'
        ]);
    }

    public function getByUser($userId) {
        $stmt = $this->connect()->prepare(
            "SELECT * FROM skills WHERE user_id = :user_id"
        );
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id, $userId) {
        $stmt = $this->connect()->prepare(
            "DELETE FROM skills WHERE id = :id AND user_id = :user_id"
        );
        return $stmt->execute([
            'id' => $id,
            'user_id' => $userId
        ]);
    }

    public function getAll() {
    $sql = "
        SELECT 
            skills.*,
            users.full_name AS user_name,
            categories.name AS category_name
        FROM skills
        JOIN users ON skills.user_id = users.id
        JOIN categories ON skills.category_id = categories.id
        WHERE skills.status = 'active'
        ORDER BY skills.created_at DESC
    ";

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
