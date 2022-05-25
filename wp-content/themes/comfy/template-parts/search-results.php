<div class="search-items">
<?php
    if ($args) :
        foreach ( $args as $product ) {
            $product_args = array(
                'product' => $product, // Important
                'thumb'   => 'cmf_search_result', // optional
            );
            get_template_part( 'template-parts/product-preview', '', $product_args );
        }
        ?>
    <div class="search-view-all">
        <a href="<?php echo get_search_link(); ?>"><?php echo __('View all search results', 'comfy'); ?></a>
    </div>
    <?php
    else: ?>
        <h4><?php echo __('Results not found', 'comfy'); ?></h4>
<?php endif; ?>
</div>


