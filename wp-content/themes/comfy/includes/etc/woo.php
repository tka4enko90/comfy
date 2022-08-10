<?php

function cmf_remove_zeros( $price ) {
	return str_replace( '.00', '', strval( $price ) );
}

function cmf_get_bundle_discount( $product ) {
	$bundled_data_items  = $product->get_bundled_data_items();
	$bundled_items_price = 0;
	foreach ( $bundled_data_items as $bundled_item ) {
		$item_data            = $bundled_item->get_data();
		$_product             = wc_get_product( $item_data['product_id'] );
		$bundled_items_price += $_product->get_price();
	}
	return round( 100 - ( $product->get_bundle_price() / ( $bundled_items_price / 100 ) ) );

}

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
		<span class="credit-text"><?php echo __( 'or 4 interest-free-payments of' ) . ' ' . wc_price( $price / 4 ) . ' ' . __( 'with', 'comfy' ) . ' '; ?></span>
			<svg width="57" height="28" viewBox="0 0 300 151" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M187.063 3.33436C152.266 -3.12452 116.316 3.93284 86.5438 23.0673C56.8604 42.1446 35.5466 71.7943 26.9177 106H41.3042C49.5913 76.6532 68.3323 51.2948 94.0589 34.7606C120.854 17.5396 153.209 11.1879 184.526 17.0009L187.063 3.33436Z" fill="#283455"/>
				<path d="M63.7186 106H51.4276C57.7484 85.1872 69.7509 66.5352 86.1012 52.1523C102.921 37.3563 123.635 27.7 145.782 24.3308C167.929 20.9616 190.577 24.0212 211.036 33.146C231.495 42.2709 248.904 57.0773 261.195 75.8059L251.414 82.2253C240.352 65.3696 224.683 52.0438 206.27 43.8314C187.857 35.6191 167.474 32.8655 147.542 35.8977C127.609 38.93 108.967 47.6206 93.8289 60.937C80.0097 73.0934 69.6416 88.6382 63.7186 106Z" fill="#283455"/>
				<path d="M17.0466 106H3C5.90708 84.9319 13.6102 64.81 25.5182 47.1846C37.4962 29.4555 53.4054 14.7309 72.0065 4.15774L78.8754 16.242C62.1344 25.7578 47.8161 39.01 37.0359 54.9661C26.6772 70.2984 19.854 87.7296 17.0466 106Z" fill="#283455"/>
				<path d="M15.006 116C18.1033 116 20.71 117.043 22.826 119.128C24.942 121.213 26 123.774 26 126.81C26 129.846 24.942 132.407 22.826 134.492C20.71 136.577 18.1033 137.62 15.006 137.62H9.348V148.2H3V116H15.006ZM15.006 131.686C16.3553 131.686 17.4747 131.226 18.364 130.306C19.2533 129.355 19.698 128.19 19.698 126.81C19.698 125.399 19.2533 124.234 18.364 123.314C17.4747 122.394 16.3553 121.934 15.006 121.934H9.348V131.686H15.006Z" fill="#283455"/>
				<path d="M47.5535 148.2L45.6215 142.404H32.7875L30.8555 148.2H24.0015L35.2715 116H43.1375L54.4535 148.2H47.5535ZM34.8115 136.47H43.6435L39.2275 123.314L34.8115 136.47Z" fill="#283455"/>
				<path d="M78.8863 116L67.8463 135.642V148.2H61.5443V135.642L50.5503 116H57.7263L64.7183 129.432L71.7104 116H78.8863Z" fill="#283455"/>
				<path d="M90.6847 149.304C88.4461 149.304 86.4374 148.844 84.6587 147.924C82.9107 146.973 81.6534 145.593 80.8867 143.784L83.6007 142.174C84.6127 144.842 86.9741 146.176 90.6847 146.176C92.9234 146.176 94.7021 145.639 96.0207 144.566C97.3701 143.493 98.0447 141.852 98.0447 139.644V116.552H101.265V139.644C101.265 142.772 100.253 145.164 98.2287 146.82C96.2354 148.476 93.7207 149.304 90.6847 149.304Z" fill="#283455"/>
				<path d="M128.3 146.176C126.092 148.261 123.21 149.304 119.653 149.304C116.095 149.304 113.212 148.261 111.004 146.176C108.796 144.091 107.692 141.3 107.692 137.804V116.552H110.913V137.804C110.913 140.38 111.679 142.419 113.213 143.922C114.746 145.425 116.892 146.176 119.653 146.176C122.413 146.176 124.559 145.425 126.093 143.922C127.626 142.419 128.393 140.38 128.393 137.804V116.552H131.613V137.804C131.613 141.3 130.508 144.091 128.3 146.176Z" fill="#283455"/>
				<path d="M148.64 149.304C145.696 149.304 143.166 148.614 141.05 147.234C138.964 145.823 137.508 143.891 136.68 141.438L139.44 139.828C140.022 141.821 141.096 143.385 142.66 144.52C144.224 145.624 146.232 146.176 148.686 146.176C151.078 146.176 152.933 145.655 154.252 144.612C155.601 143.539 156.276 142.128 156.276 140.38C156.276 138.693 155.662 137.421 154.436 136.562C153.209 135.703 151.185 134.814 148.364 133.894C145.021 132.79 142.813 131.901 141.74 131.226C139.286 129.754 138.06 127.623 138.06 124.832C138.06 122.103 139.01 119.956 140.912 118.392C142.813 116.797 145.159 116 147.95 116C150.464 116 152.642 116.659 154.482 117.978C156.322 119.266 157.686 120.922 158.576 122.946L155.862 124.464C154.39 120.907 151.752 119.128 147.95 119.128C145.956 119.128 144.346 119.619 143.12 120.6C141.893 121.581 141.28 122.946 141.28 124.694C141.28 126.289 141.832 127.485 142.936 128.282C144.04 129.079 145.864 129.892 148.41 130.72C149.575 131.119 150.403 131.41 150.894 131.594C151.415 131.747 152.151 132.023 153.102 132.422C154.083 132.79 154.804 133.127 155.264 133.434C155.724 133.71 156.276 134.109 156.92 134.63C157.594 135.121 158.07 135.627 158.346 136.148C158.652 136.639 158.913 137.252 159.128 137.988C159.373 138.693 159.496 139.46 159.496 140.288C159.496 143.017 158.499 145.21 156.506 146.866C154.512 148.491 151.89 149.304 148.64 149.304Z" fill="#283455"/>
				<path d="M184.096 116.552V119.588H174.206V148.752H170.986V119.588H161.096V116.552H184.096Z" fill="#283455"/>
				<path d="M206.726 116.644H213.074V148.844H208.244L194.444 129.156V148.844H188.096V116.644H192.926L206.726 136.286V116.644Z" fill="#283455"/>
				<path d="M246.141 144.658C242.89 147.878 238.934 149.488 234.273 149.488C229.612 149.488 225.656 147.878 222.405 144.658C219.185 141.407 217.575 137.436 217.575 132.744C217.575 128.052 219.185 124.096 222.405 120.876C225.656 117.625 229.612 116 234.273 116C238.934 116 242.89 117.625 246.141 120.876C249.392 124.096 251.017 128.052 251.017 132.744C251.017 137.436 249.392 141.407 246.141 144.658ZM226.867 140.334C228.86 142.297 231.329 143.278 234.273 143.278C237.217 143.278 239.686 142.297 241.679 140.334C243.672 138.341 244.669 135.811 244.669 132.744C244.669 129.677 243.672 127.147 241.679 125.154C239.686 123.161 237.217 122.164 234.273 122.164C231.329 122.164 228.86 123.161 226.867 125.154C224.874 127.147 223.877 129.677 223.877 132.744C223.877 135.811 224.874 138.341 226.867 140.334Z" fill="#283455"/>
				<path d="M260.757 148.844L251.741 116.644H258.411L264.575 140.518L271.291 116.644H276.719L283.481 140.518L289.645 116.644H296.315L287.299 148.844H280.077L274.005 127.592L267.979 148.844H260.757Z" fill="#283455"/>
			</svg>
	</span>
	<?php
}

function cmf_get_the_product_tags() {
	global $product;
	$terms = wp_get_post_terms( $product->get_id(), 'product_tag' );

	ob_start();
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		?>
		<div class="product-tags">
			<?php
			foreach ( $terms as $term ) {
				?>
				<span class="product-tag">
					<?php echo $term->name; ?>
				</span>
				<?php
			}
			?>
		</div>
		<?php
	}
	return ob_get_clean();
}

add_filter(
	'wc_price',
	function ( $html ) {
		return cmf_remove_zeros( $html );
	},
	1
);

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
				<span class="from-label">
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

		$bundle_discount = cmf_get_bundle_discount( $product );
		$min_price       = $product->get_min_raw_price();
		?>
		<span class="from-label">
			<?php echo __( 'From', 'comfy' ) . ' '; ?>
		</span>
		<?php
		echo wc_price( $min_price );
		if ( 0 < $bundle_discount ) {
			?>
			<span class="sale-persent"><?php echo __( 'Saves you ' ) . $bundle_discount . '%'; ?></span>
			<?php
		}
		?>
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
