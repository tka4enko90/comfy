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

);
?>
</main>
<footer class="footer">
	<div class="container">
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
					<?php if ( ! empty( $footer_options['social_links']['instagram'] ) ) { ?>
					<a href="<?php echo $footer_options['social_links']['instagram']; ?>" target="_blank">
						<i class="icon icon-inst"></i>
					</a><?php } ?>
					<?php if ( ! empty( $footer_options['social_links']['facebook'] ) ) { ?>
					<a href="<?php echo $footer_options['social_links']['facebook']; ?>" target="_blank">
						<i class="icon icon-fb"></i>
					</a><?php } ?>
					<?php if ( ! empty( $footer_options['social_links']['tik_tok'] ) ) { ?>
					<a href="<?php echo $footer_options['social_links']['tik_tok']; ?>" target="_blank">
						<i class="icon icon-tik-tok"></i>
					</a><?php } ?>

				</div>
			</div>
			<ul class="footer-widgets">
				<?php dynamic_sidebar( 'footer_area' ); ?>
			</ul>
			<div class="footer-info">
				<a href="#" class="footer-logo"></a>
				<?php if ( ! empty( $footer_options['copyright'] ) ) { ?>
					<p class="footer-copyright"><?php echo $footer_options['copyright']; ?></p>
				<?php } ?>
				<div class="footer-partners-wrap">
					<div class="footer-partners">
						<?php
						foreach ( $footer_options['partners'] as $partner ) {
							?>
							<a href="<?php echo ( ! empty( $partner['partner_link'] ) ) ? $partner['partner_link'] : ''; ?>">
								<?php echo wp_get_attachment_image( $partner['partner_logo'] ); ?>
							</a>
							<?php
						}
						?>
					</div>
				</div>
				<div class="footer-links">
					<?php
					if ( ! empty( $footer_options['footer_links'] ) ) {
						foreach ( $footer_options['footer_links'] as $footer_link ) {
							?>
							<a href="<?php $footer_link['link']['url']; ?>" <?php echo isset( $footer_link['link']['target'] ) ? 'target="' . $footer_link['link']['target'] . '"' : ''; ?>>
								<?php echo $footer_link['link']['title']; ?>
							</a>
							<?php
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
