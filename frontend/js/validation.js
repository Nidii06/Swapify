document.addEventListener('DOMContentLoaded', function(){
    const contactForm = document.getElementById('contactForm');

    if(contactForm){
      contactForm.addEventListener('submit', function(e){
        e.preventDefault();
        
        if(validateContactForm()){
          alert('Thank you for your message! We will get back to you soon.');
          contactForm.reset();
        } 
       }); 
    }

    const loginForm = document.querySelector('form[action*="login"]');
    if(loginForm && window.location.pathname.includes('login.html')){
      loginForm.addEventListener('submit', function(e){
        if(!validateLoginForm()){
          e.preventDefault();
        }
      });
    }

    const registerForm = document.querySelector('form[action*="register"]');
    if (registerForm && window.location.pathname.includes('register.html')){
      registerForm.addEventListener('submit', function(e){
        if(!validateRegisterForm()){
          e.preventDefault();
        }
      });
    }
}); 

function validateContactForm(){
  let isValid = true;

  clearErrors();

  const name = document.getElementById('name').value.trim();
  if(name === ''){
    showError('nameError', 'Name is required');
    isValid = false;
  }else if (name.length < 2){
    showError('nameError', 'Name must be at least 2 characters long');
    isValid = false;
  }

  const email = document.getElementById('email').value.trim();
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if(email === ''){
    showError('emailError', 'Email is required');
    isValid = false;
  }else if(!emailRegex.test(email)){
    showError('emailError', 'Please enter a valid email address');
    isValid = false;
  }

  const subject = document.getElementById('subject').value.trim();
  if (subject === '') {
      showError('subjectError', 'Subject is required');
      isValid = false;
  } else if (subject.length < 5) {
      showError('subjectError', 'Subject must be at least 5 characters long');
      isValid = false;
  }

  const message = document.getElementById('message').value.trim();
  if (message === '') {
      showError('messageError', 'Message is required');
      isValid = false;
  } else if (message.length < 10) {
      showError('messageError', 'Message must be at least 10 characters long');
      isValid = false;
  }
  return isValid;
}

function validateLoginForm(){
  let isValid = true;
  clearErrors();

  const email = document.querySelector('input[type="email"]').value.trim();
  const password = document.querySelector('input[type="password"]').value;

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (email === '') {
      alert('Email is required');
      isValid = false;
  } else if (!emailRegex.test(email)) {
      alert('Please enter a valid email address');
      isValid = false;
  }

  if (password === '') {
      alert('Password is required');
      isValid = false;
  } else if (password.length < 6) {
      alert('Password must be at least 6 characters long');
      isValid = false;
  }

  return isValid;
}

function validateRegisterForm() {
  let isValid = true;
  clearErrors();

  const name = document.querySelector('input[type="text"]').value.trim();
  const email = document.querySelector('input[type="email"]').value.trim();
  const password = document.querySelector('input[type="password"]').value;

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
  if (name === '') {
      alert('Full name is required');
      isValid = false;
  } else if (name.length < 2) {
      alert('Full name must be at least 2 characters long');
      isValid = false;
  }

  if (email === '') {
      alert('Email is required');
      isValid = false;
  } else if (!emailRegex.test(email)) {
      alert('Please enter a valid email address');
      isValid = false;
  }

  if (password === '') {
      alert('Password is required');
      isValid = false;
  } else if (password.length < 6) {
      alert('Password must be at least 6 characters long');
      isValid = false;
  }

  return isValid;
}

function handleRegister(event){
  if(event){
    event.preventDefault();
  }
  console.log('handleRegister function called');

  if(validateRegisterForm()){
    console.log('Validation passed');
    alert('Registration successful! You can now log in.');
  
    setTimeout(function() {
      window.location.href = 'login.html';
    }, 1000);
    return true;
  }else{
    console.log('Validation failed');
    return false;
  }
}

function showError(elementId, message) {
  const errorElement = document.getElementById(elementId);
  if (errorElement) {
      errorElement.textContent = message;
      errorElement.style.color = '#e74c3c';
      errorElement.style.fontSize = '0.8rem';
      errorElement.style.marginTop = '0.25rem';
      errorElement.style.display = 'block';
  }
}

function clearErrors() {
  const errorElements = document.querySelectorAll('.error-message');
  errorElements.forEach(element => {
      element.textContent = '';
  });
}

function removeSkill(skillId){
  if(confirm('Are you sure you want to remove this skill?')) {
    const button = event.target;
    button.classList.add('btn-loading');
    button.disabled = true;

    setTimeout(function(){
      alert('Skill removed successfully!');
      window.location.reload();
    },1000);
  }
}

function editSkill(skillId){
  window.location.href = 'edit_skill.html?skill=' + skillId;
}

function handleAddSkill(event) {
  event.preventDefault();

  const skillName = document.getElementById('skill-name').value.trim();
  const category  = document.getElementById('category').value;
  const description = document.getElementById('description').value.trim();

  if (!skillName || !category || !description) {
      alert('Please fill in all required fields');
      return false;
  }
  alert('Skill added successfully!');
  
  setTimeout(function() {
      window.location.href = 'profile.html';
  }, 1000);
  
  return true;
}

function handleEditSkill(event){
  event.preventDefault();

  const skillName = document.getElementById('skill-name').value.trim();
  const category = document.getElementById('category').value;
  const description = document.getElementById('description').value.trim();

  if(!skillName || !category || !description){
    alert('Please fill in all required fields');
    return false;
  }
  alert('Skill updated successfully!');
  setTimeout(function(){
    window.location.href = 'profile.html';
  }, 1000);
  return true;
}

function handleDeleteSkill(){
  if(confirm('Are you sure you want to delete this skill?')) {
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = 'Deleting...';
    button.disabled = true;

    setTimeout(function(){
      alert('Skill deleted successfully!');
      window.location.href = 'profile.html';
    }, 1000);
  }
}