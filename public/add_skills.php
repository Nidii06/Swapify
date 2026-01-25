<?php
require_once '../app/helpers/Session.php';
require_once '../app/helpers/flash.php';
require_once '../app/controllers/SkillController.php';
require_once '../app/controllers/CategoryController.php';

$session = Session::getInstance();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$skillController = new SkillController();
$categoryController = new CategoryController();
$categories = $categoryController->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        empty($_POST['title']) ||
        empty($_POST['category_id']) ||
        empty($_POST['description']) ||
        empty($_POST['level'])
    ) {
        setFlash('error', 'Please fill in all required fields.');
        header("Location: add_skills.php");
        exit;
    }

    if (strlen($_POST['title']) < 3) {
        setFlash('error', 'Skill title must be at least 3 characters.');
        header("Location: add_skills.php");
        exit;
    }

    $user = $session->user();
    $skillController->add($_POST, $user['id']);
    setFlash('success', 'Skill added successfully!');
    header("Location: profile.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Skill - Swapify</title>

  <link rel="stylesheet" href="css/style.css?v=4">
  <link rel="stylesheet" href="css/components/navigation.css?v=4">
  <link rel="stylesheet" href="css/components/buttons.css?v=4">
  <link rel="stylesheet" href="css/components/forms.css?v=4">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
      <li><a href="profile.php">My Profile</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main class="container">

  <div class="skill-page-hero">
    <div class="skill-hero-content">
      <h1> Add New Skill</h1>
      <p>Share your expertise with the community and help others learn</p>
    </div>
  </div>

  <div class="form-wrapper">
    <form method="POST">

      <div class="form-group">
        <label>Skill Title </label>
        <input type="text" name="title" required>
      </div>

      <div class="form-group">
        <label>Category </label>
        <select name="category_id" required>
          <option value="">Select category</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>">
              <?php echo htmlspecialchars($category['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label>Skill Level </label>
        <select name="level" required>
          <option value="beginner">Beginner</option>
          <option value="intermediate">Intermediate</option>
          <option value="advanced">Advanced</option>
          <option value="expert">Expert</option>
        </select>
      </div>

      <div class="form-group">
        <label>Description </label>
        <textarea name="description" rows="4" required></textarea>
      </div>

      <div class="form-group">
        <label>Teaching Method</label>
        <select name="teaching_method">
          <option value="online">Online</option>
          <option value="in-person">In Person</option>
          <option value="both">Both</option>
        </select>
      </div>

      <div class="form-group">
        <label>Location</label>
        <input type="text" name="location" placeholder="City, Country">
      </div>

      <div class="form-actions">
        <a href="profile.php" class="btn btn-cancel">
          <i class="fas fa-times"></i> Cancel
        </a>
        <button type="submit" class="btn btn-primary-blue">
          <i class="fas fa-plus"></i> Add Skill
        </button>
      </div>

    </form>
  </div>

</main>

</body>
</html>
