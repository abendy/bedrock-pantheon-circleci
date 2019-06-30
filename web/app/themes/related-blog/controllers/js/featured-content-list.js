/* global jQuery:true */
// eslint-disable-next-line camelcase, no-unused-vars
function rltd_featured_content_list_custom_title_template_callback() {
  const masterEl = jQuery('input[name=rltd_featured_content_list_custom_title]', this.$content);
  const dependentEl = jQuery('input[name=rltd_featured_content_list_title]', this.$content);

  masterEl.on('change', () => {
    const checkedValue = masterEl.is(':checked');

    if (checkedValue === true) {
      dependentEl.removeAttr('readonly');
    } else {
      dependentEl.attr('readonly', 'readonly');
    }
  });

  masterEl.trigger('change');
}
