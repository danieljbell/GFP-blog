(function() {

  var closeModal = document.querySelector('.modal--close');
  var launchModal = document.querySelector('#launchModal');

  if (closeModal) {

    launchModal.addEventListener('click', function(e) {
      document.querySelector('.modal').classList.remove('modal--is-hidden');
      document.body.classList.add('modal--is-open');
    });

    closeModal.addEventListener('click', function(e) {
      e.target.parentElement.parentElement.classList.add('modal--is-hidden');
      document.body.classList.remove('modal--is-open');
    });

  }

})();