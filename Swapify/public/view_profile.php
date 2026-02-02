<?php
require_once '../app/helpers/Session.php';
require_once '../app/controllers/SkillController.php';
require_once '../app/models/User.php';

if (!isset($_GET['id'])) {
    header("Location: browse_skills.php");
    exit;
}

$userId = (int) $_GET['id'];
$userModel = new User();
$skillController = new SkillController();

$user = $userModel->findById($userId);

if (!$user) {
    header("Location: browse_skills.php");
    exit;
}

$skills = $skillController->getUserSkills($userId);

function getDifficultyColor($level) {
    $colors = [
        'beginner' => '#27ae60',
        'intermediate' => '#f39c12',
        'advanced' => '#e74c3c',
        'expert' => '#8e44ad'
    ];
    return $colors[strtolower($level)] ?? '#3498db';
}

function getInitials($name) {
    $parts = explode(' ', trim($name));
    $initials = '';
    foreach ($parts as $part) {
        $initials .= strtoupper($part[0]);
    }
    return substr($initials, 0, 2);
}

function getCategoryImage($categoryName) {
    $images = [
        'Languages' => 'img/category-languages.jpg',
        'Technology' => 'img/category-tech.jpg',
        'Arts' => 'img/category-arts.jpg',
        'Sports' => 'img/category-sports.jpg',
        'Music' => 'img/category-music.jpg',
        'Business' => 'img/category-business.jpg'
    ];
    return $images[$categoryName] ?? 'img/default-category.jpg';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($user['full_name']) ?>'s Profile - Swapify</title>

  <link rel="stylesheet" href="css/style.css?v=4">
  <link rel="stylesheet" href="css/components/navigation.css?v=4">
  <link rel="stylesheet" href="css/components/buttons.css?v=4">
  <link rel="stylesheet" href="css/components/cards.css?v=4">
  <link rel="stylesheet" href="css/components/profile.css?v=1">
  <link rel="stylesheet" href="css/components/view-profile.css?v=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="js/auth_sync.js" defer></script>
</head>
<body>

<header>
  <nav>
    <div class="logo">
      <h1><a href="index.php">Swapify</a></h1>
    </div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="browse_skills.php">Browse Skills</a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li><a href="profile.php">My Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<main class="container">

  <div class="back-button">
    <a href="browse_skills.php">
      <i class="fas fa-arrow-left"></i> Back to Browse Skills
    </a>
  </div>

  <div class="public-profile-header">
    <h1><?= htmlspecialchars($user['full_name']) ?></h1>
    <p>Skills Instructor</p>
  </div>

  <div class="public-profile-content">
    <div class="profile-card">
      <div class="profile-avatar" style="background: linear-gradient(135deg, #87CEEB 0%, #5DADE2 100%);">
        <?= getInitials($user['full_name']) ?>
      </div>
      <div class="profile-info">
        <div class="profile-name"><?= htmlspecialchars($user['full_name']) ?></div>
        
        <?php if ($user['bio']): ?>
          <div class="profile-detail">
            <label>Bio</label>
            <p><?= htmlspecialchars($user['bio']) ?></p>
          </div>
        <?php endif; ?>
        
        <?php if ($user['location']): ?>
          <div class="profile-detail">
            <label><i class="fas fa-map-marker-alt"></i> Location</label>
            <p><?= htmlspecialchars($user['location']) ?></p>
          </div>
        <?php endif; ?>

        <div class="profile-detail">
          <label>Member Since</label>
          <p><?= date('F Y', strtotime($user['created_at'] ?? date('Y-m-d'))) ?></p>
        </div>

        <div class="profile-detail">
          <label>Skills Listed</label>
          <p><?= count($skills) ?></p>
        </div>
      </div>
    </div>

    <div class="user-skills-section">
      <div class="skills-title">
        <i class="fas fa-star"></i> Skills (<?= count($skills) ?>)
      </div>

      <?php if (empty($skills)): ?>
        <div class="no-skills">
          <div class="no-skills-icon">📚</div>
          <p>This user hasn't listed any skills yet.</p>
        </div>
      <?php else: ?>
        <div class="skills-flexbox">
          <?php foreach ($skills as $skill): 
            $categoryImage = getCategoryImage($skill['category_name'] ?? 'Default');
            $difficultyColor = getDifficultyColor($skill['level']);
          ?>
            <div class="skill-card-public">
              <img src="<?= htmlspecialchars($categoryImage) ?>" alt="<?= htmlspecialchars($skill['category_name'] ?? 'Category') ?>" class="skill-card-image">
              <div class="skill-card-body">
                <h3 class="skill-title"><?= htmlspecialchars($skill['title']) ?></h3>
                <p class="skill-description">
                  <?= htmlspecialchars(substr($skill['description'], 0, 80)) ?>...
                </p>
                <div class="skill-meta">
                  <span class="badge badge-level" style="background-color: <?= $difficultyColor ?>; color: white;">
                    <i class="fas fa-star"></i> <?= ucfirst($skill['level']) ?>
                  </span>
                  <span class="badge badge-method">
                    <i class="fas fa-chalkboard-user"></i> <?= ucfirst(str_replace('-', ' ', $skill['teaching_method'] ?? 'N/A')) ?>
                  </span>
                </div>
                <?php if ($skill['location']): ?>
                  <p style="color: #666; font-size: 12px;">
                    <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($skill['location']) ?>
                  </p>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

</main>

</body>
</html>
