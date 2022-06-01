<?php /* Post preview */
wp_enqueue_style( 'post-preview', get_template_directory_uri() . '/dist/css/partials/post-preview.css', '', '', 'all' );
$button_label = ( ! empty( $args['button_label'] ) ) ? $args['button_label'] : __( 'Read more', 'comfy' );
$image_size = !empty($args['image_size']) ?? 'cmf_post_preview';
?>
<article class="post">
	<div class="post-wrap">
		<div class="post-thumb">
			<?php the_post_thumbnail( $image_size ); ?>
		</div>
		<?php get_template_part( 'template-parts/post', 'cats' ); ?>
		<h3 class="post-title"><?php the_title(); ?></h3>
        <a class="button button-secondary" href="<?php get_permalink(); ?>">
            <?php echo $button_label; ?>
        </a>
	</div>

	<?php // the_content(); ?>
	<?php //wp_link_pages(); ?>
	<?php edit_post_link(); ?>
</article>

