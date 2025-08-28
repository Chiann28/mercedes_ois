document.addEventListener('DOMContentLoaded', function() {
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('mdx_content');
      const navbar = document.getElementById('mainNavbar');
      const toggleBtn = document.getElementById('sidebarCollapse');
      const icon = toggleBtn.querySelector('i');
      
      // Check if we have a saved state in localStorage
      const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
      
      if (isCollapsed) {
        sidebar.classList.add('collapsed');
        content.classList.add('collapsed');
        navbar.classList.add('collapsed');
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-chevron-right');
      }
      
      toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
        navbar.classList.toggle('collapsed');
        
        // Toggle icon
        if (sidebar.classList.contains('collapsed')) {
          icon.classList.remove('fa-bars');
          icon.classList.add('fa-chevron-right');
          localStorage.setItem('sidebarCollapsed', 'true');
        } else {
          icon.classList.remove('fa-chevron-right');
          icon.classList.add('fa-bars');
          localStorage.setItem('sidebarCollapsed', 'false');
        }
      });
      
      // For mobile view, show sidebar when toggle button is clicked
      function checkWidth() {
        if (window.innerWidth <= 992) {
          sidebar.classList.remove('show');
          sidebar.classList.add('collapsed');
          content.classList.add('collapsed');
          navbar.classList.add('collapsed');
          icon.classList.remove('fa-bars');
          icon.classList.add('fa-chevron-right');
        } else {
          // Reset to default state for larger screens
          if (localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('collapsed');
            content.classList.add('collapsed');
            navbar.classList.add('collapsed');
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-chevron-right');
          } else {
            sidebar.classList.remove('collapsed');
            content.classList.remove('collapsed');
            navbar.classList.remove('collapsed');
            icon.classList.remove('fa-chevron-right');
            icon.classList.add('fa-bars');
          }
        }
      }
      
      // Check on load and resize
      checkWidth();
      window.addEventListener('resize', checkWidth);
    });