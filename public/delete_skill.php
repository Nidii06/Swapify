<?php
require_once '../app/helpers/Session.php';
require_once '../app/helpers/flash.php';
require_once '../app/controllers/SkillController.php';

$session = Session::getInstance();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
    setFlash('error', 'Invalid delete request.');
    header("Location: profile.php");
    exit;
}

$skillId = (int) $_POST['id'];
$user = $session->user();
$userId = $user['id'];

$controller = new SkillController();

if ($controller->delete($skillId, $userId)) {
    setFlash('success', 'Skill deleted successfully!');
} else {
    setFlash('error', 'Failed to delete skill.');
}

header("Location: profile.php");
exit;
