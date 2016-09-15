<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class MPP_Social_Share_Admin_Helper {

	public function __construct() {

		// register our settings page
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		// register setting
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		// load plugin assets
		add_action( 'admin_enqueue_scripts', array( $this,'load_assets' ) );
	}

	public function load_assets() {

		$url = mpp_ss_social()->get_url();

		wp_enqueue_style( 'mpp-ss-admin-css', $url.'assets/css/admin.css' );
		wp_enqueue_script( 'mpp-ss-admin-js', $url. 'assets/js/admin.js'  );
	}

	public function register_settings(){
		register_setting( 'mpp-ss-settings', 'mpp-ss-settings' );
	}

	/*
	 * Add sub menu page in Settings for configuring plugin
	 */
	public function add_menu(){
		add_submenu_page( 'options-general.php', 'MPP Social Sharing  settings', 'MPP Social Share', 'manage_options', 'mpp-ss-setting', array( $this, 'render' ) );
	}

	/*
	 * Callback for add_submenu_page for generating markup of page
	 */
	public function render() {

	?>
		<div class="wrap">
			<h2><?php _e( 'Settings', 'mpp-social-share' ) ?></h2>
			<form method="POST" action="options.php">
			<?php

				settings_fields('mpp-ss-settings');

				$settings 						= mpp_ss_get_options();
				$settings['available-services']	= mpp_ss_social()->get_services();

			?>
			<?php require_once mpp_ss_social()->get_path().'admin/admin-form.php'; ?>
		</div>
	<?php
	}

}
new MPP_Social_Share_Admin_Helper();
