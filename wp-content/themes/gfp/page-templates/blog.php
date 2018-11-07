<?php
/*
=========================
Template Name: Blog
=========================
*/
?>

<?php get_header(); ?>

<section class="hero">
  <div class="site-width">
    <h1><?php echo get_the_title(); ?></h1>
  </div>
</section>

<section class="pad-y--most blog-posts">
  <div class="site-width">


    <?php
      $maintenance_args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'tax_query' => array(
          array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => 'maintenance-reminder',
          ),
        ),
      );
      $maintenance_query = new WP_Query( $maintenance_args );
      if ($maintenance_query->have_posts()) :
    ?>
    <div class="box--with-header">
      <header><?php echo $maintenance_query->found_posts; ?> Maintenance Reminders</header>
      <ul>
        <?php
          while ($maintenance_query->have_posts()) : $maintenance_query->the_post();
            echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
          endwhile; endif; wp_reset_postdata();
          echo '<li class="view-more"><a href="' . site_url() . '/maintenance-reminder" class="btn-solid--brand-two">See ' . ($maintenance_query->found_posts - 5) . ' More Maintenance Reminders</a></li>';
        ?>
      </ul>
    </div>

    <?php
      $service_args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'tax_query' => array(
          array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => 'service-intervals',
          ),
        ),
      );
      $service_query = new WP_Query( $service_args );
      if ($service_query->have_posts()) :
    ?>
    <div class="box--with-header">
      <header><?php echo $service_query->found_posts; ?> Service Intervals</header>
      <ul>
        <?php
          while ($service_query->have_posts()) : $service_query->the_post();
            echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
          endwhile; endif; wp_reset_postdata();
          echo '<li class="view-more"><a href="' . site_url() . '/service-intervals" class="btn-solid--brand-two">See ' . ($service_query->found_posts - 5) . ' More Service Intervals</a></li>';
        ?>
      </ul>
    </div>

    <?php
      $troubleshooting_args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'tax_query' => array(
          array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => 'troubleshooting',
          ),
        ),
      );
      $troubleshooting_query = new WP_Query( $troubleshooting_args );
      if ($troubleshooting_query->have_posts()) :
    ?>
    <div class="box--with-header">
      <header><?php echo $troubleshooting_query->found_posts; ?> Troubleshooting</header>
      <ul>
        <?php
          while ($troubleshooting_query->have_posts()) : $troubleshooting_query->the_post();
            echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
          endwhile; endif; wp_reset_postdata();
          echo '<li class="view-more"><a href="' . site_url() . '/troubleshooting" class="btn-solid--brand-two">See ' . ($troubleshooting_query->found_posts - 5) . ' More Troubleshooting</a></li>';
        ?>
      </ul>
    </div>

    <?php
      $talk_with_a_tech_args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'tax_query' => array(
          array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => 'Talk With A Tech',
          ),
        ),
      );
      $talk_with_a_tech_query = new WP_Query( $talk_with_a_tech_args );
      if ($talk_with_a_tech_query->have_posts()) :
    ?>
    <div class="box--with-header">
      <header><?php echo $talk_with_a_tech_query->found_posts; ?> Talk With A Tech</header>
      <ul>
        <?php
          while ($talk_with_a_tech_query->have_posts()) : $talk_with_a_tech_query->the_post();
            echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
          endwhile; endif; wp_reset_postdata();
          if ($talk_with_a_tech_query->found_posts > 5) {
            echo '<li><a href="' . site_url() . '/talk-with-a-tech" class="btn-solid--brand-two">See ' . ($talk_with_a_tech_query->found_posts - 5) . ' More Talk With A Tech</a></li>';
          }
        ?>
      </ul>
    </div>

  <?php
  /*
  =========================

  <?php
    $talk_with_tech_args = array(
      'post_type' => 'post',
      'posts_per_page' => 5,
      'tax_query' => array(
        array(
          'taxonomy' => 'category',
          'field'    => 'slug',
          'terms'    => 'talk-with-a-tech',
        ),
      ),
    );
    $talk_with_tech_query = new WP_Query( $talk_with_tech_args );
    if ($talk_with_tech_query->have_posts()) : while ($talk_with_tech_query->have_posts()) : $talk_with_tech_query->the_post();
      echo '<p>' . get_the_title() . '</p>';
    endwhile; endif; wp_reset_postdata();
  ?>
  =========================
  */
  ?>

  </div>
</section>



<?php get_footer(); ?>