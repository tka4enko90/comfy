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
			<?php
			if ( function_exists( 'AW_Referrals' ) ) {
				/*
				 * AutomateWoo -> Settings -> Refer a Friend -> Share Page
				 * */
				$ref_url = AW_Referrals()->get_share_page_url();
				if ( ! empty( $ref_url ) ) {
					/*
					 * Options -> My Account -> Refer a Friend (Group)
					 * */
					$refer_sidebar_el = get_field( 'refer_a_friend', 'options' );
					if ( isset( $refer_sidebar_el['enable'] ) && true === $refer_sidebar_el['enable'] ) {
						?>
						<?php
						if ( ! empty( $refer_sidebar_el['title'] ) ) {
							?>
							<h6 class="woocommerce-MyAccount-sidebar-title">
								<?php $refer_sidebar_el['title']; ?>
							</h6>
							<?php
						}
						if ( ! empty( $refer_sidebar_el['description'] ) ) {
							?>
							<p>
								<?php echo $refer_sidebar_el['description']; ?>
							</p>
							<?php
						}
						if ( ! empty( $refer_sidebar_el['button_label'] ) ) {
							?>
							<a href="<?php echo $ref_url; ?>" class="button button-secondary">
								<?php echo $refer_sidebar_el['button_label']; ?>
							</a>
							<?php
						}
					}
				}
			}
			?>
		</aside>
	</div>

</div>
