<?php
/**
 * @package WordPress
 * @subpackage comfy
 */

get_header();
if ( ! empty( $_GET['s'] ) ) :
	$query = new WP_Query(
		array(
			'posts_per_page' => -1,
			's'              => sanitize_text_field( $s ),
		)
	); ?>

		<section class="section">
			<div class="container">
				<div class="row">
					<div class="col-100">
						<h1 class="archive-header-title"><?php echo __( 'Search results for: ', 'COMFY' ) . '"' . htmlentities( wp_kses( $s, array() ), ENT_QUOTES, 'UTF-8' ) . '"'; ?> </h1>
					</div>
					<?php
					if ( $query->posts ) :
						foreach ( $query->posts as $post ) :
							$item['product'] = $post
							?>
							<div class="col-100 col-md-50">
								<?php echo  get_template_part( 'template-parts/product-preview', '', $item ); ?>
							</div>
							<?php
						endforeach;
					endif;
					?>
				</div>
			</div>
		</section>

	<?php
	wp_reset_query();
endif;
get_footer();
