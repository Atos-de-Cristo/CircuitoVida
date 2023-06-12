import './bootstrap';

import Alpine from 'alpinejs';


import focus from '@alpinejs/focus';
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();


document.addEventListener('DOMContentLoaded', () => {
    // Light switcher
    const lightSwitches = document.querySelectorAll('.light-switch');
    if (lightSwitches.length > 0) {
      lightSwitches.forEach((lightSwitch, i) => {
        if (localStorage.getItem('dark-mode') === 'true') {
          lightSwitch.checked = true;
        }
        lightSwitch.addEventListener('change', () => {
          const { checked } = lightSwitch;
          lightSwitches.forEach((el, n) => {
            if (n !== i) {
              el.checked = checked;
            }
          });
          document.documentElement.classList.add('[&_*]:!transition-none');
          if (lightSwitch.checked) {
            document.documentElement.classList.add('dark');
            document.querySelector('html').style.colorScheme = 'dark';
            localStorage.setItem('dark-mode', true);
            document.dispatchEvent(new CustomEvent('darkMode', { detail: { mode: 'on' } }));
          } else {
            document.documentElement.classList.remove('dark');
            document.querySelector('html').style.colorScheme = 'light';
            localStorage.setItem('dark-mode', false);
            document.dispatchEvent(new CustomEvent('darkMode', { detail: { mode: 'off' } }));
          }
          setTimeout(() => {
            document.documentElement.classList.remove('[&_*]:!transition-none');
          }, 1);
        });
      });
    }

    // Toggle SVG color based on dark mode
    const svgContainer = document.getElementById('mySvgContainer');
    const svgPath = document.getElementById('mySvgPath');

    function toggleDarkMode() {
      const isDarkMode = localStorage.getItem('dark-mode') === 'true';
      svgContainer.classList.toggle('dark', isDarkMode);
      svgPath.style.fill = isDarkMode ? '#000000' : '#FFFFFF';
    }

    // Call the function when the page loads or when dark mode is toggled
    toggleDarkMode();
  });
