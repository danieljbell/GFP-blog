if (window.jQuery) {

  (function() {


    $('#mc-embedded-subscribe-form').on('submit', function(e) {
      e.preventDefault();
      
      var $this = $(this);
  
      var firstName = $this.find('#mce-FNAME').val();
  
      $.ajax({
        type: $this.attr('method'),
        url: $this.attr('action'),
        data: $this.serialize(),
        cache: false,
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        error: function(err) {
  
        },
        success: function(data) {
          if (data.result != 'success') {
            $('#mc_embed_signup_scroll').prepend('<p style="border: 1px solid red; padding: 1rem;">' + data.msg + '</p>');
          } else {
            $this.hide();
            $('div[data-modal="sign-up-form"] .modal-heading').text('Great ' + firstName + '!').next().text('You will recieve a confirmation email soon and we will keep you up to date on your needed parts.');
          }
        }
      });
  
    });
  
  })();

}