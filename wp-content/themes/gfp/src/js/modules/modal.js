(function() {

  document.addEventListener('click', checkModal);
  document.addEventListener('click', closeModalClick);
  document.addEventListener('keyup', closeModalEsc);

  function checkModal(e) {
    if (!e.target.dataset.modalLaunch) {
      return;
    }
    launchModal(e.target.dataset.modalLaunch);
  }

  function closeModalClick(e) {
    if (!e.target.classList.contains('modal--close')) {
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

  function launchModal(modalTarget) {
    document.body.classList.add('modal--is-open');
    document.querySelector('.modal--' + modalTarget).classList.remove('modal--is-hidden');
    document.querySelector('.modal--' + modalTarget).classList.add('modal--is-active');

    if (modalTarget === 'send-order-comment') {
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

  }

  // var closeModal = document.querySelectorAll('.modal--close');
  // var launchModal = document.querySelectorAll('button[data-modal-launch]');

  // if (!launchModal || launchModal.length < 1) {
  //   return;
  // }
  // launchModal.forEach(function(modalTrigger) {
  //   modalTrigger.addEventListener('click', launchModal);
  //   document.addEventListener('click', closeModal);

  //   function launchModal() {
  //     var modalToLaunch = this.dataset.modalLaunch;
  //     document.body.classList.add('modal--is-open');
  //     document.querySelector('.modal--' + modalToLaunch).classList.remove('modal--is-hidden');

  //     if (modalToLaunch === 'send-order-comment') {
  //       var radioButtons = document.querySelectorAll('input[name="contact_preference"]');
  //       radioButtons.forEach(function(button) {
  //         button.addEventListener('change', function(e) {
  //           var value = e.target.value;
  //           var allContact = document.querySelectorAll('.contact-preference');
  //           allContact.forEach(function(contactPreference) {
  //             contactPreference.style.display = 'none';
  //           });
  //           document.querySelector('.contact-preference--' + value).style.display = 'flex';
  //         });
  //       });
  //     }

  //   }

  //   function closeModal(e) {
  //     if (!e.target.dataset.modalClose) {
  //       return;
  //     }
  //     document.querySelector('.modal--' + e.target.dataset.modalClose).classList.add('modal--is-hidden');
  //     document.body.classList.remove('modal--is-open');
  //   }

  // });

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