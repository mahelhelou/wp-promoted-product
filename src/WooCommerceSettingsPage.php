<?php

namespace WPPromotedProduct;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooCommerceSettingsPage {
	private $option_name = 'wp_promoted_product_settings';

	public function __construct() {
		add_action( 'admin_menu', [$this, 'add_settings_page'] );
		add_action( 'admin_init', [$this, 'register_settings'] );
	}

	public function add_settings_page() {
		add_submenu_page(
			'woocommerce',
			'Promoted Product Settings',
			'Promoted Product',
			'manage_options',
			'promoted-product-settings',
			[$this, 'view_settings_page']
		);
	}

	public function view_settings_page() { ?>
		<div class="wrap">
			<h1>Promoted Product Settings</h1>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'promoted-product-settings-group' );
					do_settings_sections( 'promoted-product-settings' );
					submit_button();
				?>
			</form>
		</div>
	<?php
	}

	public function register_settings() {
		register_setting( 'promoted-product-settings-group', $this->option_name, [$this, 'sanitize_settings'] );

		add_settings_section(
			'promoted-product-section',
			'Promoted Product Settings',
			[$this, 'section_callback'],
			'promoted-product-settings'
		);

		add_settings_field(
			'promoted-product-title',
			'Promoted Product Title',
			[$this, 'title_callback'],
			'promoted-product-settings',
			'promoted-product-section'
		);

		add_settings_field(
			'promoted-product-color-picker-background',
			'Background Color',
			[$this, 'background_color_picker_callback'],
			'promoted-product-settings',
			'promoted-product-section'
		);

		add_settings_field(
			'promoted-product-color-picker-text',
			'Text Color',
			[$this, 'text_color_picker_callback'],
			'promoted-product-settings',
			'promoted-product-section'
		);
	}

	public function sanitize_settings( $input ) {
		$input = [];

		if ( isset( $input['promoted_product_title'] ) ) {
				$input['promoted_product_title'] = sanitize_text_field( $input['promoted_product_title'] );
		}

		return $input;
	}

	public function section_callback() {
		echo '<p>Configure your promoted product settings.</p>';
	}

	public function title_callback() {
		$options = get_option( $this->option_name );
		$title = isset( $options['promoted_product_title'] ) ? $options['promoted_product_title'] : '';

		echo '<input type="text" name="' . $this->option_name . '[promoted_product_title]" value="' . esc_attr( $title ) . '" />';
	}

	public function background_color_picker_callback() {
		// Output the HTML for the background color picker field here.
		$options = get_option( $this->option_name );
		$background_color = isset( $options['promoted_product_background_color'] ) ? $options['promoted_product_background_color'] : '';

		echo '<input type="text" name="' . $this->option_name . '[promoted_product_background_color]" value="' . esc_attr( $background_color ) . '" class="color-picker" />';
	}

	public function text_color_picker_callback() {
		$options = get_option( $this->option_name );
		$text_color = isset( $options['promoted_product_text_color'] ) ? $options['promoted_product_text_color'] : '';

		echo '<input type="text" name="' . $this->option_name . '[promoted_product_text_color]" value="' . esc_attr( $text_color ) . '" class="color-picker" />';
	}
}
