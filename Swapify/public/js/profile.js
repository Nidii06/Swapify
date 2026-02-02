function openDeleteModal(id) {
  document.getElementById('deleteSkillId').value = id;
  const modal = document.getElementById('deleteModal');
  modal.style.display = 'flex';
  
  document.body.style.overflow = 'hidden';
  
  setTimeout(() => {
    modal.classList.add('modal-open');
  }, 10);
}

function closeDeleteModal() {
  const modal = document.getElementById('deleteModal');
  modal.classList.remove('modal-open');
  setTimeout(() => {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
  }, 300);
}

document.addEventListener('DOMContentLoaded', function() {
  const deleteButtons = document.querySelectorAll('.btn-skill-delete');
  deleteButtons.forEach(button => {
    button.addEventListener('click', function() {
      const skillId = this.getAttribute('data-skill-id');
      if (skillId) {
        openDeleteModal(skillId);
      }
    });
  });

  const closeModalBtn = document.querySelector('.modal-actions .btn-secondary');
  if (closeModalBtn) {
    closeModalBtn.addEventListener('click', closeDeleteModal);
  }
});

document.getElementById('deleteModal')?.addEventListener('click', (e) => {
  if (e.target.id === 'deleteModal') {
    closeDeleteModal();
  }
});

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' && document.getElementById('deleteModal').style.display === 'flex') {
    closeDeleteModal();
  }
});

setTimeout(() => {
  document.querySelectorAll('.flash').forEach(flash => {
    flash.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    flash.style.opacity = '0';
    flash.style.transform = 'translateY(-20px)';
    setTimeout(() => flash.remove(), 500);
  });
}, 3500);

window.addEventListener('load', () => {
  const cards = document.querySelectorAll('.skill-card-profile');
  cards.forEach((card, index) => {
    card.style.animation = `slideIn 0.4s ease ${index * 0.1}s both`;
  });
});

const style = document.createElement('style');
style.textContent = `
  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .modal-open {
    animation: fadeIn 0.3s ease;
  }
`;
document.head.appendChild(style);
