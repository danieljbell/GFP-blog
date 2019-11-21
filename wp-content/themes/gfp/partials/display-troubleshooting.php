<?php
  if (has_post_thumbnail()) {
    $thumb_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
    $hero_bg = 'background-image: linear-gradient(rgba(0,0,0, 0.5), rgba(0,0,0, 0.5)), url(' . $thumb_array[0] . ')';
  }
  $post_title = str_replace('Troubleshooting Common Problems for a ', '', get_the_title());
?>

<section class="hero" style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(<?php echo get_stylesheet_directory_URI(); ?>/dist/img/hero--generic-<?php echo mt_rand(1,5);?>.jpg);">
      
  <div class="site-width">
    <h1 style="margin-bottom: 0;"><?php echo ($current_cat[0]->slug === 'talk-with-a-tech') ? 'Talk With A Tech ' : '';  ?><?php echo get_the_title(); ?></h1>
  </div>

</section>

<section <?php post_class(); ?>>
  <div class="site-width">
    <aside>
      <nav id="stickyNav" class="sticky-navigation">
        <ul>
          <li><a href="/<?php echo $post->post_name; ?>/#engine">Engine</a></li>
          <li><a href="/<?php echo $post->post_name; ?>/#electrical">Electrical</a></li>
          <li><a href="/<?php echo $post->post_name; ?>/#machine">Machine</a></li>
          <li><a href="/<?php echo $post->post_name; ?>/#mower">Mower</a></li>
        </ul>
      </nav>
    </aside>
    <article>
      
      <?php
        if (have_rows('engine_problems')) : 
          echo '<h2 id="engine">Common Engine Problems <span>for ' . $post_title . '<span></h2>';
          echo '<ul class="accordian mar-b--most">';
            while(have_rows('engine_problems')) : the_row();
            echo '<li class="accordian--item">';
              echo '<button class="accordian--title">' . get_sub_field('problem') . '</button>';
              echo '<div class="accordian--content">' . get_sub_field('solution') . '</div>';
            echo '</li>';
            endwhile;
          echo '</ul>';
        endif;
      ?>

      
      <?php
        if (have_rows('electrical_problems')) : 
          echo '<h2 id="electrical">Common Electrical Problems <span>for ' . $post_title . '<span></h2>';
          echo '<ul class="accordian mar-b--most">';
            while(have_rows('electrical_problems')) : the_row();
            echo '<li class="accordian--item">';
              echo '<button class="accordian--title">' . get_sub_field('problem') . '</button>';
              echo '<div class="accordian--content">' . get_sub_field('solution') . '</div>';
            echo '</li>';
            endwhile;
          echo '</ul>';
        endif;
      ?>

      <?php
        if (have_rows('machine_problems')) : 
          echo '<h2 id="machine">Common Machine Problems <span>for ' . $post_title . '<span></h2>';
          echo '<ul class="accordian mar-b--most">';
            while(have_rows('machine_problems')) : the_row();
            echo '<li class="accordian--item">';
              echo '<button class="accordian--title">' . get_sub_field('problem') . '</button>';
              echo '<div class="accordian--content">' . get_sub_field('solution') . '</div>';
            echo '</li>';
            endwhile;
          echo '</ul>';
        endif;
      ?>

      <?php
        if (have_rows('mower_problems')) : 
          echo '<h2 id="mower">Common Mower Problems <span>for ' . $post_title . '<span></h2>';
          echo '<ul class="accordian">';
            while(have_rows('mower_problems')) : the_row();
            echo '<li class="accordian--item">';
              echo '<button class="accordian--title">' . get_sub_field('problem') . '</button>';
              echo '<div class="accordian--content">' . get_sub_field('solution') . '</div>';
            echo '</li>';
            endwhile;
          echo '</ul>';
        endif;
      ?>

    </article>

    <aside>
        
        <?php
          // Loop over tags
          foreach (get_the_tags() as $tag) {
            // if tag is set as a model then query for posts
            if (get_field('is_model', $tag)) {
              $args = array(
                'post_type' => 'post',
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
              $query = new WP_Query( $args );
              if ($query->have_posts()) : 
                echo '<div class="related-maintenance-reminder">';
                  echo '<h4>Need a maintenance guide for your ' . $post_title . '?</h4>';
                  echo '<div class="mar-t">';
                    if ($query->post_count > 1) {
                      echo '<button class="tooltip--toggle btn-solid--brand">Get Your Guide</button>';
                      echo '<ul class="tooltip--links">';
                        while ($query->have_posts()) : $query->the_post();
                          $post_title = str_replace('John Deere ', '', get_the_title());
                          $post_title = str_replace(' Maintenance Sheet', '', $post_title);
                          echo '<li class="tooltip--item"><a href="' . get_the_permalink() . '">' . $post_title . '</a></li>';
                        endwhile;
                      echo '</ul>';
                    } else {
                      while ($query->have_posts()) : $query->the_post();
                        echo '<a href="' . get_the_permalink() . '" class="btn-solid--brand">Get Your Guide</a>';
                      endwhile;
                    }
                  echo '</div>';
                echo '</div>';
              endif;
              wp_reset_postdata();
            }
          }
        ?>

      </div>
    </aside>

  </div>
</section>

<script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@graph": [
      {
        "@context": "https://schema.org",
        "@type": "HowTo",
        "name": "<?php echo get_the_title(); ?>",
        "step": [
          {
            "@type": "HowToSection",
            "name": "Common Engine Problems for <?php echo get_the_title(); ?>",
            "position": "1",
            "itemListElement": [
              <?php
                if (have_rows('engine_problems')) :
                  $i = 1;
                  while(have_rows('engine_problems')) :
                    the_row();
              ?>
                {
                  "@type": "HowToStep",
                  "position": "<?php echo $i; ?>",
                  "itemListElement": [
                    {
                      "@type": "HowToDirection",
                      "position": "1",
                      "text": "<?php echo get_sub_field('problem'); ?>"
                    },
                    {
                      "@type": "HowToTip",
                      "position": "2",
                      "text": "<?php echo preg_replace( "/\r|\n/", " ", trim(strip_tags( get_sub_field('solution') )) ); ?>"
                    }
                  ]
                }<?php if ($i < count(get_field('engine_problems'))) { echo ','; } ?>
              <?php $i++; endwhile; endif; ?>
            ]
          },
          {
            "@type": "HowToSection",
            "name": "Common Electrical Problems for <?php echo get_the_title(); ?>",
            "position": "2",
            "itemListElement": [
              <?php
                if (have_rows('electrical_problems')) :
                  $i = 1;
                  while(have_rows('electrical_problems')) :
                    the_row();
              ?>
                {
                  "@type": "HowToStep",
                  "position": "<?php echo $i; ?>",
                  "itemListElement": [
                    {
                      "@type": "HowToDirection",
                      "position": "1",
                      "text": "<?php echo get_sub_field('problem'); ?>"
                    },
                    {
                      "@type": "HowToTip",
                      "position": "2",
                      "text": "<?php echo preg_replace( "/\r|\n/", " ", trim(strip_tags( get_sub_field('solution') )) ); ?>"
                    }
                  ]
                }<?php if ($i < count(get_field('electrical_problems'))) { echo ','; } ?>
              <?php $i++; endwhile; endif; ?>
            ]
          },
          {
            "@type": "HowToSection",
            "name": "Common Machine Problems for <?php echo get_the_title(); ?>",
            "position": "3",
            "itemListElement": [
              <?php
                if (have_rows('machine_problems')) :
                  $i = 1;
                  while(have_rows('machine_problems')) :
                    the_row();
              ?>
                {
                  "@type": "HowToStep",
                  "position": "<?php echo $i; ?>",
                  "itemListElement": [
                    {
                      "@type": "HowToDirection",
                      "position": "1",
                      "text": "<?php echo get_sub_field('problem'); ?>"
                    },
                    {
                      "@type": "HowToTip",
                      "position": "2",
                      "text": "<?php echo preg_replace( "/\r|\n/", " ", trim(strip_tags( get_sub_field('solution') )) ); ?>"
                    }
                  ]
                }<?php if ($i < count(get_field('machine_problems'))) { echo ','; } ?>
              <?php $i++; endwhile; endif; ?>
            ]
          },
          {
            "@type": "HowToSection",
            "name": "Common Mower Problems for <?php echo get_the_title(); ?>",
            "position": "4",
            "itemListElement": [
              <?php
                if (have_rows('mower_problems')) :
                  $i = 1;
                  while(have_rows('mower_problems')) :
                    the_row();
              ?>
                {
                  "@type": "HowToStep",
                  "position": "<?php echo $i; ?>",
                  "itemListElement": [
                    {
                      "@type": "HowToDirection",
                      "position": "1",
                      "text": "<?php echo get_sub_field('problem'); ?>"
                    },
                    {
                      "@type": "HowToTip",
                      "position": "2",
                      "text": "<?php echo preg_replace( "/\r|\n/", " ", trim(strip_tags( get_sub_field('solution') )) ); ?>"
                    }
                  ]
                }<?php if ($i < count(get_field('mower_problems'))) { echo ','; } ?>
              <?php $i++; endwhile; endif; ?>
            ]
          }
        ]
      },
      {
        <?php $terms = get_the_terms($post->ID, 'category')[0]; ?>
        "@context": "https://schema.org/",
        "@type": "BreadcrumbList",
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": "1",
            "item": {
              "name": "Home",
              "@id": "<?php echo site_url(); ?>"
            }
          },
          {
            "@type": "ListItem",
            "position": "2",
            "item": {
              "name": "<?php echo $terms->name; ?>",
              "@id": "<?php echo site_url() . '/' . $terms->slug; ?>"
            }
          },
          {
            "@type": "ListItem",
            "position": "3",
            "item": {
              "name": "<?php echo get_the_title(); ?>",
              "@id": "<?php echo get_the_permalink(); ?>"
            }
          }
        ]
      }
    ]
  }
</script>

<?php //print_r(get_the_terms($post->ID, 'category')); ?>

<?php
/*
=========================
<script type="application/json+ld"/>
{
  "@context":"http://schema.org",
  "@type":"HowTo",
  "name":"How To Add Your Website To Google Search Console",
  "steps":
  [
  {
    "@type":"HowToSection",
    "name":"Preparation",
                "position": "1",
    "itemListElement":
    [
    {
      "@type":"HowToStep",
                        "position": "1",
      "itemListElement":
      [
      {
        "@type":"HowToDirection",
                                "position": "1",
        "description":"Install Yoast SEO and activate your Google Search Console.",
        "duringMedia":
        {
        "@type":"ImageObject",
        "contentUrl":"yoast_seo_search_console.jpg"
        }
      },
      {
        "@type":"HowToTip",
                                "position": "2",
        "description":"Did you know you can check and fix crawl errors directly from Yoast SEO?"
      }
      ]
    },
    {
    }
    ]
  },
  {
    "@type":"HowToSection",
    "name":"Adding your site to Search Console",
                "position": "2",
    "itemListElement":
    [
    {
      "@type":"HowToStep",
                        "position": "1",
      "itemListElement":
      {
      "@type":"HowToDirection",
                        "position": "1",
      "description":"Go to Google Search Console (former Google Webmaster Tools), sign into your Google account and click the red button to add your website."
      }
    },
    {
      "@type":"HowToStep",
                        "position": "2",
      "itemListElement":
      [
      {
        "@type":"HowToDirection",
                                "position": "1",
        "description":"Copy the code for the HTML tag under the Alternate Methods tab.",
        "duringMedia":
        {
        "@type":"ImageObject",
        "contentUrl":"yoast_seo_search_console_2.jpg"
        }
      },
      {
        "@type":"HowToTip",
                                "position": "2",
        "description":"Please make sure you enter your complete url."
      }
      ]
    },
    {
      "@type":"HowToStep",
                        "position": "3",
      "itemListElement":
      {
      "@type":"HowToDirection",
                        "position": "1",
      "description":"Copy the code for the HTML tag under the Alternate Methods tab."
      }
    },
    {
      "@type":"HowToStep",
                        "position": "4",
      "itemListElement":
      {
      "@type":"HowToDirection",
                        "position": "1",
      "description":"Log in to your WordPress website and click on ‘SEO’ in your menu. After that, click on General."
      }
    },
    {
      "@type":"HowToStep",
                        "position": "5",
      "itemListElement":
      [
      {
        "@type":"HowToDirection",
                                "position": "1",
        "description":"Click on the ‘Webmaster Tools’ tab and add the code under ‘Google Search Console’. Click ‘Save Changes’."
      },
        {
      "@type":"HowToStep",
                        "position": "6",
      "itemListElement":
      {
      "@type":"HowToDirection",
                        "position": "1",
      "description":"Switch back to Google Search Console (formerly Google Webmaster Tools) and click ‘Verify’."
      }
    }
      ]
    }
    ]
  },
  {
    "@type":"HowToSection",
    "name":"Finishing up",
                "position": "3",
    "itemListElement":
    [
    {
      "@type":"HowToStep",
                        "position": "1",
      "itemListElement":
      {
      "@type":"HowToDirection",
                        "position": "1",
      "description":"Congratulations! You’ve connected your website to Google Search Console (former Google Webmaster Tools)!"
      }
    },
    {
      "@type":"HowToStep",
                        "position": "2",
      "itemListElement":
      {
      "@type":"HowToDirection",
                        "position": "2",
      "description":"Now that you’ve verified and connected your website, you can submit your sitemap!"
      }
    }
    ]
  }
  ]
}
=========================
*/
?>