(function() {
  var allToolTips = document.querySelectorAll('.tooltip--toggle');
  if (allToolTips) {
    for (var i = 0; i < allToolTips.length; i++) {
      allToolTips[i].nextElementSibling.classList.add('tooltip--is-hidden');

      allToolTips[i].addEventListener('click', function(e) {
        console.log(e.target.nextElementSibling.classList.toggle('tooltip--is-hidden'));
      });
    }
  }
})();