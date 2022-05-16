<?php
/**
 * @package WordPress
 * @subpackage comfy
 */

get_header();

/**
 * Options for blog pages
 * @see Page -> Post Settings -> Preview Image
 */

?>

    <h1><?php bloginfo( 'name' ); ?></h1>
    <h2><?php bloginfo( 'description' ); ?></h2>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <h3><?php the_title(); ?></h3>

        <?php the_content(); ?>
        <?php wp_link_pages(); ?>
        <?php edit_post_link(); ?>

    <?php endwhile; ?>

        <?php
        if ( get_next_posts_link() ) {
            next_posts_link();
        }
        ?>
        <?php
        if ( get_previous_posts_link() ) {
            previous_posts_link();
        }
        ?>

    <?php else: ?>

        <p><?php _e('No posts found.', 'comfy') ?></p>

    <?php endif; ?>

<?php
get_footer();
