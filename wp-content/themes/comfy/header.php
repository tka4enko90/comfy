<?php
/**
 * @package    WordPress
 * @subpackage comfy
 */
$header_options = array(
	'header_message'       => get_field( 'header_message', 'options' ),
	'nav_image_id'         => get_field( 'header_nav_image_id', 'options' ),
	'nav_text_under_image' => get_field( 'header_nav_text_under_image', 'options' ),
	'additional_link'      => get_field( 'header_additional_link', 'options' ),
	'account_link'         => get_permalink( wc_get_page_id( 'myaccount' ) ),
	'cart_count'           => WC()->cart->get_cart_contents_count(),
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
<!--    <link rel="apple-touch-icon" sizes="180x180" href="--><?php //echo get_template_directory_uri(); ?><!--/favicon/apple-touch-icon.png">-->
<!--    <link rel="icon" type="image/png" sizes="32x32" href="--><?php //echo get_template_directory_uri(); ?><!--/favicon/favicon-32x32.png">-->
<!--    <link rel="icon" type="image/png" sizes="16x16" href="--><?php //echo get_template_directory_uri(); ?><!--/favicon/favicon-16x16.png">-->
<!--    <link rel="manifest" href="/--><?php //echo get_template_directory_uri(); ?><!--/faviconsite.webmanifest">-->
<!--    <meta name="msapplication-TileColor" content="#da532c">-->
	 <meta name="theme-color" content="#ffffff">
	<!-- /FAVICON -->

	<?php wp_head(); ?>
</head>

<body <?php body_class( $body_class ); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
<?php if ( ! empty( $header_options['header_message'] ) ) { ?>
	<div class="info-message">
		<?php echo $header_options['header_message']; ?>
	</div>
<?php } ?>
	<div class="header-wrap">
		<div class="header-logo">
			<a href="<?php echo home_url(); ?>">
				<?php get_template_part( 'template-parts/inline-svg/site-logo' ); ?>
			</a>
		</div>
		<?php
		if ( has_nav_menu( 'header_menu' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'header_menu',
					'container'      => 'primary-header-nav',
					'walker'         => new Cmf_Nav_Walker(),
				)
			);
		}
		?>
		<div class="secondary-header-nav">
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
			<!-- Searchform Template Start -->
			<div class="search-wrap secondary-header-nav-el">
				<?php echo get_product_search_form(); ?>
				<i id="search-icon"></i>
			</div>
			<!-- END Searchform Template -->
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
	</div>
</header>
<main class="story">
