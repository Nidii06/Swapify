<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Swapify - Home</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/components/navigation.css">
  <link rel="stylesheet" href="css/components/buttons.css">
  <link rel="stylesheet" href="css/components/forms.css">
  <link rel="stylesheet" href="css/components/cards.css">
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
        <li><a href="about.php">About Us</a></li>
        <li><a href="browse_skills.php">Browse Skills</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <main class="container">
    <section class="hero-slider">
      <div class="slider-container">
        <div class="slide active">
          <div class="slide-content">
            <h1>Learn New Skills</h1>
            <p>Discover amazing skills shared by our community members</p>
            <a href="browse_skills.php" class="btn btn-primary btn-lg">Browse Skills</a>
          </div>
        </div>
        <div class="slide">
          <div class="slide-content">
            <h1>Share Your Knowledge</h1>
            <p>Teach what you know and help others grow</p>
            <a href="register.php" class="btn btn-success btn-lg">Start Teaching</a>
          </div>
        </div>
        <div class="slide">
          <div class="slide-content">
            <h1>Connect & Grow</h1>
            <p>Build meaningful connections through skill exchange</p>
            <a href="about.php" class="btn btn-primary btn-lg">Learn More</a>
          </div>
        </div>
      </div>
      <div class="slider-nav">
        <button class="slider-prev">‹</button>
        <div class="slider-dots">
          <span class="dot active"></span>
          <span class="dot"></span>
          <span class="dot"></span>
        </div>
        <button class="slider-next">›</button>
      </div>
    </section>

    <section class="features-section">
      <div class="section-header">
        <h2>Why Choose Swapify?</h2>
        <p>Join thousands of learners and teachers worldwide</p>
      </div>
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-handshake" style="font-size: 3rem; color: #3498db;"></i>
          </div>
          <h3>Skill Matching</h3>
          <p>Find perfect skill exchange partners based on your interests and location</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-globe-americas" style="font-size: 3rem; color: #3498db;"></i>
          </div>
          <h3>Global Community</h3>
          <p>Connect with people from different backgrounds and cultures</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-mobile-alt" style="font-size: 3rem; color: #3498db;"></i>
          </div>
          <h3>Easy to Use</h3>
          <p>Simple and intuitive platform designed for seamless skill sharing</p>
        </div>
      </div>
    </section>

    <section class="popular-skills">
      <div class="section-header">
        <h2>Popular Skills Right Now</h2>
        <p>See what people are learning and teaching</p>
      </div>
      <div class="skills-preview">
        <div class="skill-preview-card">
          <span class="skill-category technology">Technology</span>
          <h4>Web Development</h4>
          <p>HTML, CSS, JavaScript</p>
        </div>
        <div class="skill-preview-card">
          <span class="skill-category languages">Languages</span>
          <h4>English Practice</h4>
          <p>Conversational Skills</p>
        </div>
        <div class="skill-preview-card">
          <span class="skill-category music">Music</span>
          <h4>Guitar Lessons</h4>
          <p>Beginner to Advanced</p>
        </div>
        <div class="skill-preview-card">
          <span class="skill-category arts">Arts</span>
          <h4>Photography</h4>
          <p>Digital & Traditional</p>
        </div>
      </div>
    </section>

    <section class="cta-section">
      <div class="cta-content">
        <h2>Ready to Start Your Skill Journey?</h2>
        <p>Join Swapify today and unlock a world of learning opportunities</p>
        <div class="cta-buttons">
          <a href="register.php" class="btn btn-primary btn-lg">Get Started</a>
          <a href="about.php" class="btn btn-outline btn-lg">Learn More</a>
        </div>
      </div>
    </section>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const slides = document.querySelectorAll('.slide');
      const dots = document.querySelectorAll('.dot');
      const prevBtn = document.querySelector('.slider-prev');
      const nextBtn = document.querySelector('.slider-next');
      let currentSlide = 0;

      function showSlide(n) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        currentSlide = (n + slides.length) % slides.length;
        
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
      }

      function nextSlide() {
        showSlide(currentSlide + 1);
      }

      function prevSlide() {
        showSlide(currentSlide - 1);
      }

      nextBtn.addEventListener('click', nextSlide);
      prevBtn.addEventListener('click', prevSlide);

      setInterval(nextSlide, 5000);

      dots.forEach((dot, index) => {
        dot.addEventListener('click', () => showSlide(index));
      });
    });
  </script>
</body>
</html>