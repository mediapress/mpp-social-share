<?php

/**
 * Get all settings
 *
 * @return mixed|array
 */
function mppss_get_settings() {
	return get_option( 'mppss-settings', array() );
}

/**
 * Get array of services small buttons
 *
 * @param $id
 *
 * @return array
 */
function mppss_get_small_buttons( $id = null ) {

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
 * Get array of services without count
 *
 * @param $id
 *
 * @return array
 */
function mppss_get_buttons_without_count( $id = null ) {

	if ( ! $id ) {
		return;
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
 * Get array of services with count
 *
 * @param $id
 *
 * @return array
 */
function mppss_get_buttons_with_count( $id ) {

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
 * Get MarkUp
 *
 * @param int $id Media or Gallery id.
 *
 * @return string
 */
function mppss_get_html_markup( $id = null ) {

	$settings = mppss_get_settings();
	$class    = isset ( $settings['select-style'] ) ? $settings['select-style'] : '';

	if ( $settings['select-style'] == 'horizontal-with-count' ) {
		$service_markup_arr = mppss_get_buttons_with_count( $id );
	} elseif ( $settings['select-style'] == 'small-buttons' ) {
		$service_markup_arr = mppss_get_small_buttons( $id );
	} else {
		$class              .= ' s-share-w-c'; //sspace is given to have space between classes when element will create
		$service_markup_arr = mppss_get_buttons_without_count( $id );
	}

	$html_markup = '';

	foreach ( $service_markup_arr as $key => $value ) {
		if ( in_array( $key, (array) $settings['selected-services'] ) ) {
			$html_markup .= $value;
		}
	}

	return '<div id="s-share-buttons" class="' . $class . '">' . $html_markup . '</div>';
}
