<?php
/*
 * Plugin Name: Site Functions
 * Description: Adds specific content functions to the current site. Please make sure this plugin stays activated.
 * Plugin URI: http://miniman-webdesign.co.uk
 * Version: 1.0
 * Author: Mike @ Miniman
 * Author URI: http://miniman-webdesign.co.uk
 * License: Private
*/


/***************************************************
/ GRABBING PARENT PAGE ID
/***************************************************/

function is_tree($pid) {      // $pid = The ID of the page we're looking for pages underneath
	global $post;         // load details about this page
	if(is_page()&&($post->post_parent==$pid||is_page($pid)))
               return true;   // we're at the page or at a sub page
	else
               return false;  // we're elsewhere
};


/* ------------------------------------------------------------------*/
/* Odd and Even Class
/* ------------------------------------------------------------------*/
function oddeven_post_class ( $classes ) {
   global $current_class;
   $classes[] = $current_class;
   $current_class = ($current_class == 'odd') ? 'even' : 'odd';
   return $classes;
}
add_filter ( 'post_class' , 'oddeven_post_class' );
global $current_class;
$current_class = 'odd';

/* ------------------------------------------------------------------*/
/* CURRENT TEMPLATE ID */
/* ------------------------------------------------------------------*/
add_filter( 'template_include', 'var_template_id', 1000 );
function var_template_id( $t ){
    $GLOBALS['current_template_id'] = basename($t);
    return $t;
}

function get_template_id( $echo = false ) {
    if( !isset( $GLOBALS['current_template_id'] ) )
        return false;
    if( $echo )
        echo $GLOBALS['current_template_id'];
    else
        return $GLOBALS['current_template_id'];
}

/* ------------------------------------------------------------------*/
/* RESPONSIVE IMAGES */
/* ------------------------------------------------------------------*/

add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
function remove_thumbnail_dimensions( $html ) {
$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
return $html; }


/* RD Blog Tab Fix */
function rd_fix_blog_tab_on_cpt($classes, $item, $args) {
  if (!is_singular('post') && !is_category() && !is_tag()) {
    $blog_page_id = intval(get_option('page_for_posts'));
    if ($blog_page_id != 0) {
      if ($item->object_id == $blog_page_id) {
        unset($classes[array_search('current_page_parent', $classes)]);
      }
    }
  }
  return $classes;
}

add_filter('nav_menu_css_class', 'rd_fix_blog_tab_on_cpt', 10, 3);

function ptobr($string)
{
return preg_replace("/<\/p>[^<]*<p>/", "<br /><br />", $string);
}

function stripp($string)
{
return preg_replace('/(<p>|<\/p>)/i','',$string) ;
}
add_filter('wp_nav_menu_args', 'prefix_nav_menu_args');
function prefix_nav_menu_args($args = ''){
    $args['container'] = false;
    return $args;
}
// Removes ul class from wp_nav_menu
function remove_ul ( $menu ){
    return preg_replace( array( '#^<ul[^>]*>#', '#</ul>$#' ), '', $menu );
}
add_filter( 'wp_nav_menu', 'remove_ul' );

/***************************************************
/ Site Navigation Menus
/***************************************************/

if ( function_exists( 'register_nav_menus' ) ) {
  	register_nav_menus(
  		array(
			'main_menu' => 'Main Menu',
			'footer_menu' => 'Footer Menu'
  		)
  	);
}

/***************************************************
/ HTML5 Placeholders for comments form
/***************************************************/
function my_update_fields($fields) {

	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$fields['author'] =
		'<p class="comment-form-author">
			<input required minlength="3" maxlength="30" placeholder="Your Name*" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
    '" size="30"' . $aria_req . ' />
    	</p>';

    $fields['email'] =
    	'<p class="comment-form-email">
    		<input required placeholder="Your Email*" id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    '" size="30"' . $aria_req . ' />
    	</p>';

	$fields['url'] =
		'<p class="comment-form-url">
			<input placeholder="Your URL" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
    '" size="30" />
    	</p>';

	return $fields;
}

add_filter('comment_form_default_fields','my_update_fields');

function my_update_comment_field($comment_field) {

	$comment_field =
		'<p class="comment-form-comment">
			<textarea required placeholder="Enter Your Comment…" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
		</p>';

	return $comment_field;
}
add_filter('comment_form_field_comment','my_update_comment_field');

/***************************************************
/ ADD PARENT SLUG TO BODY CLASS
/***************************************************/

add_filter('body_class','body_class_section');

function body_class_section($classes) {
    global $wpdb, $post;
    if (is_page()) {
        if ($post->post_parent) {
            $parent  = end(get_post_ancestors($current_page_id));
        } else {
            $parent = $post->ID;
        }
        $post_data = get_post($parent, ARRAY_A);
        $classes[] = 'parent-' . $post_data['post_name'];
    }
    return $classes;
}
/***************************************************
/ Page Slug Body Class
/***************************************************/

function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );
/****************************************************
GALLERIES
*****************************************************/

/* Remove inline styles printed when the gallery shortcode is used. */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :

/****************************************************
COMMENTS
*****************************************************/

/* Template for comments and pingbacks. */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'twentyten'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;


/* Removes the default styles that are packaged with the Recent Comments widget */
function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :

/* Prints HTML with meta information for the current post—date/time and author */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/* Prints HTML with meta information for the current post (category, tags and permalink) */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

/* Sponsors CPT */
add_action( 'init', 'register_cpt_videos' );
function register_cpt_videos() {

    $labels = array( 
        'name' => _x( 'Videos', 'videos' ),
        'singular_name' => _x( 'Video', 'videos' ),
        'add_new' => _x( 'Add New Video', 'videos' ),
        'add_new_item' => _x( 'Add New Video', 'videos' ),
        'edit_item' => _x( 'Edit Video', 'videos' ),
        'new_item' => _x( 'New Video', 'videos' ),
        'view_item' => _x( 'View Video', 'videos' ),
        'search_items' => _x( 'Search videos', 'videos' ),
        'not_found' => _x( 'No videos found', 'videos' ),
        'not_found_in_trash' => _x( 'No videos found in bin', 'videos' ),
        'parent_item_colon' => _x( 'Parent Videos:', 'videos' ),
        'menu_name' => _x( 'Videos', 'videos' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Post type for videos',
        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'capability_type' => 'post',
		'menu_icon' => 'dashicons-format-video',
		'taxonomies' => array( 'collections, industry'),
    );

    register_post_type( 'videos', $args );
}

/***************************************************
/ Videos "type" taxonomy
/***************************************************/
//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'mb_collections_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts

function mb_collections_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

  $labels = array(
    'name' => _x( 'Collections', 'taxonomy general name' ),
    'singular_name' => _x( 'Collection', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Collections' ),
    'all_items' => __( 'All Collections' ),
    'parent_item' => __( 'Parent Collections' ),
    'parent_item_colon' => __( 'Parent Collections:' ),
    'edit_item' => __( 'Edit Collection' ), 
    'update_item' => __( 'Update Collection' ),
    'add_new_item' => __( 'Add New Collection' ),
    'new_item_name' => __( 'New Collection Name' ),
    'menu_name' => __( 'Collections' ),
  ); 	

// Now register the taxonomy

  register_taxonomy('collections',array('videos'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'type' ),
	'show_in_nav_menus' => true
  ));

}

/***************************************************
/ Videos "Industry" taxonomy
/***************************************************/
//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'mb_industry_taxonomy', 0 );

//create a custom taxonomy name it topics for your posts

function mb_industry_taxonomy() {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

  $labels = array(
    'name' => _x( 'Industry', 'taxonomy general name' ),
    'singular_name' => _x( 'Industry', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Industries' ),
    'all_items' => __( 'All Industries' ),
    'parent_item' => __( 'Parent Industry' ),
    'parent_item_colon' => __( 'Parent Industry:' ),
    'edit_item' => __( 'Edit Industry' ), 
    'update_item' => __( 'Update Industry' ),
    'add_new_item' => __( 'Add New Industry' ),
    'new_item_name' => __( 'New Industry Name' ),
    'menu_name' => __( 'Industry' ),
  ); 	

// Now register the taxonomy

  register_taxonomy('industry',array('videos'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'industry' ),
	'show_in_nav_menus' => true
  ));

}

/*-------------------------------------------------------------------------------
	Custom Columns
-------------------------------------------------------------------------------*/

function my_page_columns($columns)
{
	$columns = array(
		'cb'	 	=> '<input type="checkbox" />',
		'thumbnail'	=>	'Thumbnail',
		'title' 	=> 'Title',
		'industry' => __('Industry'),
		'collections' => __('Collection'),
		'featured' 	=> 'Featured',
		'date'		=>	'Date',
	);
	return $columns;
}

function my_custom_columns($column)
{
	global $post;
	if($column == 'thumbnail')
	{
		if(get_the_post_thumbnail()):
		echo the_post_thumbnail( 'thumbnail' );
		else:
		echo "N/A";
		endif;
	}
	elseif($column == 'featured')
	{
		if(get_field('used_in_default_display'))
		{
			echo '&#10004;';
		}
		else
		{
			echo '';
		}
	}
	elseif($column == 'collections')
	{
		//
			/* Get the genres for the post. */
			$terms = get_the_terms( $post_id, 'collections' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'collections' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'collections', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( '-' );
			}

		//
	}
	
	elseif($column == 'industry')
	{
		//
			/* Get the genres for the post. */
			$terms = get_the_terms( $post_id, 'industry' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'industry' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'industry', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( '-' );
			}

		//
	}
}

add_filter("manage_videos_posts_columns", "my_page_columns");
add_action("manage_videos_posts_custom_column", "my_custom_columns");