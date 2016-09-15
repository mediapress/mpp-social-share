<?php
/**
 * Plugin Name: MediaPress Social Share
 * Plugin URI: http://buddydev.com/plugins/mpp-social-share/
 * Description: MediaPress add-on for displaying social media icons to share Post/Page and media 
 * Version: 1.0.0
 * Author: BuddyDev Team
 * Author URI: http://buddydev.com
 * License: GPL2
 */
/**
 * MPP Social share is a fork of Simple Social Share plugin(https://wordpress.org/plugins/simple-social-share/) by Perials( http://perials.com) licensed under GPL 2.0

 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class MPP_Social_Share_Helper {

	private $url;
	private $path;
	private static $instance = null;

	private function __construct() {

		$this->url = plugin_dir_url( __FILE__ );
		$this->path = plugin_dir_path( __FILE__ );

		$this->setup();
	}

	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function setup() {
		//load core
		add_action( 'plugins_loaded', array( $this, 'load' ) );
		//load js/css
		add_action( 'wp_enqueue_scripts', array( $this,'load_assets' ) );
		//inject config js in footer
		add_action( 'wp_footer', array( $this, 'attach_footer_scripts' ) );
		//inject scripts in lightbox
		add_action( 'mpp_after_lightbox_media', array( $this, 'after_lightbox_scripts' ) );

		//on activation
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
	}

	public function load() {

		$path = $this->path;

		$files  = array(
			'core/functions.php',
			'core/template-hooks.php'
		);

		foreach ( $files as $file ) {
			require_once( $path . $file );
		}

		if ( is_admin() ) {
			require_once( $path . 'admin/mpp-social-share-admin.php' );
		}
	}

	//on activation, add the default settings
	public function activate() {
		add_option( 'mpp-ss-settings', $this->get_defaults() );
	}


	public function load_assets() {

		$settings = mpp_ss_get_options();

		wp_enqueue_style( 'mpp-share-css', $this->url . 'assets/css/style.css' );

		//if select animation is enabled, load css for animation
		if ( ! empty( $settings['select-animations'] ) && in_array( '360-rotation', $settings['select-animations'] ) && $settings['select-style'] != 'horizontal-with-count' ) {
			wp_enqueue_style( 'mpp-share-360-rotation', $this->url . 'assets/css/360-rotate.css' );
		}

		if ( ! empty( $settings['select-animations'] ) && in_array( 'tooltip', $settings['select-animations'] ) && $settings['select-style'] != 'horizontal-with-count' ) {
			wp_enqueue_style( 'tooltipster-css', $this->url .'assets/css/tooltipster.css' );
			wp_enqueue_script( 'tooltipster-js',  $this->url . 'assets/js/jquery.tooltipster.js', array('jquery') );
		}

	}

	private function load_service_scripts() {

		$settings = mpp_ss_get_options();

		if ( $settings['select-style'] == 'horizontal-with-count' || $settings['select-style'] == 'small-buttons' ) {

			$services_scripts_arr = mpp_ss_get_services_js_arr( $settings );

			if ( ! empty( $settings['selected-services'] ) ) {
				foreach ( $settings['selected-services'] as $service ) {
					echo $services_scripts_arr[ $service ];
				}
			}

		}
	}

	public function attach_footer_scripts() {

		$this->load_service_scripts();

		$settings = mpp_ss_get_options();

		if ( ! empty( $settings['select-animations'] ) && in_array( 'tooltip', $settings['select-animations'] ) && $settings['select-style'] != 'horizontal-with-count' && $settings['select-style'] != 'small-buttons' ) {

		?>
			<script type="text/javascript">
				jQuery(".hint--top").tooltipster( {animation: "grow" } );
			</script>

		<?php
		}
	}

	public function after_lightbox_scripts() {

		$this->load_service_scripts();
		echo '<script type="text/javascript">FB.XFBML.parse();IN.parse();twttr.widgets.load();</script>';
	}

	/**
	 * Get plugin URL
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
	 * get all known services
	 *
	 * @return array
	 */
	public function get_services() {
		return array( 'facebook', 'twitter', 'googleplus', 'digg', 'reddit', 'linkedin', 'stumbleupon', 'tumblr', 'pinterest', 'email' );
	}

	public function get_defaults( $preset = true ) {

		return array(
			'select-style'          => 'horizontal-w-c-circular',
			'available-services'	=> $this->get_services(),
			'selected-services'     => $preset ? $this->get_services() : array(),
			'select-position'       => $preset ? array( 'before-content' ) : array(),
			'show-on'               => $preset ? array( 'pages', 'posts', 'gallery_list', 'gallery_single' ) : array(),
			'select-animations'     => $preset ? array( 'tooltip' ) : array(),
			'exclude-on'            => '',
		);

	}
}


/**
 * @return MPP_Social_Share_Helper
 */
function mpp_ss_social() {

	return MPP_Social_Share_Helper::get_instance();

}
//initialize
mpp_ss_social();

