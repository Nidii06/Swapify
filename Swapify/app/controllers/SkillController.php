<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/Skill.php';

class SkillController extends BaseController
{
    private $skill;

    public function __construct()
    {
        parent::__construct();
        $this->skill = new Skill();
    }

    public function add(array $data, int $userId): bool
    {
        return $this->skill->add($data, $userId);
    }

    public function getUserSkills(int $userId): array
    {
        return $this->skill->getByUser($userId);
    }

    public function getById(int $id, int $userId): ?array
    {
        return $this->skill->findById($id, $userId);
    }

    public function update(int $id, array $data, int $userId): bool
    {
        return $this->skill->update($id, $data, $userId);
    }

    public function delete(int $id, int $userId): bool
    {
        return $this->skill->delete($id, $userId);
    }

    public function getAllSkills(): array
    {
        return $this->skill->getAll();
    }

    public function getPublicById(int $id): ?array
    {
        return $this->skill->getPublicById($id);
    }

    public function search(
        ?string $keyword = null,
        ?int $category = null,
        ?string $location = null
    ): array {
        return $this->skill->search($keyword, $category, $location);
    }

    public function searchPaginated(
        ?string $keyword = null,
        ?int $category = null,
        ?string $location = null,
        int $page = 1,
        int $limit = 6
    ): array {
        $offset = ($page - 1) * $limit;
        return $this->skill->searchPaginated(
            $keyword,
            $category,
            $location,
            $limit,
            $offset
        );
    }
}
