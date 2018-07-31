(function() {

  var closeModal = document.querySelectorAll('.modal--close');
  var launchModal = document.querySelectorAll('button[data-modal-launch]');

  if (closeModal) {

    for (var i = 0; i < launchModal.length; i++) {
      launchModal[i].addEventListener('click', function(e) {
        var modalID = e.target.dataset.modalLaunch;
        document.querySelector('.modal[data-modal=' + modalID + ']').classList.remove('modal--is-hidden');
        document.body.classList.add('modal--is-open');

        // Populate Model Field with Current Model Page
        if (modalID = 'sign-up-form') {
          var pageTags = document.querySelectorAll('meta[property="article:tag"]');
          for (var i = 0; i < pageTags.length; i++) {
            if ((pageTags[i].content.includes('John Deere')) && (pageTags[i].content !== 'John Deere Lawn Tractor')) {
              var model = pageTags[i].content.split('John Deere ')[1];
              document.querySelector('#mce-MODEL').value = model;
            }
          }
        }

      });
    }

    for (var i = 0; i < closeModal.length; i++) {
      closeModal[i].addEventListener('click', function(e) {
        e.target.parentElement.parentElement.classList.add('modal--is-hidden');
        document.body.classList.remove('modal--is-open');
      });
    }

    document.addEventListener('keyup', function(e) {
      if (e.keyCode != 27) {
        return;
      }
      var launchModal = document.querySelectorAll('div[data-modal]');
      document.body.classList.remove('modal--is-open');
      for (var i = 0; i < launchModal.length; i++) {
        launchModal[i].classList.add('modal--is-hidden');
      }
    });

  }

})();