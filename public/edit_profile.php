<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile - Swapify</title>

    <link rel = "stylesheet" href="css/style.css">
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
        <li><a href="profile.php">My Profile</a></li>
      </ul>
    </nav>
  </header>


  <main class="container">
    <div class="page-header">
      <h1>Edit Your Profile</h1>
      <p>Update your personal information and preferences</p>
    </div>

    <div class="form-container">
      <form id="profileForm">
        <div class="form-group">
          <label for="name">Full name *</label>
          <input type="text" id="name" name="name" value="Anid Bojaj" required>
        </div>

        <div class="form-group">
          <label for="email">Email Address *</label>
          <input type="email" id="email" name="email" value="anidbojaj@gmail.com" required>
        </div>

        <div class="form-group">
          <label for="location">Location</label>
          <input type="text" id="location" name="location" value="Prishtina, Kosova">
        </div>

        <div class="form-group">
          <label for="bio">Bio</label>
          <textarea id="bio" name="bio" rows="4">Passionate web developer and language enthusiast. Love to teach and learn new skills!</textarea>
        </div>

        <div class="form-group">
          <label for="interests">Interests & Skills</label>
          <input type="text" id="interests" name="interests" value="Web Development, Photography, Language Learning">
          <small>Seperate interests with commas</small>
        </div>

        <div class="form-group">
          <label for="teaching-method">Preferred Teaching Method</label>
          <select id="teaching-method" name="teaching-method">
            <option value="online">Online</option>
            <option value="in-person">In Person</option>
            <option value="both" selected>Both</option>
          </select>
        </div>

        <div class="form-group">
          <label for="availability">Availability</label>
           <select id="availability" name="availability">
            <option value="weekdays">Weekdays</option>
            <option value="weekends">Weekends</option>
            <option value="evenings">Evenings</option>
            <option value="flexible" selected>Flexible</option>
          </select>
        </div>

                <div class="form-group">
          <label>Notification Preferences</label>
          <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-top: 0.5rem;">

            <label style="display: flex; align-items: center; gap: 0.5rem;">
              <input type="checkbox" name="notifications" value="email" checked> Email notifications
            </label>
            <label style="display: flex; align-items: center; gap: 0.5rem;">
              <input type="checkbox" name="notifications" value="skill-matches" checked> New skill matches
            </label>
            <label style="display: flex; align-items: center; gap: 0.5rem;">
              <input type="checkbox" name="notifications" value="messages"> Direct messages
            </label>
          </div>
        </div>

         <div class="form-actions">
          <button type="button" class="btn btn-danger" onclick="window.location.href='profile.php'">Cancel</button>
          <button type="submit" class="btn btn-success">Update Profile</button>
        </div>
      </form>
    </div>
  </main>

  <script>
      document.getElementById('profileForm').addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Profile updated successfully!');
      window.location.href = 'profile.php';
    });
  </script>

      </form>
    </div>
  </main>
  
</body>
</html>