/* eslint-disable max-len, camelcase */

// eslint-disable-next-line no-undef
const $ = jQuery;

$.fn.yit_infinitescroll = (options) => {
  const opts = $.extend({
    nextSelector: false,
    navSelector: false,
    itemSelector: false,
    contentSelector: false,
    maxPage: false,
  }, options);

  let loading = false;
  let finished = false;
  let desturl = $(opts.nextSelector).attr('href'); // init next url

  // validate options and hide std navigation
  if ($(opts.nextSelector).length && $(opts.navSelector).length && $(opts.itemSelector).length && $(opts.contentSelector).length) {
    $(opts.navSelector).hide();
  } else {
    // set finished true
    finished = true;
  }

  const main_ajax = () => {
    const last_elem = $(opts.itemSelector).last();

    // set loader and loading
    $(opts.navSelector).after('<progress class="pagination-loader progress is-small is-dark" max="100"></progress>');
    loading = true;
    // decode url to prevent error
    desturl = decodeURIComponent(desturl);
    desturl = desturl.replace(/^(?:\/\/|[^/]+)*\//, '/');

    // ajax call
    $.ajax({
      // params
      url: desturl,
      dataType: 'html',
      cache: false,
      success(data) {
        const obj = $(data);
        const elem = obj.find(opts.itemSelector);
        const next = obj.find(opts.nextSelector);
        const current_url = desturl;

        if (next.length) {
          desturl = next.attr('href');
        } else {
          // set finished var true
          finished = true;
          $(document).trigger('yith-infs-scroll-finished');
        }

        last_elem.after(elem);

        $('.pagination-loader').remove();

        $(document).trigger('yith_infs_adding_elem', [elem, current_url]);

        elem.addClass('yith-infs-wpb_animate_when_almost_visible wpb_fadeIn fadeIn wpb_start_animation animated');

        setTimeout(() => {
          loading = false;
          // remove animation class
          elem.removeClass('wpb_animate_when_almost_visible wpb_fadeIn fadeIn wpb_start_animation animated');

          $(document).trigger('yith_infs_added_elem', [elem, current_url]);
        }, 1000);
      },
    });
  };

  // set event
  $(window).on('scroll touchstart', () => {
    $(window).trigger('yith_infs_start');
  });

  $(window).on('yith_infs_start', () => {
    const w = $(window);
    const elem = $(opts.itemSelector).last();

    if (typeof elem === 'undefined') {
      return;
    }

    if (!loading && !finished && (w.scrollTop() + w.height()) >= (elem.offset().top - (2 * elem.height()))) {
      main_ajax();
    }
  });
};

// document.addEventListener('scroll', _.throttle(this.scroll.bind(this), 50));

$(document).ready(() => {
  // set options
  const infinite_scroll = {
    nextSelector: '.pagination-block .next a',
    navSelector: '.pagination-block',
    itemSelector: '.module.content-list.paginated .content-list__item',
    contentSelector: '.module.content-list.paginated .content-list__items',
  };

  $(infinite_scroll.contentSelector).yit_infinitescroll(infinite_scroll);
});
