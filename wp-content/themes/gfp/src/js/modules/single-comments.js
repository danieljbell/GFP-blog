(function() {

  var commentsContainer = document.querySelector('.single-comments');
  var commentsReply = document.querySelector('#respond');
  var commentForm = document.querySelector('#commentform');


  if (commentsReply) {
    var button = document.createElement("button");
    button.innerHTML = 'Add Comment';
    button.id = 'addComment';

    commentsReply.style.visibility = 'hidden';
    commentsReply.style.maxHeight = '0px';
    commentsReply.style.padding = '0px';
    commentsReply.style.marginTop = '0px';

    commentsContainer.appendChild(button);

    document.querySelector('#addComment').addEventListener('click', function(e) {
      e.preventDefault();
      var self = e.target;
      self.style.opacity = '0';
      commentsReply.style.visibility = 'visible';
      commentsReply.style.maxHeight = '1000px';
      commentsReply.style.padding = '1rem';
      commentsReply.style.marginTop = '3rem';
    })

  }


})();