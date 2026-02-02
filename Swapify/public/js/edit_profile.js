document.addEventListener('DOMContentLoaded', function() {
  const profileForm = document.getElementById('profileForm');
  
  if (profileForm) {
    profileForm.addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Profile updated successfully!');
      window.location.href = 'profile.php';
    });
  }
});
