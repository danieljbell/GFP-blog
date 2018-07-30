(function() {

  var closeModal = document.querySelectorAll('.modal--close');
  var launchModal = document.querySelectorAll('button[data-modal-launch]');

  if (closeModal) {

    for (var i = 0; i < launchModal.length; i++) {
      launchModal[i].addEventListener('click', function(e) {
        var modalID = e.target.dataset.modalLaunch;
        document.querySelector('.modal[data-modal=' + modalID + ']').classList.remove('modal--is-hidden');
        document.body.classList.add('modal--is-open');
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