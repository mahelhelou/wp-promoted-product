<?php

namespace WPPromotedProduct;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class ProductEditorFields {
	public function __construct() {
		add_action( 'woocommerce_product_options_general_product_data', [$this, 'add_promoted_product_fields'] );
		add_action( 'woocommerce_process_product_meta', [$this, 'save_promoted_product_fields'] );
	}

	public function add_promoted_product_fields() {
		global $post;

		woocommerce_wp_checkbox( [
			'id'            => '_promoted_product',
			'label'         => 'Promote this product',
			'value'         => get_post_meta( $post->ID, '_promoted_product', true ),
			'desc_tip'      => true,
			'description'   => 'Check this box to promote this product.',
		] );

		woocommerce_wp_text_input( [
			'id'          => '_promoted_product_title',
			'label'       => 'Custom Title',
			'placeholder' => 'Leave empty to use product title',
			'value'       => get_post_meta( $post->ID, '_promoted_product_title', true ),
		] );

		woocommerce_wp_checkbox( [
			'id'            => '_promoted_product_expiration',
			'label'         => 'Set Expiration Date and Time',
			'value'         => get_post_meta( $post->ID, '_promoted_product_expiration', true ),
			'desc_tip'      => true,
			'description'   => 'Check this box to set an expiration date and time for the promotion.',
		] );

		woocommerce_wp_text_input( [
			'id'          => '_promoted_product_expiration_datetime',
			'label'       => 'Expiration Date and Time',
			'type'        => 'datetime-local',
			'value'       => get_post_meta( $post->ID, '_promoted_product_expiration_datetime', true ),
			'custom_attributes' => [
					'step' => 1
			],
		] );
	}

	public function save_promoted_product_fields( $post_id ) {
		$promoted = isset( $_POST['_promoted_product'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_promoted_product', $promoted );

		$title = isset( $_POST['_promoted_product_title'] ) ? sanitize_text_field( $_POST['_promoted_product_title'] ) : '';
		update_post_meta( $post_id, '_promoted_product_title', $title );

		$expiration = isset( $_POST['_promoted_product_expiration'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_promoted_product_expiration', $expiration );

		$expiration_datetime = isset( $_POST['_promoted_product_expiration_datetime'] ) ? sanitize_text_field( $_POST['_promoted_product_expiration_datetime'] ) : '';
		update_post_meta( $post_id, '_promoted_product_expiration_datetime', $expiration_datetime );
	}
}
