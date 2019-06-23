import { cp } from './utils/app-utils';

const App = {
  init() {
    cp(
      'fetch',
      'mounted',
      'events',
    )(this);

    return this;
  },

  fetch() {
  },

  mounted() {
  },

  events() {
    this.el.addEventListener('click', this.clickHandler.bind(this), true);
    this.el.addEventListener('mousedown', this.clickHandler.bind(this), true);
    this.el.addEventListener('mouseup', this.clickHandler.bind(this), true);
    window.addEventListener('keydown', this.keyBoardHandler.bind(this), true);
    return this;
  },

  clickHandler(event) {
    const {
      button, detail, target, type,
    } = event;
  },

  keyBoardHandler(e) {
    const key = e.keyCode;
  },
};

export default App;
