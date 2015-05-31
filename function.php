<?php

// Code by Memory Slash Vision Studios - 2015 - Licence GPL v3.0 http://www.gnu.org/licenses/gpl-3.0.en.html
// v0.0.1

Function wp_schools_enqueue_scripts() {
wp_register_style( 'childstyle', get_stylesheet_directory_uri() . '/style.css'  );
wp_enqueue_style( 'childstyle' );
}
add_action( 'wp_enqueue_scripts', 'wp_schools_enqueue_scripts', 11);

function msv_shortcode_replacement( $atts, $content = null ) {
    extract(shortcode_atts(array(
    ), $atts));
	// retrive url
	$url = $atts[0];
	$out = '<div class="cookie_law_remove"><span>'.'Non potete visualizzare questo video in quanto non avete accettato l&#39;uso di cookie di terze parti nella policy cookie. Per un confort d&#39;uso vi consigliamo di autorizzare l&#39;uso dei cookies nel caso non lo desideriate potete comunque visualizzare il video direttamente sul sito dove è ospitato:<a href="'.$url.'" target="_blank"> qui</a>'.'</span></div>';
	return $out;
}

function msv_cookielaw_check() {
	if (!is_admin()){	
		// $cookievalue= isset( $_COOKIE['my-name'] ) ? $_COOKIE['my-name'] : 'not set'; // not save!! i prefer double check
		// if cookie exist store the value or the value is not yes
		if ( isset($_COOKIE["viewed_cookie_policy"])) { $cookievalue=$_COOKIE["viewed_cookie_policy"];}
		// if dont exist
		if ( !isset($_COOKIE["viewed_cookie_policy"]) || $cookievalue!='yes') {
			// debug
			//echo "<script type='text/javascript'>alert('cookienotset')</script>";
			// store original short code function TODO if is possible
			// YOUTUBE
			remove_shortcode('youtube');
			add_shortcode( 'youtube', 'msv_shortcode_replacement' );
			// VIMEO
			remove_shortcode('vimeo');
			add_shortcode( 'vimeo', 'msv_shortcode_replacement' );
			// add other short code here
		}
		else{
			// YOUTUBE
			remove_shortcode('youtube');
			// reset to jetpack original shortcode
			add_shortcode( 'youtube', 'youtube_shortcode');
			// VIMEO
			remove_shortcode('vimeo');
			// reset to jetpack original shortcode
			add_shortcode( 'vimeo', 'vimeo_shortcode');
			// add other short code here
		}
	}	
}

add_action('init', 'msv_cookielaw_check');
