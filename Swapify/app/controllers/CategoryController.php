<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/Category.php';

class CategoryController extends BaseController
{
    private $category;

    public function __construct()
    {
        parent::__construct();
        $this->category = new Category();
    }

    public function getAll(): array
    {
        return $this->category->getAll();
    }

    public function findById(int $id): ?array
    {
        return $this->category->findById($id);
    }
}
