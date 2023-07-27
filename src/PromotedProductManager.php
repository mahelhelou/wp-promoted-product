<?php

namespace WPPromotedProduct;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class PromotedProductManager {
	public function __construct() {
		add_action( 'init', [$this, 'init_promoted_product'] );
	}

	public function init_promoted_product() {
		$promoted_products = get_posts( [
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'meta_key'       => '_promoted_product',
			'meta_value'     => 'yes',
			'posts_per_page' => -1,
			]
		);

		$current_time = current_time( 'timestamp' );
		$active_promoted_product = null;

		foreach ( $promoted_products as $product ) {
			// Check if the product has an expiration date set
			$expiration_date = get_post_meta( $product->ID, '_promoted_product_expiration_datetime', true );

			if ( ! empty( $expiration_date ) ) {
				$expiration_time = strtotime( $expiration_date );

				// Check if the promotion has been expired
				if ( $expiration_time <= $current_time ) {
					update_post_meta( $product->ID, '_promoted_product', 'no' );
				} else {
					$active_promoted_product = $product;
				}
			} else {
				$active_promoted_product = $product;
			}
		}

		// If there is an active promoted product, update the option to store its ID.
		if ( $active_promoted_product ) {
			update_option( 'active_promoted_product_id', $active_promoted_product->ID );
		} else {
			delete_option( 'active_promoted_product_id' );
		}
	}
}
