<?php

require_once __DIR__ . '/../../app/helpers/imageHelper.php';

if (!function_exists('getDifficultyColor')) {
    function getDifficultyColor($level)
    {
        $colors = [
            'beginner' => '#27ae60',
            'intermediate' => '#f39c12',
            'advanced' => '#e74c3c',
            'expert' => '#8e44ad'
        ];
        return $colors[strtolower((string)$level)] ?? '#3498db';
    }
}

if (!isset($skills) || !is_array($skills) || count($skills) === 0) {
    echo '<div class="no-results"><p>No skills found.</p></div>';
    return;
}

$scriptName  = $_SERVER['SCRIPT_NAME'] ?? '';
$isAjax      = (strpos($scriptName, '/ajax/') !== false);
$assetPrefix = $isAjax ? '../' : '';

foreach ($skills as $skill):
    $categoryNameRaw = $skill['category_name'] ?? 'Uncategorized';
    $userNameRaw     = $skill['user_name'] ?? 'Unknown';

    $categoryImage = getCategoryImage($categoryNameRaw);
    if (!filter_var($categoryImage, FILTER_VALIDATE_URL)) {
        $categoryImage = $assetPrefix . ltrim($categoryImage, '/');
    }

    $levelRaw        = (string)($skill['level'] ?? 'N/A');
    $levelKey        = strtolower(trim($levelRaw));
    $levelKey        = preg_replace('/[^a-z0-9_-]/', '', $levelKey);
    $skillLocation   = (($skill['location'] ?? '') !== '') ? $skill['location'] : 'Not specified';
?>

<div class="skill-card" style="background-image: url('<?= htmlspecialchars($categoryImage, ENT_QUOTES, 'UTF-8') ?>'); background-size: cover; background-position: center;">
  <div class="skill-overlay"></div>

  <div class="skill-badges">
    <span class="badge badge-category"><?= htmlspecialchars($categoryNameRaw, ENT_QUOTES, 'UTF-8') ?></span>
    <span class="badge badge-level level-<?= htmlspecialchars($levelKey, ENT_QUOTES, 'UTF-8') ?>">
      <?= htmlspecialchars(ucfirst($levelRaw), ENT_QUOTES, 'UTF-8') ?>
    </span>
  </div>

  <div class="skill-content-wrapper">
    <div class="skill-header">
      <h3 class="skill-title"><?= htmlspecialchars((string)($skill['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h3>
      <div class="skill-rating">
        <i class="fas fa-user"></i> <?= htmlspecialchars($userNameRaw, ENT_QUOTES, 'UTF-8') ?>
      </div>
    </div>

    <p class="skill-description">
      <?= htmlspecialchars(substr((string)($skill['description'] ?? ''), 0, 120), ENT_QUOTES, 'UTF-8') ?>...
    </p>

    <div class="skill-meta-inline">
      <span><i class="fas fa-chalkboard-user"></i> <?= htmlspecialchars(ucfirst(str_replace('-', ' ', (string)($skill['teaching_method'] ?? 'N/A'))), ENT_QUOTES, 'UTF-8') ?></span>
      <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars((string)$skillLocation, ENT_QUOTES, 'UTF-8') ?></span>
    </div>

    <div class="skill-actions">
      <button class="btn btn-primary view-details-btn" data-skill-id="<?= (int)($skill['id'] ?? 0) ?>">
        <i class="fas fa-chevron-down"></i> View Details & Contact
      </button>
    </div>

    <div class="details-list details-section" style="display:none;" data-skill-id="<?= (int)($skill['id'] ?? 0) ?>">
      <div class="details-header">
        <h5>Details & Contact</h5>
      </div>

      <div class="detail-item">
        <label><i class="fas fa-user"></i> User</label>
        <p><?= htmlspecialchars($userNameRaw, ENT_QUOTES, 'UTF-8') ?></p>
      </div>
      <div class="detail-item">
        <label><i class="fas fa-map-marker-alt"></i> Location</label>
        <p><?= htmlspecialchars((string)$skillLocation, ENT_QUOTES, 'UTF-8') ?></p>
      </div>

      <div class="details-extra" data-loaded="0"></div>
    </div>
  </div>
</div>

<?php endforeach; ?>
