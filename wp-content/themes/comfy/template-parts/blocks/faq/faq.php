<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
	wp_enqueue_script( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.js', array( 'jquery' ), '', true );

}
$section = array(
	'chapters' => get_sub_field( 'chapters' ),
);
?>
<div class="container container-xs">
	<?php
	if ( ! empty( $section['chapters'] ) ) {
		foreach ( $section['chapters'] as $chapter ) {
			if ( ! empty( $chapter['title'] ) ) {
				?>
				<h3 class="faq-chapter-title"><?php echo $chapter['title']; ?></h3>
				<?php
			}
			if ( ! empty( $chapter['items'] ) ) {
				foreach ( $chapter['items'] as $item ) {
					?>
					<div class="faq-item">
						<?php
						if ( ! empty( $item['title'] ) ) {
							?>
							<h5 class="faq-item-title"><?php echo $item['title']; ?></h5>
							<?php
						}
						if ( ! empty( $item['content'] ) ) {
							?>
							<div class="faq-item-content">
								<?php echo $item['content']; ?>
							</div>
							<?php
						}
						?>
					</div>
					<?php
				}
			}
		}
	}
	?>
</div>
