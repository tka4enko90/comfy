<?php
/**
 * This functions show section thumbnail for flexible-content on admin.
 */

function acf_flexible_content_layout_preview( $layouts_images ) {
    $layout_preview_paths = [];
    foreach ($layouts_images as $key => $layouts_image) {
        $path = get_template_directory().'/template-parts/blocks/'.str_replace( '_', '-', $key ).'/preview/';
        if (count(glob("$path/*")) !== 0) {
            $files = array_diff(scandir($path), array('.', '..'));
            $image = $path.current($files);
            if (is_array($files) && file_exists($image)) {
                $layout_preview_paths[$key] = get_template_directory_uri().'/template-parts/blocks/'.str_replace( '_', '-', $key ).'/preview/'.current($files);
            }
        }
    }
    return $layout_preview_paths;
}
add_filter( 'acf-flexible-content-preview.images', 'acf_flexible_content_layout_preview', 10);

