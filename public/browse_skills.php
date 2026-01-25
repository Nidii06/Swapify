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

  <link rel="stylesheet" href="css/style.css?v=3">
  <link rel="stylesheet" href="css/components/navigation.css?v=3">
  <link rel="stylesheet" href="css/components/buttons.css?v=3">
  <link rel="stylesheet" href="css/components/forms.css?v=3">
  <link rel="stylesheet" href="css/components/cards.css?v=3">
  <link rel="stylesheet" href="css/components/browse.css?v=3">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    .instructor-header-link {
      transition: all 0.3s ease;
    }
    
    .instructor-header-link:hover {
      opacity: 0.8;
    }
    
    .instructor-header-link:hover .instructor-name {
      color: #667eea;
      text-decoration: underline;
    }
  </style>
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

  <div class="browse-hero">
    <div class="hero-content">
      <h1>Discover & Share Skills</h1>
      <p>Join our community of learners and experts. Find people to learn from and share your expertise with others.</p>
      <div class="hero-stats">
        <div class="stat-item">
          <span class="stat-icon">👥</span>
          <span class="stat-text">Expert Community</span>
        </div>
        <div class="stat-item">
          <span class="stat-icon">📚</span>
          <span class="stat-text">Learn Anything</span>
        </div>
        <div class="stat-item">
          <span class="stat-icon">🌍</span>
          <span class="stat-text">Worldwide Network</span>
        </div>
      </div>
    </div>
  </div>

  <div class="browse-container">

  <div class="cta-section">
      <p>Want to teach something new?</p>
      <a href="add_skills.php" class="btn btn-cta">
        <i class="fas fa-plus"></i> Add Your Skill
      </a>
    </div>

    <div class="search-section">
      <div class="search-header">
        <h2>Explore Skills</h2>
        <p id="resultCount" class="result-count"></p>
      </div>

      <div class="search-bar">
        <div class="search-input-wrapper">
          <i class="fas fa-search"></i>
          <input type="text" id="keyword" placeholder="Search by skill name...">
        </div>
        <button type="button" class="btn btn-search" onclick="loadSkills()">
          <i class="fas fa-search"></i> Search
        </button>
      </div>

      <div class="filters-wrapper">
        <div class="filter-group">
          <label for="category">
            <i class="fas fa-folder"></i> Category
          </label>
          <select id="category">
            <option value="">All Categories</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['id'] ?>">
                <?= htmlspecialchars($cat['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="filter-group">
          <label for="location">
            <i class="fas fa-map-marker-alt"></i> Location
          </label>
          <input type="text" id="location" placeholder="Enter location...">
        </div>

        <button type="button" class="btn btn-secondary btn-reset" onclick="resetFilters()">
          <i class="fas fa-redo"></i> Reset
        </button>
      </div>

      <div class="active-filters" id="activeFilters"></div>
    </div>

    <div class="skills-container">
      <div class="skills-grid" id="skillsGrid">
        <div class="loading">
          <div class="spinner"></div>
          <p>Loading skills...</p>
        </div>
      </div>
    </div>

  </div>
</main>

<script>
const keyword  = document.getElementById('keyword');
const category = document.getElementById('category');
const location = document.getElementById('location');
const grid     = document.getElementById('skillsGrid');
const activeFiltersDiv = document.getElementById('activeFilters');
const resultCountDiv = document.getElementById('resultCount');

const urlParams = new URLSearchParams(window.location.search);
const categoryParam = urlParams.get('category');
if (categoryParam) {
  category.value = categoryParam;
}

function displayActiveFilters() {
  const filters = [];
  
  if (keyword.value) {
    filters.push({ label: 'Keyword: ' + keyword.value, type: 'keyword' });
  }
  if (category.value) {
    const catName = category.options[category.selectedIndex].text;
    filters.push({ label: 'Category: ' + catName, type: 'category' });
  }
  if (location.value) {
    filters.push({ label: 'Location: ' + location.value, type: 'location' });
  }

  if (filters.length === 0) {
    activeFiltersDiv.innerHTML = '';
    return;
  }

  let html = '<div class="filters-applied"><strong>Applied Filters:</strong> ';
  filters.forEach(filter => {
    html += `<span class="filter-badge">${filter.label} <button type="button" class="remove-filter" onclick="removeFilter('${filter.type}')">×</button></span>`;
  });
  html += '</div>';
  activeFiltersDiv.innerHTML = html;
}

function removeFilter(type) {
  if (type === 'keyword') keyword.value = '';
  else if (type === 'category') category.value = '';
  else if (type === 'location') location.value = '';
  loadSkills();
}

function resetFilters() {
  keyword.value = '';
  category.value = '';
  location.value = '';
  displayActiveFilters();
  loadSkills();
}

function loadSkills() {
  const params = new URLSearchParams({
    keyword: keyword.value,
    category: category.value,
    location: location.value
  });

  grid.innerHTML = '<div class="loading"><div class="spinner"></div><p>Loading skills...</p></div>';
  
  const controller = new AbortController();
  const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout
  
  fetch('ajax/search_skills.php?' + params, { signal: controller.signal })
    .then(res => {
      clearTimeout(timeoutId);
      if (!res.ok) {
        throw new Error('Network response was not ok: ' + res.status);
      }
      return res.text();
    })
    .then(html => {
      if (!html || html.trim() === '') {
        grid.innerHTML = '<div class="no-results"><div class="no-results-icon">🔍</div><p>No skills found. Be the first to add one!</p></div>';
      } else {
        grid.innerHTML = html;
        updateResultCount();
        attachViewDetailsHandlers();
        displayActiveFilters();
      }
    })
    .catch(err => {
      clearTimeout(timeoutId);
      console.error('Error loading skills:', err);
      if (err.name === 'AbortError') {
        grid.innerHTML = '<div class="error-message">Request timed out. Please check your connection and try again.</div>';
      } else {
        grid.innerHTML = '<div class="error-message">Failed to load skills. Please try again.</div>';
      }
    });
}

function updateResultCount() {
  const skillCards = grid.querySelectorAll('.skill-card');
  const count = skillCards.length;
  
  if (count === 0) {
    resultCountDiv.textContent = 'No results found';
  } else {
    resultCountDiv.textContent = count + ' skill' + (count !== 1 ? 's' : '') + ' found';
  }
}

function attachViewDetailsHandlers() {
  const buttons = document.querySelectorAll('.view-details-btn');

  buttons.forEach(button => {
    button.addEventListener('click', () => {
      const skillId = button.getAttribute('data-skill-id');
      const card = button.closest('.skill-card');
      const detailsSection = card.querySelector('.details-section[data-skill-id="' + skillId + '"]');

      if (detailsSection && detailsSection.style.display === 'none') {
        detailsSection.style.display = 'block';
        button.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Details & Contact';
        card.classList.add('expanded');
      } else if (detailsSection) {
        detailsSection.style.display = 'none';
        button.innerHTML = '<i class="fas fa-chevron-down"></i> View Details & Contact';
        card.classList.remove('expanded');
      }
    });
  });

  const contactButtons = document.querySelectorAll('.contact-btn');
  contactButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      if (btn.classList.contains('contact-btn-message')) {
        alert('Message feature coming soon!');
      } else if (btn.classList.contains('contact-btn-schedule')) {
        alert('Schedule lesson feature coming soon!');
      } else if (btn.classList.contains('contact-btn-view-profile')) {
        alert('View profile feature coming soon!');
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
