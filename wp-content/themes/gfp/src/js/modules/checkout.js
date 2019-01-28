(function($) {
  
  var shipToDifferent = document.querySelector('#ship-to-different-address-checkbox');
  var shipDetails = document.querySelector('.shipping-details--is-hidden');
  
  if (shipToDifferent) {
    shipToDifferent.addEventListener('change', function(e) {
      if (!shipToDifferent.checked) {
        shipDetails.classList.add('shipping-details--is-hidden');
        return;
      }
      shipDetails.classList.remove('shipping-details--is-hidden');
    });
  }

  mailchimpOptIn = document.querySelector('#mailchimp_woocommerce_newsletter');
  if (mailchimpOptIn) {
    mailchimpOptIn.checked = true;
  }

})(jQuery);