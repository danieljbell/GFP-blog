(function() {

  // var closeModal = document.querySelectorAll('.modal--close');
  var launchModal = document.querySelectorAll('button[data-modal-launch]');

  if (!launchModal || launchModal.length < 1) {
    return;
  }
  launchModal.forEach(function(modalTrigger) {
    modalTrigger.addEventListener('click', launchModal);
    document.addEventListener('click', closeModal);

    function launchModal() {
      var modalToLaunch = this.dataset.modalLaunch;

      if (modalToLaunch === 'orderComment') {
        var modal = document.createElement('div');
        modal.classList.add('modal', 'modal--send-order-comment');
        modal.innerHTML = '<div class="modal-container"><button class="modal--close">&times;</button><div class="modal-content"><h2>Have A Question About Your Order?</h2><p>Fill out the form below and we\'ll be in touch.</p><form method="post" action="/wp-admin/admin-post.php"><div class="form-group input-radio"><p>How would you like for us to contact you?</p><div class="radio-options"><div class="form-group"><input type="radio" name="contact_preference" value="phone" id="contact_preference_phone" checked><label for="contact_preference_phone">Phone Call</label></div><div class="form-group"><input type="radio" name="contact_preference" value="email" id="contact_preference_email"><label for="contact_preference_email">Email</label></div></div></div><div class="form-group"><label for="customer_name">Name</label><input type="text" name="customer_name" id="customer_name"></div><div class="form-group contact-preference contact-preference--email" style="display: none;"><label for="email_address">Email Address</label><input type="email" name="email_address" id="email_address"></div><div class="form-group contact-preference contact-preference--phone"><label for="phone_number">Phone Number</label><input type="tel" name="phone_number" id="phone_number"></div><div class="form-group input-textarea"><label for="message">Message</label><textarea name="message" id="message"></textarea></div><div class="has-text-center"><input type="submit" class="btn-solid--brand-two" value="Send Message"></div><input type="hidden" name="action" value="send_order_comment"><input type="hidden" name="order_number" value="' + getParameterByName('order_number') + '"><input type="hidden" name="zipcode" value="' + getParameterByName('zipcode') + '"></form></div></div>';
        document.body.appendChild(modal);
        
        var radioButtons = document.querySelectorAll('input[name="contact_preference"]');
        radioButtons.forEach(function(button) {
          button.addEventListener('change', function(e) {
            var value = e.target.value;
            var allContact = document.querySelectorAll('.contact-preference');
            allContact.forEach(function(contactPreference) {
              contactPreference.style.display = 'none';
            });
            document.querySelector('.contact-preference--' + value).style.display = 'flex';
          });
        });
      }

      /*
<h2>Have A Question About Your Order?</h2>
<p>Fill out the form below and we\'ll be in touch.</p>
<form method="post" action="/wp-admin/admin-post.php">
  <div class="form-group input-radio">
    <p>How would you like for us to contact you?</p>
    <div class="radio-options">
      <div class="form-group">
        <input type="radio" name="contact_preference" value="phone" id="contact_preference_phone">
        <label for="contact_preference_phone">Phone Call</label>
      </div>
      <div class="form-group">
        <input type="radio" name="contact_preference" value="email" id="contact_preference_email">
        <label for="contact_preference_email">Email</label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="customer_name">Name</label>
    <input type="text" name="customer_name" id="customer_name">
  </div>
  <div class="form-group contact-preference contact-preference--email">
    <label for="email_address">Email Address</label>
    <input type="email" name="email_address" id="email_address">
  </div>
  <div class="form-group contact-preference contact-preference--phone">
    <label for="phone_number">Phone Number</label>
    <input type="tel" name="phone_number" id="phone_number">
  </div>
  <div class="form-group input-textarea">
    <label for="message">Message</label>
    <textarea name="message" id="message" cols="30" rows="10"></textarea>
  </div>
  <div class="has-text-center">
    <input type="submit" class="btn-solid--brand-two" value="Send Message">
  </div>
  <input type="hidden" name="action" value="send_order_comment">
  <input type="hidden" name="order_number" value="getParameterByName('order_number')">
</form>
      */

    }

    function closeModal(e) {
      if ((e.type === 'click') && (!e.target.classList.contains('modal--close'))) {
        return;
      }
      document.querySelector('.modal').remove();
    }

  });

  // if (closeModal) {

  //   for (var i = 0; i < launchModal.length; i++) {
  //     launchModal[i].addEventListener('click', function(e) {
  //       var modalID = e.target.dataset.modalLaunch;
  //       document.querySelector('.modal[data-modal=' + modalID + ']').classList.remove('modal--is-hidden');
  //       document.body.classList.add('modal--is-open');

  //       // Populate Model Field with Current Model Page
  //       if (modalID = 'sign-up-form') {
  //         var pageTags = document.querySelectorAll('meta[property="article:tag"]');
  //         for (var i = 0; i < pageTags.length; i++) {
  //           if ((pageTags[i].content.includes('John Deere')) && (pageTags[i].content !== 'John Deere Lawn Tractor')) {
  //             var model = pageTags[i].content.split('John Deere ')[1];
  //             document.querySelector('#mce-MODEL').value = model.toUpperCase();
  //           }
  //         }
  //       }

  //     });
  //   }

  //   for (var i = 0; i < closeModal.length; i++) {
  //     closeModal[i].addEventListener('click', function(e) {
  //       e.target.parentElement.parentElement.classList.add('modal--is-hidden');
  //       document.body.classList.remove('modal--is-open');
  //     });
  //   }

  //   document.addEventListener('keyup', function(e) {
  //     if (e.keyCode != 27) {
  //       return;
  //     }
  //     var launchModal = document.querySelectorAll('div[data-modal]');
  //     document.body.classList.remove('modal--is-open');
  //     for (var i = 0; i < launchModal.length; i++) {
  //       launchModal[i].classList.add('modal--is-hidden');
  //     }
  //   });

  // }

})();