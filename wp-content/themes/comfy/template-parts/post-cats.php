<?php /* Post Cats */
wp_enqueue_style( 'post-cats', get_template_directory_uri() . '/dist/css/partials/post-cats.css', '', '', 'all' );
?>
<div class="post-cats">
	<?php
	$cats = get_the_category();
	foreach ( $cats as $cat ) {
		?>
		<h6 class="post-cat">
			<a href="<?php echo get_category_link( $cat->term_id ); ?>">
				<?php echo $cat->name; ?>
			</a>
		</h6>
		<?php
	}
	?>
</div>
