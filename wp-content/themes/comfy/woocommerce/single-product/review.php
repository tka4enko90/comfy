<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$comment_id     = get_comment_ID();
$title          = get_comment_meta( $comment_id, 'title', true );
$text           = get_comment_text( $comment_id );
$date           = get_comment_date( 'd/m/o', $comment_id );
$rating         = get_comment_meta( $comment_id, 'rating', true );
$commented_post = array(
	'title' => get_the_title( $comment->comment_post_ID ),
	'url'   => get_permalink( $comment->comment_post_ID ),
);
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

	<div id="comment-<?php comment_ID(); ?>" class=" comment comment_container">
		<div class="comment-details">
			<?php
			if ( $rating > 0 ) {
				cmf_star_rating(
					array(
						'rating'        => $rating,
						'rounded_stars' => false,
					)
				);
			}
			?>
			<p class="comment-author">
				<?php echo $comment->comment_author; ?>
			</p>
			<time datetime="<?php echo $date; ?>"><?php echo $date; ?></time>
		</div>
		<div class="comment-info">
			<?php
			if ( ! empty( $title ) ) {
				?>
				<h5 class="comment-title">
					<?php echo $title; ?>
				</h5>
				<?php
			}
			if ( ! empty( $text ) ) {
				?>
				<p>
					<?php echo $text; ?>
				</p>
				<?php
			}
			?>
			<a class="comment-url" href="<?php echo $commented_post['url']; ?>"><?php echo __( 'On ', 'comfy' ) . $commented_post['title']; ?></a>
		</div>
	</div>
