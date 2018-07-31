<?php
  $deere_permalink = get_field('deere_permalink');
  $url = $deere_permalink . 'index.json';
  $getJSON = curl_init();
  curl_setopt($getJSON, CURLOPT_URL, $url);
  curl_setopt($getJSON, CURLOPT_HEADER, 0);
  curl_setopt($getJSON, CURLOPT_RETURNTRANSFER, 1);
  
  $returnDeereModel = json_decode(curl_exec($getJSON), true);

  $model_number = $returnDeereModel['Page']['analytics']['MetaData']['product-model-number'];
  $model_name = $returnDeereModel['Page']['analytics']['MetaData']['product-model-name'];
  $model_image = 'https://deere.com/' . $returnDeereModel['Page']['analytics']['MetaData']['product-image'];
  $maintenance_kit = get_field('maintenance_kit_part_number');

  $formal_model_name = $model_number . ' ' . $model_name;
?>  


<?php
/*
=====================================================
LOOP OVER TAGS TO GET TROUBLESHOOTING RELATED CONTENT
=====================================================
*/  
foreach (get_the_tags() as $tag) {
  // if tag is set as a model then query for posts
  if (get_field('is_model', $tag)) {
    $troubleshooting_args = array(
      'post_type' => 'post',
      'tax_query' => array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'category',
          'field'    => 'slug',
          'terms'    => array( 'troubleshooting' ),
        ),
        array(
          'taxonomy' => 'post_tag',
          'field'    => 'term_id',
          'terms'  => $tag->term_id,
        ),
      ),
    );
    $troubleshooting_query = new WP_Query( $troubleshooting_args );
  }
}

/*
=====================================================
LOOP OVER TAGS TO GET SERVICE RELATED CONTENT
=====================================================
*/  
foreach (get_the_tags() as $tag) {
  // if tag is set as a model then query for posts
  if (get_field('is_model', $tag)) {
    $service_args = array(
      'post_type' => 'post',
      'tax_query' => array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'category',
          'field'    => 'slug',
          'terms'    => array( 'service-intervals' ),
        ),
        array(
          'taxonomy' => 'post_tag',
          'field'    => 'term_id',
          'terms'  => $tag->term_id,
        ),
      ),
    );
    $service_query = new WP_Query( $service_args );
  }
}
?>

<section <?php post_class(); ?>>
  <div class="site-width">

    <aside>
      <div class="model-image">
        <img src="<?php echo $model_image; ?>" alt="John Deere <?php echo $model_number . ' ' . $model_name; ?>">
      </div>
      <?php
        foreach (get_the_tags() as $tag) {
          if (get_field('is_series', $tag)) {
            // print_r($tag->term_id);
            $related_model_args = array(
              'post_type' => 'post',
              'order' => 'ASC',
              'tax_query' => array(
                'relation' => 'AND',
                array(
                  'taxonomy' => 'category',
                  'field'    => 'slug',
                  'terms'    => array( 'maintenance-reminder' ),
                ),
                array(
                  'taxonomy' => 'post_tag',
                  'field'    => 'term_id',
                  'terms'  => $tag->term_id,
                ),
              ),
            );
            $related_model_args_query = new WP_Query( $related_model_args );
          }
        }
        
        if ($related_model_args_query->have_posts()) :
          echo '<h4>Looking for a different model in this series?</h4><p style="margin-bottom: 0.5rem;">Browse other models in this series below</p>';
          echo '<select id="modelModifiers" style="width: 100%;">';
            echo '<option selected disabled>Choose Different Model in this Series</option>';
          while ($related_model_args_query->have_posts()) : $related_model_args_query->the_post();
            $is_current_page = str_replace(site_url(), '', get_the_permalink());
            $stripped_title = str_replace('John Deere ', '', str_replace('Maintenance Sheet', '', get_the_title()));
            if ($is_current_page === $_SERVER['REQUEST_URI']) {
              echo '<option selected value="' . get_the_permalink() . '">' . $stripped_title . '</option>';
            } else {
              echo '<option value="' . get_the_permalink() . '">' . $stripped_title . '</option>';
            }
          endwhile;
          echo '</select>';
        endif; wp_reset_postdata();
      ?>

      <?php if ($maintenance_kit) : ?>
        <div class="maintenance-kit-container">
          <h3>Need A Home Maintenance Kit<span> for your John Deere <?php echo $model_number . ' ' . $model_name; ?> </span>?</h3>
          <div class="maintenance-kit-content">
            <div class="maintenance-kit-img">
              <a href="https://greenfarmparts.com/-p/<?php echo $maintenance_kit; ?>.htm" title="Maintenance Kit: <?php echo $maintenance_kit; ?> for a John Deere <?php echo $model_number . ' ' . $model_name; ?>">
                <img src="https://greenfarmparts.com/v/vspfiles/photos/<?php echo $maintenance_kit; ?>-2T.jpg" alt="Maintenance Kit: <?php echo $maintenance_kit; ?> for a John Deere <?php echo $model_number . ' ' . $model_name; ?>">
              </a>
            </div>
            <?php if (have_rows('maintenance_part_items')) : ?>
              <div class="maintenance-kit-copy">
                <p><strong>Kit Includes:</strong></p>
                <ul>
                  <?php while (have_rows('maintenance_part_items')) : the_row(); ?>
                    <li><?php echo get_sub_field('maintenance_part_item'); ?></li>
                  <?php endwhile; ?>
                </ul>
              </div>  
            <?php endif; ?>
          </div>
          <div class="has-text-center">
            <a href="https://greenfarmparts.com/-p/<?php echo $maintenance_kit; ?>.htm" title="Maintenance Kit: <?php echo $maintenance_kit; ?> for a John Deere <?php echo $model_number . ' ' . $model_name; ?>" class="btn-solid--brand">Buy <?php echo strtoupper($maintenance_kit); ?> Now</a>
            <?php if (have_rows('maintenance_kit_serial_breaks')) : while (have_rows('maintenance_kit_serial_breaks')) : the_row(); ?>
              <a href="https://greenfarmparts.com/-p/<?php echo get_sub_field('serial_break_maintenance_kit_part_number'); ?>.htm" title="Maintenance Kit: <?php echo get_sub_field('serial_break_maintenance_kit_part_number'); ?> for a John Deere <?php echo $model_number . ' ' . $model_name; ?>" class="btn-solid--brand">Buy <?php echo strtoupper(get_sub_field('serial_break_maintenance_kit_part_number')); ?> Now</a>
            <?php endwhile; endif; ?>
          </div>
        </div>
      <?php endif; ?>
    </aside>
      
    <article>
      <h1><?php echo get_the_title(); ?></h1>
      <h2><?php echo get_the_excerpt(); ?></h2>
      <p>Common sense goes a long ways when maintaining your machine. If you have extreme heat, dust, or terrain that you operate in you, service frequency will need to increase.</p>
      

      <?php
        if ( ($troubleshooting_query->have_posts()) || ($service_query->have_posts()) )
      ?>
      <section class="mar-y--most pad-b related-model-links">
        <ul class="related-model-link-list">
            <?php
              if ($service_query->have_posts()) :
                echo '<li class="related-model-link-item">';
                  while ($service_query->have_posts()) :
                    $service_query->the_post();
                      echo '<div class="related-model-image">';
                        echo '<img src="/wp-content/themes/gfp/dist/img/tools.svg" alt="">';
                      echo '</div>';
                      echo '<div class="related-model-content">';
                        echo '<h3 class="mar-b">Need a Service Checklist<span> for a ' . $formal_model_name . ' </span>?</h3>';
                        echo '<a href="' . get_the_permalink() . '" >See the Schedule</a>';
                      echo '</div>';
                  endwhile;
                echo '</li>';
              endif;
              wp_reset_postdata();
            ?>
            <?php
              if ($troubleshooting_query->have_posts()) :
                echo '<li class="related-model-link-item">';
                  while ($troubleshooting_query->have_posts()) :
                    $troubleshooting_query->the_post();
                      echo '<div class="related-model-image">';
                        echo '<img src="/wp-content/themes/gfp/dist/img/question.svg" alt="">';
                      echo '</div>';
                      echo '<div class="related-model-content">';
                        echo '<h3 class="mar-b">Having Problems<span> with your ' . $formal_model_name . '</span>?</h3>';
                        echo '<a href="' . get_the_permalink() . '">See Troubleshooting Guide</a>';
                      echo '</div>';
                  endwhile;
                echo '</li>';
              endif;
              wp_reset_postdata();
            ?>
            <li class="related-model-link-item">
              <div class="related-model-image">
                <img src="/wp-content/themes/gfp/dist/img/alarm.svg" alt="">
              </div>
              <div class="related-model-content">
                <h3 class="mar-b">Want to Sign Up for Maintenance Reminders?</h3>
                <button data-modal-launch="sign-up-form">Get Notified</button>
              </div>
            </li>
        </ul>
      </section>

      <section class="mar-y--most">
        <h3>Service Schedule Parts<span> for John Deere <?php echo $model_number . ' ' . $model_name; ?></span></h3>
        <p>While your John Deere machine is certainly built with quality parts, they have a limited life. Good news is you can easily service your machine yourself using a John Deere maintenance kit or service kits or by getting the specific John Deere part needed to keep your John Deere mower or tractor running for a long time. These are the parts on your John Deere <?php echo $formal_model_name; ?> that need to be regularly serviced.</p>
        <?php if (have_rows('hourly_parts')) : ?>
          <table>
            <tr>
              <th>Part Type</th>
              <th>Part Number</th>
              <th width="75">Quantity</th>
              <th>Hour Intervals</th>
              <th width="130"></th>
            </tr>
        <?php while (have_rows('hourly_parts')) : the_row(); ?>
            <?php
              // $url = 'https://www.greenfarmparts.com/-p/' . get_sub_field('hourly_part_number') . '.htm';
              // $getHTML = curl_init();
              // curl_setopt($getHTML, CURLOPT_URL, $url);
              // curl_setopt($getHTML, CURLOPT_HEADER, 0);
              // curl_setopt($getHTML, CURLOPT_RETURNTRANSFER, 1);
              // $returnProductData = curl_exec($getHTML);

              // check for sold online or not
              if (!get_sub_field('not_sold')) {
                $available_online = '<button class="add-to-cart">Add to Cart</button>';
                $product_link = '<a href="https://www.greenfarmparts.com/-p/' . get_sub_field('hourly_part_number') . '.htm">' . strtoupper(get_sub_field('hourly_part_number')) . '</a>';
              } else {
                $available_online = '<button class="disabled">Not Sold Online</button>';
                $product_link = get_sub_field('hourly_part_number');
              }

                // Add Serial Break on seperate line
                $hourly_part_description = get_sub_field('hourly_part_description');
                $hourly_part_description = explode('(', $hourly_part_description);
                if (count($hourly_part_description) > 1) {
                  $hourly_part_description = $hourly_part_description[0] . '<br><em>(' . $hourly_part_description[1] . '</em>';
                } else {
                  $hourly_part_description = get_sub_field('hourly_part_description');
                }
                $interval_hour = get_sub_field('interval');
                $intervals = join("/", $interval_hour);
            ?>
            <tr>
              <td data-header="Part Type" data-product-image="https://greenfarmparts.com/v/vspfiles/photos/<?php echo get_sub_field('hourly_part_number'); ?>-2T.jpg">
                <?php echo $hourly_part_description; ?>    
              </td>
              <td data-header="Part Number"><?php echo $product_link; ?></td>
              <td data-header="Quantity"><?php echo get_sub_field('quantity'); ?></td>
              <td data-header="Hour Intervals"><?php echo $intervals; ?></td>
              <td><?php echo $available_online; ?></td>
            </tr>
            <?php if (have_rows('serial_breaks')) : while(have_rows('serial_breaks')) : the_row(); ?>
              <?php
                // Add Serial Break on seperate line
                $serial_break_hourly_part_description = get_sub_field('serial_break_hourly_part_description');
                $serial_break_hourly_part_description = explode('(', $serial_break_hourly_part_description);
              ?>
              <tr>
                <td data-header="Part Type"><?php echo $serial_break_hourly_part_description[0]; ?><br><em>(<?php echo $serial_break_hourly_part_description[1]; ?></em></td>
                <td data-header="Part Number"><a href="https://www.greenfarmparts.com/-p/<?php echo get_sub_field('serial_break_hourly_part_number'); ?>.htm"><?php echo get_sub_field('serial_break_common_part_number'); ?></a></td>
                <td data-header="Quantity">$9.99</td>
                <td data-header="Hour Intervals">$9.99</td>
                <td>
                  <?php
                    if (!get_sub_field('not_sold')) {
                      echo '<button class="add-to-cart">Add to Cart</button>';
                    } else {
                      echo 'Not sold online';
                    }
                  ?>
                </td>
              </tr>
            <?php endwhile; endif; ?>
        <?php endwhile; ?>
          </table>
        <?php endif; ?>
      </section>

      <section class="mar-y--most">
        <h3>Commonly Used Parts<span> for John Deere <?php echo $model_number . ' ' . $model_name; ?></span></h3>
        <p>Outside of the schedule service intervals, you may need a part for a quick repair. While this is not an inclusive list of all the John Deere parts for <?php echo $formal_model_name; ?>, these are the typical parts that we see purchased for your model. To see all the John Deere parts for your model, view our parts diagrams <a href="https://www.greenfarmparts.com/articles.asp?ID=287" target="_blank" rel="noopener noreferrer">here</a>.</p>
        <?php if (have_rows('common_parts')) : ?>
          <table>
            <tr>
              <th>Part Type</th>
              <th>Part Number</th>
              <!-- <th>Price</th> -->
              <th width="130"></th>
            </tr>
        <?php while (have_rows('common_parts')) : the_row(); ?>
            <?php
              // $url = 'https://www.greenfarmparts.com/-p/' . get_sub_field('common_part_number') . '.htm';
              // $getHTML = curl_init();
              // curl_setopt($getHTML, CURLOPT_URL, $url);
              // curl_setopt($getHTML, CURLOPT_HEADER, 0);
              // curl_setopt($getHTML, CURLOPT_RETURNTRANSFER, 1);
              // $returnProductData = curl_exec($getHTML);

              // check for sold online or not
              if (!get_sub_field('not_sold')) {
                $available_online = '<button class="add-to-cart">Add to Cart</button>';
                $product_link = '<a href="https://www.greenfarmparts.com/-p/' . get_sub_field('common_part_number') . '.htm">' . strtoupper(get_sub_field('common_part_number')) . '</a>';
                $sold_online = 'true';
              } else {
                $available_online = '<button class="disabled">Not Sold Online</button>';
                $product_link = get_sub_field('common_part_number');
                $sold_online = 'false';
              }

                // Add Serial Break on seperate line
                $common_part_description = get_sub_field('common_part_description');
                $common_part_description = explode('(', $common_part_description);
                if (count($common_part_description) > 1) {
                  $common_part_description = $common_part_description[0] . '<br><em>(' . $common_part_description[1] . '</em>';
                } else {
                  $common_part_description = get_sub_field('common_part_description');
                }
            ?>
            <tr>
              <td data-header="Part Type" data-product-sold="<?php echo $sold_online; ?>" data-product-image="https://greenfarmparts.com/v/vspfiles/photos/<?php echo get_sub_field('common_part_number'); ?>-2T.jpg">
                <?php echo $common_part_description; ?>    
              </td>
              <td data-header="Part Number"><?php echo $product_link; ?></td>
              <!-- <td data-header="Price">$9.99</td> -->
              <td><?php echo $available_online; ?></td>
            </tr>
            <?php if (have_rows('serial_breaks')) : while(have_rows('serial_breaks')) : the_row(); ?>
              <?php
                // Add Serial Break on seperate line
                $serial_break_common_part_description = get_sub_field('serial_break_common_part_description');
                $serial_break_common_part_description = explode('(', $serial_break_common_part_description);
              ?>
              <tr>
                <td data-header="Part Type"><?php echo $serial_break_common_part_description[0]; ?><br><em>(<?php echo $serial_break_common_part_description[1]; ?></em></td>
                <td data-header="Part Number"><a href="https://www.greenfarmparts.com/-p/<?php echo get_sub_field('serial_break_common_part_number'); ?>.htm"><?php echo get_sub_field('serial_break_common_part_number'); ?></a></td>
                <!-- <td data-header="Price">$9.99</td> -->
                <td>
                  <?php
                    if (!get_sub_field('not_sold')) {
                      echo '<button class="add-to-cart">Add to Cart</button>';
                    } else {
                      echo 'Not sold online';
                    }
                  ?>
                </td>
              </tr>
            <?php endwhile; endif; ?>
        <?php endwhile; ?>
          </table>
        <?php endif; ?>
      </section>
      
      <section class="mar-y--most">
        <h3>As Needed Parts<span> for John Deere <?php echo $model_number . ' ' . $model_name; ?></span></h3>
        <p>Regardless of your John Deere model, these John Deere parts are used frequently in maintaining and your <?php echo $formal_model_name; ?> and can be used around your garage.</p>
        <?php if (have_rows('as_needed_parts')) : ?>
          <table>
            <tr>
              <th>Part Type</th>
              <th>Part Number</th>
              <!-- <th>Price</th> -->
              <th width="130"></th>
            </tr>
        <?php while (have_rows('as_needed_parts')) : the_row(); ?>
            <?php
              // $url = 'https://www.greenfarmparts.com/-p/' . get_sub_field('as_needed_part_number') . '.htm';
              // $getHTML = curl_init();
              // curl_setopt($getHTML, CURLOPT_URL, $url);
              // curl_setopt($getHTML, CURLOPT_HEADER, 0);
              // curl_setopt($getHTML, CURLOPT_RETURNTRANSFER, 1);
              // $returnProductData = curl_exec($getHTML);

              // check for sold online or not
              if (!get_sub_field('not_sold')) {
                $available_online = '<button class="add-to-cart">Add to Cart</button>';
                $product_link = '<a href="https://www.greenfarmparts.com/-p/' . get_sub_field('as_needed_part_number') . '.htm">' . strtoupper(get_sub_field('as_needed_part_number')) . '</a>';
              } else {
                $available_online = '<button class="disabled">Not Sold Online</button>';
                $product_link = get_sub_field('as_needed_part_number');
              }

                // Add Serial Break on seperate line
                $as_needed_part_description = get_sub_field('as_needed_part_description');
                $as_needed_part_description = explode('(', $as_needed_part_description);
                if (count($as_needed_part_description) > 1) {
                  $as_needed_part_description = $as_needed_part_description[0] . '<br><em>(' . $as_needed_part_description[1] . '</em>';
                } else {
                  $as_needed_part_description = get_sub_field('as_needed_part_description');
                }
            ?>
            <tr>
              <td data-header="Part Type" data-product-image="https://greenfarmparts.com/v/vspfiles/photos/<?php echo get_sub_field('as_needed_part_number'); ?>-2T.jpg">
                <?php echo $as_needed_part_description; ?>    
              </td>
              <td data-header="Part Number"><?php echo $product_link; ?></td>
              <!-- <td data-header="Price">$9.99</td> -->
              <td><?php echo $available_online; ?></td>
            </tr>
            <?php if (have_rows('serial_breaks')) : while(have_rows('serial_breaks')) : the_row(); ?>
              <?php
                // Add Serial Break on seperate line
                $serial_break_as_needed_part_description = get_sub_field('serial_break_as_needed_part_description');
                $serial_break_as_needed_part_description = explode('(', $serial_break_as_needed_part_description);
              ?>
              <tr>
                <td data-header="Part Type"><?php echo $serial_break_as_needed_part_description[0]; ?><br><em>(<?php echo $serial_break_as_needed_part_description[1]; ?></em></td>
                <td data-header="Part Number"><a href="https://www.greenfarmparts.com/-p/<?php echo get_sub_field('serial_break_as_needed_part_number'); ?>.htm"><?php echo get_sub_field('serial_break_as_needed_part_number'); ?></a></td>
                <!-- <td data-header="Price">$9.99</td> -->
                <td>
                  <?php
                    if (!get_sub_field('not_sold')) {
                      echo '<button class="add-to-cart">Add to Cart</button>';
                    } else {
                      echo 'Not sold online';
                    }
                  ?>
                </td>
              </tr>
            <?php endwhile; endif; ?>
        <?php endwhile; ?>
            <?php
              $add_on_parts = array(
                array("Shop Towels", "TY26777"),
                array("Hand Cleaner", "TY26081"),
                array("Green Spray Paint", "TY25624"),
                array("Yellow Spray Paint", "TY25641"),
                array("Black Spray Paint", "TY25609")
              );
            ?>
            <?php foreach ($add_on_parts as $part) :  ?>
              <tr>
                <td data-header="Part Type" data-product-image="https://greenfarmparts.com/v/vspfiles/photos/<?php echo $part[1]; ?>-2T.jpg"><?php echo $part[0]; ?></td>
                <td data-header="Part Number"><a href="https://www.greenfarmparts.com/-p/<?php echo $part[1]; ?>.htm"><?php echo $part[1]; ?></a></td>
                <td><button class="add-to-cart">Add to Cart</button></td>
              </tr>
            <?php endforeach; ?>
          </table>
        <?php endif; ?>
      </section>

    </article>

  </div>
  
  <div class="alert--add-to-cart">
    <div class="alert--header">
      <h4>Products in Cart</h4>
      <button class="alert--close" id="closeAlert">&times;</button>
    </div>
    <div class="alert--content">
      <ul class="alert--cart-list">
        <li class="alert--cart-item">
          <span class="alert--cart-part">
            <span class="alert--cart-part-type">productType</span>
            <span class="alert--cart-part-number">productCode</span>
          </span>
          <span>
            <label for="product_quantity">Qty: </label>
            <input type="number" name="product_quantity" min="1" max="50" value="1">
            <button class="alert--remove-item">&times;</button>
          </span>
        </li>
      </ul>
      <div class="has-text-center mar-t--more">
        <button id="saveForLater" class="btn-outline--brand-two">Save for Later</button>
        <a id="submitCheckout" href="https://www.greenfarmparts.com/shoppingcart.asp?" class="btn-solid--brand">Checkout</a>
      </div>
    </div>
  </div>

<?php
  if ($service_query->have_posts()) :
?>
  <div class="modal modal--is-hidden" data-modal="service-checklist">
    <div class="modal-container">
      <button class="modal--close">&times;</button>
      <div class="modal-content">
        <h2 class="modal-heading"><?php echo $formal_model_name; ?> Service Checklist</h2>
        <ul class="accordian">
        <?php
          while ($service_query->have_posts()) : $service_query->the_post();
            if (have_rows('service_interval', $post->ID)) : while (have_rows('service_interval', $post->ID)) : the_row();
              echo '<li class="accordian--item">';
                echo '<button class="accordian--title">' . get_sub_field('interval') . '</button>';
                echo '<ul class="accordian--content">';
                  if (have_rows('interval_checklist')) : while (have_rows('interval_checklist')) : the_row();
                    $item_array = get_sub_field('interval_checklist_item');
                    echo '<li>';
                      if ($item_array['url'] !== '#0') {
                        echo '<a href="' . $item_array['url'] . '">' . $item_array['title'] . '</a>';
                      } else {
                        echo $item_array['title'];
                      }
                    echo '</li>';
                  endwhile; endif;
                echo '</ul>';
              echo '</li>';
              endwhile; endif;
            endwhile;
          ?>
        </ul>
        <div class="has-text-center mar-t--more">
          <?php
            while ($service_query->have_posts()) : $service_query->the_post();
              echo '<a href="' . get_the_permalink() . '" class="btn-solid--brand">View As Full Page</a>';
            endwhile;
          ?>
        </div>
      </div>
    </div>
  </div>
<?php
  endif;
  wp_reset_postdata();
?>


<div class="modal modal--is-hidden" data-modal="sign-up-form">
  <div class="modal-container">
    <button class="modal--close">&times;</button>
    <div class="modal-content">
      <div class="has-text-center">
        <h2 class="modal-heading">Sign Up for Maintenance Reminder Emails</h2>
        <p>We will periodically send you emails based on how you submit the form.</p>
      </div>
      <form action="https://greenfarmparts.us12.list-manage.com/subscribe/post-json?u=c80372a35929a7b281b76c090&id=d4452378de&c=?" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate form--maintenance-sign-up" target="_blank" novalidate>
        <div id="mc_embed_signup_scroll">
          <div class="mc-field-group">
            <label for="mce-EMAIL">Email Address</label>
            <input required type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
          </div>
          <div class="mc-field-group">
            <label for="mce-FNAME">First Name</label>
            <input type="text" value="" name="FNAME" class="" id="mce-FNAME">
          </div>
          <div class="mc-field-group">
            <label for="mce-LNAME">Last Name</label>
            <input type="text" value="" name="LNAME" class="" id="mce-LNAME">
          </div>
          <div class="mc-field-group">
            <label for="mce-MODEL">Model</label>
            <select name="MODEL" class="required" id="mce-MODEL">
            <option value="" disabled selected>Choose Your Model</option>
            <option value="115">115</option>
            <option value="125">125</option>
            <option value="L100">L100</option>
            <option value="L110">L110</option>
            <option value="LA155">LA155</option>
            <option value="D100">D100</option>
            <option value="D105">D105</option>
            <option value="D110">D110</option>
            <option value="D125">D125</option>
            <option value="D130">D130</option>
            <option value="D140">D140</option>
            <option value="D170">D170</option>
            <option value="E100">E100</option>
            <option value="E110">E110</option>
            <option value="E120">E120</option>
            <option value="E130">E130</option>
            <option value="E140">E140</option>
            <option value="E150">E150</option>
            <option value="E160">E160</option>
            <option value="E170">E170</option>
            <option value="E180">E180</option>
            <option value="S240">S240</option>
            <option value="X300R">X300R</option>
            <option value="X304">X304</option>
            <option value="X310">X310</option>
            <option value="X324">X324</option>
            <option value="X330">X330</option>
            <option value="X340">X340</option>
            <option value="X350">X350</option>
            <option value="X350R">X350R</option>
            <option value="X354">X354</option>
            <option value="X360">X360</option>
            <option value="X370">X370</option>
            <option value="X380">X380</option>
            <option value="X384">X384</option>
            <option value="X384">X384</option>
            <option value="X390">X390</option>
            <option value="X394">X394</option>
            <option value="X520">X520</option>
            <option value="X534">X534</option>
            <option value="X540">X540</option>
            <option value="X570">X570</option>
            <option value="X580">X580</option>
            <option value="X580">X580</option>
            <option value="X584">X584</option>
            <option value="X590">X590</option>
            <option value="X710">X710</option>
            <option value="X728">X728</option>
            <option value="X730">X730</option>
            <option value="X734">X734</option>
            <option value="X738">X738</option>
            <option value="X739">X739</option>
            <option value="X739">X739</option>
            <option value="X750">X750</option>
            <option value="X754">X754</option>
            <option value="X758">X758</option>
            <option value="Z225">Z225</option>
            <option value="Z235">Z235</option>
            <option value="Z255">Z255</option>
            <option value="Z335E">Z335E</option>
            <option value="Z335M">Z335M</option>
            <option value="Z345M">Z345M</option>
            <option value="Z345R">Z345R</option>
            <option value="Z355E">Z355E</option>
            <option value="Z355R">Z355R</option>
            <option value="Z375R">Z375R</option>
            <option value="Z425">Z425</option>
            <option value="Z435">Z435</option>
            <option value="Z445">Z445</option>
            <option value="Z465">Z465</option>
            <option value="Z525E">Z525E</option>
            <option value="Z535M">Z535M</option>
            <option value="Z535R">Z535R</option>
            <option value="Z540M">Z540M</option>
            <option value="Z540R">Z540R</option>
            <option value="Z625">Z625</option>
            <option value="Z645">Z645</option>
            <option value="Z655">Z655</option>
            <option value="Z665">Z665</option>
            </select>
          </div>
          <div class="mc-field-group size1of2">
            <label for="mce-CURRENT_HR">Current Hours </label>
            <input type="number" name="CURRENT_HR" class="" value="" id="mce-CURRENT_HR" min="0">
          </div>
          <div class="mc-field-group">
            <label for="mce-MOWING_TIM">Mowing Duration </label>
            <select name="MOWING_TIM" class="" id="mce-MOWING_TIM">
              <option value="" selected disabled>How long does it take to mow?</option>
              <option value="Small-Medium Yard (Less than 1.5 hours)">Small-Medium Yard (Less than 1.5 hours)</option>
              <option value="Large Property (More than 1.5 hours)">Large Property (More than 1.5 hours)</option>
            </select>
          </div>
          <div class="mc-field-group input-group">
            <ul>
              <li><input type="checkbox" value="1" name="group[141][1]" id="mce-group[141]-141-0" checked><label for="mce-group[141]-141-0">Give me maintenance reminders via email communications.</label></li>
            </ul>
          </div>
          <div class="mc-field-group input-group">
            <ul>
              <li><input type="checkbox" value="2" name="group[145][2]" id="mce-group[145]-145-0" checked><label for="mce-group[145]-145-0">I consent to having my maintenance reminder engagement tracked and analyzed.</label></li>
            </ul>
          </div>
          <div id="mce-responses" class="clear">
            <div class="response" id="mce-error-response" style="display:none"></div>
            <div class="response" id="mce-success-response" style="display:none"></div>
          </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
          <div style="position: absolute; left: -5000px;" aria-hidden="true">
            <input type="text" name="b_c80372a35929a7b281b76c090_d4452378de" tabindex="-1" value="">
          </div>
          <div class="clear has-text-center">
            <input type="submit" value="Keep Me Notified" name="subscribe" id="mc-embedded-subscribe" class="button btn-solid--brand">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>