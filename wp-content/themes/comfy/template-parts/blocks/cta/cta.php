<?php
$section = array(
	'title'   => get_sub_field( 'title' ),
	'content' => get_sub_field( 'content' ),
	'link'    => get_sub_field( 'link' ),

);
?>
<div class="container container-small">
	<div class="row justify-content-between">
		<div class="col left-col">
			<?php
			if ( ! empty( $section['title'] ) ) {
				?>
				<h1 class="section-title">
					<?php echo $section['title']; ?>
				</h1>
				<?php
			}
			?>
		</div>
		<div class="col right-col">
			<div class="section-content">
				<?php
				echo ( ! empty( $section['content'] ) ) ? $section['content'] : '';
				if ( isset( $section['link'] ) ) {
					if ( isset( $section['link']['url'] ) && isset( $section['link']['title'] ) ) {
						?>
						<a class="button button-secondary" href="<?php echo $section['link']['url']; ?>" <?php echo ! empty( $section['link']['target'] ) ? 'target="' . $header_options['link']['target'] . '"' : ''; ?>>
							<?php echo $section['link']['title']; ?>
						</a>
						<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
