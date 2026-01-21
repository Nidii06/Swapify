<?php
require_once '../../app/controllers/SkillController.php';
require_once '../../app/helpers/imageHelper.php';

$keyword  = $_GET['keyword'] ?? null;
$category = $_GET['category'] ?? null;
$location = $_GET['location'] ?? null;

$controller = new SkillController();
$skills = $controller->search($keyword, $category, $location);

if (empty($skills)) {
    echo '<div class="no-results">
            <p>No skills found matching your criteria.</p>
            <p class="no-results-hint">Try adjusting your search filters.</p>
          </div>';
    exit;
}

foreach ($skills as $skill):
    $categoryImage = getCategoryImage($skill['category_name']);
    $skillLocation = $skill['location'] ?: 'Not specified';
    $categoryName = htmlspecialchars($skill['category_name']);
    $categoryClass = strtolower(str_replace(' ', '-', $categoryName));
?>
<div class="skill-card" style="background-image: url('<?= htmlspecialchars($categoryImage) ?>'); background-size: cover; background-position: center;">
  <div class="skill-overlay"></div>
  
  <div class="skill-content-wrapper">
    <div class="skill-header">
      <h3><?= htmlspecialchars($skill['title']) ?></h3>
      <span class="category <?= $categoryClass ?>"><?= $categoryName ?></span>
    </div>
    
    <p class="skill-description">
      <?= htmlspecialchars($skill['description']) ?>
    </p>
    
    <span class="user"><?= htmlspecialchars($skill['user_name']) ?></span>
    <span class="location"><?= htmlspecialchars($skillLocation) ?></span>
    
    <div class="skill-actions">
      <button class="btn btn-primary view-details-btn" data-skill-id="<?= $skill['id'] ?>">View Details</button>
    </div>
    
    <ul class="details-list" style="display:none;" data-skill-id="<?= $skill['id'] ?>">
      <li><strong>Name:</strong> <?= htmlspecialchars($skill['user_name']) ?></li>
      <li><strong>Location:</strong> <?= htmlspecialchars($skillLocation) ?></li>
      <li><strong>Skill:</strong> <?= htmlspecialchars($skill['title']) ?></li>
      <li><strong>Description:</strong> <?= htmlspecialchars($skill['description']) ?></li>
      <li><strong>Level:</strong> <?= ucfirst($skill['level'] ?? 'Not specified') ?></li>
      <li><strong>Teaching Method:</strong> <?= ucfirst(str_replace('-', ' ', $skill['teaching_method'] ?? 'Not specified')) ?></li>
    </ul>
  </div>
</div>
<?php endforeach; ?>
