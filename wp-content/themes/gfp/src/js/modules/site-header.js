(function ($) {

  var topLevel = $('.mega-menu--shop-by-part > li');
  $.each(topLevel, function () {
    $(this).addClass('mega-menu--parent--is-hidden mega-menu--parent').children('ul').addClass('mega-menu--child-list');
  });
  topLevel.first().removeClass('mega-menu--parent--is-hidden');


  var megaMenus = document.querySelectorAll('.mega-menu');

  if (!megaMenus) {
    return;
  }

  megaMenus.forEach(function (menu) {
    var allLinks = menu.querySelectorAll('a');
    allLinks.forEach(function (link) {
      link.textContent = link.textContent.replace('John Deere ', '')
    })

    menu.addEventListener('mouseenter', function () {
      document.querySelector('.screen').classList.remove('screen--is-hidden');
    }, false);

    menu.addEventListener('mouseleave', function () {
      if (document.querySelector('#s:focus')) {
        return;
      }
      document.querySelector('.screen').classList.add('screen--is-hidden');
    }, false);
  });

  var megaMenuParents = document.querySelectorAll('.mega-menu--parent');
  if (!megaMenuParents) {
    return;
  }

  megaMenuParents.forEach(function (item) {
    if (window.innerWidth > 769) {
      item.addEventListener('mouseenter', function (e) {
        megaMenuParents.forEach(function (item) {
          item.classList.add('mega-menu--parent--is-hidden');
        });
        if (e.target.classList.contains('mega-menu--parent--is-hidden')) {
          e.target.classList.remove('mega-menu--parent--is-hidden');
        }
      });
    }
  });

  var navButtons = document.querySelectorAll('.navigation--button');
  navButtons.forEach(function (button) {
    button.addEventListener('click', toggleSubMenu);
  });

  if (window.innerWidth < 769) {
    megaMenuParents.forEach(function (item) {
      item.addEventListener('click', function (e) {
        if (e.target.parentElement.classList.contains('menu-item-has-children')) {
          e.preventDefault();
          e.target.parentElement.classList.toggle('mega-menu--parent--is-hidden');
        }
      });
    });
  }

  var equipmentButtons = document.querySelectorAll('.mega-menu--equipment-parent');
  equipmentButtons.forEach(function (button) {
    button.addEventListener('click', showChildEquipment);
  });

  // var allBack = document.querySelectorAll('.equipmentResultsBack');
  // allBack.forEach(function(button) {
  //   button.addEventListener('click', function(e) {
  //     e.target.parentElement.classList.add('visually-hidden');
  //     var items = e.target.parentElement.parentElement.querySelectorAll('.mega-menu--child-item');
  //     items.forEach(function(item) {
  //       item.classList.remove('visually-hidden');
  //     });
  //     document.querySelector('.equipment-results h4').textContent = '';
  //   });
  // })

  function showChildEquipment(e) {
    e.preventDefault();

    $(this).parent().siblings().toggle();
    $(this).next().toggleClass('visually-hidden');
    $(this).toggleClass('display-back');

  }

  function toggleSubMenu(e) {
    if (window.innerWidth < 769) {
      e.target.nextElementSibling.classList.toggle('mobile-open');
    }
  }

  function toggleMenu() {
    document.body.classList.toggle('menu-open');
    var menuButton = document.querySelector('#hamburger');
    menuButton.classList.toggle('is-active');
    var headerHeignt = document.querySelector('.site-header').offsetHeight;
    document.querySelector('.navigation--level-zero').style.top = headerHeignt + 'px';
    if (window.innerWidth < 769) {
      megaMenuParents.forEach(function (item) {
        item.classList.add('mega-menu--parent--is-hidden');
      });
    }
  }

  document.querySelector('button#hamburger').addEventListener('click', toggleMenu);

})(jQuery);