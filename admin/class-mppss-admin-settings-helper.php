<?php
/**
 * Class handler plugin settings in backend
 *
 * @package mpp-social-share
 */

// Exit if file access directly over web.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Class MPPSS_Admin_Settings_Helper
 */
class MPPSS_Admin_Settings_Helper {

	/**
	 * MPPSS_Admin_Settings_Helper constructor.
	 */
	public function __construct() {
		$this->setup();
	}

	/**
	 * Callback to WordPress admin hooks
	 */
	public function setup() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
	}

	/**
	 *  Load admin assets
	 */
	public function load_assets() {
		wp_enqueue_style( 'mpp-social-share-admin-css', mpp_social_share()->get_url() . 'assets/css/admin.css' );
		wp_enqueue_script( 'mpp-social-share-admin-js', mpp_social_share()->get_url() . 'assets/js/admin.js' );
	}

	/**
	 * Register new settings
	 */
	public function register_settings() {
		register_setting( 'mppss-settings', 'mppss-settings' );
	}

	/**
	 * Add sub menu page in Settings for configuring plugin
	 */
	public function add_menu() {
		add_submenu_page( 'options-general.php', 'MPP Social Sharing  settings', 'MPP Social Share', 'manage_options', 'mpp-ss-setting', array( $this, 'render' ) );
	}

	/**
	 * Callback for add_submenu_page for generating markup of page
	 */
	public function render() {
		require_once mpp_social_share()->get_path() . 'admin/admin-form.php';
	}

}
new MPPSS_Admin_Settings_Helper();

