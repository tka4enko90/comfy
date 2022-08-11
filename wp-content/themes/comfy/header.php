<?php
/**
 * @package    WordPress
 * @subpackage comfy
 */
$header_options = array(
	'header_message'            => get_field( 'header_message', 'options' ),
	'header_message_background' => get_field( 'header_message_background', 'options' ),
	'nav_image_id'              => get_field( 'header_nav_image_id', 'options' ),
	'nav_text_under_image'      => get_field( 'header_nav_text_under_image', 'options' ),
	'additional_link'           => get_field( 'header_additional_link', 'options' ),
	'account_link'              => get_permalink( wc_get_page_id( 'myaccount' ) ),
	'cart_count'                => WC()->cart->get_cart_contents_count(),
);
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta http-equiv="x-ua-compatible" content="ie=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
	<meta content="telephone=no" name="format-detection"/>
	<meta name="HandheldFriendly" content="true"/>
	<title><?php bloginfo( 'name' ); ?> <?php wp_title( '', true ); ?></title>

	<!-- FAVICON -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/favicon/favicon.png">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	<!-- /FAVICON -->

	<?php wp_head(); ?>
</head>
<?php $body_class = ( ! empty( $header_options['header_message'] ) ) ? 'header-info-message' : ''; ?>
<body <?php body_class( $body_class ); ?>>

<?php wp_body_open(); ?>
<header class="site-header">
<?php if ( ! empty( $header_options['header_message'] ) ) { ?>
	<div class="info-message" <?php echo ( ! empty( $header_options['header_message_background'] ) && '#283455' !== $header_options['header_message_background'] ) ? 'style="background-color:' . $header_options['header_message_background'] . '"' : ''; ?>>
		<?php echo $header_options['header_message']; ?>
	</div>
<?php } ?>
	<div class="header-wrap">
		<div class="nav-toggle"></div>
		<div class="header-logo">
			<a href="<?php echo home_url(); ?>">
				<?php get_template_part( 'template-parts/inline-svg/site-logo' ); ?>
			</a>
		</div>
		<div class="relative d-flex justify-content-between flex-grow-2">
			<div id="primary-header-nav-container">
				<?php
				if ( has_nav_menu( 'header_menu' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'header_menu',
							'walker'         => new Cmf_Nav_Walker(),
						)
					);
				}
				?>
				<div class="mobile-links mobile-only">
					<?php
					if ( isset( $header_options['additional_link'] ) ) {
						if ( isset( $header_options['additional_link']['url'] ) && isset( $header_options['additional_link']['title'] ) ) {
							?>
							<a href="<?php echo $header_options['additional_link']['url']; ?>" <?php echo ! empty( $header_options['additional_link']['target'] ) ? 'target="' . $header_options['link']['target'] . '"' : ''; ?>>
								<?php echo $header_options['additional_link']['title']; ?>
							</a>
							<?php
						}
					}
					?>
					<a href="<?php echo $header_options['account_link']; ?>" class="account-link" title="<?php _e( 'Account Link', 'comfy' ); ?>">
						<?php
						if ( is_user_logged_in() ) {
							_e( 'My Account', 'comfy' );
						} else {
							_e( 'Login', 'comfy' );
						}
						?>
					</a>
				</div>
			</div>
		</div>

		<div class="secondary-header-nav">
			<?php
			if ( isset( $header_options['additional_link'] ) ) {
				if ( isset( $header_options['additional_link']['url'] ) && isset( $header_options['additional_link']['title'] ) ) {
					?>
					<a class="mobile-none" href="<?php echo $header_options['additional_link']['url']; ?>" <?php echo ! empty( $header_options['additional_link']['target'] ) ? 'target="' . $header_options['additional_link']['target'] . '"' : ''; ?>>
						<?php echo $header_options['additional_link']['title']; ?>
					</a>
					<?php
				}
			}
			?>
			<div class="search-wrap secondary-header-nav-el">
				<?php get_template_part( 'template-parts/inline-svg/icon', 'search' ); ?>
			</div>
			<a href="<?php echo $header_options['account_link']; ?>" class="account-link secondary-header-nav-el" title="<?php _e( 'Account Link', 'comfy' ); ?>">
				<?php get_template_part( 'template-parts/inline-svg/icon', 'account' ); ?>
			</a>
			<a href="<?php echo wc_get_cart_url(); ?>" class="cart-link secondary-header-nav-el" title="<?php _e( 'Cart Link', 'comfy' ); ?>">
				<?php get_template_part( 'template-parts/inline-svg/icon', 'cart' ); ?>
				<?php
				if ( ! empty( $header_options['cart_count'] ) ) {
					?>
					<span class="cart-link-amount">
						<?php esc_html_e( $header_options['cart_count'] ); ?>
					</span>
				<?php } ?>
			</a>
		</div>
		<div class="header-container">
			<div class="header-search">
				<div class="header-search-icon">
					<?php get_template_part( 'template-parts/inline-svg/icon', 'search' ); ?>
				</div>
				<?php echo get_search_form(); ?>
				<div id="search-results"></div>
				<div class="search-close-icon"></div>
			</div>
		</div>
	</div>

</header>
