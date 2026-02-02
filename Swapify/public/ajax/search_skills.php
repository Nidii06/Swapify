<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../app/controllers/SkillController.php';

header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

$keyword  = (isset($_GET['keyword']) && trim($_GET['keyword']) !== '') ? trim($_GET['keyword']) : null;
$category = (isset($_GET['category']) && trim($_GET['category']) !== '') ? (int)$_GET['category'] : null;
$location = (isset($_GET['location']) && trim($_GET['location']) !== '') ? trim($_GET['location']) : null;

try {
    $controller = new SkillController();
    $skills = $controller->search($keyword, $category, $location);
    if (!is_array($skills)) $skills = [];
} catch (Exception $e) {
    echo '<div class="error-message">Failed to load skills.</div>';
    exit;
}

// Renders "No skills found" itself when empty
include __DIR__ . '/../partials/skills_list.php';
