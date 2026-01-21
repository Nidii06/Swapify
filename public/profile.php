<?php
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile - Swapify</title>

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/components/navigation.css">
  <link rel="stylesheet" href="css/components/buttons.css">
  <link rel="stylesheet" href="css/components/forms.css">
  <link rel="stylesheet" href="css/components/cards.css">
</head>

<body>

<header>
  <nav>
    <div class="logo">
      <h1><a href="index.php">Swapify</a></h1>
    </div>

    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php">About Us</a></li>
      <li><a href="browse_skills.php">Browse Skills</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="profile.php">My Profile</a></li>
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
      <div class="avatar-placeholder">
        <?php echo strtoupper(substr($user['name'], 0, 2)); ?>
      </div>
    </div>

    <div class="profile-details">
      <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>
      <p class="profile-location">Prishtina, Kosova</p>
      <p class="profile-bio">Passionate web developer and language enthusiast.</p>

      <div class="profile-stats">
        <div class="stat">
          <span class="stat-number"><?php echo count($skills); ?></span>
          <span class="stat-label">Skills Shared</span>
        </div>
        <div class="stat">
          <span class="stat-number">4.8</span>
          <span class="stat-label">Rating</span>
        </div>
      </div>
    </div>
  </div>

  <div class="profile-actions">
    <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
    <a href="add_skills.php" class="btn btn-success">Add New Skills</a>
  </div>
</div>

<section class="skills-section">
  <h2>My Skills</h2>

  <?php if (empty($skills)): ?>
    <p>You haven't added any skills yet.</p>
  <?php else: ?>
    <div class="skills-grid">
      <?php foreach ($skills as $skill): ?>
        <div class="card">
          <h3><?php echo htmlspecialchars($skill['title']); ?></h3>
          <p><?php echo htmlspecialchars($skill['description']); ?></p>
          <p><strong>Level:</strong> <?php echo htmlspecialchars($skill['level']); ?></p>
          <p><strong>Location:</strong> <?php echo htmlspecialchars($skill['location']); ?></p>

          <div class="card-actions">
            <a href="edit_skill.php?id=<?php echo $skill['id']; ?>" class="btn btn-primary">
              Edit
            </a>
            <button
              type="button"
              class="btn btn-danger"
              onclick="openDeleteModal(<?php echo $skill['id']; ?>)">
              Delete
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
        <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
          Cancel
        </button>
        <button type="submit" class="btn btn-danger">
          Delete
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openDeleteModal(id) {
  document.getElementById('deleteSkillId').value = id;
  document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
  document.getElementById('deleteModal').style.display = 'none';
}

setTimeout(() => {
  document.querySelectorAll('.flash').forEach(flash => {
    flash.style.transition = 'opacity 0.5s ease';
    flash.style.opacity = '0';
    setTimeout(() => flash.remove(), 500);
  });
}, 3500);
</script>

</body>
</html>
