(function() {

  var currentPromotionsList = document.querySelector('.current-promotions--list');
  if (!currentPromotionsList) { return; }

  var currentPromotions = currentPromotionsList.querySelectorAll('.current-promotions--item');
  currentPromotions.forEach(function(promotion) {
    
    if (!promotion.dataset.offerExpiry) {
      return;
    }

    var expiry = promotion.dataset.offerExpiry;
    if (!promotion.querySelector('.current-promotions--body-copy')) {
      promotion.classList.add('current-promotions--item__has-body-copy');
      var exipryElem = document.createElement('span');
      exipryElem.classList.add('current-promotions--body-copy');
      promotion.querySelector('.current-promotions--content').appendChild(exipryElem);
    } else {
      var exipryElem = document.createElement('span');
      promotion.querySelector('.current-promotions--body-copy').appendChild(exipryElem);
    }

    setInterval(updatePromoExipry, 1000);
    // updatePromoExipry(promotion);

    function updatePromoExipry() {   
        var expireArray = moment(expiry, 'YYYYMMDD, HH:m a').countdown();
        exipryElem.textContent = ' Offer expires in ' + expireArray.toString();        
    }    

  });

})();