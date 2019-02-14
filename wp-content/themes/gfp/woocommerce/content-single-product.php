<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

$nla_part = get_post_meta($post->ID, 'nla_part');
?>

<?php

	$args = array(
		'post_type' 		=> 'product',
		'meta_key'			=> 'product_alternatives',
		'meta_value' 		=> $product,
		'meta_compare'	=> 'LIKE'
	);
	$query = new WP_Query( $args );
	if ($query->have_posts()) :
		while($query->have_posts()) : $query->the_post();
		$deere_part = $post->ID;
		$deere_alternatives = get_post_meta($post->ID, 'product_alternatives');
		endwhile;
	endif; wp_reset_postdata();
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>

	<?php
		$wooproduct = wc_get_product( $post->ID );
		if (wp_get_attachment_url( $wooproduct->get_image_id() )) {
			$image = wp_get_attachment_url( $wooproduct->get_image_id() );
		} else {
			$image = get_stylesheet_directory_URI() . '/dist/img/partPicComingSoon.jpg';
		}

		if ($wooproduct->get_attributes()['pa_brand']) {
			$brand = $wooproduct->get_attributes()['pa_brand']->get_terms()[0]->name;
		}
		
		if ( $wooproduct->get_review_count() && 'yes' === get_option( 'woocommerce_enable_review_rating' ) ) {
			$aggregate_rating = true;
		}
		
		$review_comments = get_comments( array(
			'post_id' => $post->ID
		) );
	?>



	<script type="application/ld+json">
		{
		  "@context": "http://schema.org",
		  "@graph": [
		  	{
		  		"@context": "http://schema.org",
		  		"@type": "Product",
				  "name": <?php echo '"' . get_the_title() . '"'; ?>,
				  "image": [
						<?php
							if ($wooproduct->get_gallery_image_ids()) {
								echo '"' . wp_get_attachment_url($wooproduct->get_image_id()) . '",';
								$i = 1;
								foreach ($wooproduct->get_gallery_image_ids() as $image) {
									if ($i < count($wooproduct->get_gallery_image_ids())) {
										echo '"' . wp_get_attachment_url($image) . '",';
									} else {
										echo '"' . wp_get_attachment_url($image) . '"';
									}
									$i++;
								}
							} else {
								echo '"' . wp_get_attachment_url($wooproduct->get_image_id()) . '"';
							}
						?>
				  ],
				  "description": <?php echo '"' . strip_tags($post->post_excerpt) . '"'; ?>,
				  "url": "<?php echo $wooproduct->get_permalink(); ?>",
				  "offers": {
				    "@type": "Offer",
				    "availability": "InStock",
				    "itemCondition": "NewCondition",
				    "price": "<?php echo $wooproduct->get_price(); ?>",
				    "priceCurrency": "USD"
				  },
				  <?php if ($aggregate_rating) : ?>
				  	"aggregateRating": {
					    "@type": "AggregateRating",
					    "ratingValue": "<?php echo $wooproduct->get_average_rating(); ?>",
					    "reviewCount": "<?php echo count($wooproduct->get_rating_counts()); ?>"
					  },
			  	<?php endif; ?>
				  <?php if ($wooproduct->get_attributes()['pa_brand']) {
				  	echo '"brand": "' . $brand . '",';
				  } ?>
				  <?php if ($review_comments) : ?>
				  	"review": [
							<?php 
								$i = 0;
								foreach ($review_comments as $review_comment) :
							?>
								{
									"@type": "Review",
									"author": "<?php echo $review_comment->comment_author; ?>",
									"datePublished": "<?php echo $review_comment->comment_date_gmt; ?>",
									"description": "<?php echo $review_comment->comment_content; ?>"
								}<?php if ($i < (count($review_comments) - 1)) { echo ','; }  ?>
							<?php 
									$i++;
								endforeach;
							?>
				  	],
			  	<?php endif; ?>
				  "sku": "<?php echo $wooproduct->get_sku(); ?>"
		  	},
		  	{
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
		        <?php
		        	$i = 1;
		        	foreach ($wooproduct->get_category_ids() as $key => $category_id) :
		        		$count = count($wooproduct->get_category_ids());
		        		$i++;
		        		$term_obj = get_term_by('id', $category_id, 'product_cat');
		        ?>
		        {
		        	"@type": "ListItem",
		        	"position": "<?php echo $i; ?>",
		        	"item": {
			        	"name": "<?php echo $term_obj->name; ?>",
			        	"@id": "<?php echo site_url() . '/category/' . ($term_obj->slug); ?>"
			        }
		        },
		        <?php endforeach; ?>
		        {
		        	"@type": "ListItem",
		        	"position": "<?php echo $i + 1; ?>",
		        	"item": {
			        	"name": "<?php echo $wooproduct->get_name(); ?>",
			        	"@id": "<?php echo $wooproduct->get_permalink(); ?>"
			        }
		        }
		      ]
		    }
		  ]
		}
	</script>
	<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			// do_action( 'woocommerce_single_product_summary' );
			// echo '<div class="single-product--content">';
				do_action( 'woocommerce_template_single_title' );
				do_action( 'woocommerce_template_single_rating' );
				$part_replacements = get_post_meta($post->ID, 'product_subs');
				if ((count($part_replacements) > 0) && ($nla_part[0] !== 'yes')) {
					echo '<div class="part--replaced_by mar-t">';
						echo '<p class="mar-b">This part is no longer available. It\'s been replaced by:</p>';
						echo '<ul>';
							foreach ($part_replacements as $part) {
								$replacement_part_id = wc_get_product_id_by_sku($part);
								if ($replacement_part_id) {
									$replacement_part = wc_get_product($replacement_part_id);
									echo '<li class="products--item product-card--slim">';
										echo '<div class="products--image">';
											echo '<a href="' . $replacement_part->get_permalink() . '">';
												if ( has_post_thumbnail() ) :
									        echo '<img src="https://res.cloudinary.com/greenfarmparts/image/upload/e_brightness:30,w_100,h_100,c_fill/' . $replacement_part->get_sku() . '-0.jpg" alt="" style="max-width: 65px;">';
												else :
									        echo '<img src="' . wc_placeholder_img_src() . '" alt="Part Photo Coming Soon" style="max-width: 65px;">';
									      endif;
								      echo '</a>';
										echo '</div>';
										echo '<div class="products--content">';
											echo '<a href="' . $replacement_part->get_permalink() . '" style="font-size: 0.85rem;">';
												echo $replacement_part->get_name();
											echo '</a>';
										echo '</div>';
									echo '</li>';
								}
							}
						echo '</ul>';
					echo '</div>';
				} else {
					do_action( 'woocommerce_template_single_price' );
					do_action( 'woocommerce_template_single_add_to_cart' );
				}

				
				if ($nla_part[0] === 'yes') {
					echo '<p>Sorry, this part is no longer available.</p>';
				}
				
				echo '<div class="product-content">', get_the_content(), '</div>';

				$product_alternative = get_post_meta($post->ID, 'product_alternatives');
				$product_alternatives = explode('|', $product_alternative[0]);
				print_r($product_alternatives);
				$alt_array = explode('|', $deere_alternatives[0]);
				$product = wc_get_product($post->ID);
				
				$has_alt_parts = false;
				foreach ($product_alternatives as $part) {
					$wc_part_id = wc_get_product_id_by_sku($part);
					if ($wc_part_id) {
						$has_alt_parts = true;
					}
				}

				// if on deere part or alt part, open up div
				if ($has_alt_parts && ($product_alternatives[0] !== '') || (count($alt_array) > 1)) {
					echo '<div class="mar-y--most box--with-header">';
						echo '<header>Alternative Products to ' . $product->get_name() . '</header>';
						echo '<ul class="product-alternatives--list">';
				

						// on the deere part
						if ((count($product_alternatives) > 1)) {
							$parts = array();
							foreach ($product_alternatives as $part) {
								$wc_part_id = wc_get_product_id_by_sku($part);
								if ($wc_part_id) {
									$wc_part = wc_get_product($wc_part_id);
									array_push($parts, array(
										'name' => $wc_part->get_name(),
										'link' => $wc_part->get_permalink(),
										'image' => $wc_part->get_image('thumbnail'),
										'price' => $wc_part->get_price()
									));
								}
							}
						} else {
							$parts = array();
							foreach ($alt_array as $part) {
								$wc_part_id = wc_get_product_id_by_sku($part);
								if ($wc_part_id) {
									$wc_part = wc_get_product($wc_part_id);
									if ($post->ID === $wc_part->get_ID()) {
										$deere_part = wc_get_product($deere_part);
										array_push($parts, array(
											'name' => $deere_part->get_name(),
											'link' => $deere_part->get_permalink(),
											'image' => $deere_part->get_image('thumbnail'),
											'price' => $deere_part->get_price()
										));
									} else {
										array_push($parts, array(
											'name' => $wc_part->get_name(),
											'link' => $wc_part->get_permalink(),
											'image' => $wc_part->get_image('thumbnail'),
											'price' => $wc_part->get_price()
										));
									}
								}
							}
						}
						if (count($parts) > 0) :
						foreach ($parts as $part) {
							?>
							<li class="product-alternatives--item">
								<a href="<?php echo $part['link']; ?>">
									<div class="product-alternatives--image">
										<?php echo $part['image']; ?>
									</div>
									<div class="product-alternatives--meta">
										<p class="product-alternatives--name"><?php echo $part['name']; ?></p>
										<?php if ($part['price'] < $product->get_price()) : ?>
											<p class="prodct-alternatives--price">$<?php echo $part['price']; ?> &mdash; <strong style="color: red;">Save $<?php echo number_format((float)$product->get_price() - $part['price'], 2, '.', ''); ?></strong></p>
										<?php else : ?>
											<p class="prodct-alternatives--price">$<?php echo $part['price']; ?></p>
										<?php endif; ?>
									</div>
								</a>
							</li>
							<?php
						}
						endif;
				
				// if on deere part or alt part, close div
						echo '</ul>';
					echo '</div>';
				}

				$oversized = $wpdb->query( $wpdb->prepare( 
          "
            SELECT * FROM wp_woocommerce_per_product_shipping_rules
            WHERE product_id = %s
          ", 
          $post->ID
        ) );

        if (!$oversized && !$part_replacements) : ?>
				<div class="notification--free-shipping">
					<img src="<?php echo get_stylesheet_directory_URI(); ?>/dist/img/shipping.svg" alt="Shipping Icon">
					This product is eligible for free shipping with orders over $49.99!
				</div>
        <?php
        endif;
				
				do_action( 'woocommerce_output_product_data_tabs' );
				
		?>

		<?php
			if ( function_exists('dynamic_sidebar') ) :
        dynamic_sidebar( 'Product Recommendations' );
      endif; 
		?>
	</div>

	<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		// do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php //get_template_part('partials/display', 'alert--add-to-cart'); ?>