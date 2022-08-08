<?php
/**
 * Autoload PHP classes.
 *
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

spl_autoload_register(
	function ( $class ) {
		$path = dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR . 'includes/classes';
		$file = strtolower( str_replace( 'Scrubbill\\Plugin\\Scrubbill\\', '', $class ) );

		// Class paths and name.
		$file  = str_replace( '_', '-', $file );
		$parts = explode( '\\', $file );

		foreach ( $parts as $index => $part ) {
			if ( count( $parts ) - 1 === $index ) {
				$type = 'class';

				if ( preg_match( '/traits/i', $class ) ) {
					$type = 'trait';
				}

				$part = sprintf( '%s-%s.php', $type, $part );
			}

			$path .= sprintf( '%s%s', DIRECTORY_SEPARATOR, $part );
		}

		if ( file_exists( $path ) ) {
			require_once $path;
		}
	}
);
