<?php
/**
 * Main loader file
 *
 * @package mpp-social-share
 */

/**
 * Plugin Name: MediaPress Social Share
 * Plugin URI: https://buddydev.com/plugins/mpp-social-share/
 * Description: An addon for MediaPress that allows site users to share media or gallery on social sites.
 * Version: 1.0.0
 * Author: BuddyDev Team
 * Author URI: https://buddydev.com
 * License: GPL2
 */

/**
 * Contributor: raviousprime
 * Contributor URI: http://github.com/raviousprime
 *
 * @copyright MPP Social share is a fork of Simple Social Share plugin(https://wordpress.org/plugins/simple-social-share/) by Perials( http://perials.com) licensed under GPL 2.0
 */

// Exit if file access directly over web.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Class MPP_Social_Share
 */
class MPP_Social_Share {

	/**
	 * Plugin directory url
	 *
	 * @var string
	 */
	private $url;

	/**
	 * Plugin directory absolute path
	 *
	 * @var string
	 */
	private $path;

	/**
	 * Class instance
	 *
	 * @var MPP_Social_Share
	 */
	private static $instance = null;

	/**
	 * MPP_Social_Share constructor.
	 */
	private function __construct() {
		$this->url  = plugin_dir_url( __FILE__ );
		$this->path = plugin_dir_path( __FILE__ );

		$this->setup();
	}

	/**
	 * Get class instance
	 *
	 * @return MPP_Social_Share
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Setup plugin functionality
	 */
	private function setup() {
		register_activation_hook( __FILE__, array( $this, 'activate' ) );

		add_action( 'mpp_loaded', array( $this, 'load' ) );
		add_action( 'mpp_enqueue_scripts', array( $this, 'load_assets' ) );
		add_action( 'mpp_after_lightbox_media', array( $this, 'after_lightbox_scripts' ) );

		// add_action( 'wp_footer', array( $this, 'attach_footer_scripts' ) );
	}

	/**
	 * Load other plug-in files
	 */
	public function load() {

		$files = array(
			'core/mppss-functions.php',
			'core/class-mppss-hooks-helper.php',
		);

		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			$files[] = 'admin/class-mppss-admin-settings-helper.php';
		}

		foreach ( $files as $file ) {
			require_once $this->path . $file;
		}
	}

	/**
	 * On activate save default settings
	 */
	public function activate() {
		add_option( 'mppss-settings', $this->get_defaults() );
	}

	/**
	 * Load plugin assets
	 */
	public function load_assets() {

		$settings = mppss_get_settings();

		wp_register_style( 'mppss-css', $this->url . 'assets/css/style.css' );
		wp_enqueue_style( 'mppss-css' );
		wp_register_style( 'rotation360-css', $this->url . 'assets/css/360-rotate.css' );
		wp_register_style( 'tooltipster-css', $this->url . 'assets/css/tooltipster.css' );

		wp_register_script( 'tooltipster-js', $this->url . 'assets/js/jquery.tooltipster.js', array( 'jquery' ) );
		wp_register_script( 'facebook-sdk-js', $this->url . 'assets/js/facebook-sdk.js', array( 'jquery' ), false, true );
		wp_register_script( 'googleplus-sdk-js', $this->url . 'assets/js/google-plus-sdk.js', array( 'jquery' ), false, true );
		wp_register_script( 'twitter-sdk-js', $this->url . 'assets/js/twitter-sdk.js', array( 'jquery' ), false, true );
		wp_register_script( 'linkdin-sdk-js', 'https://platform.linkedin.com/in.js', array( 'jquery' ), false, true );
		wp_register_script( 'pinterest-sdk-js', 'https://assets.pinterest.com/js/pinit.js', array( 'jquery' ), false, true );
		wp_register_script( 'stumbleupon-sdk-js', $this->url . 'assets/js/stumbleupon-sdk.js', array( 'jquery' ), false, true );

		if ( ! empty( $settings['selected-services'] ) &&
		     ( in_array( $settings['select-style'], array( 'horizontal-with-count', 'small-buttons' ) ) ) ) {
			foreach ( $settings['selected-services'] as $service ) {
				wp_enqueue_script( $service . '-sdk-js' );
			}
		}

		if ( ! empty( $settings['select-animations'] ) && $settings['select-style'] != 'horizontal-with-count' ) {

			if ( in_array( '360-rotation', $settings['select-animations'] ) ) {
				wp_enqueue_style( 'rotation360-css' );
			}

			if ( in_array( 'tooltip', $settings['select-animations'] ) ) {
				wp_enqueue_style( 'tooltipster-css' );
				wp_enqueue_script( 'tooltipster-js' );

				if ( $settings['select-style'] != 'small-buttons' ) {
					wp_add_inline_script( 'tooltipster-js', 'jQuery(".hint--top").tooltipster( {animation: "grow" } );' );
				}
			}
		}
	}

	/**
	 * Add script after loading lightbox
	 */
	public function after_lightbox_scripts() {

		$settings = mppss_get_settings();

		if ( ! in_array( 'light_box', $settings['show-on'] ) || ! in_array( $settings['select-style'], array( 'horizontal-with-count', 'small-buttons' ) ) ) {
			return;
		}

		$script = '';

		if ( 'facebook' == $settings['selected-services'] ) {
			$script .= 'FB.XFBML.parse();';
		}

		if ( 'linkedin' == $settings['selected-services'] ) {
			$script .= 'IN.parse();';
		}

		if ( 'twitter' == $settings['selected-services'] ) {
			$script .= 'twttr.widgets.load();';
		}

		$script = trim( $script );

		if ( empty( $script ) ) {
			return;
		}

		echo '<script type="text/javascript">' . $script . '</script>';
	}

	/**
	 * Get plugin URL
	 *
	 * @return string
	 */
	public function get_url() {
		return $this->url;
	}

	/**
	 * Get plugin Path
	 *
	 * @return string
	 */
	public function get_path() {
		return $this->path;
	}

	/**
	 * Get all known services
	 *
	 * @return array
	 */
	public function get_services() {
		return array( 'facebook', 'twitter', 'googleplus', 'digg', 'reddit', 'linkedin', 'stumbleupon', 'tumblr', 'pinterest', 'email' );
	}

	/**
	 * Get default settings
	 *
	 * @param bool $preset If already set.
	 *
	 * @return array
	 */
	public function get_defaults( $preset = true ) {

		return array(
			'select-style'      => 'horizontal-w-c-circular',
			'selected-services' => $preset ? $this->get_services() : array(),
			'select-position'   => $preset ? array( 'before-content' ) : array(),
			'show-on'           => $preset ? array( 'gallery_list', 'gallery_single', 'media_single' ) : array(),
			'select-animations' => $preset ? array( 'tooltip' ) : array(),
			'exclude-on'        => '',
		);
	}
}

/**
 * Class instance
 *
 * @return MPP_Social_Share
 */
function mpp_social_share() {
	return MPP_Social_Share::get_instance();
}

mpp_social_share();

