<?php
/**
 * @package WordPress
 * @subpackage comfy
 */

/****************************************************************
 * Require custom functions
 ****************************************************************/
$include_folders = array(
	'includes/classes/',
	'includes/',
	'includes/etc/',
);
foreach ( $include_folders as $inc_folder ) {
	$include_folder = get_stylesheet_directory() . '/' . $inc_folder;
	foreach ( glob( $include_folder . '*.php' ) as $file ) {
		require $file;
	}
}
