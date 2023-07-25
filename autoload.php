<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

spl_autoload_register( 'wp_promoted_product_autoload' );

function wp_promoted_product_autoload( $class ) {
	$namespace = 'WPPromotedProduct\\';

	$base_dir = __DIR__ . '/src/';

	$class_file = str_replace( $namespace, '', $class );
	$class_file = str_replace( '\\', '/', $class_file );

	$file = $base_dir . $class_file . '.php';

	if ( file_exists( $file ) ) {
		require $file;
	}
}