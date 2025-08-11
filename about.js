// Fade in effect for the About Us content
document.addEventListener('DOMContentLoaded', function () {
  const aboutContent = document.querySelector('.about-content');
  if (aboutContent) {
    aboutContent.style.opacity = '0';
    aboutContent.style.transform = 'translateY(30px)';
    setTimeout(() => {
      aboutContent.style.transition = 'opacity 0.9s cubic-bezier(0.4,0,0.2,1), transform 0.9s cubic-bezier(0.4,0,0.2,1)';
      aboutContent.style.opacity = '1';
      aboutContent.style.transform = 'translateY(0)';
    }, 100);
  }
});

// Example: Responsive navbar toggle for mobile (optional, if you want hamburger menu)
// Uncomment this section and modify your HTML to add a menu button if you need it
/*
const menuBtn = document.getElementById('menu-btn');
const navList = document.querySelector('.nav-list');

if (menuBtn && navList) {
  menuBtn.addEventListener('click', function () {
    navList.classList.toggle('show-menu');
  });
}
*/