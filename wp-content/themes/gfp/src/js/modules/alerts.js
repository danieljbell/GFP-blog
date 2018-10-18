(function() {
  
  if (getParameterByName('success') === '1') {

    if (window.location.pathname === '/order-tracking/') {
      var alert = document.createElement('div');
      alert.classList.add('alert', 'alert--success');
      alert.innerHTML = '<button class="alert--close" onclick="this.parentElement.remove()">&times;</button><div class="alert--content"><h4>Great!</h4><p>We\'ve received your message and will respond shortly.</p></div>';
      document.body.prepend(alert);
    }

  }

})();