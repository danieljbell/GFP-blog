if (window.jQuery) {

  (function() {


    $('#mc-embedded-subscribe-form').on('submit', function(e) {
      e.preventDefault();
      
      var $this = $(this);
  
      var email = $this.find('#mce-EMAIL').val();
      var firstName = $this.find('#mce-FNAME').val();
      var lastName = $this.find('#mce-LNAME').val();
      var modelNumber = $this.find('#mce-MODEL').val();
      var currentHours = $this.find('#mce-CURRENT_HR').val();
      var mowingTime = $this.find('#mce-MOWING_TIM').val();
      mowingTime = mowingTime.split('(')[1].split(')')[0].toLowerCase();
  
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
            $('div[data-modal="sign-up-form"] .modal-heading').text('Great ' + firstName + '!').next().text('You will receive a confirmation email soon and we will keep you up to date on your needed parts.');
          }
          $.ajax({
            type: 'POST',
            url: 'https://api.flock.com/hooks/sendMessage/855832cd-bd79-436d-9f1f-dcf0020251dd',
            data: JSON.stringify({
              "text": firstName + " " + lastName + " has a " + modelNumber + " with " + currentHours + " hours and takes " + mowingTime + " to mow. Contact " + firstName + " at " + email
            }),
            dataType: 'json',
            contentType: "application/json"
          })
        }
      });
  
    });
  
  })();

}