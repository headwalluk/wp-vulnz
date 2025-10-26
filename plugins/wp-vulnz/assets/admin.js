/**
 * Admin JavaScript for WP VULNZ plugin.
 */
console.log('WP VULNZ Admin JS Loaded');

jQuery(document).ready(function ($) {
  $('#wp-vulnz-sync-now').on('click', function (e) {
    e.preventDefault();

    var $button = $(this);
    $button.prop('disabled', true);

    $.post(ajaxurl, {
      action: 'wp_vulnz_sync_now',
      nonce: wp_vulnz.nonce,
    })
      .done(function (response) {
        if (response.success) {
          alert('Sync complete!');
          location.reload();
        } else {
          alert('Error: ' + response.data.message);
        }
      })
      .fail(function (jqXHR) {
        var message = 'An unknown error occurred.';
        if (
          jqXHR.responseJSON &&
          jqXHR.responseJSON.data &&
          jqXHR.responseJSON.data.message
        ) {
          message = jqXHR.responseJSON.data.message;
        }
        alert('Error: ' + message);
      })
      .always(function () {
        $button.prop('disabled', false);
      });
  });
});
