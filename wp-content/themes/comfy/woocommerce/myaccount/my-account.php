<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="woocommerce-MyAccount-page">
	<h1 class="woocommerce-MyAccount-page-title" ><?php _e( 'My Account', 'comfy' ); ?></h1>
	<?php
	/**
	 * My Account navigation.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_navigation' );
	?>

	<div class="woocommerce-MyAccount-content-wrap">
		<div class="woocommerce-MyAccount-content">
			<?php
			/**
			 * My Account content.
			 *
			 * @since 2.6.0
			 */
			do_action( 'woocommerce_account_content' );
			?>
		</div>
		<aside class="woocommerce-MyAccount-sidebar">
			<h6 class="woocommerce-MyAccount-sidebar-title">
				<?php _e( 'Have a return or exchange?', 'comfy' ); ?>
			</h6>
			<a href="" class="button button-secondary">
				<?php _e( 'start a return', 'comfy' ); ?>
			</a>
		</aside>
	</div>

</div>
