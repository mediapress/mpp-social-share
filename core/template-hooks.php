<?php

/**
 * @param $content
 *
 * @return string
 */

function mpp_ss_add_share_links( $content ) {

	$show_on  = mpp_ss_get_show_on_options();
	$post_id  = get_the_ID();

	if ( is_archive() && ! in_array( 'archive', $show_on ) ) {
		return $content;
	} elseif ( is_page() && ! in_array( 'pages', $show_on ) ) {
		return $content;
	} elseif ( is_home() && ! in_array( 'home', $show_on ) ) {
		return $content;
	} elseif ( is_single() && ! in_array( 'posts', $show_on ) ) {
		return $content;
	} elseif ( in_array( $post_id, mpp_ss_get_excluded() ) ) {
		return $content;
	}

	$html_markup = mpp_ss_get_html_markup( $post_id );
	$position    = mpp_ss_get_position();

	if ( ! empty( $position ) && in_array( 'before-content', $position ) ) {
		$content = $html_markup . $content;
	}

	if ( ! empty( $position ) && in_array( 'after-content', $position ) ) {
		$content .= $html_markup;
	}

	return $content;

}
add_filter( 'the_content', 'mpp_ss_add_share_links' );


/**
 * @return string
 */
function mpp_ss_add_media_share_link( $media = null ) {

	$media = mpp_get_media( $media );
	$show  = mpp_ss_show_social_link();

	if ( $show && mpp_is_valid_media( $media->id ) ) {
		echo mpp_ss_get_html_markup( $media->id );
	}

}
add_action( 'mpp_media_meta', 'mpp_ss_add_media_share_link' );

function mpp_ss_lightbox_add_media_share_link( $media = null ) {

	$media 	 = mpp_get_media( $media );
	$show_on = mpp_ss_get_show_on_options();
	
	if ( mpp_is_valid_media( $media->id ) && in_array( 'light_box', $show_on ) ) {

		echo mpp_ss_get_html_markup( $media->id );
	}
}
add_action( 'mpp_lightbox_media_meta', 'mpp_ss_lightbox_add_media_share_link' );

function mpp_ss_add_gallery_share_link( $gallery = null ) {

	$gallery = mpp_get_gallery( $gallery );
	$show 	 = mpp_ss_show_social_link();

	if ( $show && mpp_is_valid_gallery( $gallery->id ) ) {
		echo mpp_ss_get_html_markup( $gallery->id );
	}
}
add_action( 'mpp_gallery_meta', 'mpp_ss_add_gallery_share_link' );

function mpp_ss_lightbox_add_gallery_share_link( $gallery = null ) {

	$gallery = mpp_get_gallery( $gallery );
	$show_on = mpp_ss_get_show_on_options();

	if ( mpp_is_valid_gallery( $gallery->id ) && in_array( 'light_box', $show_on )  ) {

		echo mpp_ss_get_html_markup( $gallery->id );
	}
}
add_action( 'mpp_lightbox_gallery_meta', 'mpp_ss_lightbox_add_gallery_share_link' );

//inject opengraph meta into the page
function mpp_ss_social_inject_og_meta() {

	if ( ! apply_filters( 'mpp_ss_inject_og_meta', true ) ) {
		return;
	}

	$show_on = mpp_ss_get_show_on_options();
	//if it is enabled, and we are on gallery listing/single gallery/media/lightbox let us add its
	if ( ! mpp_ss_show_social_link() && ! in_array( 'light_box', $show_on ) ) {
		return;
	}

	$title       = '';
	$url         = site_url();
	$description = '';
	$image       = '';


	if ( mpp_is_single_media() ) {

		$media 		 = mpp_get_current_media();
		$title 		 = mpp_get_media_title( $media );
		$url   		 = mpp_get_media_permalink( $media );
		$description = mpp_get_media_description( $media );
		$image       = mpp_get_media_cover_src( null, $media );

	} elseif ( mpp_is_single_gallery() ) {
		//we are on single gallery

		$gallery 	 = mpp_get_current_gallery();
		$title       = mpp_get_gallery_title( $gallery );
		$url         = mpp_get_gallery_permalink( $gallery );
		$description = mpp_get_gallery_description( $gallery );
		$image       = mpp_get_gallery_cover_src( null, $gallery );

	}

	?>

	<?php if ( $url ): ?>
		<meta property="og:url" content="<?php echo esc_url( $url ); ?>"/>
	<?php endif; ?>

	<meta property="og:type" content="article"/>
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>"/>
	<meta property="og:description" content="<?php echo $description; ?>"/>

	<?php if ( $image ){ ?>
		<meta property="og:image" content="<?php echo esc_url( $image ); ?>"/>
	<?php } else{ ?>
		<meta property="og:image"  content="https://fbstatic-a.akamaihd.net/images/devsite/attachment_blank.png" />
	<?php } ?>
	
	<?php
}
add_action( 'wp_head', 'mpp_ss_social_inject_og_meta', 0 );

function mpp_ss_load_meta_on_wp_page_post( $show ) {

	$show_on = mpp_ss_get_show_on_options();

	if ( mpp_is_single_media() || mpp_is_single_gallery() || ( mpp_is_user_gallery_component() || mpp_is_gallery_directory() || mpp_is_group_gallery_component() ) ) {
		return $show;
	}

	if ( is_front_page()) {
		$show = in_array( 'home', $show_on ) ? true : false;
	} elseif ( is_single() ) {
		$show = in_array( 'posts', $show_on ) ? true : false;
	} elseif ( is_page() ) {
		$show = in_array( 'pages', $show_on ) ? true : false;
	} elseif ( is_archive() ) {
		$show = in_array( 'archive', $show_on ) ? true : false;
	}

	return $show;
}
add_filter( 'mpp_ss_share_social_link', 'mpp_ss_load_meta_on_wp_page_post' );
