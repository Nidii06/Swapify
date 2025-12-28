<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once '../app/controllers/SkillController.php';

$skillController = new SkillController();
$skills = $skillController->getUserSkills($_SESSION['user']['id']);
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

 
  <div class="profile-header">
    <div class="profile-info">

      <div class="profile-avatar">
        <div class="avatar-placeholder">
          <?php echo strtoupper(substr($_SESSION['user']['name'], 0, 2)); ?>
        </div>
      </div>

      <div class="profile-details">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']['name']); ?></h1>
        <p class="profile-location">Prishtina, Kosova</p>
        <p class="profile-bio">
          Passionate web developer and language enthusiast.
        </p>

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
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
  </section>

</main>

</body>
</html>
