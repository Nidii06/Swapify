<?php
session_start();

require_once '../app/controllers/SkillController.php';

$skillController = new SkillController();
$skills = $skillController->getAllSkills();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Browse Skills - Swapify</title>
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
        <li><a href="register.php">Register</a></li>
        <li><a href="login.php">Login</a></li>
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
        <input type="text" placeholder="Search skills...">
        <button class="btn">Search</button>
      </div>

      <div class="filters">
        <select>
          <option value="">All Categories</option>
          <option value="technology">Technology</option>
          <option value="languages">Languages</option>
          <option value="music">Music</option>
          <option value="arts">Arts & Crafts</option>
          <option value="sports">Sports</option>
          <option value="academic">Academic</option>
        </select>
        <select>
          <option value="">All Locations</option>
          <option value="prishtine">Prishtine</option>
          <option value="prizren">Prizren</option>
          <option value="peje">Peje</option>
          <option value="ferizaj">Ferizaj</option>
        </select>
      </div>

      <div class="skills-grid">

        <div class="skill-card">

          <div class="skill-header">
            <h3>Web Development</h3>
            <span class="category technology">Technology</span>
          </div>
          <p class="skill-description">Learn HTML, CSS, JavaScript and build modern website.</p>
          <span class="user">Altin Berisha</span>
          <span class="location">Prishtine</span>
          <div class="skill-actions">
            <button class="btn btn-primary view-details-btn">View Details</button>
          </div>
          <ul class="details-list" style="display:none;"></ul>
        </div>

        <div class="skill-card">
          <div class="skill-header">
            <h3>English Language</h3>
            <span class="category languages">Languages</span>
          </div>
          <p class="skill-description">Conversational English practice and grammar lessons.</p>
          <span class="user">Sarah Gashi</span>
          <span class="location">Prizren</span>
          <div class="skill-actions">
            <button class="btn btn-primary view-details-btn">View Details</button>
          </div>
          <ul class="details-list" style="display:none;"></ul>
        </div>

        <div class="skill-card">
          <div class="skill-header">
            <h3>Guitar Lessons</h3>
            <span class="category music">Music</span>
          </div>
          <p class="skill-description">Beginner to intermediate guitar lessons for all ages.</p>
          <span class="user">Erblin Gashi</span>
          <span class="location">Peje</span>
          <div class="skill-actions">
            <button class="btn btn-primary view-details-btn">View Details</button>
          </div>
          <ul class="details-list" style="display:none;"></ul>
        </div>

        <div class="skill-card">
          <div class="skill-header">
            <h3>Photography</h3>
            <span class="category arts">Arts</span>
          </div>
          <p class="skill-description">Learn composition, lighting, and photo editing techniques.</p>
          <span class="user">Elma Gjakova</span>
          <span class="location">Peje</span>
          <div class="skill-actions">
            <button class="btn btn-primary view-details-btn">View Details</button>
          </div>
          <ul class="details-list" style="display:none;"></ul>
        </div>

        <div class="skill-card">
          <div class="skill-header">
            <h3>Cooking - Italian</h3>
            <span class="category cooking">Cooking</span>
          </div>
          <p class="skill-description">Learn authentic Italian pasta and sauce recipes.</p>
          <span class="user">Ben Krasniqi</span>
          <span class="location">Ferizaj</span>
          <div class="skill-actions">
            <button class="btn btn-primary view-details-btn">View Details</button>
          </div>
          <ul class="details-list" style="display:none;"></ul>
        </div>

        <div class="skill-card">
          <div class="skill-header">
            <h3>Yoga & Meditation</h3>
            <span class="category sports">Sports</span>
          </div>
          <p class="skill-description">Beginner yoga sessions and meditation techniques.</p>
          <span class="user">Lisa Miftari</span>
          <span class="location">Prishtine</span>
          <div class="skill-actions">
            <button class="btn btn-primary view-details-btn">View Details</button>
          </div>
          <ul class="details-list" style="display:none;"></ul>
        </div>

      </div>
    </div>
  </main>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const buttons = document.querySelectorAll('.view-details-btn');

  buttons.forEach(button => {
    button.addEventListener('click', () => {
      const card = button.closest('.skill-card');
      const user = card.querySelector('.user').textContent;
      const location = card.querySelector('.location').textContent;
      const skill = card.querySelector('.skill-header h3').textContent;
      const description = card.querySelector('.skill-description').textContent;

      const detailsList = card.querySelector('.details-list');

      if(detailsList.style.display === 'none') {
        detailsList.style.display = 'block';
        detailsList.innerHTML = `
          <li><strong>Name:</strong> ${user}</li>
          <li><strong>Location:</strong> ${location}</li>
          <li><strong>Skill:</strong> ${skill}</li>
          <li><strong>Description:</strong> ${description}</li>
        `;
        button.textContent = 'Hide Details';
      } else {
        detailsList.style.display = 'none';
        button.textContent = 'View Details';
      }
    });
  });
});
</script>

</body>
</html>
