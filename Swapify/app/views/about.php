<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>

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
        <?php foreach ($navItems as $item): ?>
          <li>
            <a href="<?= htmlspecialchars($item['href']) ?>"<?= !empty($item['active']) ? ' class="active"' : '' ?>>
              <?= htmlspecialchars($item['label']) ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </header>

  <main class="container">
    <div class="page-header">
      <h1><?= htmlspecialchars($sections['header']['title']) ?></h1>
      <p><?= htmlspecialchars($sections['header']['subtitle']) ?></p>
    </div>

    <section class="about-content">
      <div class="about-section">
        <h2><?= htmlspecialchars($sections['mission']['title']) ?></h2>
        <p><?= htmlspecialchars($sections['mission']['text']) ?></p>
      </div>

      <div class="about-section">
        <h2><?= htmlspecialchars($sections['how_it_works']['title']) ?></h2>
        <div class="features">
          <?php foreach ($sections['how_it_works']['features'] as $feature): ?>
            <div class="feature-card">
              <h3><?= htmlspecialchars($feature['title']) ?></h3>
              <p><?= htmlspecialchars($feature['text']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="about-section">
        <h2><?= htmlspecialchars($sections['story']['title']) ?></h2>
        <p><?= htmlspecialchars($sections['story']['text']) ?></p>
      </div>
    </section>
  </main>
</body>
</html>
