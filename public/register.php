<?php
require_once '../app/controllers/AuthController.php';

$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->register($_POST);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Skill Swap</title>
  <link rel = "stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/components/navigation.css">
  <link rel="stylesheet" href="css/components/buttons.css">
  <link rel="stylesheet" href="css/components/forms.css">

</head>
<body>
  <header>
    <nav>
      <div class = "logo">
        <h1><a href = "index.php">Skill Swap</a></h1>

      </div>

      <ul class="nav-links">
        <li><a href = "index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="browse_skills.php">Browse Skills</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href = "register.php">Register</a></li>
        <li><a href = "login.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <main class = "container">
    <div class = "form-container">
      <h2>Create Your Account</h2>

      <form method="POST">
        <div class = "form-group">
          <label for="name">Full Name</label>
          <input type = "text" id = "name" name = "name" required>

        </div>

        <div class = "form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

      </div>

      <div class = "form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name = "password" required>
      </div>

      <div class = "form-group">
        <label for = "bio">Bio</label>
        <textarea id="bio" name="bio" placeholder="Tell us about yourself..."></textarea>
      </div>

      <div class = "form-group">
        <label for="location">Location</label>
        <input type = "text" id = "location" name = "location" placeholder="City, Country">
       </div>

      <button type="submit" class="btn" style="width: 100%;">Register</button>

      </form>

      <p style = "text-align: center; margin-top: 1rem;">
        Already have an account? <a href = "login.php">Login here</a>
      </p>
    </div>
  </main>
</body>
</html>