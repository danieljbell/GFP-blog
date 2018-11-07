(function() {

  var loadMore = document.querySelector('#loadMorePosts');
  if (!loadMore) { return; }

  var offset = 10;
  var postsList = document.querySelector('.post-listing--results');

  loadMore.addEventListener('click', getPosts);

  function getPosts(e) {
    e.preventDefault();
    e.target.disabled = true;
    e.target.classList.add('disabled');
    var spinner = e.target.parentElement.querySelector('.spinner')
    spinner.style.display = 'block';
    console.log('fetching posts');
    atomic(window.location.origin + '/wp-json/wp/v2/posts?offset=' + offset + '&categories=' + currentCategory)
      .then(function(response) {
        offset += 10;
        loadMore.disabled = false;
        loadMore.classList.remove('disabled');
        spinner.style.display = 'none';
        console.log('posts fetched');
        formatPosts(response.data);
        appendPosts();
      })
  }

  function formatPosts(posts) {
    console.log('format Posts');
    posts.forEach(function(post) {
      var card = document.createElement('div');
      card.classList.add('card');
      card.innerHTML = '<div class="card-content"><p class="card-category"><a href="' + post.link + '">' + categoryName  + '</a></p><h4 class="card-title"><a href="' + post.link + '">' + post.title.rendered + '</a></h4><p class="card-description">' + post.excerpt.rendered.slice(3, -5) + '</p></div>';
      postsList.appendChild(card);
    });
  }

  function appendPosts() {
    console.log('appendPosts');
  }

})();