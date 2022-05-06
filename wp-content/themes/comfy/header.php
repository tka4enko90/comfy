<?php
/**
 * @package WordPress
 * @subpackage comfy
 */
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset') ?>"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta content="telephone=no" name="format-detection"/>
    <meta name="HandheldFriendly" content="true"/>
    <title><?php bloginfo('name'); ?> <?php wp_title("", true); ?></title>

    <!-- FAVICON -->
<!--    <link rel="apple-touch-icon" sizes="180x180" href="--><?php //echo get_template_directory_uri(); ?><!--/favicon/apple-touch-icon.png">-->
<!--    <link rel="icon" type="image/png" sizes="32x32" href="--><?php //echo get_template_directory_uri(); ?><!--/favicon/favicon-32x32.png">-->
<!--    <link rel="icon" type="image/png" sizes="16x16" href="--><?php //echo get_template_directory_uri(); ?><!--/favicon/favicon-16x16.png">-->
<!--    <link rel="manifest" href="/--><?php //echo get_template_directory_uri(); ?><!--/faviconsite.webmanifest">-->
<!--    <meta name="msapplication-TileColor" content="#da532c">-->
     <meta name="theme-color" content="#ffffff">
    <!-- /FAVICON -->

    <?php wp_head(); ?>
</head>

<body <?php body_class($body_class) ?>>
<?php wp_body_open(); ?>
<header>

</header>
<main class="story">