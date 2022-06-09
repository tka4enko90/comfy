<?php
/**
 * @package WordPress
 * @subpackage comfy
 */
$footer_options = array(
	'subscription_title'     => get_field( 'footer_subscription_title', 'options' ),
	'subscription_shortcode' => get_field( 'footer_subscription_shortcode', 'options' ),
	'social_links'           => get_field( 'social_links', 'options' ),
	'partners'               => get_field( 'partners', 'options' ),
	'footer_links'           => get_field( 'footer_links', 'options' ),
	'copyright'              => get_field( 'footer_copyright', 'options' ),
	'logo'                   => get_field( 'footer_logo_id', 'options' ),

);
?>
<footer class="footer">
	<div class="container container-lg">
		<div class="row justify-content-between">
			<div class="footer-social">
				<?php
				if ( ! empty( $footer_options['subscription_title'] ) ) {
					?>
					<h3 class="footer-social-title"><?php echo $footer_options['subscription_title']; ?></h3>
				<?php } ?>
				<div class="form-dark">
					<?php
					if ( ! empty( $footer_options['subscription_shortcode'] ) ) {
						echo do_shortcode( $footer_options['subscription_shortcode'] );
					}
					?>
				</div>
				<div class="footer-social-icons">
					<?php
					foreach ( $footer_options['social_links'] as $social_link ) {
						if ( ! empty( $social_link['image_id'] ) ) {
							?>
							<a href="<?php echo ( ! empty( $social_link['url'] ) ) ? $social_link['url'] : ''; ?>" target="_blank">
								<?php echo wp_get_attachment_image( $social_link['image_id'], 'cmf_social_icon' ); ?>
							</a>
							<?php
						}
					}
					?>
				</div>
			</div>
			<ul class="footer-widgets">
				<?php dynamic_sidebar( 'footer_area' ); ?>
			</ul>
			<div class="footer-info">
				<?php if ( ! empty( $footer_options['logo'] ) ) { ?>
					<a href="<?php echo home_url(); ?>" class="footer-logo">
						<?php echo wp_get_attachment_image( $footer_options['logo'], 'cmf_logo' ); ?>
					</a>
				<?php } ?>
				<?php if ( ! empty( $footer_options['copyright'] ) ) { ?>
					<p class="footer-copyright"><?php echo $footer_options['copyright']; ?></p>
				<?php } ?>
				<div class="footer-partners-wrap">
					<div class="footer-partners">
						<?php
						foreach ( $footer_options['partners'] as $partner ) {
							if ( ! empty( $partner['partner_logo'] ) ) {
								if ( ! empty( $partner['partner_link'] ) ) {
									?>
									<a href="<?php echo $partner['partner_link']; ?>" target="_blank">
										<?php echo wp_get_attachment_image( $partner['partner_logo'], 'cmf_footer_partner' ); ?>
									</a>
									<?php
								} else {
									?>
									<span>
										<?php echo wp_get_attachment_image( $partner['partner_logo'], 'cmf_footer_partner' ); ?>
									</span>
									<?php
								}
							}
						}
						?>
					</div>
				</div>
				<div class="footer-links">
					<?php
					if ( ! empty( $footer_options['footer_links'] ) ) {
						foreach ( $footer_options['footer_links'] as $footer_link ) {
							if ( isset( $footer_link['link']['url'] ) && isset( $footer_link['link']['title'] ) ) {
								?>
								<a href="<?php $footer_link['link']['url']; ?>" <?php echo isset( $footer_link['link']['target'] ) ? 'target="' . $footer_link['link']['target'] . '"' : ''; ?>>
									<?php echo $footer_link['link']['title']; ?>
								</a>
								<?php
							}
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>

</footer>
<?php wp_footer(); ?>
</body>
</html>
