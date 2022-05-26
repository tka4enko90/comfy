<?php
/**
 * Header ajax search
 *
 * @since 1.0.0
 */
function cmf_ajax_search() {
	$search_request = $_POST['search'];
	$products       = array();
	if ( ! empty( $search_request ) ) {
		$results = new WP_Query(
			array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => 10,
				's'              => stripslashes( sanitize_text_field( $search_request ) ),
			)
		);

		if ( ! empty( $results->posts ) ) {
			$products = $results->posts;
		}
	}

	//Search Product Categories
	ob_start();
	get_template_part( 'template-parts/search-results', '', $products );

	$response['layout'] = ob_get_clean();
	wp_reset_query();
	wp_send_json_success( $response );
}

add_action( 'wp_ajax_search_site', 'cmf_ajax_search' );
add_action( 'wp_ajax_nopriv_search_site', 'cmf_ajax_search' );
