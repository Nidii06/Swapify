<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../app/controllers/SkillController.php';
require_once __DIR__ . '/../../app/models/User.php';

header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

$skillId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($skillId <= 0) {
    http_response_code(400);
    echo '<div class="detail-item"><p>Invalid request.</p></div>';
    exit;
}

try {
    $skillController = new SkillController();
    $skill = $skillController->getPublicById($skillId);

    if (!$skill || !isset($skill['user_id'])) {
        http_response_code(404);
        echo '<div class="detail-item"><p>Not found.</p></div>';
        exit;
    }

    $userModel = new User();
    $user = $userModel->findById((int)$skill['user_id']);

    if (!$user) {
        http_response_code(404);
        echo '<div class="detail-item"><p>User not found.</p></div>';
        exit;
    }

    $fullName = htmlspecialchars((string)($user['full_name'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email    = htmlspecialchars((string)($user['email'] ?? ''), ENT_QUOTES, 'UTF-8');
    $bio      = htmlspecialchars((string)($user['bio'] ?? ''), ENT_QUOTES, 'UTF-8');
    $location = htmlspecialchars((string)($user['location'] ?? ''), ENT_QUOTES, 'UTF-8');

    // Render profile/contact info using existing .detail-item styles
    echo '<div class="detail-item">';
    echo '  <label><i class="fas fa-id-card"></i> Profile</label>';
    echo '  <p>' . ($fullName !== '' ? $fullName : 'Not available') . '</p>';
    echo '</div>';

    echo '<div class="detail-item">';
    echo '  <label><i class="fas fa-envelope"></i> Email</label>';
    if ($email !== '') {
        echo '  <p><a href="mailto:' . $email . '" style="color:inherit; text-decoration:underline;">' . $email . '</a></p>';
    } else {
        echo '  <p>Not available</p>';
    }
    echo '</div>';

    echo '<div class="detail-item">';
    echo '  <label><i class="fas fa-location-dot"></i> User location</label>';
    echo '  <p>' . ($location !== '' ? $location : 'Not available') . '</p>';
    echo '</div>';

    echo '<div class="detail-item">';
    echo '  <label><i class="fas fa-comment"></i> Bio</label>';
    echo '  <p>' . ($bio !== '' ? $bio : 'Not available') . '</p>';
    echo '</div>';

} catch (Throwable $e) {
    http_response_code(500);
    echo '<div class="detail-item"><p>Server error.</p></div>';
}
