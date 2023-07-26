<?php
/**
 * Plugin Name: WP Promoted Product
 * Description: Display a promoted product on every page with custom settings in WooCommerce.
 * Author: Mahmoud Elhelou
 * Author URI: https://linkedin.com/in/mahelhelou
 * Version: 1.0.0
 * Text Domain: wp-promoted-product
 */

namespace WPPromotedProduct;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

define( 'WP_PROMOTED_PRODUCT_VERSION', '1.0.0' );
define( 'WP_PROMOTED_PRODUCT_TEXT_DOMAIN', 'wp-promoted-product' );

require_once __DIR__ . '/autoload.php';

class WP_Promoted_Product {
	public function __construct() {
		new WooCommerceSettingsPage();
		new ProductEditorFields();
		new PromotedProductManager();
		new FrontendDisplay();
		new PromotedProductAssets();

		// Add activation and deactivation hooks.
		register_activation_hook( __FILE__, [$this, 'on_activate'] );
		register_deactivation_hook( __FILE__, [$this, 'on_deactivate'] );
	}

		public function on_activate() {
			$default_title = 'FLASH SALE:';
			add_option( 'promoted_product_title', $default_title );

			$default_bg_color = '#f7f7f7';
			add_option( 'promoted_product_bg_color', $default_bg_color );

			$default_text_color = '#000000';
			add_option( 'promoted_product_text_color', $default_text_color );

			// Create custom database tables (if needed).
			global $wpdb;
			$table_name = $wpdb->prefix . 'my_custom_table';
			$sql = "CREATE TABLE $table_name (
					id INT NOT NULL AUTO_INCREMENT,
					name VARCHAR(100) NOT NULL,
					PRIMARY KEY (id)
			)";
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $sql );
	}

	public function on_deactivate() {
		delete_option( 'promoted_product_title' );

		global $wpdb;
		$table_name = $wpdb->prefix . 'wp_promotions';
		$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
	}
}

new WP_Promoted_Product();
