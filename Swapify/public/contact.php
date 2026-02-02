<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - Swapify</title>

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/components/navigation.css">
  <link rel="stylesheet" href="css/components/buttons.css">
  <link rel="stylesheet" href="css/components/forms.css">
  <link rel="stylesheet" href="css/components/cards.css">
  <link rel="stylesheet" href="css/components/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
  <header class="header">
    <nav class="navbar">
      <div class="logo">
        <h1><a href="index.php">Swapify</a></h1>
      </div>

      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <main class="contact-main">
    <section class="location-section">
      <div class="location-header">
        <h2>Find Us</h2>
        <p class="location-address">
          <i class="fas fa-map-marker-alt"></i>
          Rruga Xhevdet Doda, Prishtine 10000
        </p>
      </div>
      <div class="map-container">
        <iframe 
          src="https://maps.google.com/maps?q=Rruga+Xhevdet+Doda,+Prishtina+10000&t=&z=13&ie=UTF8&iwloc=&output=embed" 
          width="100%" 
          height="450" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade"
          class="location-map">
        </iframe>
      </div>
    </section>
  </main>

  <footer>
    <div class="footer-container">
      <div class="footer-content">
        <div class="footer-section">
          <div class="footer-logo">Swapify</div>
          <p>Connecting people through knowledge sharing. Learn new skills, teach what you know, and grow together.</p>
          <div class="footer-social">
            <a href="#" class="social-icon facebook" aria-label="Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon twitter" aria-label="Twitter">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon instagram" aria-label="Instagram">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="social-icon linkedin" aria-label="LinkedIn">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="social-icon youtube" aria-label="YouTube">
              <i class="fab fa-youtube"></i>
            </a>
          </div>
        </div>

        <div class="footer-section">
          <h3>Quick Links</h3>
          <ul>
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="about.php"><i class="fas fa-info-circle"></i> About Us</a></li>
            <li><a href="browse_skills.php"><i class="fas fa-search"></i> Browse Skills</a></li>
            <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
          </ul>
        </div>

        <div class="footer-section">
          <h3>Contact Info</h3>
          <div class="footer-contact-item">
            <i class="fas fa-envelope"></i>
            <span>hello@swapify.com</span>
          </div>
          <div class="footer-contact-item">
            <i class="fas fa-phone"></i>
            <span>+383 49 110 111</span>
          </div>
          <div class="footer-contact-item">
            <i class="fas fa-map-marker-alt"></i>
            <span>Prishtina, Kosova</span>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> Swapify. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="js/validation.js"></script>
  
