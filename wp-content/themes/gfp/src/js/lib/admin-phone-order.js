(function($) {

  $('.tab-trigger').on('click', toggle);
  $('#returning_email_address').on('change submit', findUser);

  function toggle(e) {
    e.preventDefault();
    var val = $(this).prop('id');
    var elem = $('.' + val);
    elem.siblings().addClass('visually-hidden');
    elem.removeClass('visually-hidden');
  }

  function findUser(e) {
    e.preventDefault();
    var val = $(this).val();
    if (val && val !== '') {
      console.log('finding user => ', $(this).val());
      $.ajax({
        url: window.location.origin + '/wp-admin/admin-ajax.php',
        method: 'POST',
        data: {
          action: 'find_user_by_email',
          _ajax_nonce: window.ajax_order_tracking.nonce,
          email_address: $(this).val(),
        },
        success: function(results) {
          if (results.success === false) {
            $('.returning-customer-list').html('<li>' + results.message + '</li>');
          } else {
            console.log(results);
            $('.returning-customer-list').html('');
          }
        },
        error: function(error) {
          console.log(error);
        }
      })
    }
  }

})(jQuery);