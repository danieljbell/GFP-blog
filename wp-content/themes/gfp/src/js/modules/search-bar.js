(function() {

var dompurify = window.DOMPurify;

  var searchBar = document.querySelector('.global-search-bar form');
  if (!searchBar) {
    return;
  }

  var searchInput = searchBar.querySelector('input[type="text"]');
  var defaultText = document.querySelector('.global-search-bar .default');
  var searchResults = document.querySelector('.global-search-bar .search-results');
  var postSearchResults = searchResults.querySelector('.search-results--posts ul');
  var productSearchResults = searchResults.querySelector('.search-results--products ul');
  var categoriesSearchResults = searchResults.querySelector('.search-results--categories ul');
  var modelsSearchResults = searchResults.querySelector('.search-results--models ul');
  var viewAllSearchResults = searchResults.querySelector('.search-results--view-all');

  searchInput.addEventListener('keyup', handleChange);

  function handleChange(e) {

    if (!this.value) {
      // searchResults.style.display = 'none';
      return;
    }

    searchResults.classList.remove('visually-hidden');

    var searchInputValue = this.value;

    document.querySelector('.screen').classList.remove('screen--is-hidden');

    searchInput.style.position = 'relative';
    searchInput.style.zIndex = 99;
    // searchResults.style.zIndex = 101;
    searchResults.style.display = 'block';
    viewAllSearchResults.querySelector('.search-term').textContent = searchInputValue;
    viewAllSearchResults.href = '/?s=' + searchInputValue;

    atomic('/wp-json/gfp/v1/search?s=' + this.value)
      .then(function(response) {
        console.log(response);
        searchResultsHTML(response.data, searchInputValue);
      })
      .catch(function(err) {
        console.log(err);
      })
  }

  function searchResultsHTML(results, value) {
    var posts = [];
    var products = [];
    var categories = [];
    var models = [];
    results.forEach(function(result, i) {
        if (result.type === 'post') {
          posts.push(result);
        }
        if (result.type === 'product') {
          products.push(result);
        }
        if (result.type === 'category') {
          categories.push(result);
        }
        if (result.type === 'model') {
          models.push(result);
        }
    })

    if (posts.length < 1) {
      postSearchResults.innerHTML = '<li class="search-result-item--empty">No result for ' + value + '</li>';
    } else {
      postSearchResults.innerHTML = posts.map(function(post) {
        return '<li class="search-result-item--post"><a href="' + post.link + '">' + post.title + '</a></li>';
      }).join('');
    }

    if (products.length < 1) {
      productSearchResults.innerHTML = '<li class="search-result-item--empty">No result for ' + value + '</li>';
    } else {
      productSearchResults.innerHTML = products.map(function(product) {
        return '<li class="search-result-item--product"><a href="' + product.link + '"><div class="search-results--product-image">' + product.image + '</div>' + product.title + '</a></li>';
      }).join('');
    }

    if (categories.length < 1) {
      categoriesSearchResults.innerHTML = '<li class="search-result-item--empty">No result for ' + value + '</li>';
    } else {
      categoriesSearchResults.innerHTML = categories.map(function(category) {
        return '<li class="search-result-item--category"><a href="' + category.link + '"><div class="search-results--product-image"><img src="' + category.image + '" /></div>' + category.title + '</a></li>';
      }).join('');
    }

    if (models.length < 1) {
      modelsSearchResults.innerHTML = '<li class="search-result-item--empty">No result for ' + value + '</li>';
    } else {
      modelsSearchResults.innerHTML = models.map(function(models) {
        return '<li class="search-result-item--model"><a href="' + models.link + '"><div class="search-results--product-image"><img src="' + models.image + '" /></div>' + models.title + '</a></li>';
      }).join('');
    }

  }

  searchResults.addEventListener('click', sendGAEvent, false);

  function sendGAEvent(e) {
    e.preventDefault();
    var link;
    if (e.target.tagName !== 'A') {
      if (e.target.tagName === 'IMG') {
        link = e.target.parentElement.parentElement;
      }
      if (e.target.tagName === 'DIV') {
        link = e.target.parentElement;
      }
    } else {
      link = e.target;
    }
    var searchLinkCategory = link.parentElement.classList[0].split('--')[1];
    var searchLinkText = link.textContent;
    if (!window.ga) {
      document.location = link;
      return;
    }
    ga('send', 'event', {
      eventCategory: 'live-search',
      eventAction: searchLinkCategory,
      eventLabel: searchLinkText,
      hitCallback: function() {
        document.location = link;
      }
    });
  }

  document.addEventListener('keyup', closeSearchBar);
  document.addEventListener('click', closeSearchBarClick);

  function closeSearchBar(e) {
    if (e.keyCode !== 27 || !document.querySelector('#s:focus')) {
      return;
    }
    searchResults.classList.add('visually-hidden');
    document.querySelector('.screen').classList.add('screen--is-hidden');
  }

  function closeSearchBarClick(e) {
    if (!e.target.classList.contains('screen')) {
      return;
    }
    searchResults.classList.add('visually-hidden');
    document.querySelector('.screen').classList.add('screen--is-hidden');
  }


})();