<?php
require_once '../app/controllers/CategoryController.php';

$categoryController = new CategoryController();
$categories = $categoryController->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
  <title>Browse Skills - Swapify</title>

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/components/navigation.css">
  <link rel="stylesheet" href="css/components/buttons.css">
  <link rel="stylesheet" href="css/components/forms.css">
  <link rel="stylesheet" href="css/components/cards.css">
  <link rel="stylesheet" href="css/components/browse.css">
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
      <li><a href="contact.php">Contact</a></li>
      <li><a href="about.php">About Us</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main class="container">

  <div class="page-header">
    <h1>Browse Available Skills</h1>
    <p>Find people to learn from and share your knowledge</p>
  </div>

  <div class="search-section">

    <div class="search-bar">
      <input type="text" id="keyword" placeholder="Search skills...">
      <button type="button" class="btn" onclick="loadSkills()">Search</button>
    </div>

    <div class="filters">
      <select id="category">
        <option value="">All Categories</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>">
            <?= htmlspecialchars($cat['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <input type="text" id="location" placeholder="Location">
    </div>

    <div class="skills-grid" id="skillsGrid"></div>

  </div>
</main>

<script>
const keyword  = document.getElementById('keyword');
const category = document.getElementById('category');
const location = document.getElementById('location');
const grid     = document.getElementById('skillsGrid');

const urlParams = new URLSearchParams(window.location.search);
const categoryParam = urlParams.get('category');
if (categoryParam) {
  category.value = categoryParam;
}

function loadSkills() {
  const params = new URLSearchParams({
    keyword: keyword.value,
    category: category.value,
    location: location.value
  });

  fetch('ajax/search_skills.php?' + params)
    .then(res => res.text())
    .then(html => {
      grid.innerHTML = html;
      attachViewDetailsHandlers();
    });
}

function attachViewDetailsHandlers() {
  const buttons = document.querySelectorAll('.view-details-btn');

  buttons.forEach(button => {
    button.addEventListener('click', () => {
      const skillId = button.getAttribute('data-skill-id');
      const card = button.closest('.skill-card');
      const detailsList = card.querySelector('.details-list[data-skill-id="' + skillId + '"]');

      if (detailsList && detailsList.style.display === 'none') {
        detailsList.style.display = 'block';
        button.textContent = 'Hide Details';
      } else if (detailsList) {
        detailsList.style.display = 'none';
        button.textContent = 'View Details';
      }
    });
  });
}

[keyword, category, location].forEach(el =>
  el.addEventListener('input', loadSkills)
);

loadSkills();
</script>

</body>
</html>
