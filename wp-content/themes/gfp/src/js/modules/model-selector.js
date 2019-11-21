(function($) {

  var allCheckboxes = $('.sticky-elements input');
  allCheckboxes.on('change', function(e) {
    var val = e.target;
    if (val.checked) {
      $('section.equipment-container--' + val.id).removeClass('visually-hidden');
    } else {
      $('section.equipment-container--' + val.id).addClass('visually-hidden');
    }
  });

  var input = $('#search_model');
  var allAccordians = $('.all-models-container .accordian');
  input.on('keyup', function(e) {
    
    $.each(allCheckboxes, function(i, elem) {
      $(elem).prop('checked', true);
    });

    if (e.target.value === '') {
      clearEverything();
      return;
    }

    $.each(allAccordians, function(i, elem) {
      var allItems = $(elem).find('.accordian--item');
      $(elem).parents('.equipment-container').addClass('visually-hidden');
      $.each(allItems, function(i, item) {
        $(item).addClass('visually-hidden');
      })
    });

    var val = e.target.value.toUpperCase();
    var matches = $('[data-model-number*="' + val + '"]');


    matches.siblings().addClass('visually-hidden');
    matches.removeClass('visually-hidden');
    matches.parents('.accordian--item').removeClass('accordian--is-collapsed visually-hidden');
    matches.parents('.equipment-container').removeClass('visually-hidden');
  });

  function clearEverything() {
    console.log('reset');
    $('.all-models-container .accordian').removeClass('visually-hidden');
    $('.equipment-container').removeClass('visually-hidden');
    $('.accordian--item').removeClass('visually-hidden').addClass('accordian--is-collapsed');
  }

})(jQuery);