(function() {

  var searchBar = document.querySelector('.global-search-bar form');
  if (!searchBar) {
    return;
  }

  var searchInput = searchBar.querySelector('input[type="text"]');
  var defaultText = document.querySelector('.global-search-bar .default');
  var searchResults = document.querySelector('.search-results');

  searchInput.addEventListener('focus', showDefaultResults);
  searchInput.addEventListener('blur', showDefaultResults);

  searchInput.addEventListener('keyup', handleChange);

  function showDefaultResults() {
    if (searchResults.classList.contains('visually-hidden')) {
      searchResults.classList.remove('visually-hidden');
      return;
    }
    searchResults.classList.add('visually-hidden');
  }

  function handleChange(e) {
    var searchInputLength = this.value.length;

    
    // check search string length
    if (searchInputLength >= 3) {
      
      // hide default text
      defaultText.classList.add('visually-hidden');
      
      console.log('start searching');

    } else {
      
      // set character count
      defaultText.querySelector('.search-characters').textContent = (3 - searchInputLength);
      
      // show default text
      defaultText.classList.remove('visually-hidden');
      
    }
  }

})();