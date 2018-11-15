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
  var viewAllSearchResults = searchResults.querySelector('.search-results--view-all');

  searchInput.addEventListener('keyup', handleChange);

  function handleChange(e) {

    if (!this.value) {
      // searchResults.style.display = 'none';
      return;
    }

    var searchInputValue = this.value;

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
    })

    if (posts.length < 1) {
      postSearchResults.innerHTML = '<li class="search-result-item--empty">No result for ' + value + '</li>';
    } else {
      postSearchResults.innerHTML = posts.map(function(post) {
        return '<li><a href="' + post.link + '">' + post.title + '</a></li>';
      }).join('');
    }

    if (products.length < 1) {
      productSearchResults.innerHTML = '<li class="search-result-item--empty">No result for ' + value + '</li>';
    } else {
      productSearchResults.innerHTML = products.map(function(product) {
        return '<li><a href="' + product.link + '"><div class="search-results--product-image">' + product.image + '</div>' + product.title + '</a></li>';
      }).join('');
    }

    if (categories.length < 1) {
      categoriesSearchResults.innerHTML = '<li class="search-result-item--empty">No result for ' + value + '</li>';
    } else {
      categoriesSearchResults.innerHTML = categories.map(function(category) {
        return '<li><a href="' + category.link + '"><div class="search-results--product-image"><img src="' + category.image + '" /></div>' + category.title + '</a></li>';
      }).join('');
    }

    

    // return searchResults.innerHTML = results.map(function(result, i) {
    //   if ( results.length === i+1 ) {
    //     return '<a class="search-result-view-all" href="/?s=' + value + '">View Full Search for ' + value + '</a>';
    //   } else {
    //     if (result.type === "post") {
    //       return '<ul class="search-results--posts"><li><a href="' + result.link + '">' + result.title + '</a></li></ul>';
    //     }
    //     if (result.type === "product") {
    //       return '<ul class="search-results--products"><li><a href="' + result.link + '">' + result.title + '</a></li></ul>';
    //     }
    //     /*
    //     <ul class="search-results--posts"></ul>
    //     <ul class="search-results--products"></ul>
    //   */
    //     // return '<a class="search-result-item" href="' + result.link + '">' + result.title + '</a>';
    //   }
    // }).join('');
  }


})();