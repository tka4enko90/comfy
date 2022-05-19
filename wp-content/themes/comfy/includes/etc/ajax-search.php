<?php
/**
 * Live autocomplete search feature.
 *
 * @since 1.0.0
 */
function cmf_ajax_search() {
	if ( empty( $_POST['search'] ) ) {
		wp_send_json_error( __( 'Nothing to search', 'comfy' ), 400 );
	}
	$results = new WP_Query(
		array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'nopaging'       => true,
			'posts_per_page' => 10,
			's'              => stripslashes( sanitize_text_field( $_POST['search'] ) ),
		)
	);

	$items = array();

	if ( ! empty( $results->posts ) ) {
		foreach ( $results->posts as $result ) {
			$items['products'][] = array(
				'title' => $result->post_title,
				'url'   => get_permalink( $result->ID ),
				'thumb' => get_the_post_thumbnail_url( $result->ID, 'cmf_search_result' ),
			);
		}
	}

	//Search Product Categories

	wp_send_json_success( $items );
}

add_action( 'wp_ajax_search_site', 'cmf_ajax_search' );
add_action( 'wp_ajax_nopriv_search_site', 'cmf_ajax_search' );
