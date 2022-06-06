<?php /* Post preview */
wp_enqueue_style( 'post-preview', get_template_directory_uri() . '/dist/css/partials/post-preview.css', '', '', 'all' );
$btn_with_content = ! empty( $args['btn_with_content'] ) ? true : false;
$button_label     = ( ! empty( $args['button_label'] ) ) ? $args['button_label'] : __( 'Read more', 'comfy' );
$image_size       = ! empty( $args['image_size'] ) ? $args['image_size'] : 'cmf_post_preview';
$excerpt          = ! empty( $args['excerpt'] ) ? $args['excerpt'] : '';
?>
<article class="post">
	<?php
	if ( false === $btn_with_content ) {
		?>
	<div class="post-wrap">
		<?php
	}
	?>

		<div class="post-thumb">
			<?php the_post_thumbnail( $image_size ); ?>
		</div>
		<?php
		if ( isset( $args['content_wrap'] ) && true === $args['content_wrap'] ) {
			?>
		<div class="post-info">
			<?php
		}
		?>
			<?php get_template_part( 'template-parts/post', 'cats' ); ?>
			<h3 class="post-title"><?php the_title(); ?></h3>
			<?php
			if ( ! empty( $excerpt ) ) {
				?>
				<p>
					<?php echo $excerpt; ?>
				</p>
				<?php
			}
			if ( true === $btn_with_content ) {
				?>
				<a class="button button-secondary" href="<?php echo get_permalink(); ?>">
					<?php echo $button_label; ?>
				</a>
				<?php
			}
			?>
		<?php
		if ( isset( $args['content_wrap'] ) && true === $args['content_wrap'] ) {
			?>
		</div>
				<?php
		}
		if ( false === $btn_with_content ) {
			?>
	</div>
	<a class="button button-secondary" href="<?php echo get_permalink(); ?>">
			<?php echo $button_label; ?>
	</a>
				<?php
		}
		?>
	<?php edit_post_link(); ?>
</article>

