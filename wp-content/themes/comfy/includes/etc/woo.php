<?php

function cmf_star_rating( $args = array() ) {

	$defaults    = array(
		'rating'        => 0,
		'type'          => 'rating',
		'number'        => 0,
		'echo'          => true,
		'rounded_stars' => true,
		'star_width'    => 14,
		'star_height'   => 14,
	);
	$parsed_args = wp_parse_args( $args, $defaults );

	$star = array(
		'width'  => $parsed_args['star_width'],
		'height' => $parsed_args['star_height'],
	);
	if ( true === $parsed_args['rounded_stars'] ) {
		$star['url'] = get_stylesheet_directory_uri() . '/dist/img/stars/star-full.svg';
	} else {
		$star['url'] = get_stylesheet_directory_uri() . '/dist/img/slider-stars/star.svg';
	}

	// Non-English decimal places when the $rating is coming from a string.
	$rating = (float) str_replace( ',', '.', $parsed_args['rating'] );

	// Convert percentage to star rating, 0..5 in .5 increments.
	if ( 'percent' === $parsed_args['type'] ) {
		$rating = round( $rating / 10, 0 ) / 2;
	}

	// Calculate the number of each type of star needed.
	$full_stars  = floor( $rating );
	$half_stars  = ceil( $rating - $full_stars );
	$empty_stars = 5 - $full_stars - $half_stars;

	if ( $parsed_args['number'] ) {
		/* translators: 1: The rating, 2: The number of ratings. */
		$format = _n( '%1$s rating based on %2$s rating', '%1$s rating based on %2$s ratings', $parsed_args['number'] );
		$title  = sprintf( $format, number_format_i18n( $rating, 1 ), number_format_i18n( $parsed_args['number'] ) );
	} else {
		/* translators: %s: The rating. */
		$title = sprintf( __( '%s rating' ), number_format_i18n( $rating, 1 ) );
	}

	$output  = '<div class="cmf-star-rating">';
	$output .= '<span class="screen-reader-text">' . $title . '</span>';
	$output .= str_repeat( '<img src="' . $star['url'] . '" loading="lazy" width="' . $star['width'] . '" height="' . $star['height'] . '" class="star star-full" >', $full_stars );
	$output .= str_repeat( '<img src="' . $star['url'] . '" loading="lazy" width="' . $star['width'] . '" height="' . $star['height'] . '" class="star star-half" >', $half_stars );
	$output .= str_repeat( '<img src="' . $star['url'] . '" loading="lazy" width="' . $star['width'] . '" height="' . $star['height'] . '" class="star star-empty" >', $empty_stars );
	$output .= '</div>';

	if ( $parsed_args['echo'] ) {
		echo $output;
	}

	return $output;
}

function cmf_find_matching_product_variation( $product, $attributes ) {
	foreach ( $attributes as $key => $value ) {
		if ( strpos( $key, 'attribute_' ) === 0 ) {
			continue;
		}
		unset( $attributes[ $key ] );
		$attributes[ sprintf( 'attribute_%s', $key ) ] = $value;
	}
	if ( class_exists( 'WC_Data_Store' ) ) {
		$data_store = WC_Data_Store::load( 'product' );
		return $data_store->find_matching_product_variation( $product, $attributes );
	}
	return $product->get_matching_variation( $attributes );

}

add_filter(
	'woocommerce_get_price_html',
	function ( $price, $product ) {
		$price         = preg_replace( '/.00/', '', $price );
		$regular_price = $product->get_regular_price();

		ob_start();
		if ( 0.00 < $regular_price ) {
			$sale = $product->get_price() / $regular_price;
			if ( 1 > $sale ) {
				?>
				<span>
							<?php _e( 'From: ', 'comfy' ); ?>
						</span>
				<?php
			}
		}

		echo $price;

		if ( isset( $sale ) && 1 > $sale ) {
			$sale = round( ( 1 - $sale ) * 100 ) . '%';
			?>
			<span class="sale-persent">
				<?php echo __( 'Save ' ) . ' ' . $sale; ?>
			</span>
			<?php
		}

		return ob_get_clean();
	},
	0,
	2
);

// WordPress support
add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'woocommerce' );
	}
);


add_filter(
	'woocommerce_breadcrumb_defaults',
	function( $args ) {
		$args['delimiter']   = ' → ';
		$args['wrap_before'] = '<section class="section section-breadcrumbs"><div class="container">';
		$args['wrap_after']  = '</div></section>';
		return $args;
	}
);
add_filter(
	'woocommerce_get_breadcrumb',
	function ( $breadcrumb ) {
		if ( is_singular() ) {
			array_pop( $breadcrumb );
		}
		return $breadcrumb;
	}
);


// Add title field to comment form
add_filter(
	'comment_form_fields',
	function( $fields ) {
		ob_start();
		?>
		<p class="comment-form-phone">
			<label for="review-title"><?php _e( 'Review title', 'comfy' ); ?></label>
			<input id="review-title" name="review-title" type="text" size="30"  tabindex="4" />
		</p>
		<?php
		$fields['phone'] = ob_get_clean();
		return $fields;
	}
);
add_action(
	'comment_post',
	function( $comment_id ) {
		if ( ( isset( $_POST['review-title'] ) ) && ( ’ != $_POST['review-title'] ) ) {
			$review_title = wp_filter_nohtml_kses( $_POST['review-title'] );
			add_comment_meta( $comment_id, 'title', $review_title );
		}
	}
);

