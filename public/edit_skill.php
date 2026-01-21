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

if (!isset($_GET['id'])) {
    header("Location: profile.php");
    exit;
}

$skillId = (int) $_GET['id'];
$user = $session->user();
$userId = $user['id'];

$skillController = new SkillController();
$categoryController = new CategoryController();

$skill = $skillController->getById($skillId, $userId);
$categories = $categoryController->getAll();

if (!$skill) {
    setFlash('error', 'Skill not found.');
    header("Location: profile.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        empty($_POST['title']) ||
        empty($_POST['category_id']) ||
        empty($_POST['description']) ||
        empty($_POST['level'])
    ) {
        setFlash('error', 'All required fields must be filled.');
        header("Location: edit_skill.php?id=" . $skillId);
        exit;
    }

    $skillController->update($skillId, $_POST, $userId);
    setFlash('success', 'Skill updated successfully!');
    header("Location: profile.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Skill - Swapify</title>

  <link rel="stylesheet" href="css/style.css">
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
      <li><a href="profile.php">My Profile</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main class="container">

  <div class="page-header">
    <h1>Edit Skill</h1>
    <p>Update your skill information</p>
  </div>

  <div class="form-container">
    <form method="POST">

      <div class="form-group">
        <label>Skill Title *</label>
        <input type="text" name="title"
               value="<?php echo htmlspecialchars($skill['title']); ?>" required>
      </div>

      <div class="form-group">
        <label>Category *</label>
        <select name="category_id" required>
          <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>"
              <?php if ($category['id'] == $skill['category_id']) echo 'selected'; ?>>
              <?php echo htmlspecialchars($category['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label>Skill Level *</label>
        <select name="level" required>
          <?php
          $levels = ['beginner', 'intermediate', 'advanced', 'expert'];
          foreach ($levels as $level):
          ?>
            <option value="<?php echo $level; ?>"
              <?php if ($skill['level'] === $level) echo 'selected'; ?>>
              <?php echo ucfirst($level); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label>Description *</label>
        <textarea name="description" rows="4" required><?php
            echo htmlspecialchars($skill['description']);
        ?></textarea>
      </div>

      <div class="form-group">
        <label>Teaching Method</label>
        <select name="teaching_method">
          <?php
          $methods = ['online', 'in-person', 'both'];
          foreach ($methods as $method):
          ?>
            <option value="<?php echo $method; ?>"
              <?php if ($skill['teaching_method'] === $method) echo 'selected'; ?>>
              <?php echo ucfirst($method); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label>Location</label>
        <input type="text" name="location"
               value="<?php echo htmlspecialchars($skill['location']); ?>">
      </div>

      <div class="form-actions">
        <a href="profile.php" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success">Update Skill</button>
      </div>

    </form>
  </div>

</main>

</body>
</html>
