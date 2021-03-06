<?php
/**
 * MayDuganGiveCamp13 functions and definitions
 *
 * @package MayDuganGiveCamp13
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'maydugangivecamp13_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function maydugangivecamp13_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on MayDuganGiveCamp13, use a find and replace
	 * to change 'maydugangivecamp13' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'maydugangivecamp13', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'maydugangivecamp13' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'maydugangivecamp13_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // maydugangivecamp13_setup
add_action( 'after_setup_theme', 'maydugangivecamp13_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function maydugangivecamp13_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'maydugangivecamp13' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'maydugangivecamp13_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function maydugangivecamp13_scripts() {
	wp_enqueue_style( 'maydugangivecamp13-style', get_stylesheet_uri() );

	wp_enqueue_script( 'maydugangivecamp13-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'maydugangivecamp13-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'maydugangivecamp13-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'maydugangivecamp13_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

// 
// 
// 
// May Dugan Custom Scripts

// Custom Post Type for stories
function MD_story_postType(){
	$labels = array(
		'name'               => __( 'Stories'),
		'singular_name'      => __( 'Story'),
		'add_new'            => __( 'Add New Story'),
		'add_new_item'       => __( 'Add New Story'),
		'edit_item'          => __( 'Edit Story' ),
		'new_item'           => __( 'New Story' ),
		'all_items'          => __( 'All Stories' ),
		'view_item'          => __( 'View Story' ),
		'search_items'       => __( 'Search Story' ),
		'not_found'          => __( 'No Story found' ),
		'not_found_in_trash' => __( 'No Story found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Story'
	);
	$args = array(
		'labels'        => $labels,
		'public'        => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'_builtin' => false,
		'query_var' => true,
		'supports'      => array( 'title', 'editor', 'category'),
		'menu_position' => 5,
		'capability_type' => 'post',
		'hierarchical' => false,
		'has_archive'   => true,
		'taxonomies' => array('post_tag')
		// 'register_meta_box_cb' => 'add_MD_story_metaBoxes'
	);

	register_post_type('story', $args);
}
add_action('init', 'MD_story_postType');

function remove_taxonomy_boxes() {
	remove_meta_box('tagsdiv-storyType', 'story', 'side');
}
add_action( 'admin_menu' , 'remove_taxonomy_boxes' );

function add_custom_taxonomies() {
	// Add new taxonomy to Posts
	register_taxonomy('storyType', 'story', array(
		// Hierarchical taxonomy (like categories)
		'hierarchical' => false,
		// This array of options controls the labels displayed in the WordPress Admin UI
		'labels' => array(
			'name' => _x( 'Story Types', 'taxonomy general name' ),
			'singular_name' => _x( 'Story Type', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Story Types' ),
			'all_items' => __( 'All Story Types' ),
			'parent_item' => __( 'Parent Story Type' ),
			'parent_item_colon' => __( 'Parent Story Type:' ),
			'edit_item' => __( 'Edit Story Type' ),
			'update_item' => __( 'Update Story Type' ),
			'add_new_item' => __( 'Add New Story Type' ),
			'new_item_name' => __( 'New Story Type Name' ),
			'menu_name' => __( 'Story Types' ),
		),
		// Control the slugs used for this taxonomy
		'rewrite' => array(
			'slug' => 'story-type', // This controls the base slug that will display before each term
			'with_front' => false, // Don't display the category base before "/locations/"
			'hierarchical' => false // This will allow URL's like "/locations/boston/cambridge/"
		),
	));
}
add_action( 'init', 'add_custom_taxonomies', 0 );

?>