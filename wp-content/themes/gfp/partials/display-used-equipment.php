<?php

$response = file_get_contents(get_stylesheet_directory_uri() . '/config.php');
$lines = explode(PHP_EOL, $response);
$rfe_ck = '';
$rfe_cs = '';
foreach ($lines as $key => $line) {
  $thing = explode('=', $line);
  if ($thing[0] === 'rfe_consumer_key') {
    $rfe_ck = $thing[1];
  }
  if ($thing[0] === 'rfe_consumer_secret') {
    $rfe_cs = $thing[1];
  }
}

$url = "https://www.reynoldsfarmequipment.com/equipment/wp-json/wc/v3/products?consumer_key=$rfe_ck&consumer_secret=$rfe_cs&per_page=10&category=142";
$getJSON = curl_init();
curl_setopt($getJSON, CURLOPT_URL, $url);
curl_setopt($getJSON, CURLOPT_HEADER, 0);
curl_setopt($getJSON, CURLOPT_RETURNTRANSFER, 1);

$usedEquip = curl_exec($getJSON);
$usedEquip = json_decode($usedEquip);

if ($usedEquip && count($usedEquip) > 0) {
  echo '<div class="rfe-used-equip box--with-header mar-t--more">';
    echo '<h3 class="has-text-center">Interested in Used Equipment?</h3>';
    echo '<p class="has-text-center mar-b"><small>Used Equipment brought to you by:</small><br><a href="https://www.reynoldsfarmequipment.com/equipment/category/used?utm_medium=GFP&utm_source=' . urlencode(get_the_permalink()) . '&utm_campaign=used_on_gfp"><img src="https://www.reynoldsfarmequipment.com/wp-content/themes/rfe/dist/img/reynolds-logo.svg" alt="Reynolds Farm Equipment" style="max-width: 125px; display: inline-block; margin-top: 5px;"></p>';
    echo '<ul class="used-equip--list">';
      foreach ($usedEquip as $key => $equip) {
        $equip_location = '';
        $hours = '';
        foreach ($equip->attributes as $key => $value) {
          if ($value->name === 'Location') {
            $equip_location = $value->options[0];
          }
          if ($value->name === 'Operation Hours') {
            $hours = $value->options[0];
          }
        }
        $indiana = ['Fishers', 'Muncie', 'Atlanta', 'Lebanon', 'Mooresville'];
        if (in_array($equip_location, $indiana)) {
          $state = 'IN';
        } elseif ($equip_location === 'Xenia') {
          $state = 'OH';
        } else {
          $state = 'KY';
        }
        echo '<li class="used-equip--item"><a href="' . $equip->permalink . '?utm_medium=GFP&utm_source=' . urlencode(get_the_permalink()) . '&utm_campaign=used_on_gfp">';
          echo '<div class="used-equip--image">';
            echo '<img src="' . $equip->images[0]->src . '" alt="' . $equip->name . '">';
          echo '</div>';
          echo '<h4>' . $equip->name . '</h4>';
          if ($equip->price !== $equip->regular_price) {
            echo '<div class="used-equip--price-container">';
              echo '<p><del>$' . number_format($equip->regular_price, "2", '.', ',') . '</del><ins>$' . number_format($equip->price, '2', '.', ',') . '</ins></p>';
            echo '</div>';
          } else {
            echo '<div class="used-equip--price-container">';
              echo '<p>$' . number_format($equip->regular_price, "2", '.', ',') . '</p>';
            echo '</div>';
          }
          if ($hours !== '') {
            echo '<p style="font-size: 0.9em;">' . number_format($hours, '0', '.', ',') . ' Hours</p>';
          }
          echo '<p style="font-size: 0.9em;">' . $equip_location . ', ' . $state . '</p>';
          echo '<p class="btn-solid--brand mar-t"><small>See More Details</small></p>';
        echo '</a></li>';
      }
    echo '</ul>';
    echo '<p class="has-text-center mar-t--more mar-b"><a href="https://www.reynoldsfarmequipment.com/equipment/category/used?utm_medium=GFP&utm_source=' . urlencode(get_the_permalink()) . '&utm_campaign=used_on_gfp" class="btn-solid--brand-two">See All Used Equipment</a></p>';
  echo '</div>';
}