<?php
/**
 * @package WordPress
 * @subpackage comfy
 */
get_header();
?>


    <?php while (have_posts()) :
		the_post(); ?>
		<div class="section-post">
			<div class="container">
				<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<div class="breadcrumbs">','</div>' );
					}
				?>
				<div class="section-inner">
					<?php get_template_part('template-parts/single/content', get_post_type()); ?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
<?php
get_footer();
