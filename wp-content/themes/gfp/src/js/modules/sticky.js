(function() {

  var baseFontSize = parseInt(window.getComputedStyle(document.querySelector('body')).getPropertyValue('font-size'));
  var stickyContainer = document.querySelector('.sticky--container');
  var stickyElement = document.querySelector('.sticky--element');

  // If elements are not on page or smaller screen, exit function
  if (!stickyContainer || !stickyElement || (window.innerWidth < 960)) {
    return;
  }

  //  GET SIBLING WIDTH
  var stickySibling = stickyContainer.parentElement.children;
  Array.from(stickySibling).forEach(function(child) {
    if (child.classList.contains('sticky--container')) {
      return;
    }
    stickySibling = child;
  })
  var stickySiblingWidth = stickySibling.offsetWidth;


  // get sizes of elements
  var stickyContainerHeight = stickyContainer.offsetHeight;
  var stickyContainerTop = stickyContainer.offsetTop;
  var stickyContainerWidth = stickyContainer.offsetWidth;
  var stickyElementHeight = stickyElement.offsetHeight;
  

  var scrollY = window.scrollY;

  // fun on page load
  watchForSticky();
  

  window.addEventListener('scroll', function(e) {
    scrollY = window.scrollY;
    watchForSticky();
  });

  function watchForSticky() {
    if (scrollY > (stickyContainerTop - (baseFontSize * 3))) {
      stickyElement.classList.add('sticky--element--is-fixed');
      stickyElement.style.maxWidth = stickyContainerWidth + 'px';
      stickyElement.style.transform = 'translateY(' + (baseFontSize * 3) + 'px)';
      stickySibling.style.maxWidth = stickySiblingWidth + 'px';

      if (scrollY > (stickyContainerHeight - stickyContainerTop - (baseFontSize * 3))) {
        var scrollTransformAmount = scrollY - stickyContainerHeight + stickyContainerTop + (baseFontSize * 3);
        stickyElement.style.transform = 'translateY(-' + scrollTransformAmount + 'px)';
      }

    }

    if (scrollY < (stickyContainerTop - (baseFontSize * 3))) {
      stickyElement.classList.remove('sticky--element--is-fixed');
      stickyElement.style.transform = 'translateY(0)';
    }

  }
  
  
})();