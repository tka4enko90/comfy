<?php /* Comfy Search Form */ ?>
<form id="search-form" class="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<input id="search-form-input"  type="search" class="search-field" name="s" placeholder="Search products..." value="<?php echo get_search_query(); ?>">
</form>
<?php
