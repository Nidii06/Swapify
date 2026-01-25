<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once '../../app/controllers/SkillController.php';
require_once '../../app/helpers/imageHelper.php';
require_once '../../app/models/User.php';

header('Content-Type: text/html; charset=utf-8');

$keyword  = $_GET['keyword'] ?? null;
$category = $_GET['category'] ?? null;
$location = $_GET['location'] ?? null;

try {
    $controller = new SkillController();
    $skills = $controller->search($keyword, $category, $location);

    if (empty($skills)) {
        echo '<div class="no-results">
                <div class="no-results-icon">🔍</div>
                <p>No skills found matching your criteria.</p>
                <p class="no-results-hint">Try adjusting your search filters or browse all skills. Be the first to add a skill!</p>
              </div>';
        exit;
    }
} catch (Exception $e) {
    error_log('Error in search_skills.php: ' . $e->getMessage());
    echo '<div class="error-message">Unable to load skills. Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    exit;
}

function getInitials($name) {
    $parts = explode(' ', trim($name));
    $initials = '';
    foreach ($parts as $part) {
        $initials .= strtoupper($part[0]);
    }
    return substr($initials, 0, 2);
}

function getUserRating($userId) {
    return 4.8; 
}

function getReviewCount($userId) {
    return rand(5, 50);
}


function getDifficultyColor($level) {
    $colors = [
        'beginner' => '#27ae60',
        'intermediate' => '#f39c12',
        'advanced' => '#e74c3c',
        'expert' => '#8e44ad'
    ];
    return $colors[strtolower($level)] ?? '#3498db';
}

foreach ($skills as $skill):
    $categoryImage = getCategoryImage($skill['category_name']);
    // Fix path for AJAX context - prepend ../ since we're in /public/ajax/
    if (!filter_var($categoryImage, FILTER_VALIDATE_URL) && strpos($categoryImage, '../') !== 0) {
        $categoryImage = '../' . $categoryImage;
    }
    $skillLocation = $skill['location'] ?: 'Not specified';
    $categoryName = htmlspecialchars($skill['category_name']);
    $categoryClass = strtolower(str_replace(' ', '-', $categoryName));
    $instructorInitials = getInitials($skill['user_name']);
    $instructorRating = getUserRating($skill['user_id']);
    $reviewCount = getReviewCount($skill['user_id']);
    $difficultyColor = getDifficultyColor($skill['level']);
?>

<div class="skill-card" style="background-image: url('<?= htmlspecialchars($categoryImage) ?>'); background-size: cover; background-position: center;">
  <div class="skill-overlay"></div>
  
  <!-- Badge Section -->
  <div class="skill-badges">
    <span class="badge badge-category <?= $categoryClass ?>"><?= $categoryName ?></span>
    <span class="badge badge-level" style="background-color: <?= $difficultyColor ?>; color: white;">
      <i class="fas fa-star"></i> <?= ucfirst($skill['level'] ?? 'N/A') ?>
    </span>
  </div>
  
  <div class="skill-content-wrapper">
    
    <div class="skill-header">
      <h3 class="skill-title"><?= htmlspecialchars($skill['title']) ?></h3>
      <div class="skill-rating">
        <span class="stars">
          <i class="fas fa-star"></i>
          <span class="rating-number"><?= $instructorRating ?></span>
          <span class="rating-count">(<?= $reviewCount ?>)</span>
        </span>
      </div>
    </div>
    
    <p class="skill-description">
      <?= htmlspecialchars(substr($skill['description'], 0, 120)) ?>...
    </p>
    
    <div class="skill-meta-inline">
      <span class="meta-badge">
        <i class="fas fa-chalkboard-user"></i>
        <?= ucfirst(str_replace('-', ' ', $skill['teaching_method'] ?? 'N/A')) ?>
      </span>
      <span class="meta-badge">
        <i class="fas fa-map-marker-alt"></i>
        <?= htmlspecialchars($skillLocation) ?>
      </span>
    </div>
    

    <div class="instructor-section">
      <a href="view_profile.php?id=<?= $skill['user_id'] ?>" class="instructor-header-link" style="text-decoration: none; color: inherit;">
        <div class="instructor-header">
          <div class="instructor-avatar" style="background: linear-gradient(135deg, #87CEEB 0%, #5DADE2 100%);">
            <span><?= $instructorInitials ?></span>
          </div>
          <div class="instructor-info">
            <h4 class="instructor-name"><?= htmlspecialchars($skill['user_name']) ?></h4>
            <p class="instructor-title">Instructor</p>
          </div>
          <div class="instructor-rating">
            <div class="rating-stars">
              <i class="fas fa-star"></i>
              <span><?= $instructorRating ?></span>
            </div>
            <p class="review-text"><?= $reviewCount ?> Reviews</p>
          </div>
        </div>
      </a>
    </div>
    
    <div class="skill-actions">
      <button class="btn btn-primary view-details-btn" data-skill-id="<?= $skill['id'] ?>">
        <i class="fas fa-chevron-down"></i> View Details & Contact
      </button>
    </div>
    
    <div class="details-list details-section" style="display:none;" data-skill-id="<?= $skill['id'] ?>">
      
      <div class="details-header">
        <h5>Skill Details</h5>
      </div>
      
      <div class="detail-item">
        <label><i class="fas fa-book"></i> Skill Title</label>
        <p><?= htmlspecialchars($skill['title']) ?></p>
      </div>
      
      <div class="detail-item">
        <label><i class="fas fa-align-left"></i> Full Description</label>
        <p><?= htmlspecialchars($skill['description']) ?></p>
      </div>
      
      <div class="detail-row">
        <div class="detail-item">
          <label><i class="fas fa-signal"></i> Level</label>
          <p><span class="level-badge" style="background-color: <?= $difficultyColor ?>; color: white;"><?= ucfirst($skill['level'] ?? 'N/A') ?></span></p>
        </div>
        <div class="detail-item">
          <label><i class="fas fa-chalkboard"></i> Teaching Method</label>
          <p><?= ucfirst(str_replace('-', ' ', $skill['teaching_method'] ?? 'N/A')) ?></p>
        </div>
      </div>
      
      <div class="detail-item">
        <label><i class="fas fa-map-marker-alt"></i> Location</label>
        <p><?= htmlspecialchars($skillLocation) ?></p>
      </div>
      
      <div class="instructor-contact-section">
        <h5><i class="fas fa-user-circle"></i> Instructor Information</h5>
        
        <div class="instructor-details">
          <div class="instructor-detail-card">
            <div class="detail-item">
              <label><i class="fas fa-user"></i> Name</label>
              <p><?= htmlspecialchars($skill['user_name']) ?></p>
            </div>
            
            <div class="detail-item">
              <label><i class="fas fa-star"></i> Rating</label>
              <p>
                <span class="rating-display"><?= $instructorRating ?> / 5</span>
                <span class="rating-bar">
                  <span class="rating-fill" style="width: <?= ($instructorRating / 5) * 100 ?>%"></span>
                </span>
                <span class="review-count"><?= $reviewCount ?> reviews</span>
              </p>
            </div>
          </div>
        </div>
        
        <div class="contact-section">
          <h6><i class="fas fa-envelope"></i> Get in Touch</h6>
          <div class="contact-buttons">
            <button class="contact-btn contact-btn-message" type="button">
              <i class="fas fa-comments"></i> Message
            </button>
            <button class="contact-btn contact-btn-schedule" type="button">
              <i class="fas fa-calendar-alt"></i> Schedule Lesson
            </button>
            <button class="contact-btn contact-btn-view-profile" type="button">
              <i class="fas fa-user"></i> View Profile
            </button>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

<?php endforeach; ?>
