<?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

require_once '../app/helpers/Session.php';
require_once '../app/helpers/flash.php';
require_once '../app/controllers/SkillController.php';

$session = Session::getInstance();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$skillController = new SkillController();
$user = $session->user();
$skills = $skillController->getUserSkills($user['id']);

function getDifficultyColor($level) {
    $colors = [
        'beginner' => '#27ae60',
        'intermediate' => '#f39c12',
        'advanced' => '#e74c3c',
        'expert' => '#8e44ad'
    ];
    return $colors[strtolower($level)] ?? '#3498db';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile - Swapify</title>

  <link rel="stylesheet" href="css/style.css?v=4">
  <link rel="stylesheet" href="css/components/navigation.css?v=4">
  <link rel="stylesheet" href="css/components/buttons.css?v=4">
  <link rel="stylesheet" href="css/components/forms.css?v=4">
  <link rel="stylesheet" href="css/components/cards.css?v=4">
  <link rel="stylesheet" href="css/components/profile.css?v=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="js/auth_sync.js" defer></script>
  <script src="js/profile.js"></script>
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

<?php if ($msg = getFlash('success')): ?>
  <div class="flash flash-success"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>

<?php if ($msg = getFlash('error')): ?>
  <div class="flash flash-error"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>

<div class="profile-header">
  <div class="profile-info">

    <div class="profile-avatar">
      <div class="avatar-placeholder" style="background: linear-gradient(135deg, #87CEEB 0%, #5DADE2 100%);">
        <?php echo strtoupper(substr($user['full_name'] ?? $user['name'], 0, 2)); ?>
      </div>
    </div>

    <div class="profile-details">
      <h1><i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars($user['full_name'] ?? $user['name']); ?></h1>
      <p class="profile-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($user['location'] ?? 'Location not set'); ?></p>
      <p class="profile-bio"><i class="fas fa-quote-left"></i> <?php echo htmlspecialchars($user['bio'] ?? 'No bio added yet'); ?></p>

      <div class="profile-stats">
        <div class="stat">
          <span class="stat-number"><?php echo count($skills); ?></span>
          <span class="stat-label">Skills Shared</span>
        </div>
        <div class="stat">
          <span class="stat-number">4.8</span>
          <span class="stat-label">Rating</span>
        </div>
        <div class="stat">
          <span class="stat-number">24</span>
          <span class="stat-label">Students</span>
        </div>
      </div>
    </div>
  </div>

  <div class="profile-actions">
    <a href="edit_profile.php" class="btn btn-profile-edit">
      <i class="fas fa-edit"></i> Edit Profile
    </a>
    <a href="add_skills.php" class="btn btn-profile-add-skill">
      <i class="fas fa-plus-circle"></i> Add New Skill
    </a>
  </div>
</div>

<section class="skills-section">
  <div class="skills-section-header">
    <h2>My Skills</h2>
    <p class="skills-count">You have <?php echo count($skills); ?> skill<?php echo count($skills) !== 1 ? 's' : ''; ?> shared</p>
  </div>

  <?php if (empty($skills)): ?>
    <div class="no-skills-message">
      <div class="no-skills-icon">📚</div>
      <p>You haven't added any skills yet.</p>
      <p class="no-skills-hint">Start sharing your expertise and help others learn!</p>
      <a href="add_skills.php" class="btn btn-profile-add-skill">
        <i class="fas fa-plus-circle"></i> Add Your First Skill
      </a>
    </div>
  <?php else: ?>
    <div class="skills-flexbox">
      <?php foreach ($skills as $skill): ?>
        <div class="skill-card-profile">
          <div class="skill-card-header">
            <h3><?php echo htmlspecialchars($skill['title']); ?></h3>
            <span class="skill-level-badge" style="background-color: <?php echo getDifficultyColor($skill['level']); ?>;">
              <?php echo ucfirst($skill['level']); ?>
            </span>
          </div>
          
          <p class="skill-card-description"><?php echo htmlspecialchars(substr($skill['description'], 0, 100)); ?>...</p>
          
          <div class="skill-card-meta">
            <span class="meta-item">
              <i class="fas fa-map-marker-alt"></i>
              <?php echo htmlspecialchars($skill['location'] ?? 'Not specified'); ?>
            </span>
            <span class="meta-item">
              <i class="fas fa-chalkboard"></i>
              <?php echo ucfirst(str_replace('-', ' ', $skill['teaching_method'] ?? 'N/A')); ?>
            </span>
          </div>

          <div class="skill-card-actions">
            <a href="edit_skill.php?id=<?php echo $skill['id']; ?>" class="btn btn-skill-edit">
              <i class="fas fa-edit"></i> Edit
            </a>
            <button
              type="button"
              class="btn btn-skill-delete"
              data-skill-id="<?php echo $skill['id']; ?>">
              <i class="fas fa-trash-alt"></i> Delete
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

</main>

<div id="deleteModal" class="modal-overlay">
  <div class="modal-box">
    <h3>Delete Skill</h3>
    <p>Are you sure you want to delete this skill?</p>

    <form method="POST" action="delete_skill.php">
      <input type="hidden" name="id" id="deleteSkillId">

      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" id="closeModalBtn">
          Cancel
        </button>
        <button type="submit" class="btn btn-primary">
          Delete
        </button>
      </div>
    </form>
  </div>
</div>

</body>
</html>