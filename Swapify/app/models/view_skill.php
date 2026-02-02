<?php
require_once '../app/controllers/SkillController.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: browse_skills.php");
    exit;
}

$controller = new SkillController();
$skill = $controller->getPublicById((int)$_GET['id']);

if (!$skill) {
    header("Location: browse_skills.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($skill['title']) ?> - Swapify</title>

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/components/navigation.css">
  <link rel="stylesheet" href="css/components/cards.css">
</head>

<body>

<header>
  <nav>
    <div class="logo">
      <h1><a href="index.php">Swapify</a></h1>
    </div>
    <ul class="nav-links">
      <li><a href="browse_skills.php">Back</a></li>
    </ul>
  </nav>
</header>

<main class="container">
  <div class="card">
    <h2><?= htmlspecialchars($skill['title']) ?></h2>

    <p><?= nl2br(htmlspecialchars($skill['description'])) ?></p>

    <p><strong>Category:</strong> <?= htmlspecialchars($skill['category_name']) ?></p>
    <p><strong>Level:</strong> <?= htmlspecialchars($skill['level']) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($skill['location']) ?></p>
    <p><strong>Teacher:</strong> <?= htmlspecialchars($skill['user_name']) ?></p>
  </div>
</main>

</body>
</html>
