var loadPosts = document.querySelector('#loadMorePosts');

if (loadPosts) {
    var offset = 1;
    var postCount = 10;
    var postListing = document.querySelector('.post-listing--list');

    loadPosts.addEventListener('click', function(e) {
        var url = window.location.origin + '/wp-json/wp/v2/posts?offset=' + (offset * postCount);
        
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
                case 6:
                  postCategory = 'Talk With A Tech';
                  break;
              }
              
              // create the card
              var card = document.createElement('div');
              card.classList.add('card');
              card.innerHTML = '<div class="card-meta"></div><div class="card-content">' + postTitle + '</div>';
              card.querySelector('.card-meta').innerHTML = '<time datetime="' + postTime + '">' + postPrettyTime + '</time><p><small>By: <a href="#0">Daniel</a></small></p>';
              card.querySelector('.card-content').innerHTML = '<p class="card-category"><a href="/?cat=' + postObj[i].postCategory + '">' + postCategory + '</a></p><h4 class="card-title"><a href="' + postLink + '">' + postTitle + '</a></h4><p class="card-description">' + postDescription + '</p><ul class="single-tags--list"></ul>';

              // add the card to results
              postListing.appendChild(card);
            }
          })
          
          // .then(function(postObj) {
          //   if (postObj != undefined) {
          //     var includedCats = [];

          //     postObj.forEach(function(post) {
          //       includedCats.push(post.postCategory);
          //     });

          //     function removeDups(cats) {
          //       var unique = {};
          //       cats.forEach(function(i) {
          //         if(!unique[i]) {
          //           unique[i] = true;
          //         }
          //       });
          //       return Object.keys(unique);
          //     }

          //     var cleanCats = [];
              
          //     atomic('/wp-json/wp/v2/categories/?include=' + removeDups(includedCats))
          //       .then(function(response) {
          //         var data = response.data;

          //         console.log(data);
            
          //         // for (var i = 0; i < data.length; i++) {
          //         //   cleanCats.push(data.name)
          //         // }

          //       })

          //     console.log(cleanCats);
          //   }
          // })
          
          .catch(function (error) {
            console.log(error);
          });

        offset++;
    });
}


// .then(function (response) {
//   for (var i = 0; i < response.data.length; i++) {
//     // assign all data
//     var postTime = response.data[i].date;
//     var postTitle = response.data[i].title.rendered;
//     var postDescription = response.data[i].excerpt.rendered;
//     postDescription = postDescription.split('<p>')[1].split('</p>')[0];
//     var postCategory = response.data[i].categories[0];
//     var primaryCategories = {};

//     atomic('/wp-json/wp/v2/categories/?include=' + postCategory)
//       .then(function (response, primaryCategories) {
        
//         response.data.forEach(function(post, primaryCategories) {
//           // console.log(post.name);
//           primaryCategories.push(post.name);
//           console.log(primaryCategories);
//         });

//       })
//       .catch(function(error) {
//         console.log(error);
//       })

//       console.log(primaryCategories);
    
//     // create the card
//     var card = document.createElement('div');
//     card.classList.add('card');
//     card.innerHTML = '<div class="card-meta"></div><div class="card-content">' + postTitle + '</div>';
//     card.querySelector('.card-meta').innerHTML = '<time datetime="' + postTime + '">Tuesday</time><p><small>By: <a href="#0">Daniel</a></small></p>';
//     card.querySelector('.card-content').innerHTML = '<p class="card-category"><a href="#0">asdf</a></p><h4 class="card-title"><a href="#0">' + postTitle + '</a></h4><p class="card-description">' + postDescription + '</p><ul class="single-tags--list"></ul>';

//     // add the card to results
//     postListing.appendChild(card);
//     // console.log(response.data[i]);
    
//   }
  
  
  

// })