<?php
/**
 * @package WordPress
 * @subpackage comfy
 */
get_header();

/**
 * Options for 404 Page
 * @see Options -> Page 404 -> Title 404, Text 404, Button text 404.
 */
$title_404 = get_field('title_404', 'option');
$text_404 = get_field('text_404', 'option');
$button_text_404 = get_field('button_text_404', 'option');
?>

<main class="main">
	<div class="section-404">
		<div class="container">
			<div class="section-inner">
				<?php if($title_404): ?>
					<h1><?php echo $title_404; ?></h1>
				<?php endif ?>
				<?php if($text_404): ?>
					<p><?php echo $text_404; ?></p>
				<?php endif ?>
				<?php if($button_text_404): ?>
					<a href="<?php echo home_url('/'); ?>" class="btn-cta"><?php echo $button_text_404; ?></a>
				<?php endif ?>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
