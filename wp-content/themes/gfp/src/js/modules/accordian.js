(function() {
  var accordianButtons = document.querySelectorAll('.accordian--title');
  if (accordianButtons) {

    for (var i = 0; i < accordianButtons.length; i++) {
      accordianButtons[i].parentElement.classList.add('accordian--is-collapsed');
      accordianButtons[i].addEventListener('click', function(e) {
        var containingElement = e.target.parentElement;
        if (containingElement.classList.contains('accordian--is-collapsed')) {
          e.target.parentElement.classList.remove('accordian--is-collapsed');
        } else {
          e.target.parentElement.classList.add('accordian--is-collapsed');
        }
      })
    }
  }
})();