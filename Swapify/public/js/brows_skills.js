let keyword, category, location, flexbox, activeFiltersDiv, resultCountDiv;

document.addEventListener('DOMContentLoaded', function () {
  keyword = document.getElementById('keyword');
  category = document.getElementById('category');
  location = document.getElementById('location');
  flexbox = document.getElementById('skillsFlexbox');
  activeFiltersDiv = document.getElementById('activeFilters');
  resultCountDiv = document.getElementById('resultCount');

  const urlParams = new URLSearchParams(window.location.search);
  const categoryParam = urlParams.get('category');
  if (categoryParam && category) category.value = categoryParam;

  const searchBtn = document.querySelector('.btn-search');
  const resetBtn = document.querySelector('.btn-reset');

  if (searchBtn) searchBtn.addEventListener('click', loadSkills);
  if (resetBtn) resetBtn.addEventListener('click', resetFilters);

  if (keyword) keyword.addEventListener('input', debounce(loadSkills, 300));
  if (keyword) keyword.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      loadSkills();
    }
  });
  if (location) location.addEventListener('input', debounce(loadSkills, 300));
  if (location) location.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      loadSkills();
    }
  });
  if (category) category.addEventListener('change', loadSkills);

  // In case the page was server-rendered and the first AJAX call fails,
  // keep buttons working.
  attachViewDetailsHandlers();

  loadSkills();
});

function debounce(fn, delay) {
  let t;
  return function () {
    clearTimeout(t);
    t = setTimeout(fn, delay);
  };
}

function displayActiveFilters() {
  const filters = [];

  if (keyword && keyword.value) {
    filters.push({ label: 'Keyword: ' + keyword.value, type: 'keyword' });
  }
  if (category && category.value) {
    const catName = category.options[category.selectedIndex].text;
    filters.push({ label: 'Category: ' + catName, type: 'category' });
  }
  if (location && location.value) {
    filters.push({ label: 'Location: ' + location.value, type: 'location' });
  }

  if (!activeFiltersDiv) return;

  if (filters.length === 0) {
    activeFiltersDiv.innerHTML = '';
    return;
  }

  let html = '<div class="filters-applied"><strong>Applied Filters:</strong> ';
  filters.forEach(filter => {
    html += `<span class="filter-badge">${filter.label} <button type="button" class="remove-filter" data-filter-type="${filter.type}">×</button></span>`;
  });
  html += '</div>';

  activeFiltersDiv.innerHTML = html;

  const removeFilterBtns = activeFiltersDiv.querySelectorAll('.remove-filter');
  removeFilterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      const filterType = this.getAttribute('data-filter-type');
      removeFilter(filterType);
    });
  });
}

function removeFilter(type) {
  if (type === 'keyword' && keyword) keyword.value = '';
  else if (type === 'category' && category) category.value = '';
  else if (type === 'location' && location) location.value = '';
  loadSkills();
}

function resetFilters() {
  if (keyword) keyword.value = '';
  if (category) category.value = '';
  if (location) location.value = '';
  displayActiveFilters();
  loadSkills();
}

let currentController = null;

function loadSkills() {
  if (!flexbox) return;

  const params = new URLSearchParams();
  if (keyword && keyword.value.trim() !== '') params.append('keyword', keyword.value.trim());
  if (category && category.value !== '') params.append('category', category.value);
  if (location && location.value.trim() !== '') params.append('location', location.value.trim());

  if (currentController) currentController.abort();
  const controller = new AbortController();
  currentController = controller;

  fetch('./ajax/search_skills.php?' + params.toString(), {
    signal: controller.signal,
    cache: 'no-store'
  })
    .then(res => {
      if (!res.ok) throw new Error('HTTP ' + res.status);
      return res.text();
    })
    .then(html => {
      if (currentController !== controller) return;

      const clean = (html || '').trim();

      if (clean === '' || clean.includes('No skills found')) {
        flexbox.innerHTML =
          '<div class="no-results"><p>No skills found.</p></div>';
      } else {
        flexbox.innerHTML = clean;
      }

      attachViewDetailsHandlers();

      updateResultCount();
      displayActiveFilters();
    })
    .catch(err => {
      if (err.name === 'AbortError') return;
      flexbox.innerHTML = '<div class="error-message">Failed to load skills.</div>';
      if (resultCountDiv) resultCountDiv.textContent = '';
    });
}



function updateResultCount() {
  if (!flexbox || !resultCountDiv) return;

  const skillCards = flexbox.querySelectorAll('.skill-card');
  const count = skillCards.length;

  if (count === 0) resultCountDiv.textContent = 'No results found';
  else resultCountDiv.textContent = count + ' skill' + (count !== 1 ? 's' : '') + ' found';
}

function attachViewDetailsHandlers() {
  const buttons = document.querySelectorAll('.view-details-btn');

  buttons.forEach(button => {
    button.addEventListener('click', () => {
      const skillId = button.getAttribute('data-skill-id');
      const card = button.closest('.skill-card');
      if (!card) return;

      const detailsSection = card.querySelector('.details-section[data-skill-id="' + skillId + '"]');

      if (detailsSection && detailsSection.style.display === 'none') {
        detailsSection.style.display = 'block';
        button.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Details & Contact';
        card.classList.add('expanded');

        // Lazy-load profile/contact details once per card
        const extra = detailsSection.querySelector('.details-extra');
        if (extra && extra.getAttribute('data-loaded') !== '1') {
          extra.innerHTML = '<div class="detail-item"><p>Loading...</p></div>';

          fetch('ajax/skill_contact.php?id=' + encodeURIComponent(skillId), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
          })
            .then(r => (r.ok ? r.text() : Promise.reject()))
            .then(html => {
              extra.innerHTML = html;
              extra.setAttribute('data-loaded', '1');
            })
            .catch(() => {
              extra.innerHTML = '<div class="detail-item"><p>Failed to load contact details.</p></div>';
            });
        }
      } else if (detailsSection) {
        detailsSection.style.display = 'none';
        button.innerHTML = '<i class="fas fa-chevron-down"></i> View Details & Contact';
        card.classList.remove('expanded');
      }
    });
  });

  const contactButtons = document.querySelectorAll('.contact-btn');
  contactButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      if (btn.classList.contains('contact-btn-message')) alert('Message feature coming soon!');
      else if (btn.classList.contains('contact-btn-schedule')) alert('Schedule lesson feature coming soon!');
      else if (btn.classList.contains('contact-btn-view-profile')) alert('View profile feature coming soon!');
    });
  });
}
