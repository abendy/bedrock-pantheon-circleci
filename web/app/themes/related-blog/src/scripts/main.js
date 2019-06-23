import App from './app';

/* app */

const app = (proto, ext) => Object.assign(Object.create(proto), ext);

const bodyEl = document.querySelector('body');
const ext = {
  el: bodyEl,
};

if (document.readyState !== 'loading') {
  app(App, ext).init();
} else {
  document.addEventListener('DOMContentLoaded', () => {
    app(App, ext).init();
  });
}
