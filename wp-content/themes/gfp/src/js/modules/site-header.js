if (window.innerWidth > 1080) {
    // $('.menu-item--top-level .sub-menu--level-one > li:first-child').addClass('active').find('.sub-menu--level-two').addClass('accordian-open');
    // alert('tad');
}


document.querySelector('button#hamburger').addEventListener('click', function(e) {
  toggleMenu();
  var headerHeignt = document.querySelector('.site-header').offsetHeight;
  document.querySelector('.navigation--level-zero').style.top = headerHeignt + 'px';
});

var headerTopButtons = document.querySelectorAll('.navigation--button');
var navLevelOne = document.querySelectorAll('.navigation--level-one');

for (var i = 0; i < navLevelOne.length; i++) {
  navLevelOne[i].querySelector('li:first-child a').classList.add('active');
}

for (var i = 0; i < headerTopButtons.length; i++) {
  headerTopButtons[i].addEventListener('click', function (e) {
    e.preventDefault();
    var self = e.target;
    var childMenu = self.nextElementSibling.querySelector('.navigation--level-one');
    if (childMenu.classList.contains('active')) {
      childMenu.classList.remove('active');
      self.nextElementSibling.classList.remove('active');
    } else {
      self.parentElement.classList.add('active');
      self.nextElementSibling.classList.add('active');
      self.nextElementSibling.querySelector('.navigation--level-one').classList.add('active');
    }
    // console.log(self.parentElement);
    // self.parentElement.nextElementSibling.querySelector('.navigation--level-one').classList.remove('active');
  });
}

var allLevelOneLinks = document.querySelectorAll('.navigation--level-one > li > a');

for (var i = 0; i < allLevelOneLinks.length; i++) {
  allLevelOneLinks[i].addEventListener('click', function(e) {
    e.preventDefault();
    var links = document.querySelectorAll('.navigation--level-one > li > a');
    for (var j = 0; j < links.length; j++) {
      links[j].classList.remove('active');
    }
    // if (allLevelOneLinks.classList.contains('')) {}
    // allLevelOneLinks.classList.remove('active');
    e.target.classList.add('active');
    // console.log(e.target.parentElement.parentElement.parentElement.querySelector('.navigation--level-one > li > a'));
  });
}

function toggleMenu() {
    document.body.classList.toggle('menu-open');
    var menuButton = document.querySelector('#hamburger');
    menuButton.classList.toggle('is-active');
}