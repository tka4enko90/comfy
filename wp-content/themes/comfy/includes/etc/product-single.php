<?php

function cmf_get_variation_colors_count() {
	global $product;
	$color_counter = 0;
	if ( $product->is_type( 'variable' ) ) {
		$variations = $product->get_variation_attributes();
		if ( isset( $variations['pa_color'] ) ) {
			$color_counter = count( $variations['pa_color'] );
		}
	}
	return $color_counter;
}
add_action(
	'woocommerce_before_single_product',
	function () {
		wp_enqueue_style( 'single-product', get_template_directory_uri() . '/dist/css/pages/single-product.css', '', '', 'all' );
		wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/dist/css/partials/slick.css', '', '', 'all' );

		wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/dist/js/partials/slick.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'single-product', get_template_directory_uri() . '/dist/js/pages/single-product.js', array( 'jquery' ), '', true );
	}
);

// Remove variation "Clear" button
add_filter(
	'woocommerce_reset_variations_link',
	function () {
		return;
	}
);

// Add buttons minus/plus to quantity
add_action(
	'woocommerce_before_quantity_input_field',
	function() {
		echo '<button type="button" class="btn btn-qty minus" aria-label="' . __( 'minus', 'comfy' ) . '"></button>';
	}
);
add_action(
	'woocommerce_after_quantity_input_field',
	function() {
		echo '<button type="button" class="btn btn-qty plus" aria-label="' . __( 'plus', 'comfy' ) . '"></button>';
	}
);


// Move tabs
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 40 );



// Move up sells section
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_main_content', 'woocommerce_upsell_display', 9 );

//Remove linked products from product summary
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

//Remove sale flash
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

add_action(
	'woocommerce_single_variation',
	'cmf_product_includes',
	15
);
function cmf_product_includes() {
	$includes = get_field( 'includes' );
	if ( ! empty( $includes ) ) {
		?>
		<p class="includes">
			<?php echo __( 'Includes:', 'comfy' ) . ' ' . $includes; ?>
		</p>
		<?php
	}
}

add_filter(
	'woocommerce_dropdown_variation_attribute_options_html',
	function ( $html, $args ) {
		ob_start();
		switch ( $args['attribute'] ) {
			case 'pa_size':
				?>
				<a class="size-guide-link guide-link" href="#">
					<svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M9.52594 1.53125C9.24953 1.29834 8.83463 1.09997 8.28297 0.937781C7.39125 0.675625 6.21428 0.53125 4.96875 0.53125C3.72325 0.53125 2.54622 0.675625 1.65456 0.937781C0.556656 1.26053 0 1.72659 0 2.32297C0 2.32644 0.00028125 2.32984 0.0003125 2.33331H0V7.87666C0 8.32363 0.447406 8.57262 0.594437 8.65444C0.862125 8.80341 1.2215 8.94041 1.66259 9.06159C2.61819 9.32416 3.79234 9.46875 4.96875 9.46875C5.6375 9.46875 6.30538 9.42188 6.93294 9.33334H6.95837V9.32959C7.42544 9.26272 7.86994 9.17288 8.27497 9.06159C8.716 8.94041 9.07538 8.80341 9.34309 8.65444C9.45881 8.59003 9.76053 8.42197 9.88378 8.13544H16V1.53125H9.52594ZM2.07916 1.79253C2.86816 1.58375 3.89437 1.46875 4.96875 1.46875C6.04313 1.46875 7.06934 1.58375 7.85834 1.79253C8.64659 2.00112 8.93412 2.234 8.99291 2.323C8.93412 2.412 8.64659 2.64484 7.85834 2.85344C7.06934 3.06225 6.04313 3.17722 4.96875 3.17722C3.89437 3.17722 2.86819 3.06222 2.07919 2.85344C1.29091 2.64484 1.00337 2.412 0.944594 2.323C1.00337 2.23397 1.29091 2.00116 2.07916 1.79253ZM9 7.76475C8.92269 7.82166 8.75053 7.91797 8.44794 8.02597V6.33331H7.51044V8.28116C7.33206 8.31844 7.14769 8.352 6.95834 8.38131V7.33331H6.02084V8.48953C5.83809 8.50391 5.65369 8.51463 5.46875 8.52153V6.66663H4.53125V8.52369C4.33944 8.51737 4.14806 8.50697 3.95834 8.49266V7.33328H3.02084V8.38753C2.83178 8.35897 2.64722 8.32641 2.46875 8.28991V6.33328H1.53125V8.04059C1.20259 7.92666 1.01828 7.82419 0.9375 7.76469V3.44159C1.14306 3.53916 1.38212 3.62809 1.65456 3.70819C2.54625 3.97034 3.72325 4.11472 4.96875 4.11472C6.21428 4.11472 7.39125 3.97034 8.28297 3.70819C8.55544 3.62809 8.79447 3.53912 9 3.44159V7.76475ZM15.0625 7.19791H9.9375V2.46875H15.0625V7.19791Z" fill="#283455"/>
					</svg>
					<span><?php _e( 'Size Guide', 'comfy' ); ?></span>
				</a>
				<?php
				break;
			case 'pa_lenght':
				?>
				<a class="guide-link" href="#">
					<span><?php _e( 'What’s the difference?', 'comfy' ); ?></span>
				</a>
				<?php
				break;
		}
		return $html . ob_get_clean();
	},
	220,
	2
);
add_action(
	'woocommerce_after_main_content',
	function () {
		global $product;
		if ( $product->is_type( 'variable' ) ) {
			foreach ( array_keys( $product->get_variation_attributes() ) as $taxonomy ) {
				if ( 'pa_size' === $taxonomy ) {
					$size_guide_image_id = get_field( 'size_guide_image_id', 'options' );
					?>
					<div id="size-guide-wrap">
						<div class="size-guide">
							<span class="close-guide"></span>
							<h2><?php _e( 'Size Guide' ); ?></h2>
							<?php echo ! empty( $size_guide_image_id ) ? wp_get_attachment_image( $size_guide_image_id, 'cmf_content_with_image_2' ) : ''; ?>
						</div>
					</div>
					<?php
				}
			}
		}
	}
);


add_action(
	'woocommerce_single_variation',
	'cmf_product_in_stock',
	20
);
function cmf_product_in_stock() {
	global $product;
	if ( $product->is_in_stock() ) {
		?>
		<div class="clear"></div>
		<p class="in-stock">
			<svg width="10" height="7" viewBox="0 0 10 7" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1 3.5L3.66667 6L9 1" stroke="#283455" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
			<?php _e( 'In Stock & Ready to Ship', 'comfy' ); ?>
		</p>
		<?php
	}
}


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

function cmf_get_product_care_guide_tab() {
	$content = get_field( 'care_guide' );
	echo ! empty( $content ) ? $content : '';
}
function cmf_get_product_shipping_tab() {
	$content = get_field( 'shipping__returns' );
	echo ! empty( $content ) ? $content : '';
}
function cmf_get_product_faq_tab() {
	$faq_items = get_field( 'faq' );
	if ( ! empty( $faq_items ) ) {
		$i = 0;
		foreach ( $faq_items as $item ) {
			?>
			<div class="faq-item">
				<?php
				if ( ! empty( $item['title'] ) ) {
					?>
					<h5 class="faq-item-title<?php echo ( 0 === $i ) ? ' active' : ''; ?>"><?php echo $item['title']; ?></h5>
					<?php
				}
				if ( ! empty( $item['content'] ) ) {
					?>
					<div class="faq-item-content"  <?php echo ( 0 === $i ) ? 'style="display: block;"' : ''; ?>>
						<?php echo $item['content']; ?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
			$i++;
		}
	}
}

//Product tabs
add_filter(
	'woocommerce_product_tabs',
	function ( $tabs ) {
		unset( $tabs['reviews'] );
		unset( $tabs['additional_information'] );
		$tabs['description']['title'] = __( 'Details', 'comfy' );
		$is_enable                    = array(
			'care_guide'        => ! empty( get_field( 'care_guide' ) ),
			'shipping__returns' => ! empty( get_field( 'shipping__returns' ) ),
			'faq'               => ! empty( get_field( 'faq' ) ),
		);

		if ( $is_enable['care_guide'] ) {
			$tabs['care_guide'] = array(
				'title'    => 'Care Guide',
				'priority' => 11,
				'callback' => 'cmf_get_product_care_guide_tab',
			);
		}
		if ( $is_enable['shipping__returns'] ) {
			$tabs['shipping__returns'] = array(
				'title'    => 'Shipping & Returns',
				'priority' => 12,
				'callback' => 'cmf_get_product_shipping_tab',
			);
		}
		if ( $is_enable['faq'] ) {
			$tabs['faq'] = array(
				'title'    => 'FAQ',
				'priority' => 13,
				'callback' => 'cmf_get_product_faq_tab',
			);
		}
		return $tabs;
	}
);

// Remove product_description_heading
add_filter(
	'woocommerce_product_description_heading',
	function () {
		return;
	}
);


//Content Product -> Remove "Add to cart" button
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

// Content Product -> Rating & Product info
add_action(
	'woocommerce_after_shop_loop_item_title',
	function () {
		if ( class_exists( 'JGM_Widget' ) ) {
			remove_action( 'woocommerce_after_shop_loop_item_title', array( 'JGM_Widget', 'judgeme_preview_badge' ), 5 );
		} else {
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		}
	},
	4
);
add_action(
	'woocommerce_after_shop_loop_item_title',
	function () {
		global $product;

		$includes      = get_field( 'includes', $product->get_id() );
		$color_counter = cmf_get_variation_colors_count();

		?>
		<div class="product-other-info">
			<?php
			if ( ! empty( $includes ) ) {
				?>
				<p class="product-description">
					<?php echo __( 'Includes', 'comfy' ) . ' ' . $includes; ?>
				</p>
				<?php
			}
			if ( ! empty( $color_counter ) ) {
				?>
				<span class="product-colors"><?php echo $color_counter . ' ' . __( 'colors', 'comfy' ); ?></span>
				<?php
			}
			?>
			<span class="product-rating">
			<?php
			if ( class_exists( 'JGM_Widget' ) ) {
				JGM_Widget::judgeme_preview_badge();
			} else {
				$rating        = $product->get_average_rating();
				$reviews_count = $product->get_review_count();
				cmf_star_rating( array( 'rating' => $rating ) );
			}
			?>
			</span>
			<?php
			if ( isset( $reviews_count ) ) {
				?>
				<span class="product-reviews-count"><?php echo $reviews_count . ' ' . __( 'reviews', 'comfy' ); ?></span>
				<?php
			}
			?>
		</div>
		<?php
	},
	10
);


// Content Product -> Price
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action(
	'woocommerce_after_shop_loop_item_title',
	function () {
		global $product;
		?>
		<div class="product-price">
			<?php
			if ( $product->is_type( 'variable' ) ) {
				//Get price of default product variation
				$default_attributes = $product->get_default_attributes();
				$variation_id       = cmf_find_matching_product_variation( $product, $default_attributes );
				$product            = wc_get_product( $variation_id );
			}
			echo $product->get_price_html();
			?>
		</div>
		<?php
	},
	5
);


// Product Mobile header
add_action(
	'woocommerce_before_single_product_summary',
	function () {
		?>
	<div class="mobile-info">
		<h1 class="product_title"><?php the_title(); ?></h1>
		<div class="d-flex">
			<?php
			$color_counter = cmf_get_variation_colors_count();
			if ( ! empty( $color_counter ) ) {
				?>
				<span class="product-colors"><?php echo $color_counter . ' ' . __( 'colors', 'comfy' ); ?></span>
				<?php
			}
			wc_get_template( 'single-product/rating.php' );
			?>
		</div>
	</div>
		<?php
	}
);

//Product Gallery large size
add_filter(
	'woocommerce_gallery_full_size',
	function () {
		return'cmf_product_single_zoomed';
	}
);

// Remove JGM_Widget from product_summary
add_action(
	'woocommerce_after_single_product_summary',
	function () {
		if ( class_exists( 'JGM_Widget' ) ) {
			remove_action( 'woocommerce_after_single_product_summary', array( 'JGM_Widget', 'judgeme_review_widget' ), 14 );
		}
	},
	13
);

add_filter(
	'cmf_review_widget',
	function( $html ) {
		$html = str_replace( "<div class='jdgm-rev-widg__header'>", "<div class='jdgm-rev-widg__header'><h3 class='section-title'><span id='jdgm-rev-widg__rev-counter'></span>" . __( 'Reviews' ) . '</h3>', $html );
		$html = str_replace( "<div class='jdgm-rev-widg__summary-text'>", "<p class='jdgm-rev-widg__summary-rating-text'><span id='jdgm-rev-widg__summary-rating-num'></span>" . __( 'out of 5 stars' ) . "</p><div class='jdgm-rev-widg__summary-text'>", $html );
		return   $html;
	}
);
