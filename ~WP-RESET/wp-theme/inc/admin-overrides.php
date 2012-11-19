<?

//***************
	// This page customizes some of the generic WordPress features
//***************


// Change admin login logo (16x16)
function my_custom_login_logo() {
	echo '<style type="text/css"> h1 a { background-image:url('.get_bloginfo('template_directory').'/img/login-logo.png) !important; } </style>';
}
add_action('login_head', 'my_custom_login_logo');


// Change the admin logo (326x67)
add_action('admin_head', 'my_custom_logo');
function my_custom_logo() {
   echo '
      <style type="text/css">
         #header-logo { background-image: url('.get_bloginfo('template_directory').'/img/backend-logo.png) !important; }
      </style>
   ';
}


// Change the admin footer text
function remove_footer_admin () {
    echo "Created by <a href='http://taxi.ca'>TAXI Canada</a> | <a href='http://codex.wordpress.org/'>Wordpress Documentation</a>";
}
add_filter('admin_footer_text', 'remove_footer_admin');


// Disable RSS feeds
function fb_disable_feed() {
	wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
}
add_action('do_feed', 'fb_disable_feed', 1);
add_action('do_feed_rdf', 'fb_disable_feed', 1);
add_action('do_feed_rss', 'fb_disable_feed', 1);
add_action('do_feed_rss2', 'fb_disable_feed', 1);
add_action('do_feed_atom', 'fb_disable_feed', 1);

// Remove links and WordPress version number altogether
remove_action( 'wp_head', 'feed_links' );
remove_action( 'wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'index_rel_link');
remove_action( 'wp_head', 'parent_post_rel_link');
remove_action( 'wp_head', 'start_post_rel_link');
remove_action( 'wp_head', 'adjacent_posts_rel_link');
remove_action( 'wp_head', 'wp_generator');


add_filter('the_content_feed', 'rss_post_thumbnail');
function rss_post_thumbnail($content) {
	global $post;
	if( has_post_thumbnail($post->ID) )
		$content = '<p>' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</p>' . $content;
	return $content;
}


// Disable search functionality
// function fb_filter_query( $query, $error = true ) {
// if ( is_search() ) {
// 	$query->is_search = false;
// 	$query->query_vars[s] = false;
// 	$query->query[s] = false;
// 
// 	// to error
// 	if ( $error == true )
// 		$query->is_404 = true;
// 	}
// }
// add_action( 'parse_query', 'fb_filter_query' );
// add_filter( 'get_search_form', create_function( '$a', "return null;" ) );

?>