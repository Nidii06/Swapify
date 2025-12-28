<?php
session_start();
require_once '../app/controllers/AuthController.php';

$auth = new AuthController();

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($auth->login($email, $password)) {
        if ($_SESSION['user']['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: profile.php");
        }
        exit;
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Swapify</title>
  <link rel = "stylesheet" href = "css/style.css">
  <link rel="stylesheet" href="css/components/navigation.css">
  <link rel="stylesheet" href="css/components/buttons.css">
  <link rel="stylesheet" href="css/components/forms.css">
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
        <li><a href="contact.php">Contact</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="login.php">Login</a></li>  
      </ul>
    </nav>
  </header>

  <main class="container">
    <div class="form-container">
      <h2>Login to Your Account</h2>

      <?php if (!empty($error_message)): ?>
        <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn" style="width: 100%;">Login</button>
      </form>

      <p style="text-align: center; margin-top: 1rem;">
        Don't have an account? <a href="register.php">Register here</a>
      </p>
    </div>
  </main>
</body>
</html>