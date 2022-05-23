<?php
add_filter(
    'acf-flexible-content-preview.images_path',
    function ( $path ) {
        return 'template-parts/blocks';
    }
);
