<?php
/**
 * @package WordPress
 * @subpackage comfy
 */

wp_enqueue_style( 'search-results', get_template_directory_uri() . '/dist/css/pages/search-results.css', '', '', 'all' );

get_header();
if ( ! empty( $_GET['s'] ) ) :
	$query = new WP_Query(
		array(
			'posts_per_page' => -1,
			's'              => sanitize_text_field( $s ),
		)
	); ?>
<main class="main">
	<section class="section">
		<div class="container">
			<div class="row">
				<div class="col-100">
					<h3 class="archive-header-title">
						<?php echo __( 'Search results for: ', 'comfy' ) . '"' . htmlentities( wp_kses( $s, array() ), ENT_QUOTES, 'UTF-8' ) . '"'; ?>
					</h3>
					<p class="archive-header-subtitle">
						<?php echo count( $query->posts ) . ' ' . __( 'results found', 'comfy' ); ?>
					</p>
				</div>
				<?php
				if ( $query->posts ) :
					foreach ( $query->posts as $post ) :
						if ( 'product' === get_post_type( $post ) ) {
							$item['product'] = $post;
							?>
							<div class="col-100 col-md-50">
								<?php get_template_part( 'template-parts/product-preview', '', $item ); ?>
							</div>
							<?php
						}
					endforeach;
				endif;
				?>
			</div>
		</div>
	</section>
</main>
	<?php
	wp_reset_query();
else :
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	get_template_part( 404 );
	exit();
endif;
get_footer();
