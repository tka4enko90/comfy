<?php
/**
 * @package WordPress
 * @subpackage comfy
 */
wp_enqueue_style( 'post-archive', get_template_directory_uri() . '/dist/css/pages/post-archive.css', '', '', 'all' );
$page_title = __( 'Blog', 'comfy' );

$post_button_label = __( 'Read more', 'comfy' );
$post_counter      = 0;

get_header();
?>
<main class="main first-section-margin-64px">
	<section class="section">
		<div class="container container-sm">
			<h1 class="page-title"><?php echo $page_title; ?></h1>
		</div>
	</section>
	<?php
	$i = 0;
	if ( have_posts() ) :
		?>
	<section class="section archive-section">
		<div class="container container-sm">
			<div class="row">
			<?php
			while ( have_posts() ) :
				the_post();

				$post_subtitle = get_field( 'post_subtitle' );
				$excerpt       = ! empty( $post_subtitle ) ? $post_subtitle : get_the_excerpt();
				?>
				<?php
				$i++;
				$args = array();
				if ( 1 === $i ) {
					$args['image_size']       = 'cmf_review_slider';
					$args['class']            = 'post-first';
					$args['content_wrap']     = true;
					$args['btn_with_content'] = true;
					$args['excerpt']          = $excerpt;
				}
				if ( 2 === $i ) {
					?>
					<h3 class="archive-section-title"><?php echo __( 'Latest on our blog', 'comfy' ); ?></h3>
					<?php
				}

				if ( 6 === $i ) {
					$args['image_size'] = 'cmf_post_big';
					$args['class']      = 'post-big';
					$args['excerpt']    = $excerpt;
				}
				/*
				switch ( $i++ ) {
					case 0:
						$args = array(
							'image_size'       => 'cmf_review_slider',
							'class'            => 'post-first',
							'content_wrap'     => true,
							'btn_with_content' => true,
							'excerpt'          => $excerpt,

						);
						break;
					case 1:
						?>
						<h3 class="archive-section-title"><?php echo __( 'Latest on our blog', 'comfy' ); ?></h3>
						<?php
						break;
					case 5:
						$args = array(
							'image_size' => 'cmf_post_big',
							'class'      => 'post-big',
							'excerpt'    => $excerpt,
						);
						break;

				}
				*/
				?>
				<div class="post-col <?php echo ! empty( $args['class'] ) ? $args['class'] : ''; ?>">
					<?php get_template_part( 'template-parts/post', 'preview', $args ); ?>
				</div>
				<?php
			endwhile;
			?>
			</div>
			<?php get_template_part( 'template-parts/pagination' ); ?>
		</div>
	</section>
		<?php
	else :
		?>
		<p><?php _e( 'No posts found.', 'comfy' ); ?></p>

	<?php endif; ?>
</main>
<?php
get_footer();
