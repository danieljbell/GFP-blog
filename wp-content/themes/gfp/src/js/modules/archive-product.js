(function($) {

  $('#filter--select-fitment').on('change', filterProductResults);

  function filterProductResults(e) {
    e.preventDefault();
    document.location = window.location.origin + '/part-catalog/' + $(this).val();
    // $.ajax({
    //   url: window.location.origin + '/part-catalog/' + $(this).val(),
    //   success: function(res) {
    //     console.log(res);
    //   }
    // })
  }

})(jQuery);