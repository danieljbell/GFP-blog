(function() {

var dompurify = window.DOMPurify;

  var searchBar = document.querySelector('.global-search-bar form');
  if (!searchBar) {
    return;
  }

  var searchInput = searchBar.querySelector('input[type="text"]');
  var defaultText = document.querySelector('.global-search-bar .default');
  var searchResults = document.querySelector('.global-search-bar .search-results');

  searchInput.addEventListener('input', handleChange);

  function handleChange(e) {

    if (!this.value) {
      // searchResults.style.display = 'none';
      return;
    }

    var searchInputValue = this.value;

    searchResults.style.display = 'block';

    atomic('/wp-json/gfp/v1/search?s=' + this.value)
      .then(function(response) {
        searchResultsHTML(response.data, searchInputValue);
      })
      .catch(function(err) {
        searchResults.innerHTML = dompurify.sanitize('<p class="search-result-item--empty">No results found for ' + searchInputValue + '</p>');
      })
  }

  function searchResultsHTML(results, value) {
    return searchResults.innerHTML = results.map(function(result, i) {
      if ( results.length === i+1) {
        return '<a class="search-result-view-all" href="/?s=' + value + '">View Full Search for ' + value + '</a>';
      } else {
        return '<a class="search-result-item" href="' + result.link + '">' + result.title + '</a>';
      }
    }).join('');
  }

  searchInput.addEventListener('keyup', function(e) {
    // e.preventDefault();
    
    // Bail if not up arrow, down arrow or enter key
    if (![38, 40, 13].includes(e.keyCode)) {
      return;
    }

    var activeClass = 'search__result--active';
    var current = searchResults.querySelector('.search__result--active');
    var items = searchResults.querySelectorAll('a');
    var next;

    if (e.keyCode === 40 && current) {
      next = current.nextElementSibling || items[0];
    } else if (e.keyCode === 40) {
      next = items[0];
    } else if (e.keyCode === 38 && current) {
      next = current.previousElementSibling || items[items.length - 1]
    } else if (e.keyCode === 38) {
      next = items[items.length - 1];
    } else if (e.keyCode === 13 && current.href) {
      window.location = current.href;
      return;
    }
    
    if (current) {
      current.classList.remove(activeClass);
    }
    next.classList.add(activeClass);



  });

})();