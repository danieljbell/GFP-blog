(function() {
  

  var fitmentTextFilter = document.querySelector('#fitment-text-filter');
  var productFitmentTags = document.querySelectorAll('.single--part-fitment-list a');

  if (fitmentTextFilter) {
    fitmentTextFilter.addEventListener('keyup', function(e) {
      
      var value = e.target.value.toUpperCase();
      for (var i = 0; i < productFitmentTags.length; i++) {
        productFitmentTags[i].parentElement.classList.add('hidden');
        if (productFitmentTags[i].textContent.includes(value)) {
          productFitmentTags[i].parentElement.classList.remove('hidden');
        }
      }

      

    });
  }


})();