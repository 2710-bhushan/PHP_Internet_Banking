// Instant Theme Applier (prevents flash of white/dark background)
(function() {
  const currentTheme = localStorage.getItem('theme') || 'light';
  if (currentTheme === 'dark') {
    document.documentElement.classList.add('theme-dark');
  } else {
    document.documentElement.classList.remove('theme-dark');
  }
})();

document.addEventListener('DOMContentLoaded', () => {
  const currentTheme = localStorage.getItem('theme') || 'light';
  
  // Ensure body has the class
  if (currentTheme === 'dark') {
    document.body.classList.add('theme-dark');
  } else {
    document.body.classList.remove('theme-dark');
  }

  // Create Floating Toggle Button
  const toggleBtn = document.createElement('div');
  toggleBtn.className = 'theme-toggle-floating';
  toggleBtn.title = 'Toggle Dark/Light Mode';
  
  const icon = document.createElement('i');
  icon.className = currentTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
  toggleBtn.appendChild(icon);
  
  document.body.appendChild(toggleBtn);

  // Toggle Functionality
  function toggleTheme() {
    const isDark = document.body.classList.contains('theme-dark');
    if (isDark) {
      document.body.classList.remove('theme-dark');
      document.documentElement.classList.remove('theme-dark');
      localStorage.setItem('theme', 'light');
      icon.className = 'fas fa-moon';
      updateNavIcons('light');
    } else {
      document.body.classList.add('theme-dark');
      document.documentElement.classList.add('theme-dark');
      localStorage.setItem('theme', 'dark');
      icon.className = 'fas fa-sun';
      updateNavIcons('dark');
    }
  }

  toggleBtn.addEventListener('click', toggleTheme);

  // Also integrate inside Navbars if available (AdminLTE nav)
  const navbars = document.querySelectorAll('.navbar-nav, .ml-auto');
  navbars.forEach(navbar => {
    // Avoid double adding
    if (navbar.querySelector('.nav-theme-toggle-item')) return;

    const navItem = document.createElement('li');
    navItem.className = 'nav-item nav-theme-toggle-item';
    
    const navLink = document.createElement('a');
    navLink.className = 'nav-link';
    navLink.href = '#';
    navLink.style.cursor = 'pointer';
    navLink.style.display = 'flex';
    navLink.style.alignItems = 'center';
    navLink.style.padding = '0.5rem 1rem';
    
    const navIcon = document.createElement('i');
    navIcon.className = currentTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    navIcon.style.marginRight = '5px';
    
    const label = document.createElement('span');
    label.className = 'd-lg-none';
    label.textContent = ' Toggle Theme';
    
    navLink.appendChild(navIcon);
    navLink.appendChild(label);
    navItem.appendChild(navLink);
    
    // Add to navbar (either prepended or appended)
    navbar.appendChild(navItem);

    navLink.addEventListener('click', (e) => {
      e.preventDefault();
      toggleTheme();
    });
  });

  function updateNavIcons(theme) {
    const navIcons = document.querySelectorAll('.nav-theme-toggle-item i');
    navIcons.forEach(navIcon => {
      navIcon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    });
  }
});
