<?php
// My Account Navigation
add_filter(
	'woocommerce_account_menu_items',
	function( $menu_links ) {
		// Remove Links from My Account
		unset( $menu_links['dashboard'], $menu_links['downloads'] );
		return $menu_links;
	},
	40
);

// Redirect from my account dashboard to orders
add_action(
	'parse_request',
	function ( $wp ) {
		// All other endpoints such as change-password will redirect to
		// my-account/orders
		$allowed_endpoints = array( 'orders', 'edit-account', 'customer-logout', 'edit-general-preferences' );

		if ( is_user_logged_in() &&
			preg_match( '%^my\-account(?:/([^/]+)|)/?$%', $wp->request, $m ) &&
			( empty( $m[1] ) || ! in_array( $m[1], $allowed_endpoints ) )
		) {
			if ( 'my-account/edit-address' === $wp->request ) {
				wp_safe_redirect( '/my-account/edit-account/' );
				exit;
			}

			wp_safe_redirect( '/my-account/orders/' );
			exit;
		}
	}
);
