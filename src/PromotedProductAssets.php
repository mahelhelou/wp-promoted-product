<?php

namespace WPPromotedProduct;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class PromotedProductAssets {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
	}

	public function enqueue_assets() {
		wp_enqueue_style( 'promoted-product-style', plugin_dir_url( __FILE__ ) . 'css/promoted-product-style.css', [], '1.0.0' );
	}
}
