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

function cmf_the_credit_text( $price ) {
	if ( ! is_numeric( $price ) ) {
		return;
	}
	?>
	<span class="credit">
		<?php echo __( 'or 4 interest-free-payments of' ) . ' ' . wc_price( $price / 4 ) . ' ' . __( 'with', 'comfy' ) . ' '; ?>
		<svg width="57" height="28" viewBox="0 0 57 28" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
			<rect width="57" height="28" fill="url(#pattern0)"></rect>
			<defs>
				<pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
					<use xlink:href="#image0_1657_65369" transform="translate(0 -0.0123214) scale(0.00333333 0.00678571)"></use>
				</pattern>
				<image id="image0_1657_65369" width="300" height="151" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACXCAYAAACvB2Z3AAAACXBIWXMAABcSAAAXEgFnn9JSAAAE9GlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNy4xLWMwMDAgNzkuZWRhMmIzZmFjLCAyMDIxLzExLzE3LTE3OjIzOjE5ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgMjMuMSAoTWFjaW50b3NoKSIgeG1wOkNyZWF0ZURhdGU9IjIwMjItMDEtMjRUMTI6MzE6NTUrMDE6MDAiIHhtcDpNb2RpZnlEYXRlPSIyMDIyLTAxLTI0VDEyOjM0OjEzKzAxOjAwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDIyLTAxLTI0VDEyOjM0OjEzKzAxOjAwIiBkYzpmb3JtYXQ9ImltYWdlL3BuZyIgcGhvdG9zaG9wOkNvbG9yTW9kZT0iMyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoxNjhjNjA3NS1kZGJhLTQ2N2YtODhmZi1mYWY4M2E0NTlhZWEiIHhtcE1NOkRvY3VtZW50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"></image>
			</defs>
		</svg>
	</span>
	<?php
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
				<?php echo __( 'Saves you' ) . ' ' . $sale; ?>
			</span>
			<?php

		}

		if ( ! $product->is_type( 'variable' ) ) {
			cmf_the_credit_text( $product->get_price() );
		}

		return ob_get_clean();
	},
	0,
	2
);

//Default variation price
add_filter(
	'woocommerce_get_price_html',
	function ( $price, $product ) {

		if ( ! $product->is_type( 'variable' ) ) {
			return $price;
		}

		//Get price of default product variation
		$default_attributes = $product->get_default_attributes();
		$variation_id       = cmf_find_matching_product_variation( $product, $default_attributes );
		$product            = wc_get_product( $variation_id );

		return $product->get_price_html();
	},
	1,
	2
);

// Product bundle price filter
add_filter(
	'woocommerce_get_price_html',
	function ( $price, $product ) {
		if ( ! $product->is_type( 'bundle' ) ) {
			return $price;
		}

		ob_start();
		$min_price = $product->get_min_raw_price();
		?>
		<span>
			<?php echo __( 'From', 'comfy' ) . ' ' . wc_price( $min_price ); ?>
		</span>
		<span class="sale-persent"><?php echo __( 'Saves you NaN%' ); ?></span>
		<?php
		cmf_the_credit_text( $min_price );

		return ob_get_clean();
	},
	1,
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
