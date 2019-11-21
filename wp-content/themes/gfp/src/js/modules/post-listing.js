(function() {

  var loadPosts = document.querySelector('#loadMorePosts');

  if (loadPosts) {
      var offset = 1;
      var postCount = 10;
      var postListing = document.querySelector('.post-listing--list');

      loadPosts.addEventListener('click', function(e) {
          var url = window.location.origin + '/wp-json/wp/v2/posts?offset=' + (offset * postCount);
          if (document.body.classList.contains('category')) {
            var cat = document.body.classList;
            console.log(cat);
            // url = window.location.origin + '/wp-json/wp/v2/posts?offset=' + (offset * postCount);
          }

          loadPosts.disabled = true;
          loadPosts.classList.add('disabled');
          
          atomic(url)
            .then(function (response) {
              var postObj = [];
              var data = response.data;
              // console.log(data);
              
              for (var i = 0; i < data.length; i++) {
                postObj.push({
                  date: data[i].date,
                  author: data[i].author,
                  category: data[i].categories[0],
                  title: data[i].title.rendered,
                  tags: data[i].tags,
                  link: data[i].link,
                  description: data[i].excerpt.rendered.slice(3, -5),
                });
              }

              loadPosts.disabled = false;
              loadPosts.classList.remove('disabled');
              
              if (response.data.length < 10) {
                loadPosts.textContent = 'All Posts Loaded';
                loadPosts.disabled = true;
                loadPosts.classList.add('disabled');
              }

              return postObj;
            })

            .then(function(postObj) {
              for (var i = 0; i < postObj.length; i++) {
                // assign all data
                var postTime = postObj[i].date;
                var postPrettyTime = new Date(postTime);
                    postPrettyTime = postPrettyTime.toDateString().slice(3);
                var postTitle = postObj[i].title;
                var postCategory = 'Uncategorized';
                var postLink = postObj[i].link;
                var postDescription = postObj[i].description;

                switch(postObj[i].category) {
                  case 17:
                    postCategory = 'Maintenance Reminder';
                    break;
                  case 63:
                    postCategory = 'Service Intervals';
                    break;
                  case 65:
                    postCategory = 'Troubleshooting';
                    break;
                  case 6:
                    postCategory = 'Talk With A Tech';
                    break;
                }
                
                // create the card
                var card = document.createElement('div');
                card.classList.add('card');
                card.innerHTML = '<div class="card-content">' + postTitle + '</div>';
                card.querySelector('.card-content').innerHTML = '<p class="card-category"><a href="/?cat=' + postObj[i].category + '">' + postCategory + '</a></p><h4 class="card-title"><a href="' + postLink + '">' + postTitle + '</a></h4><p class="card-description">' + postDescription + '</p><ul class="single-tags--list"></ul>';

                // add the card to results
                postListing.appendChild(card);
              }
            })
            .catch(function (error) {
              console.log(error);
            });

          offset++;
      });
  }


  var productListFilters = document.querySelector('.product-list-filters-list');
  var submitFilters = document.querySelector('#filter-products');
  if (!productListFilters) {
    return;
  }

  productListFilters.addEventListener('change', function(e) {
    var selectedBrands = [];
    productListFilters.querySelectorAll('li').forEach(function(brand) {
      if (!brand.querySelector('input').checked) {
        return;
      }
      selectedBrands.push(brand.querySelector('input').value);
    });
    filterProducts(selectedBrands);
  });

  function filterProducts(brands) {
    var productList = document.querySelectorAll('.product-list-with-filters .products--item');
    productList.forEach(function(product) {
      product.classList.remove('visually-hidden');
      if (!product.dataset.brand.includes(brands)) {
        product.classList.add('visually-hidden');
      }
    });
  }

})();