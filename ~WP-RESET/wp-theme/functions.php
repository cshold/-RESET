<?php

if ( ! isset( $content_width ) )
	$content_width = 640;
	
add_action( 'after_setup_theme', 'wptheme_setup' );
if ( ! function_exists( 'wptheme_setup' ) ):

function wptheme_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'wptheme', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );


	// Set up post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true );
	add_image_size( 'slider-thumb', 411, 200, true );

}
endif;


// set up the page titles
function wptheme_filter_wp_title( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	global $paged, $page;
	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( __( 'Search results for %s', 'wptheme' ), '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'wptheme' ), $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'wptheme' ), max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'wptheme_filter_wp_title', 10, 2 );

// set excerpt length and 'continue reading' links
function wptheme_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'wptheme_excerpt_length' );
function wptheme_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wptheme' ) . '</a>';
}
function wptheme_auto_excerpt_more( $more ) {
	return ' &hellip;' . wptheme_continue_reading_link();
}
add_filter( 'excerpt_more', 'wptheme_auto_excerpt_more' );

// add 'continue reading' links to custom post types
function wptheme_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= wptheme_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'wptheme_custom_excerpt_more' );


// register sidebar
if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}

// only include some body classes
function my_body_class($wp_classes, $extra_classes) {
    // List of the only WP generated classes allowed
    $whitelist = array('page', 'home', 'post', 'error404', 'archive');
    // Filter the body classes
    $wp_classes = array_intersect($wp_classes, $whitelist);
    // Add the extra classes back untouched
    return array_merge($wp_classes, (array) $extra_classes);
}
add_filter('body_class', 'my_body_class', 10, 2);


// change Search Form input type from "text" to "search" and add placeholder text
function wptheme_search_form ( $form ) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<div><label class="screen-reader-text" title="search" for="s">' . __('Search for:') . '</label>
	<input type="search" value="' . get_search_query() . '" name="s" id="s" />
	<p id="searchsubmit"  />
	</div>
	</form>';
	return $form;
}
add_filter( 'get_search_form', 'wptheme_search_form' );


// youtube embed shortcode
function cwc_youtube($atts) {
	extract(shortcode_atts(array(
		"value" => 'http://',
		"width" => '374',
		"height" => '235',
		"name"=> 'movie',
		"allowFullScreen" => 'true',
		"allowScriptAccess"=>'always',
	), $atts));
return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" allowfullscreen src="'.$value.'?showinfo=0&amp;rel=0"></iframe>';
}
add_shortcode("youtube", "cwc_youtube");


// language list for WPML plugin
// function languages_list_footer(){
//     $languages = icl_get_languages('orderby=code');
//     if(!empty($languages)){
//         echo '<div id="lang-toggle">';
//         foreach($languages as $l){
//             if(!$l['active']) echo '<a href="'.$l['url'].'">';
//             if(!$l['active']) echo icl_disp_language($l['native_name'], NULL);
//             if(!$l['active']) echo '</a>';
//         }
//         echo '</div>';
//     }
// }
// add_filter('get_langs','languages_list_footer');

include('inc/admin-overrides.php');

?>