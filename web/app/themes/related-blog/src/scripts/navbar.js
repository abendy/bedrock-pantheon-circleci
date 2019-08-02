let x = 0;
let y = 0;

const getDimensions = () => {
  const w = window;
  const d = document;
  const e = d.documentElement;
  const g = d.getElementsByTagName('body')[0];
  x = w.innerWidth || e.clientWidth || g.clientWidth;
  y = w.innerHeight || e.clientHeight || g.clientHeight;
};

window.onresize = () => {
  getDimensions();
};

document.addEventListener('DOMContentLoaded', () => {
  window.dispatchEvent(new Event('resize'));

  // Get all "navbar-burger" elements
  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {
    // Add a click event on each of them
    $navbarBurgers.forEach((el) => {
      el.addEventListener('click', () => {
        // Get the target from the "data-target" attribute
        const { target } = el.dataset;
        const $target = document.getElementById(target);

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');
      });
    });
  }

  // Mobile click to expand nav
  const $hasDropdowns = Array.prototype.slice.call(document.querySelectorAll('.navbar-item.has-dropdown'), 0);

  if ($hasDropdowns.length > 0 && x < 1024) {
    // Add a click event on each of them
    $hasDropdowns.forEach((el) => {
      const childLinkSelector = `[data-item-id="${el.dataset.itemId}"] .navbar-link`;
      const childLink = document.querySelectorAll(childLinkSelector)[0];

      if (childLink) {
        childLink.addEventListener('click', (event) => {
          event.preventDefault();

          const dropdownSelector = `[data-item-id="${el.dataset.itemId}"] .navbar-dropdown`;

          const dropdown = document.querySelectorAll(dropdownSelector)[0];

          dropdown.classList.toggle('is-block');
        });
      }
    });
  }
});
