(function($) {
  
  if (getParameterByName('success') === '1') {
    var alert = document.createElement('div');
    alert.classList.add('alert', 'alert--success');
    alert.innerHTML = '<button class="alert--close" onclick="this.parentElement.remove()">&times;</button><div class="alert--content"><h4>Great!</h4><p>We\'ve received your message and will respond shortly.</p></div>';
    document.body.prepend(alert);
  }

  setTimeout(function(){
    if (!document.cookie.split(';').filter(function(item) { return item.indexOf('alert=dismissed') >= 0; }).length) {
      $('.alert--is-hidden').removeClass('alert--is-hidden');
    }
  }, 1000);

  $('.alert--site-wide-dismiss').on('click', function(e) {
    e.preventDefault();
    var date = new Date();
    var expires = 'expires=';
    date.setDate(date.getDate() + 1);
    expires += date.toGMTString();
    document.cookie = 'alert=dismissed;' + expires;
    $(this).parent().addClass('alert--is-hidden');
  })

})(jQuery);