<?php
require_once __DIR__ . '/../core/BaseModel.php';

class Skill extends BaseModel
{

    public function add(array $data, int $userId): bool
    {
        $sql = "INSERT INTO skills 
            (user_id, category_id, title, description, level, teaching_method, location, status)
            VALUES 
            (:user_id, :category_id, :title, :description, :level, :teaching_method, :location, 'active')";

        return $this->execute($sql, [
            'user_id' => $userId,
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'level' => $data['level'],
            'teaching_method' => $data['teaching_method'],
            'location' => $data['location']
        ]);
    }

    public function getByUser(int $userId): array
    {
        return $this->fetchAll(
            "SELECT * FROM skills WHERE user_id = :user_id ORDER BY created_at DESC",
            ['user_id' => $userId]
        );
    }

    public function getAll(): array
    {
        return $this->fetchAll("
            SELECT 
                skills.*,
                users.full_name AS user_name,
                categories.name AS category_name
            FROM skills
            JOIN users ON skills.user_id = users.id
            JOIN categories ON skills.category_id = categories.id
            WHERE skills.status = 'active'
            ORDER BY skills.created_at DESC
        ");
    }

    public function search(?string $keyword, ?int $category, ?string $location): array
    {
        $sql = "
            SELECT 
                skills.*,
                users.full_name AS user_name,
                categories.name AS category_name
            FROM skills
            JOIN users ON skills.user_id = users.id
            JOIN categories ON skills.category_id = categories.id
            WHERE skills.status = 'active'
        ";

        $params = [];

        if ($keyword) {
            $sql .= " AND (skills.title LIKE :keyword OR skills.description LIKE :keyword)";
            $params['keyword'] = "%$keyword%";
        }

        if ($category) {
            $sql .= " AND skills.category_id = :category";
            $params['category'] = $category;
        }

        if ($location) {
            $sql .= " AND skills.location LIKE :location";
            $params['location'] = "%$location%";
        }

        $sql .= " ORDER BY skills.created_at DESC";

        return $this->fetchAll($sql, $params);
    }

    public function searchPaginated(?string $keyword, ?int $category, ?string $location, int $limit, int $offset): array
    {
        $sql = "
            SELECT 
                skills.*,
                users.full_name AS user_name,
                categories.name AS category_name
            FROM skills
            JOIN users ON skills.user_id = users.id
            JOIN categories ON skills.category_id = categories.id
            WHERE skills.status = 'active'
        ";

        $params = [];

        if ($keyword) {
            $sql .= " AND (skills.title LIKE :keyword OR skills.description LIKE :keyword)";
            $params['keyword'] = "%$keyword%";
        }

        if ($category) {
            $sql .= " AND skills.category_id = :category";
            $params['category'] = $category;
        }

        if ($location) {
            $sql .= " AND skills.location LIKE :location";
            $params['location'] = "%$location%";
        }

        $sql .= " ORDER BY skills.created_at DESC LIMIT :limit OFFSET :offset";

        $params['limit'] = $limit;
        $params['offset'] = $offset;

        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $k => $v) {
            $type = is_int($v) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue(":$k", $v, $type);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPublicById(int $id): ?array
    {
        return $this->fetchOne("
            SELECT 
                skills.*,
                users.full_name AS user_name,
                categories.name AS category_name
            FROM skills
            JOIN users ON skills.user_id = users.id
            JOIN categories ON skills.category_id = categories.id
            WHERE skills.id = :id AND skills.status = 'active'
        ", ['id' => $id]);
    }

    public function update(int $id, array $data, int $userId): bool
    {
        return $this->execute("
            UPDATE skills SET
                title = :title,
                category_id = :category_id,
                description = :description,
                level = :level,
                teaching_method = :teaching_method,
                location = :location
            WHERE id = :id AND user_id = :user_id
        ", [
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'description' => $data['description'],
            'level' => $data['level'],
            'teaching_method' => $data['teaching_method'],
            'location' => $data['location'],
            'id' => $id,
            'user_id' => $userId
        ]);
    }

    public function delete(int $id, int $userId): bool
    {
        return $this->execute(
            "DELETE FROM skills WHERE id = :id AND user_id = :user_id",
            ['id' => $id, 'user_id' => $userId]
        );
    }

    public function deleteById(int $id): bool
    {
        return $this->execute(
            "DELETE FROM skills WHERE id = :id",
            ['id' => $id]
        );
    }

    public function findById(int $id, int $userId): ?array
    {
        return $this->fetchOne(
            "SELECT * FROM skills WHERE id = :id AND user_id = :user_id",
            ['id' => $id, 'user_id' => $userId]
        );
    }
}
