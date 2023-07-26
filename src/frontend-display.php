<?php

namespace WPPromotedProduct;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class FrontendDisplay {
	public function __construct() {
		add_action( 'wp', [$this, 'display_promoted_product'] );
	}

    public function display_promoted_product() {
			// Display active promoted product (If any)
			$active_promoted_product_id = get_option( 'active_promoted_product_id' );

			if ( $active_promoted_product_id ) {
				$product = wc_get_product( $active_promoted_product_id );

			if ( $product ) {
				$product_title = $product->get_title();
				$custom_title = get_post_meta( $active_promoted_product_id, '_promoted_product_title', true );
				$promoted_title = ! empty( $custom_title ) ? $custom_title : $product_title;

				echo '<div class="promoted-product">';
				echo '<span class="promoted-title">' . esc_html( $promoted_title ) . ': </span>';
				echo '<span class="product-title">' . esc_html( $product_title ) . '</span>';
				echo '</div>';
			}
		}
	}
}
