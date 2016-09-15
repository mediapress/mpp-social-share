<?php

/**
 * Get all settings
 *
 * @return mixed|array
 */
function mpp_ss_get_options() {
	return get_option('mpp-ss-settings', array());
}

/**
 *
 * @return array
 */
function mpp_ss_get_services_js_arr() {

	static $loaded;

	$fb = '';

	if ( ! isset ( $loaded ) ) {
		$fb 	= "<div id='fb-root'></div>";
		$loaded = true;
	}

	$service_js_arr = array(

		'facebook'      => $fb .
		                   '<script>(function(d, s, id) {
								var js, fjs = d.getElementsByTagName(s)[0];
								if (d.getElementById(id)) return;
								js = d.createElement(s); js.id = id;
								js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
								fjs.parentNode.insertBefore(js, fjs);
							}(document, "script", "facebook-jssdk"));						
							</script>',
		'twitter'       => '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script>',
		'googleplus'    => '<script type="text/javascript">
							(function() {
								var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
								po.src = "https://apis.google.com/js/platform.js";
								var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
							})();
							</script>',
		'digg'          => '',
		'reddit'        => '',
		'linkedin'      => '<script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>',
		'stumbleupon'	=> '<script type="text/javascript">
								(function() {
							    	var li = document.createElement("script"); li.type = "text/javascript"; li.async = true;
									li.src = ("https:" == document.location.protocol ? "https:" : "http:") + "//platform.stumbleupon.com/1/widgets.js";
									var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(li, s);
								})();
					  		</script>',
		'tumblr'        => '',
		'pinterest'     => ''
	);
	return $service_js_arr;
}

/**
 * @return array
 */
function mpp_ss_get_small_buttons_markup_arr( $id = null ) {

	if ( ! $id ) {
		return ;
	}

	$post  = get_post( $id );
	$url   = get_permalink( $post );
	$title = $post->post_title;

	$service_markup_arr = array(
		'facebook' 		=> '<div class="s-single-share">
								<div class="fb-share-button" data-href="'.$url.'" data-type="button"></div>
							</div>',
		'twitter' 		=> '<div class="s-single-share">
								<a href="https://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
					  		</div>',
		'googleplus' 	=> '<div class="s-single-share">
								<div class="g-plusone" data-size="medium" data-annotation="none"></div>
							</div>',
		'digg' 			=> '',
		'reddit' 		=> '<div class="s-single-share">
								<a href="http://www.reddit.com/submit" onclick="window.location = \'http://www.reddit.com/submit?url=\' + encodeURIComponent(window.location); return false"> <img src="http://www.reddit.com/static/spreddit7.gif" alt="submit to reddit" border="0" /> </a>
							</div>',
		'linkedin' 		=> '<div class="s-single-share"><script type="IN/Share"></script></div>',
		'stumbleupon'	=> '<div class="s-single-share"><su:badge layout="4"></su:badge></div>',
		'tumblr' 		=> '<div class="s-single-share"><a href="http://www.tumblr.com/share" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:61px; height:20px; background:url(\'http://platform.tumblr.com/v1/share_2.png\') top left no-repeat transparent;">Share on Tumblr</a></div>',
		'pinterest' 	=> '<div class="s-single-share">
								<a href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"  data-pin-color="red"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png" /></a>
								<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
							</div>',
		'email' 		=> '<div class="s-single-share">
								<a href="mailto:?Subject='.str_replace(' ', '%20', $title).'&Body='.str_replace(' ', '%20', 'Here is the link to the article: '.$url).'" title="Email" class="s3-email"><img src="'.plugins_url( '../images/share-email.png' , __FILE__ ).'"></a>
							</div>'
	);

	return $service_markup_arr;

}

/**
 * @return array of social share buttons without count
 */
function mpp_ss_get_buttons_without_count_markup_arr( $id = null ) {

	if ( ! $id ) {
		return ;
	}

	$post  = get_post( $id );
	$url   = get_permalink( $post );
	$title = $post->post_title;

	$service_markup_arr = array(
		'facebook' 		=> '<a href="http://www.facebook.com/sharer.php?u='.$url.'" target="_blank" title="Share to Facebook" class="s3-facebook hint--top"></a>',
		'twitter' 		=> '<a href="http://twitter.com/intent/tweet?text='.$title.'&url='.$url.'" target="_blank"  title="Share to Twitter" class="s3-twitter hint--top"></a>',
		'googleplus' 	=> '<a href="https://plus.google.com/share?url='.$url.'" target="_blank"  title="Share to Google Plus" class="s3-google-plus hint--top"></a>',
		'digg' 			=> '<a href="http://www.digg.com/submit?url='.$url.'" target="_blank"  title="Share to Digg" class="s3-digg hint--top"></a>',
		'reddit' 		=> '<a href="http://reddit.com/submit?url='.$url.'&title='.$title.'" target="_blank" title="Share to Reddit" class="s3-reddit hint--top"></a>',
		'linkedin' 		=> '<a href="http://www.linkedin.com/shareArticle?mini=true&url='.$url.'" target="_blank" title="Share to LinkedIn" class="s3-linkedin hint--top"></a>',
		'stumbleupon'	=> '<a href="http://www.stumbleupon.com/submit?url='.$url.'&title='.$title.'" target="_blank" title="Share to StumbleUpon" class="s3-stumbleupon hint--top"></a>',
		'tumblr' 		=> '<a href="http://www.tumblr.com/share/link?url='.urlencode($url).'&name='.urlencode($title).'" target="_blank" title="Share to Tumblr" class="s3-tumblr hint--top"></a>',
		'pinterest' 	=> '<div class="pinit-btn-div"><a href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"  data-pin-color="red" title="Share to Pinterest" class="s3-pinterest hint--top"></a></div>
							<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>',
		'email' 		=> '<a href="mailto:?Subject='.str_replace(' ', '%20', $title).'&Body='.str_replace(' ', '%20', 'Here is the link to the article: '.$url).'" title="Email this article" class="s3-email hint--top"></a>'
	);

	return $service_markup_arr;
}


/**
 * @return array of social share button with count
 */
function mpp_ss_get_buttons_with_count_markup_arr( $id ) {

	if ( ! $id ) {
		return ;
	}

	$post  = get_post( $id );
	$url   = get_permalink( $post );
	$title = $post->post_title;

	$service_markup_arr = array(

		'facebook'      => '<div class="s-single-share">
								<div class="fb-share-button" data-href="'.$url.'" data-type="button_count"></div>
							</div>',
		'twitter'       => '<div class="s-single-share">
								<a href="https://twitter.com/share" class="twitter-share-button"></a>
							</div>',
		'googleplus'    => '<div class="s-single-share"><div class="g-plusone" data-size="medium"></div></div>',
		'digg'          => '',
		'reddit'        => '<div class="s-single-share"><script type="text/javascript" src="http://www.reddit.com/static/button/button1.js"></script></div>',
		'linkedin'      => '<div class="s-single-share"><script type="IN/Share" data-counter="right"></script></div>',
		'stumbleupon'   => '<div class="s-single-share"><su:badge layout="1"></su:badge></div>',
		'tumblr'        => '<div class="s-single-share"><a href="http://www.tumblr.com/share" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:61px; height:20px; background:url(\'http://platform.tumblr.com/v1/share_2.png\') top left no-repeat transparent;">Share on Tumblr</a></div>',
		'pinterest'     => '<div class="s-single-share">
								<a href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"  data-pin-color="red"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png" /></a>
								<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
							</div>',
		'email'         => '<div class="s-single-share">
								<a href="mailto:?Subject='.str_replace(' ', '%20', $title).'&Body='.str_replace(' ', '%20', 'Here is the link to the article: '.$url).'" title="Email" class="s3-email"><img src="'.plugins_url( '../images/share-email.png' , __FILE__ ).'"></a>
							</div>'
	);

	return $service_markup_arr;
}


/**
 * @return string
 */
function mpp_ss_get_html_markup( $id = null ) {

	$settings = mpp_ss_get_options();
	$class    = isset ( $settings['select-style'] ) ? $settings['select-style'] : '';

	if ( $settings['select-style'] == 'horizontal-with-count' ) {
		$service_markup_arr = mpp_ss_get_buttons_with_count_markup_arr( $id );
	} elseif ( $settings['select-style'] == 'small-buttons' ) {
		$service_markup_arr = mpp_ss_get_small_buttons_markup_arr( $id );
	} else {
		$class .= ' s-share-w-c'; //sspace is given to have space between classes when element will create
		$service_markup_arr = mpp_ss_get_buttons_without_count_markup_arr( $id );
	}

	$html_markup = '';

	foreach ( $service_markup_arr as $key => $value ) {

		if ( in_array( $key, (array) $settings['selected-services'] )  ) {
			$html_markup .= $value;
		}
	}

	return '<div id="s-share-buttons" class="'.$class.'">'.$html_markup.'</div>';

}

function mpp_ss_show_social_link() {

	$show_on = mpp_ss_get_show_on_options();
	$show = false;

	if ( mpp_is_single_media() ) {
        $show = in_array( 'media_single', $show_on ) ? true : false;
    } elseif ( mpp_is_single_gallery()  ) {
        $show = in_array( 'gallery_single', $show_on ) ? true : false;
    } elseif ( mpp_is_user_gallery_component() || mpp_is_gallery_directory() || mpp_is_group_gallery_component() ) {
        $show = in_array( 'gallery_list', $show_on ) ? true : false;
    }
    
	return apply_filters( 'mpp_ss_share_social_link', $show );

}

function mpp_ss_get_show_on_options() {

	$settings = mpp_ss_get_options();
	$show_on  = ( array ) $settings['show-on'];
	return $show_on;
}

function mpp_ss_get_excluded() {

	$settings = mpp_ss_get_options();
	$excluded = explode( ',', $settings['exclude-on'] );
	return $excluded;
}

function mpp_ss_get_position() {

	$settings = mpp_ss_get_options();
	$position = (array) $settings['select-position'];
	return $position;
}

function mpp_ss_lightbox_media_show_share_link( $show ) {

	$show = true;
	return $show;
}

function mpp_ss_lightbox_gallery_show_share_link( $show ) {

	$show = true;
	return $show;
}
