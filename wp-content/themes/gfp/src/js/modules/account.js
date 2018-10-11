(function() {
  
  function navigationLinks() {
    
    var accountNavigation = document.querySelector('.woocommerce-MyAccount-navigation');
    var accountNavigationList = accountNavigation.querySelector('ul');
    var toggleAccountNavigation = accountNavigation.querySelector('button');
    
    if (!accountNavigation) {
      return;
    }

    function toggleMenu(e) {
      e.preventDefault();
      this.classList.toggle('is-active');
      accountNavigationList.classList.toggle('is-open');
    }

    toggleAccountNavigation.addEventListener('click', toggleMenu);

  }

  navigationLinks();

})()