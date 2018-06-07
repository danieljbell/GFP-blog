if (window.innerWidth > 1080) {
    // $('.menu-item--top-level .sub-menu--level-one > li:first-child').addClass('active').find('.sub-menu--level-two').addClass('accordian-open');
    // alert('tad');
}


// if ((e.target.id === 'hamburger') || (e.target.classList.contains('hamburger-box')) || (e.target.classList.contains('hamburger-inner'))) {
//   toggleMenu();
// }

function toggleMenu() {
    document.body.classList.toggle('menu-open');
    var menuButton = document.querySelector('#hamburger');
    menuButton.classList.toggle('is-active');
}