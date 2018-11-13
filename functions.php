<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 680;

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Add featured thumbnails to the index, and header.
	if ( function_exists( 'add_image_size' ) ) add_theme_support( 'post-thumbnails' );
	if ( function_exists( 'add_image_size' ) ) {
		add_image_size( 'thumb', 200, 200, true );
		add_image_size( 'home-thumbs', 390, 220, true );
		add_image_size( 'brands', 9999, 50, false );
		add_image_size( 'banners', 2000, 9999, false );
		add_image_size( 'wide', 970, 300, true );
		add_image_size( 'wide-front', 1000, 316, true );
	}

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
}
endif;

/***************************************************
/ PAGINATE
/***************************************************/

if ( ! function_exists( 'miniman_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 * Based on paging nav function from Twenty Fourteen
	 */

	function miniman_paging_nav() {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'     => $pagenum_link,
			'format'   => $format,
			'total'    => $GLOBALS['wp_query']->max_num_pages,
			'current'  => $paged,
			'mid_size' => 3,
			'add_args' => array_map( 'urlencode', $query_args ),
			'prev_text' => __( '&laquo;', 'yourtheme' ),
			'next_text' => __( '&raquo;', 'yourtheme' ),
			'type'      => 'list',
		) );

		if ( $links ) :

		?>
		<nav class="navigation paging-navigation" role="navigation">
			<?php echo $links; ?>
		</nav><!-- .navigation -->
		<?php
		endif;
	}
	endif;
/****************************************************
EXCERPTS
*****************************************************/

function cust_excerpt_length($length) {
	return 50;
}
add_filter('excerpt_length', 'cust_excerpt_length');
/* Returns a "Continue Reading" link for excerpts */
function twentyeleven_continue_reading_link() {
	return ' <a class="read-more" href="'. esc_url( get_permalink() ) . '">' . __( 'read more &raquo;', 'twentyeleven' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyeleven_continue_reading_link() */
function twentyeleven_auto_excerpt_more( $more ) {
	return '&hellip;' . twentyeleven_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyeleven_auto_excerpt_more' );


/****************************************************
ENQUEUES
*****************************************************/
function miniman_load_scripts() {

	wp_register_script( 'slick-js', get_template_directory_uri() . '/js/slick.min.js', array(),'',true  );
	wp_register_script( 'vimeo', 'https://player.vimeo.com/api/player.js', array(),'',true  );
	wp_register_script( 'site-common', get_template_directory_uri() . '/js/site-common.js', array(),'',true  );
	wp_register_style( 'main-css', get_template_directory_uri() . '/style.css','','', 'screen' );
	wp_register_style( 'slick-css', get_template_directory_uri() . '/css/slick.css','','', 'screen' );
	wp_register_style( 'muli', 'https://fonts.googleapis.com/css?family=Muli:300,400,600','','', 'screen' );

	wp_enqueue_script('jquery');
	wp_enqueue_script( 'slick-js' );
	wp_enqueue_script( 'vimeo' );
	wp_enqueue_script( 'site-common' );
	wp_enqueue_style( 'main-css' );
	wp_enqueue_style( 'slick-css' );
	wp_enqueue_style( 'muli' );
}
add_action('wp_enqueue_scripts', 'miniman_load_scripts');


/***************************************************
/ Options Pages
/***************************************************/

if(function_exists('acf_add_options_page')) {

	acf_add_options_page();
	acf_add_options_sub_page('Contact');
	acf_add_options_sub_page('Footer');

}
add_theme_support( 'title-tag' );
