<?php
require_once '../app/controllers/CategoryController.php';
require_once '../app/controllers/SkillController.php';

$categoryController = new CategoryController();
$categories = $categoryController->getAll();

$skillController = new SkillController();
$skills = $skillController->search(null, null, null);
if (!is_array($skills)) {
  $skills = [];
}
function getDifficultyColor($level) {
  $colors = [
    'beginner' => '#27ae60',
    'intermediate' => '#f39c12',
    'advanced' => '#e74c3c',
    'expert' => '#8e44ad'
  ];
  $level = strtolower((string)$level);
  return $colors[$level] ?? '#3498db';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
  <title>Browse Skills - Swapify</title>

  <link rel="stylesheet" href="css/style.css?v=3">
  <link rel="stylesheet" href="css/components/navigation.css?v=3">
  <link rel="stylesheet" href="css/components/buttons.css?v=3">
  <link rel="stylesheet" href="css/components/forms.css?v=3">
  <link rel="stylesheet" href="css/components/cards.css?v=3">
  <link rel="stylesheet" href="css/components/browse.css?v=3">
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
      <li><a href="profile.php">My Profile</a></li>
      <li><a href="browse_skills.php">Browse Skills</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main class="container">

  <div class="browse-hero">
    <div class="hero-content">
      <h1>Discover & Share Skills</h1>
      <p>Join our community of learners and experts. Find people to learn from and share your expertise with others.</p>
      <div class="hero-stats">
        <div class="stat-item"><span class="stat-icon">👥</span><span class="stat-text">Expert Community</span></div>
        <div class="stat-item"><span class="stat-icon">📚</span><span class="stat-text">Learn Anything</span></div>
        <div class="stat-item"><span class="stat-icon">🌍</span><span class="stat-text">Worldwide Network</span></div>
      </div>
    </div>
  </div>

  <div class="browse-container">

    <div class="cta-section">
      <p>Want to teach something new?</p>
      <a href="add_skills.php" class="btn btn-cta"><i class="fas fa-plus"></i> Add Your Skill</a>
    </div>

    <div class="skills-container">
      <div class="skills-flexbox" id="skillsFlexbox">
        <?php include __DIR__ . '/partials/skills_list.php'; ?>
      </div>
    </div>

  </div>
</main>

<script src="js/brows_skills.js?v=2" defer></script>
</body>
</html>
