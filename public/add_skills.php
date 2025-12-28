<?php
session_start();
require_once '../app/controllers/SkillController.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$controller = new SkillController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->add($_POST, $_SESSION['user']['id']);
    header("Location: profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Skills - Swapify</title>
  
    <link rel = "stylesheet" href="css/style.css">
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
        <li><a href="profile.php">My Profile</a></li>
           <li><a href="contact.php">Contact</a></li>
        <li><a href="login.php">Logout</a></li>
      </ul>

    </nav>
  </header>

  <main class="container">
    <div class="page-header">
      <h1>Add New Skills</h1>
      <p>Share your expertise with the Swapify community</p>
    </div>

    <div class="form-container">
      <form method="POST" action="add_skills.php">

  <div class="form-group">
    <label>Skill Name </label>
    <input type="text" name="title" required>
  </div>

  <div class="form-group">
    <label>Category ID *</label>
    <input type="number" name="category_id" required>
  </div>

  <div class="form-group">
    <label>Skill Level</label>
    <input type="text" name="level">
  </div>

  <div class="form-group">
    <label>Skill Description *</label>
    <textarea name="description" required></textarea>
  </div>

  <div class="form-group">
    <label>Teaching Method</label>
    <input type="text" name="teaching_method">
  </div>

  <div class="form-group">
    <label>Location</label>
    <input type="text" name="location">
  </div>

  <div class="form-actions">
    <a href="profile.php" class="btn btn-danger">Cancel</a>
    <button type="submit" class="btn btn-success">Add Skill</button>
  </div>

</form>

    </div>
  </main>
  
</body>
</html>