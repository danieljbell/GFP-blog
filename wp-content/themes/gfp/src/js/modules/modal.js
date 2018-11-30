// (function() {

  document.addEventListener('click', checkModal);
  document.addEventListener('click', closeModalClick);
  document.addEventListener('keyup', closeModalEsc);

  function checkModal(e) {
    if (!e.target.dataset.modalLaunch) {
      return;
    }
    launchModal(e);
  }

  function closeModalClick(e) {
    if (!e.target.classList.contains('modal--close') && !e.target.classList.contains('modal')) {
      return;
    }
    closeModal(e);
  }

  function closeModalEsc(e) {
    if (e.keyCode !== 27) {
      return;
    }
    closeModal(e);
  }

  function closeModal(e) {
    if (!document.body.classList.contains('modal--is-open')) {
      return;
    }
    document.querySelector('.modal--is-active').classList.add('modal--is-hidden');
    document.querySelector('.modal--is-active').classList.remove('modal--is-active');
    document.body.classList.remove('modal--is-open');
  }

  function launchModal(e) {
    var modalTarget = e.target.dataset.modalLaunch;
    if (modalTarget === undefined) {
      modalTarget = e.target.parentElement.dataset.modalLaunch;
    }
    document.body.classList.add('modal--is-open');
    document.querySelector('.modal--' + modalTarget).classList.remove('modal--is-hidden');
    document.querySelector('.modal--' + modalTarget).classList.add('modal--is-active');

    if (modalTarget === 'send-order-comment') {
      document.querySelector('input[name="order_number"]').value = e.target.dataset.orderNumber;
      // document.querySelector('input[name="customer_name"]');
      
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

      var form = document.querySelector('#submitOrderComment');
      form.addEventListener('submit', submitOrderComment);
      function submitOrderComment(e) {
        e.preventDefault();
        atomic(window.ajax_order_tracking.ajax_url, {
          method: 'POST',
          data: {
            action: 'send_order_comment',
            _ajax_nonce: window.ajax_order_tracking.nonce,
            contact_preference: form.querySelector('input[name="contact_preference"]:checked').value,
            customer_name: form.querySelector('input[name="customer_name"]').value,
            email_address: form.querySelector('input[name="email_address"]').value,
            phone_number: form.querySelector('input[name="phone_number"]').value,
            message: form.querySelector('textarea[name="message"]').value,
            order_number: form.querySelector('input[name="order_number"]').value,
          }
        }).then(function(response) {
          if (response.data.status === 'success') {
            if (response.data.contact_preference === 'phone') {
              var message = 'We will give you a phone call shortly at ' + response.data.phone_number + '.';
            } else {
              var message = 'We will send you an email shortly at ' + response.data.email_address + '.';
            }

            var modalContent = document.querySelector('.modal-content');
            modalContent.innerHTML = '<h2>Thanks ' + response.data.name + '!</h2><p>' + message + '</p>';
          }
          // if (response.data.) {}
        }).catch(function(err) {
          console.log('failed call');
          console.log(err);
        });
      }
    }

  }

// })();