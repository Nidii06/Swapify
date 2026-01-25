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
        <li><a href="contact.php" class="active">Contact</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <main class="container">
    <section class="page-header">
      <h1>Contact Us</h1>
      <p>We'd love to hear from you! Please fill out the form below.</p>
    </section>

    <section class="form-section">
      <div class="form-container">
        <form id="contactForm" novalidate>
          
          <div class="form-group">
            <label for="name">Full Name <span class="required"></span></label>
            <input type="text" id="name" name="name" placeholder="Your full name" required>
            <small class="error-message" id="nameError"></small>
          </div>

          <div class="form-group">
            <label for="email">Email Address <span class="required"></span></label>
            <input type="email" id="email" name="email" placeholder="you@example.com" required>
            <small class="error-message" id="emailError"></small>
          </div>

          <div class="form-group">
            <label for="subject">Subject <span class="required"></span></label>
            <input type="text" id="subject" name="subject" placeholder="Message subject" required>
            <small class="error-message" id="subjectError"></small>
          </div>

          <div class="form-group">
            <label for="message">Message <span class="required"></span></label>
            <textarea id="message" name="message" rows="6" placeholder="Type your message here..." required></textarea>
            <small class="error-message" id="messageError"></small>
          </div>

          <div id="successMessage" style="display:none; background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #28a745;"></div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary-blue"><i class="fas fa-paper-plane"></i> Send Message</button>
          </div>
        </form>
      </div>
    </section>

    <section class="location-section">
      <div class="location-header">
        <h2>Find Us</h2>
        <p class="location-address">
          <i class="fas fa-map-marker-alt"></i>
          Rruga Xhevdet Doda, Prishtina 10000
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
  <script>
    document.getElementById('contactForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      // Clear previous error messages
      document.getElementById('nameError').textContent = '';
      document.getElementById('emailError').textContent = '';
      document.getElementById('subjectError').textContent = '';
      document.getElementById('messageError').textContent = '';

      const name = document.getElementById('name').value.trim();
      const email = document.getElementById('email').value.trim();
      const subject = document.getElementById('subject').value.trim();
      const message = document.getElementById('message').value.trim();

      let hasError = false;

      // Validation
      if (!name) {
        document.getElementById('nameError').textContent = 'Full name is required';
        hasError = true;
      }
      
      if (!email) {
        document.getElementById('emailError').textContent = 'Email is required';
        hasError = true;
      } else if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
        document.getElementById('emailError').textContent = 'Please enter a valid email';
        hasError = true;
      }
      
      if (!subject) {
        document.getElementById('subjectError').textContent = 'Subject is required';
        hasError = true;
      }
      
      if (!message) {
        document.getElementById('messageError').textContent = 'Message is required';
        hasError = true;
      }

      if (hasError) return;

      // Submit form
      const formData = new FormData();
      formData.append('name', name);
      formData.append('email', email);
      formData.append('subject', subject);
      formData.append('message', message);

      try {
        const response = await fetch('handle_contact.php', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        if (data.success) {
          document.getElementById('successMessage').textContent = '✓ ' + data.message;
          document.getElementById('successMessage').style.display = 'block';
          document.getElementById('contactForm').reset();
          
          // Hide success message after 5 seconds
          setTimeout(() => {
            document.getElementById('successMessage').style.display = 'none';
          }, 5000);
        } else {
          alert('Error: ' + data.message);
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Failed to send message. Please try again later.');
      }
    });
  </script>

