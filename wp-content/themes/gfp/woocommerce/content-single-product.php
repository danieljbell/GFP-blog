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
?>

<?php
	$args = array(
		'post_type' 		=> 'product',
		'meta_key'			=> 'product_alternatives',
		'meta_value' 		=> $post->ID,
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
				$part_replacements = get_post_meta($post->ID, 'replaced_by');
				$replacement_count = count($part_replacements[0]);
				$replacement_text = 'It\'s been replaced by:';
				if ($replacement_count > 1) {
					$replacement_text = 'It\'s been replaced by these ' .$replacement_count .' parts:';
				}
				if ($replacement_count === 0) {
					do_action( 'woocommerce_template_single_price' );
					do_action( 'woocommerce_template_single_add_to_cart' );
				} else {
					echo '<div class="part--replaced_by">';
						echo '<p>This part is no longer available. ' . $replacement_text . '</p>';
						echo '<ul>';
							foreach ($part_replacements[0] as $part) {
								$replacement_part = wc_get_product($part);
								echo '<li class="product-card--slim">';
									echo '<a href="' . $replacement_part->get_permalink() . '">';
										// echo '<img src="' .  . '">';
										echo $replacement_part->get_image(array(75,75));
										print_r($replacement_part->get_name());
									echo '</a>';
								echo '</li>';
							}
						echo '</ul>';
					echo '</div>';
				}
				echo '<div class="product-content">', get_the_content(), '</div>';
				do_action( 'woocommerce_template_single_excerpt' );

				$product_alternative = get_post_meta($post->ID, 'product_alternatives');
				if ((count($product_alternative[0]) > 0) || (count($deere_alternatives[0]) > 0)) {
					$product = wc_get_product($post->ID);
					echo '<div class="mar-y--most box--with-header">';
						echo '<header>Product Alternatives to ' . $product->get_name() . '</header>';
						echo '<ul class="product-alternatives--list">';
							foreach ($product_alternative[0] as $key => $alternative) :
								$alternative_part = wc_get_product($alternative);
								echo '<li class="product-alternatives--item">';
									echo '<a href="' . $alternative_part->get_permalink() . '">';
										echo '<div class="product-alternatives--image">';
											echo  $alternative_part->get_image('thumbnail');
										echo '</div>';
										echo '<div class="product-alternatives--meta">';
											echo '<p class="product-alternatives--name">' . $alternative_part->get_name() . '</p>';
											if ($alternative_part->get_price() < $wooproduct->get_price()) {
												echo '<p class="product-alternatives--price">Price: $' . $alternative_part->get_price() . ' &mdash; <span style="color: red; font-weight: bold;">Save $' . ($wooproduct->get_price() - $alternative_part->get_price()) . '</span></p>';
											} else {
												echo '<p class="product-alternatives--price">Price: $' . $alternative_part->get_price() . '</p>';
											}
										echo '</div>';
									echo '</a>';
								echo '</li>';
							endforeach;

							if ((count($deere_alternatives[0]) > 0)) {
								$deere_product = wc_get_product($deere_part);
								echo '<li class="product-alternatives--item">';
									echo '<a href="' . $deere_product->get_permalink() . '">';
										echo '<div class="product-alternatives--image">';
											echo  $deere_product->get_image('thumbnail');
										echo '</div>';
										echo '<div class="product-alternatives--meta">';
											echo '<p class="product-alternatives--name">' . $deere_product->get_name() . '</p>';
											if ($deere_product->get_price() < $wooproduct->get_price()) {
												echo '<p class="product-alternatives--price">Price: $' . $deere_product->get_price() . ' &mdash; <span style="color: red; font-weight: bold;">Save $' . ($wooproduct->get_price() - $deere_product->get_price()) . '</span></p>';
											} else {
												echo '<p class="product-alternatives--price">Price: $' . money_format('%+n', $deere_product->get_price()) . '</p>';
											}
										echo '</div>';
									echo '</a>';
								echo '</li>';
							}

							foreach ($deere_alternatives[0] as $key => $alternative) :
								$alternative_part = wc_get_product($alternative);
								if ($post->ID != $alternative) {
									echo '<li class="product-alternatives--item">';
										echo '<a href="' . $alternative_part->get_permalink() . '">';
											echo '<div class="product-alternatives--image">';
												echo  $alternative_part->get_image('thumbnail');
											echo '</div>';
											echo '<div class="product-alternatives--meta">';
												echo '<p class="product-alternatives--name">' . $alternative_part->get_name() . '</p>';
												if ($alternative_part->get_price() < $wooproduct->get_price()) {
													echo '<p class="product-alternatives--price">Price: $' . $alternative_part->get_price() . ' &mdash; <span style="color: red; font-weight: bold;">Save $' . ($wooproduct->get_price() - $alternative_part->get_price()) . '</span></p>';
												} else {
													echo '<p class="product-alternatives--price">Price: $' . money_format('%+n', $alternative_part->get_price()) . '</p>';
												}
											echo '</div>';
										echo '</a>';
									echo '</li>';
								}
							endforeach;
						echo '</ul>';
					echo '</div>';
				}

				do_action( 'woocommerce_after_single_product_summary' );
				// do_action( 'woocommerce_output_product_data_tabs' );
				// do_action( 'woocommerce_template_single_meta' );
				// do_action( 'woocommerce_template_single_sharing' );
			// echo '</div>';
			// echo '<div class="single-product--actions">';
			// echo '</div>';
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

<?php get_template_part('partials/display', 'alert--add-to-cart'); ?>