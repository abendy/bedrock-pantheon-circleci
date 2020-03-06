// eslint-disable-next-line no-undef
const $ = jQuery;

const options = {
  nextSelector: '.pagination-block .next a',
  navSelector: '.pagination-block',
  itemSelector: '.content-list.paginated .content-list__item',
  contentSelector: '.content-list.paginated .content-list__items',
};

let loading = false;
let finished = false;
let desturl = $(options.nextSelector).attr('href'); // init next url

const mainAjax = () => {
  const lastElem = $(options.itemSelector).last();

  // set loader and loading
  $(options.navSelector).after('<progress class="pagination-loader progress is-small is-dark" max="100"></progress>');
  loading = true;

  // decode url to prevent error
  desturl = decodeURIComponent(desturl);
  desturl = desturl.replace(/^(?:\/\/|[^/]+)*\//, '/');

  // ajax call
  $.ajax({
    url: desturl,
    dataType: 'html',
    cache: false,
    success(data) {
      const obj = $(data);

      const elems = obj.find(options.itemSelector);
      const next = obj.find(options.nextSelector);

      if (next.length) {
        desturl = next.attr('href');
      } else {
        finished = true;
      }

      elems.addClass('wpb_animate_when_almost_visible wpb_fadeIn fadeIn wpb_start_animation animated');

      lastElem.after(elems);

      $('.pagination-loader').remove();

      setTimeout(() => {
        loading = false;
        elems.removeClass('wpb_animate_when_almost_visible wpb_fadeIn fadeIn wpb_start_animation animated');
      }, 1000);
    },
  });
};

const initPagination = () => {
  const w = $(window);
  const elem = $(options.itemSelector).last();

  if (
    typeof elem !== 'undefined'
    && !loading
    && !finished
    && desturl
    && (w.scrollTop() + w.height()) >= (elem.offset().top - (2 * elem.height()))
  ) {
    mainAjax();
  }
};

document.addEventListener('scroll', () => initPagination());
document.addEventListener('touchstart', () => initPagination());
