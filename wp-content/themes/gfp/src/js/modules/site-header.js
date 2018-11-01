(function() {
  var megaMenus = document.querySelectorAll('.mega-menu');
  
  if (!megaMenus) {
    return;
  }
  
  megaMenus.forEach(function(menu) {
    menu.addEventListener('mouseenter', function() {
      document.querySelector('.screen').classList.remove('screen--is-hidden');
    }, false);
    
    menu.addEventListener('mouseleave', function() {
      document.querySelector('.screen').classList.add('screen--is-hidden');
    }, false);
  });

  var megaMenuParents = document.querySelectorAll('.mega-menu--parent');
  if (!megaMenuParents) {
    return;
  }

  megaMenuParents.forEach(function(item) {
    item.addEventListener('mouseenter', function(e) {
      megaMenuParents.forEach(function(item) {
        item.classList.add('mega-menu--parent--is-hidden');
      });
      if (e.target.classList.contains('mega-menu--parent--is-hidden')) {
          e.target.classList.remove('mega-menu--parent--is-hidden');
      }
    });
  });

  var navButtons = document.querySelectorAll('.navigation--button');
  navButtons.forEach(function(button) {
    button.addEventListener('click', toggleSubMenu);
  });

  function toggleSubMenu(e) {
    if (window.innerWidth < 769) {
      console.log(e.target.nextElementSibling.classList.toggle('mobile-open'));
    }
  }

  function toggleMenu() {
    document.body.classList.toggle('menu-open');
    var menuButton = document.querySelector('#hamburger');
    menuButton.classList.toggle('is-active');
    var headerHeignt = document.querySelector('.site-header').offsetHeight;
    document.querySelector('.navigation--level-zero').style.top = headerHeignt + 'px';
  }

  document.querySelector('button#hamburger').addEventListener('click', toggleMenu);

})();

// if (window.innerWidth > 1080) {
//     // $('.menu-item--top-level .sub-menu--level-one > li:first-child').addClass('active').find('.sub-menu--level-two').addClass('accordian-open');
//     // alert('tad');
// }


// document.querySelector('button#hamburger').addEventListener('click', function(e) {
//   toggleMenu();
//   var headerHeignt = document.querySelector('.site-header').offsetHeight;
//   document.querySelector('.navigation--level-zero').style.top = headerHeignt + 'px';
// });

// var headerTopButtons = document.querySelectorAll('.navigation--button');
// var navLevelOne = document.querySelectorAll('.navigation--level-one');

// for (var i = 0; i < navLevelOne.length; i++) {
//   navLevelOne[i].querySelector('li:first-child a').classList.add('active');
// }

// for (var i = 0; i < headerTopButtons.length; i++) {
//   headerTopButtons[i].addEventListener('click', function (e) {
//     e.preventDefault();
//     var self = e.target;
//     var childMenu = self.nextElementSibling.querySelector('.navigation--level-one');
//     if (childMenu.classList.contains('active')) {
//       childMenu.classList.remove('active');
//       self.nextElementSibling.classList.remove('active');
//     } else {
//       self.parentElement.classList.add('active');
//       self.nextElementSibling.classList.add('active');
//       self.nextElementSibling.querySelector('.navigation--level-one').classList.add('active');
//     }
//     // console.log(self.parentElement);
//     // self.parentElement.nextElementSibling.querySelector('.navigation--level-one').classList.remove('active');
//   });
// }

// var allLevelOneLinks = document.querySelectorAll('.navigation--level-one > li > a');

// for (var i = 0; i < allLevelOneLinks.length; i++) {
//   allLevelOneLinks[i].addEventListener('click', function(e) {
//     e.preventDefault();
//     var links = document.querySelectorAll('.navigation--level-one > li > a');
//     for (var j = 0; j < links.length; j++) {
//       links[j].classList.remove('active');
//     }
//     // if (allLevelOneLinks.classList.contains('')) {}
//     // allLevelOneLinks.classList.remove('active');
//     e.target.classList.add('active');
//     // console.log(e.target.parentElement.parentElement.parentElement.querySelector('.navigation--level-one > li > a'));
//   });
// }