(function() {
  
  function navigationLinks() {
    
    var accountNavigation = document.querySelector('.woocommerce-MyAccount-navigation');
    if (!accountNavigation) {
      return;
    }
    
    var accountNavigationList = accountNavigation.querySelector('ul');
    var toggleAccountNavigation = accountNavigation.querySelector('button');
    

    function toggleMenu(e) {
      e.preventDefault();
      this.classList.toggle('is-active');
      accountNavigationList.classList.toggle('is-open');
    }

    toggleAccountNavigation.addEventListener('click', toggleMenu);

  }

  navigationLinks();

})();