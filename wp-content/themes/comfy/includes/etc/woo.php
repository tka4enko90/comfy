<?php

// WordPress support
add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'woocommerce' );
	}
);

function cmf_star_rating( $args = array() ) {
    $defaults    = array(
        'rating' => 0,
        'type'   => 'rating',
        'number' => 0,
        'echo'   => true,
    );
    $parsed_args = wp_parse_args( $args, $defaults );

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

    $output  = '<div class="star-rating">';
    $output .= '<span class="screen-reader-text">' . $title . '</span>';
    $output .= str_repeat( '<div class="star star-full" aria-hidden="true"></div>', $full_stars );
    $output .= str_repeat( '<div class="star star-half" aria-hidden="true"></div>', $half_stars );
    $output .= str_repeat( '<div class="star star-empty" aria-hidden="true"></div>', $empty_stars );
    $output .= '</div>';

    if ( $parsed_args['echo'] ) {
        echo $output;
    }

    return $output;
}
