<?php
require_once __DIR__ . '/../models/Skill.php';

class SkillController {

    private $skill;

    public function __construct() {
        $this->skill = new Skill();
    }

    public function add($post, $userId) {
        return $this->skill->add($post, $userId);
    }

    public function getUserSkills($userId) {
    return $this->skill->getByUser($userId);
}


    public function delete($id, $userId) {
        return $this->skill->delete($id, $userId);
    }

    public function getAllSkills() {
    return $this->skill->getAll();
}

}
