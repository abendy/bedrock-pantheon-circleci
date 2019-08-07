import Sticky from 'sticky-js';

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

  if (x >= 1024) {
    const stickyNav = new Sticky('#header');
  }
});
