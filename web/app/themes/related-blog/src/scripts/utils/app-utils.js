export const cp = (...fns) => (context = window) => {
  fns.forEach((fn) => {
    if (typeof context[fn] === 'function') {
      context[fn].call(context);
    }
  });
};

export const getParent = (m, name) => (m.props.name === name ? m : getParent(m.context, name));

// eslint-disable-next-line max-len
export const nodeHasChildren = (n, selector) => Array.from(n.children).some(c => c.matches(selector));

export const querySelectorFrom = (selector, elements) => {
  // return [].filter.call(elements, (element) => {
  //   console.log('element...', element.childNodes.matches('.highlight'));
  //   // return element.matches(selector);
  // });

  const elementsArr = [...elements];
  return [...document.querySelectorAll(selector)]
    .filter(elm => elementsArr.includes(elm));
};

export const findParent = (node, selector, boundary) => {
  const p = node.parentNode;

  if (!p.matches(selector)) {
    return p === document.body || p.matches(boundary) ? null : findParent(p, selector, boundary);
  }

  return p;
};

// eslint-disable-next-line max-len
export const elementVisible = element => !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length);

export const unwrap = (el) => {
  const parentEl = el.parentNode;

  // move all children out of the element
  while (el.firstChild) parentEl.insertBefore(el.firstChild, el);

  // remove the empty element
  parentEl.removeChild(el);

  // Join adjacent text nodes
  parentEl.normalize();
};
