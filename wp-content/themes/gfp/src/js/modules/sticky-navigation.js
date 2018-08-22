(function() {

  var baseFontSize = parseInt(window.getComputedStyle(document.querySelector('body')).getPropertyValue('font-size'));

  var nav = document.querySelector('#stickyNav');

  if (nav) {

    var scrollY = window.scrollY;
    var navOffset = nav.offsetTop;
    var navWidth = nav.clientWidth;

    window.addEventListener('resize', function() {
      navOffset = nav.offsetTop;
      console.log(navOffset);
    });

    document.addEventListener('scroll', function() {
      scrollY = window.scrollY;
      var makeSticky = scrollY > (navOffset - (baseFontSize * 3));

      if (makeSticky) {
        nav.classList.add('nav--is-sticky');
        nav.style.maxWidth = navWidth + 'px';
      } else {
        nav.classList.remove('nav--is-sticky');
      }


    });

  }

})(); 