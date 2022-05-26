<?php
/**
 * @package WordPress
 * @subpackage comfy
 */

get_header();
if ( ! empty( $_GET['post_type'] && ! empty( $_GET['s'] ) ) ) :
	$query = new WP_Query(
		array(
			'post_type'      => $_GET['post_type'],
			'posts_per_page' => -1,
			's'              => $_GET['s'],
		)
	); ?>
	<main class="main">
		<section class="section">
			<div class="container">
				<div class="row">
					<?php
					if ( $query->posts ) :
						foreach ( $query->posts as $post ) :
							$item['product'] = $post
							?>

							<div class="col">
								<?php echo  get_template_part( 'template-parts/product-preview', '', $item ); ?>
							</div>
							<?php
						endforeach;
					endif;
					?>
				</div>
			</div>
		</section>
	</main>
	<?php
endif;
get_footer();
