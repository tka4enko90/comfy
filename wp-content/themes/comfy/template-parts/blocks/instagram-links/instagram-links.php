<?php
wp_enqueue_style( 'instagram-links' . '-section', get_template_directory_uri() . '/template-parts/blocks/' . 'instagram-links' . '/' . 'instagram-links' . '.css', '', '', 'all' );
$section = array(
	'title'            => get_sub_field( 'title' ),
	'account'          => get_sub_field( 'account' ),
	'items'            => get_sub_field( 'items' ),
	'links_in_new_tab' => get_sub_field( 'in_new_tab' ),
);

?>
	<div class="container">
		<div class="row">
			<div class="col-100">
				<?php
				if ( ! empty( $section['account'] ) ) {
					?>
					<div class="instagram-links-section-account">
						<?php
						if ( ! empty( $section['account']['url'] ) ) {
							?>
						<a href="<?php echo $section['account']['url']; ?>" class="instagram-links-section-account-link" <?php echo ( isset( $section['links_in_new_tab'] ) && true === $section['links_in_new_tab'] ) ? 'target="_blank"' : ''; ?>>
							<?php
						}
						?>
						<?php
						if ( ! empty( $section['account']['icon'] ) ) {
							echo wp_get_attachment_image( $section['account']['icon'], array( 22, 22 ) );
						}
						if ( ! empty( $section['account']['label'] ) ) {
							?>
							<h6 class="instagram-links-section-account-heading">
								<?php echo $section['account']['label']; ?>
							</h6>
							<?php
						}

						if ( ! empty( $section['account']['url'] ) ) {
							?>
							</a>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
				<?php
				if ( ! empty( $section['title'] ) ) {
					?>
					<h3 class="instagram-links-section-title">
						<?php echo $section['title']; ?>
					</h3>
					<?php
				}
				?>
			</div>
			<div class="col-100 instagram-links-cols">
				<?php
				if ( is_array( $section['items'] ) && 0 < count( $section['items'] ) ) {
					foreach ( $section['items'] as $item ) {
						?>
						<div class="instagram-links-col <?php echo ( true === $item['mobile_only'] ) ? 'mobile-only' : ''; ?>">
							<?php
							if ( ! empty( $item['url'] ) ) {
								?>
							<a href="<?php echo $item['url']; ?>" class="instagram-links-link" <?php echo ( isset( $item['in_new_tab'] ) && true === $item['in_new_tab'] ) ? 'target="_blank"' : ''; ?>>
								<?php
							}
								echo ( ! empty( $item['image_id'] ) ) ? wp_get_attachment_image( $item['image_id'], 'cmf_product_preview' ) : '';
							if ( ! empty( $item['label'] ) ) {
								?>
									<span class="instagram-links-label">
										<?php echo $item['label']; ?>
									</span>
									<?php
							}
							if ( ! empty( $item['url'] ) ) {
								?>
							</a>
								<?php
							}
							?>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
	</div>

