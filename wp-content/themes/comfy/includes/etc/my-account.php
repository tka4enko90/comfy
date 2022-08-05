<?php
// My Account Navigation
add_filter(
	'woocommerce_account_menu_items',
	function( $menu_links ) {
		// Remove Links from My Account
		unset( $menu_links['dashboard'], $menu_links['downloads'], $menu_links['edit-account'] );

		$menu_links['orders'] = __( 'Orders & returns', 'comfy' );

		// Add Link to My Account Page -> General Preferences in My Account Menu
		$menu_links = array_slice( $menu_links, 0, 1, true )
			+ array( 'account-details' => __( 'Account Details', 'comfy' ) )
			+ array_slice( $menu_links, 1, null, true );

		return $menu_links;
	},
	40
);

//  Register Permalink Endpoint for Account Details
add_action(
	'init',
	function () {
		add_rewrite_endpoint( 'account-details', EP_PAGES );
	}
);

// Content for the General Preferences in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
add_action(
	'woocommerce_account_account-details_endpoint',
	function () {
		$current_user_id = get_current_user_id();
		$customer        = new WC_Customer( $current_user_id );
		$address_1       = $customer->get_billing_address_1();
		$address_2       = $customer->get_billing_address_2();
		?>
		<h5><?php _e( 'Account Details', 'comfy' ); ?></h5>
		<div class="account-details">
			<p class="account-details-label"><?php _e( 'Full name', 'comfy' ); ?></p>
			<p class="account-details-val"><?php echo $customer->get_first_name() . ' ' . $customer->get_last_name(); ?></p>

			<p class="account-details-label"><?php _e( 'Email', 'comfy' ); ?></p>
			<p class="account-details-val"><?php echo $customer->get_email(); ?></p>

			<p class="account-details-label"><?php _e( 'Address', 'comfy' ); ?></p>
			<p class="account-details-val">
				<?php
				echo $address_1;
				echo ( ! empty( $address_2 ) ) ? '<br>' . $address_2 : '';
				?>
			</p>
			<a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ) . 'edit-account/'; ?>" class="button button-secondary">
				<?php _e( 'Edit', 'comfy' ); ?>
			</a>

		</div>
		<?php
	}
);

//Display account details as active on edit account
add_filter(
	'woocommerce_account_menu_item_classes',
	function ( $classes, $endpoint ) {
		if ( 'account-details' === $endpoint ) {
			global $wp;
			if ( 'my-account/edit-account' === $wp->request ) {
				$classes[] = 'is-active';
			}
		}
		return $classes;
	},
	2,
	5
);

add_action(
	'woocommerce_after_edit_account_form',
	function () {
		wc_get_template( 'myaccount/my-address.php' );
	}
);

// Redirect from my account dashboard to orders
add_action(
	'parse_request',
	function ( $wp ) {
		// All other endpoints such as change-password will redirect to
		$allowed_endpoints = array( 'orders', 'edit-account', 'customer-logout', 'account-details' );

		if ( is_user_logged_in() &&
			preg_match( '%^my\-account(?:/([^/]+)|)/?$%', $wp->request, $m ) &&
			( empty( $m[1] ) || ! in_array( $m[1], $allowed_endpoints ) )
		) {

			//redirect from /edit-address/ to /edit-account/
			if ( 'my-account/edit-address' === $wp->request ) {
				wp_safe_redirect( '/my-account/edit-account/' );
				exit;
			}

			wp_safe_redirect( '/my-account/orders/' );
			exit;
		}
	}
);
