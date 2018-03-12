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
class MPPSS_Hooks_Helper {

	/**
	 * MPPSS_Hooks_Helper constructor.
	 */
	public function __construct() {
		$this->setup();
	}

	/**
	 * Callback to WordPress admin hooks
	 */
	public function setup() {
		// MediaPress actions to attach social links.
		add_action( 'mpp_media_meta', array( $this, 'on_media' ) );
		add_action( 'mpp_lightbox_media_meta', array( $this, 'on_lightbox' ) );
		add_action( 'mpp_gallery_meta', array( $this, 'on_gallery' ) );

		add_action( 'wp_head', array( $this, 'inject_og_meta' ), 0 );
	}

	/**
	 * If is enable on different page or not
	 *
	 * @return bool
	 */
	public function is_enabled() {

		$is_enabled          = false;
		$settings            = mppss_get_settings();
		$settings['show-on'] = ( $settings ) ? $settings['show-on'] : array();

		if ( mpp_is_single_media() && in_array( 'media_single', $settings['show-on'] ) ) {
			$is_enabled = true;
		} elseif ( mpp_is_single_gallery() && in_array( 'gallery_single ', $settings['show-on'] ) ) {
			$is_enabled = true;
		} elseif ( mpp_is_user_gallery_component() || mpp_is_gallery_directory() || mpp_is_group_gallery_component() ) {
			if ( in_array( 'gallery_list', $settings['show-on'] ) ) {
				$is_enabled = true;
			}
		}

		return $is_enabled;
	}

	/**
	 * If is enable on lightbox
	 *
	 * @return bool
	 */
	public function is_lightbox_enabled() {

		$is_enabled          = false;
		$settings            = mppss_get_settings();
		$settings['show-on'] = ( $settings ) ? $settings['show-on'] : array();

		if ( in_array( 'light_box', $settings['show-on'] ) ) {
			$is_enabled = true;
		}

		return $is_enabled;
	}

	/**
	 * Add social link on media page
	 *
	 * @param MPP_Media|null $media MediaPress Media object.
	 */
	public function on_media( $media = null ) {

		if ( ! $this->is_enabled() ) {
			return;
		}

		$media = mpp_get_media( $media );
		echo mppss_get_html_markup( $media->id );
	}

	/**
	 * Add link on lightbox media
	 *
	 * @param MPP_Media|null $media Media object.
	 */
	public function on_lightbox( $media = null ) {

		if ( ! $this->is_lightbox_enabled() ) {
			return;
		}

		$media = mpp_get_media( $media );
		echo mppss_get_html_markup( $media->id );
	}

	/**
	 * Add link for gallery
	 *
	 * @param MPP_Gallery|null $gallery MediaPress Gallery object.
	 */
	public function on_gallery( $gallery = null ) {

		if ( ! $this->is_enabled() ) {
			return;
		}

		$gallery = mpp_get_gallery( $gallery );
		echo mppss_get_html_markup( $gallery->id );
	}

	/**
	 * Inject necessary og meta details
     *
     * @todo need to improve
	 */
	public function inject_og_meta() {

		if ( ! $this->is_enabled() || ! $this->is_lightbox_enabled() ) {
			return;
		}

		$title       = '';
		$url         = '';
		$description = '';
		$image       = '';


		if ( mpp_is_single_media() ) {
			$media       = mpp_get_current_media();
			$title       = mpp_get_media_title( $media );
			$url         = mpp_get_media_permalink( $media );
			$description = mpp_get_media_description( $media );
			$image       = mpp_get_media_cover_src( 'thumbnail', $media );
		} elseif ( mpp_is_single_gallery() ) {
			$gallery     = mpp_get_current_gallery();
			$title       = mpp_get_gallery_title( $gallery );
			$url         = mpp_get_gallery_permalink( $gallery );
			$description = mpp_get_gallery_description( $gallery );
			$image       = mpp_get_gallery_cover_src( 'thumbnail', $gallery );
		}

		?>

        <meta property="og:title" content="<?php echo esc_attr( $title ); ?>"/>
        <meta property="og:description" content="<?php echo $description; ?>"/>

		<?php if ( $url ): ?>
            <meta property="og:url" content="<?php echo esc_url( $url ); ?>"/>
		<?php endif; ?>

		<?php if ( $image ) : ?>
            <meta property="og:image" content="<?php echo esc_url( $image ); ?>"/>
            <meta property="og:image:width" content="<?php echo mpp_get_option( 'size_thumbnail' ); ?>">
            <meta property="og:image:height" content="<?php echo mpp_get_option( 'size_thumbnail' ); ?>">
		<?php endif; ?>

		<?php
	}

}
new MPPSS_Hooks_Helper();













