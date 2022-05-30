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
<main class="main first-section-margin-52px">
	<section class="section">
		<div class="container container-small">
			<div class="row">
				<div class="col-100">
					<h1 class="page-title"><?php echo $page_title; ?></h1>
				</div>
			</div>
		</div>
	</section>
	<?php
	if ( have_posts() ) :
		?>
	<section class="section archive-section">
		<?php
		while ( have_posts() ) :
			the_post();
			$post_subtitle = get_field( 'post_subtitle' );
			$excerpt       = ! empty( $post_subtitle ) ? $post_subtitle : get_the_excerpt();
			?>
			<?php
			switch ( $post_counter++ ) {
				case 0:
					$settings = array(
						'image_position' => 'left',
						'content_width'  => '43', // %
						'image_group'    => array(
							'image_id' => get_post_thumbnail_id(),
							'size'     => 'cmf_review_slider',
						),
					);
					$settings[ 'content_padding_' . $settings['image_position'] ] = '18'; // px
					ob_start();
					get_template_part( 'template-parts/post', 'cats' );
					?>
					<h2><?php the_title(); ?></h2>
					<?php
					if ( ! empty( $excerpt ) ) {
						?>
						<p class="short-description">
						<?php echo $excerpt; ?>
						</p>
						<?php
					}
					?>

					<?php

					$settings['content_group']['content'] = ob_get_clean();
					$settings['content_group']['link']    = array(
						'url'   => get_permalink(),
						'title' => $post_button_label,

					);
					?>
					<div class="content-with-image-section">
						<?php get_template_part( 'template-parts/blocks/content-with-image/content-with-image', '', $settings ); ?>
					</div>
					<div class="container container-small">
						<div class="row">
							<div class="col col-100">
								<h3 class="archive-section-title"><?php _e( 'Latest on our blog', 'comfy' ); ?></h3>
							</div>
					<?php
					break;
				case 4:
					?>
							<div class="col-100 col-sm-50 post-col">
								<?php get_template_part( 'template-parts/post', 'preview' ); ?>
							</div>
						</div>
					</div>
					<?php
					break;
				case 5:
					?>
					<div class="container">
						<div class="row">
							<div class="col-100">
								<article class="post post-big">
									<div class="post-thumb">
										<?php the_post_thumbnail( 'cmf_post_big' ); ?>
									</div>
									<div class="post-content">
										<?php get_template_part( 'template-parts/post', 'cats' ); ?>
										<h2 class="post-title-big">
											<?php the_title(); ?>
										</h2>
										<?php
										if ( ! empty( $excerpt ) ) {
											?>
											<p>
												<?php echo $excerpt; ?>
											</p>
											<?php
										}
										?>
										<a class="button button-secondary-white" href="<?php get_permalink(); ?>">
											<?php echo $post_button_label; ?>
										</a>
									</div>
								</article>
							</div>
						</div>
					</div>
					<div class="container container-small">
						<div class="row">
					<?php
					break;
				default:
					?>
					<div class="col-100 col-sm-50 post-col">
						<?php get_template_part( 'template-parts/post', 'preview' ); ?>
					</div>
					<?php
					break;
			}
				endwhile;
		?>
				<div class="col-100">
						<?php get_template_part( 'template-parts/pagination' ); ?>
				</div>
			</div>
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
