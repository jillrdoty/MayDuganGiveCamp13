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
// 
// Adding custom javascript for front end and admin pages
// if(is_admin()) {
//    	$ss_url = get_template_directory_uri();
// 	wp_enqueue_script( 'DAS-scripts', "{$ss_url}/js/DAS-admin.js" );
// }
// function DAS_enqueue(){
// 	$ss_url = get_template_directory_uri();
//   	wp_enqueue_script( 'DAS-scripts', "{$ss_url}/js/DAS-scripts.js" );
// }
// add_action('wp_enqueue_scripts','DAS_enqueue');

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


define( 'CUSTOM_METABOXES_DIR', get_template_directory_uri() . '/metaboxes' );

/*
 * recives data about a form field and spits out the proper html
 *
 * @param	array					$field			array with various bits of information about the field
 * @param	string|int|bool|array	$meta			the saved data for this field
 * @param	array					$repeatable		if is this for a repeatable field, contains parant id and the current integar
 *
 * @return	string									html for the field
 */
function custom_meta_box_field( $field, $meta = null, $repeatable = null ) {
	if ( ! ( $field || is_array( $field ) ) )
		return;

	// get field data
	$type = isset( $field['type'] ) ? $field['type'] : null;
	$label = isset( $field['label'] ) ? $field['label'] : null;
	$desc = isset( $field['desc'] ) ? '<span class="description">' . $field['desc'] . '</span>' : null;
	$place = isset( $field['place'] ) ? $field['place'] : null;
	$size = isset( $field['size'] ) ? $field['size'] : null;
	$post_type = isset( $field['post_type'] ) ? $field['post_type'] : null;
	$options = isset( $field['options'] ) ? $field['options'] : null;
	$multiple = isset( $field['multiple'] ) ? $field['multiple'] : null;
	$required = isset( $field['required'] ) ? $field['required'] : null;
	$settings = isset( $field['settings'] ) ? $field['settings'] : null;
	$repeatable_fields = isset( $field['repeatable_fields'] ) ? $field['repeatable_fields'] : null;

	// the id and name for each field
	$id = $name = isset( $field['id'] ) ? $field['id'] : null;
	if ( $repeatable ) {
		$name = $repeatable[0] . '[' . $repeatable[1] . '][' . $id .']';
		$id = $repeatable[0] . '_' . $repeatable[1] . '_' . $id;
	}
	switch( $type ) {
		// basic
		case 'text':
		case 'tel':
		case 'email':
		default:
			echo '<input type="' . $type . '" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_attr( $meta ) . '" class="regular-text" size="30" />
					<br />' . $desc;
		break;
		case 'url':
			echo '<input type="' . $type . '" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . esc_url( $meta ) . '" class="regular-text" size="30" />
					<br />' . $desc;
		break;
		case 'number':
			echo '<input type="' . $type . '" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . intval( $meta ) . '" class="regular-text" size="30" />
					<br />' . $desc;
		break;
		// textarea
		case 'textarea':
			echo '<textarea name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" cols="60" rows="4">' . esc_textarea( $meta ) . '</textarea>
					<br />' . $desc;
		break;
		// editor
		case 'editor':
			echo wp_editor( $meta, $id, $settings ) . '<br />' . $desc;
		break;
		// checkbox
		case 'checkbox':
			echo '<input type="checkbox" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" ' . checked( $meta, true, false ) . ' value="1" />
					<label for="' . esc_attr( $id ) . '">' . $desc . '</label>';
		break;
		// select, chosen
		case 'select':
		case 'chosen':
			echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '"' , $type == 'chosen' ? ' class="chosen"' : '' , isset( $multiple ) && $multiple == true ? ' multiple="multiple"' : '' , '>';
					if (!(isset( $required ) && $required == true)) echo '<option value="">Select One</option>';
			foreach ( $options as $option )
				echo '<option' . selected( $meta, $option['value'], false ) . ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
			echo '</select><br />' . $desc;
		break;
		// radio
		case 'radio':
			echo '<ul class="meta_box_items">';
			foreach ( $options as $option )
				echo '<li><input type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '-' . $option['value'] . '" value="' . $option['value'] . '" ' . checked( $meta, $option['value'], false ) . ' />
						<label for="' . esc_attr( $id ) . '-' . $option['value'] . '">' . $option['label'] . '</label></li>';
			echo '</ul>' . $desc;
		break;
		// checkbox_group
		case 'checkbox_group':
			echo '<ul class="meta_box_items">';
			foreach ( $options as $option )
				echo '<li><input type="checkbox" value="' . $option['value'] . '" name="' . esc_attr( $name ) . '[]" id="' . esc_attr( $id ) . '-' . $option['value'] . '"' , is_array( $meta ) && in_array( $option['value'], $meta ) ? ' checked="checked"' : '' , ' />
						<label for="' . esc_attr( $id ) . '-' . $option['value'] . '">' . $option['label'] . '</label></li>';
			echo '</ul>' . $desc;
		break;
		// color
		case 'color':
			$meta = $meta ? $meta : '#';
			echo '<input type="text" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . $meta . '" size="10" />
				<br />' . $desc;
			echo '<div id="colorpicker-' . esc_attr( $id ) . '"></div>
				<script type="text/javascript">
				jQuery(function(jQuery) {
					jQuery("#colorpicker-' . esc_attr( $id ) . '").hide();
					jQuery("#colorpicker-' . esc_attr( $id ) . '").farbtastic("#' . esc_attr( $id ) . '");
					jQuery("#' . esc_attr( $id ) . '").bind("blur", function() { jQuery("#colorpicker-' . esc_attr( $id ) . '").slideToggle(); } );
					jQuery("#' . esc_attr( $id ) . '").bind("focus", function() { jQuery("#colorpicker-' . esc_attr( $id ) . '").slideToggle(); } );
				});
				</script>';
		break;
		// post_select, post_chosen
		case 'post_select':
		case 'post_list':
		case 'post_chosen':
			echo '<select data-placeholder="Select One" name="' . esc_attr( $name ) . '[]" id="' . esc_attr( $id ) . '"' , $type == 'post_chosen' ? ' class="chosen"' : '' , isset( $multiple ) && $multiple == true ? ' multiple="multiple"' : '' , '>
					<option value=""></option>'; // Select One
			$posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'name', 'order' => 'ASC' ) );
			foreach ( $posts as $item )
				echo '<option value="' . $item->ID . '"' . selected( is_array( $meta ) && in_array( $item->ID, $meta ), true, false ) . '>' . $item->post_title . '</option>';
			$post_type_object = get_post_type_object( $post_type );
			echo '</select> &nbsp;<span class="description"><a href="' . admin_url( 'edit.php?post_type=' . $post_type . '">Manage ' . $post_type_object->label ) . '</a></span><br />' . $desc;
		break;
		// post_checkboxes
		case 'post_checkboxes':
			$posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1 ) );
			echo '<ul class="meta_box_items">';
			foreach ( $posts as $item )
				echo '<li><input type="checkbox" value="' . $item->ID . '" name="' . esc_attr( $name ) . '[]" id="' . esc_attr( $id ) . '-' . $item->ID . '"' , is_array( $meta ) && in_array( $item->ID, $meta ) ? ' checked="checked"' : '' , ' />
						<label for="' . esc_attr( $id ) . '-' . $item->ID . '">' . $item->post_title . '</label></li>';
			$post_type_object = get_post_type_object( $post_type );
			echo '</ul> ' . $desc , ' &nbsp;<span class="description"><a href="' . admin_url( 'edit.php?post_type=' . $post_type . '">Manage ' . $post_type_object->label ) . '</a></span>';
		break;
		// post_drop_sort
		case 'post_drop_sort':
			//areas
			$post_type_object = get_post_type_object( $post_type );
			echo '<p>' . $desc . ' &nbsp;<span class="description"><a href="' . admin_url( 'edit.php?post_type=' . $post_type . '">Manage ' . $post_type_object->label ) . '</a></span></p><div class="post_drop_sort_areas">';
			foreach ( $areas as $area ) {
				echo '<ul id="area-' . $area['id']  . '" class="sort_list">
						<li class="post_drop_sort_area_name">' . $area['label'] . '</li>';
						if ( is_array( $meta ) ) {
							$items = explode( ',', $meta[$area['id']] );
							foreach ( $items as $item ) {
								$output = $display == 'thumbnail' ? get_the_post_thumbnail( $item, array( 204, 30 ) ) : get_the_title( $item );
								echo '<li id="' . $item . '">' . $output . '</li>';
							}
						}
				echo '</ul>
					<input type="hidden" name="' . esc_attr( $name ) . '[' . $area['id'] . ']"
					class="store-area-' . $area['id'] . '"
					value="' , $meta ? $meta[$area['id']] : '' , '" />';
			}
			echo '</div>';
			// source
			$exclude = null;
			if ( !empty( $meta ) ) {
				$exclude = implode( ',', $meta ); // because each ID is in a unique key
				$exclude = explode( ',', $exclude ); // put all the ID's back into a single array
			}
			$posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'post__not_in' => $exclude ) );
			echo '<ul class="post_drop_sort_source sort_list">
					<li class="post_drop_sort_area_name">Available ' . $label . '</li>';
			foreach ( $posts as $item ) {
				$output = $display == 'thumbnail' ? get_the_post_thumbnail( $item->ID, array( 204, 30 ) ) : get_the_title( $item->ID );
				echo '<li id="' . $item->ID . '">' . $output . '</li>';
			}
			echo '</ul>';
		break;
		// tax_select
		case 'tax_select':
		case 'tax_chosen':
			echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '"', $type == 'tax_chosen' ? ' class="chosen"' : '', isset( $multiple ) && $multiple == true ? ' multiple="multiple"' : '', '>'; // Select One
			if (!(isset( $multiple ) && $multiple == true)) echo '<option value="">Select One</option>';
			$terms = get_terms( $id, 'get=all' );
			$post_terms = wp_get_object_terms( get_the_ID(), $id );

			$taxonomy = get_taxonomy( $id );
			$selected = $post_terms ? $taxonomy->hierarchical ? $post_terms[0]->term_id : $post_terms[0]->slug : null;
			foreach ( $terms as $term ) {
				$term_value = $taxonomy->hierarchical ? $term->term_id : $term->slug;
				echo '<option value="' . $term_value . '"' . selected( $selected, $term_value, false ) . '>' . $term->name . '</option>';
			}
			echo '</select>
				<br /> '. $desc;
				// <div class="statusMessage sendingMessage"><p>Sending your message. Please wait...</p></div>
				// <form id="new'.$field['label'].'" class="submitTaxRequest" action="submitTaxonomy.php" method="post">
				// <input type="text" id="newTaxonomy" name="newTaxonomy" placeholder="New '.$field['label'].'" required="required" />
				// <input type="hidden" id="taxonomy" name="taxonomy" value="'.$field['label'].'" />
				// <input type="submit" class="request-taxonomy" value="Send Request" />
				// </form>';
		break;

		// tax_checkboxes
		case 'tax_checkboxes':
			$terms = get_terms( $id, 'get=all' );
			$post_terms = wp_get_object_terms( get_the_ID(), $id );
			$taxonomy = get_taxonomy( $id );
			$checked = $post_terms ? $taxonomy->hierarchical ? $post_terms[0]->term_id : $post_terms[0]->slug : null;
			foreach ( $terms as $term ) {
				$term_value = $taxonomy->hierarchical ? $term->term_id : $term->slug;
				echo '<input type="checkbox" value="' . $term_value . '" name="' . $id . '[]" id="term-' . $term_value . '"' . checked( $checked, $term_value, false ) . ' /> <label for="term-' . $term_value . '">' . $term->name . '</label><br />';
			}
			echo '<span class="description">' . $field['desc'] . ' <a href="'.get_bloginfo( 'url' ) . '/wp-admin/edit-tags.php?taxonomy=' . $id . '&post_type=' . $page . '">Manage ' . $taxonomy->label . '</a></span>';
		break;
		// date
		case 'date':
			echo '<input type="text" class="datepicker" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . $meta . '" size="30" />
					<br />' . $desc;
		break;
		// slider
		case 'slider':
		$value = $meta != '' ? intval( $meta ) : '0';
			echo '<div id="' . esc_attr( $id ) . '-slider"></div>
					<input type="text" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="' . $value . '" size="5" />
					<br />' . $desc;
		break;
		// image
		case 'image':
			$image = CUSTOM_METABOXES_DIR . '/images/image.png';
			echo '<div class="meta_box_image"><span class="meta_box_default_image" style="display:none">' . $image . '</span>';
			if ( $meta ) {
				$image = wp_get_attachment_image_src( intval( $meta ), 'medium' );
				$image = $image[0];
			}
			echo	'<input name="' . esc_attr( $name ) . '" type="hidden" class="meta_box_upload_image" value="' . intval( $meta ) . '" />
						<img src="' . esc_attr( $image ) . '" class="meta_box_preview_image" alt="" />
							<a href="#" class="meta_box_upload_image_button button" rel="' . get_the_ID() . '">Choose Image</a>
							<small>&nbsp;<a href="#" class="meta_box_clear_image_button">Remove Image</a></small></div>
							<br clear="all" />' . $desc;
		break;
		// file
		case 'file':
			$iconClass = 'meta_box_file';
			if ( $meta ) $iconClass .= ' checked';
			echo	'<div class="meta_box_file_stuff"><input name="' . esc_attr( $name ) . '" type="hidden" class="meta_box_upload_file" value="' . esc_url( $meta ) . '" />
						<span class="' . $iconClass . '"></span>
						<span class="meta_box_filename">' . esc_url( $meta ) . '</span>
							<a href="#" class="meta_box_upload_file_button button" rel="' . get_the_ID() . '">Choose File</a>
							<small>&nbsp;<a href="#" class="meta_box_clear_file_button">Remove File</a></small></div>
							<br clear="all" />' . $desc;
		break;
		// repeatable
		case 'repeatable':
			echo '<table id="' . esc_attr( $id ) . '-repeatable" class="meta_box_repeatable" cellspacing="0">
				<tbody>';
			$i = 0;
			// create an empty array
			if ( $meta == '' || $meta == array() ) {
				$keys = wp_list_pluck( $repeatable_fields, 'id' );
				$meta = array ( array_fill_keys( $keys, null ) );
			}
			$meta = array_values( $meta );
			foreach( $meta as $row ) {
				echo '<tr>
						<td><span class="sort hndle"></span></td><td>';
				foreach ( $repeatable_fields as $repeatable_field ) {
					if ( ! array_key_exists( $repeatable_field['id'], $meta[$i] ) )
						$meta[$i][$repeatable_field['id']] = null;
					echo '<label>' . $repeatable_field['label']  . '</label><p>';
					echo custom_meta_box_field( $repeatable_field, $meta[$i][$repeatable_field['id']], array( $id, $i ) );
					echo '</p>';
				} // end each field
				echo '</td><td><a class="meta_box_repeatable_remove" href="#"></a></td></tr>';
				$i++;
			} // end each row
			echo '</tbody>';
			echo '
				<tfoot>
					<tr>
						<th></th>
						<th></th>
						<th><a class="meta_box_repeatable_add" href="#"></a></th>
					</tr>
				</tfoot>';
			echo '</table>
				' . $desc;
		break;
	} //end switch
}

/*
 * Finds any item in any level of an array
 *
 * @param	string	$needle 	field type to look for
 * @param	array	$haystack	an array to search the type in
 *
 * @return	bool				whether or not the type is in the provided array
 */
function meta_box_find_field_type( $needle, $haystack ) {
	foreach ( $haystack as $h )
		if ( isset( $h['type'] ) && $h['type'] == 'repeatable' )
			return meta_box_find_field_type( $needle, $h['repeatable_fields'] );
		elseif ( ( isset( $h['type'] ) && $h['type'] == $needle ) || ( isset( $h['repeatable_type'] ) && $h['repeatable_type'] == $needle ) )
			return true;
	return false;
}

/*
 * Find repeatable
 *
 * This function does almost the same exact thing that the above function
 * does, except we're exclusively looking for the repeatable field. The
 * reason is that we need a way to look for other fields nested within a
 * repeatable, but also need a way to stop at repeatable being true.
 * Hopefully I'll find a better way to do this later.
 *
 * @param	string	$needle 	field type to look for
 * @param	array	$haystack	an array to search the type in
 *
 * @return	bool				whether or not the type is in the provided array
 */
function meta_box_find_repeatable( $needle = 'repeatable', $haystack ) {
	foreach ( $haystack as $h )
		if ( isset( $h['type'] ) && $h['type'] == $needle )
			return true;
	return false;
}

/*
 * sanitize boolean inputs
 */
function meta_box_santitize_boolean( $string ) {
	if ( ! isset( $string ) || $string != 1 || $string != true )
		return false;
	else
		return true;
}

/*
 * outputs properly sanitized data
 *
 * @param	string	$string		the string to run through a validation function
 * @param	string	$function	the validation function
 *
 * @return						a validated string
 */
function meta_box_sanitize( $string, $function = 'sanitize_text_field' ) {
	switch ( $function ) {
		case 'intval':
			return intval( $string );
		case 'absint':
			return absint( $string );
		case 'wp_kses_post':
			return wp_kses_post( $string );
		case 'wp_kses_data':
			return wp_kses_data( $string );
		case 'esc_url_raw':
			return esc_url_raw( $string );
		case 'is_email':
			return is_email( $string );
		case 'sanitize_title':
			return sanitize_title( $string );
		case 'santitize_boolean':
			return santitize_boolean( $string );
		case 'sanitize_text_field':
		default:
			return sanitize_text_field( $string );
	}
}

/*
 * Map a multideminsional array
 *
 * @param	string	$func		the function to map
 * @param	array	$meta		a multidimensional array
 * @param	array	$sanitizer	a matching multidimensional array of sanitizers
 *
 * @return	array				new array, fully mapped with the provided arrays
 */
function meta_box_array_map_r( $func, $meta, $sanitizer ) {

	$newMeta = array();
	$meta = array_values( $meta );

	foreach( $meta as $key => $array ) {
		if ( $array == '' )
			continue;
		/**
		 * some values are stored as array, we only want multidimensional ones
		 */
		if ( ! is_array( $array ) ) {
			return array_map( $func, $meta, (array)$sanitizer );
			break;
		}
		/**
		 * the sanitizer will have all of the fields, but the item may only
		 * have valeus for a few, remove the ones we don't have from the santizer
		 */
		$keys = array_keys( $array );
		$newSanitizer = $sanitizer;
		if ( is_array( $sanitizer ) ) {
			foreach( $newSanitizer as $sanitizerKey => $value )
				if ( ! in_array( $sanitizerKey, $keys ) )
					unset( $newSanitizer[$sanitizerKey] );
		}
		/**
		 * run the function as deep as the array goes
		 */
		foreach( $array as $arrayKey => $arrayValue )
			if ( is_array( $arrayValue ) )
				$array[$arrayKey] = meta_box_array_map_r( $func, $arrayValue, $newSanitizer[$arrayKey] );

		$array = array_map( $func, $array, $newSanitizer );
		$newMeta[$key] = array_combine( $keys, array_values( $array ) );
	}
	return $newMeta;
}

/*
 * takes in a few peices of data and creates a custom meta box
 *
 * @param	string			$id			meta box id
 * @param	string			$title		title
 * @param	array			$fields		array of each field the box should include
 * @param	string|array	$page		post type to add meta box to
 */
class Custom_Add_Meta_Box {

	var $id;
	var $title;
	var $fields;
	var $page;

    public function __construct( $id, $title, $fields, $page ) {
		$this->id = $id;
		$this->title = $title;
		$this->fields = $fields;
		$this->page = $page;

		if( ! is_array( $this->page ) )
			$this->page = array( $this->page );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_head',  array( $this, 'admin_head' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_box' ) );
		add_action( 'save_post',  array( $this, 'save_box' ));
    }

	/*
	 * enqueue necessary scripts and styles
	 */
	function admin_enqueue_scripts() {
		global $pagenow;
		if ( in_array( $pagenow, array( 'post-new.php', 'post.php' ) ) && in_array( get_post_type(), $this->page ) ) {
			// js
			$deps = array( 'jquery' );
			if ( meta_box_find_field_type( 'date', $this->fields ) )
				$deps[] = 'jquery-ui-datepicker';
			if ( meta_box_find_field_type( 'slider', $this->fields ) )
				$deps[] = 'jquery-ui-slider';
			if ( meta_box_find_field_type( 'color', $this->fields ) )
				$deps[] = 'farbtastic';
			if ( in_array( true, array(
				meta_box_find_field_type( 'chosen', $this->fields ),
				meta_box_find_field_type( 'post_chosen', $this->fields )
			) ) ) {
				wp_register_script( 'chosen', CUSTOM_METABOXES_DIR . '/js/chosen.js', array( 'jquery' ) );
				$deps[] = 'chosen';
				wp_enqueue_style( 'chosen', CUSTOM_METABOXES_DIR . '/css/chosen.css' );
			}
			if ( in_array( true, array(
				meta_box_find_field_type( 'date', $this->fields ),
				meta_box_find_field_type( 'slider', $this->fields ),
				meta_box_find_field_type( 'color', $this->fields ),
				meta_box_find_field_type( 'chosen', $this->fields ),
				meta_box_find_field_type( 'post_chosen', $this->fields ),
				meta_box_find_repeatable( 'repeatable', $this->fields ),
				meta_box_find_field_type( 'image', $this->fields ),
				meta_box_find_field_type( 'file', $this->fields )
			) ) )
				wp_enqueue_script( 'meta_box', CUSTOM_METABOXES_DIR . '/js/scripts.js', $deps );

			// css
			$deps = array();
			wp_register_style( 'jqueryui', CUSTOM_METABOXES_DIR . '/css/jqueryui.css' );
			if ( meta_box_find_field_type( 'date', $this->fields ) || meta_box_find_field_type( 'slider', $this->fields ) )
				$deps[] = 'jqueryui';
			if ( meta_box_find_field_type( 'color', $this->fields ) )
				$deps[] = 'farbtastic';
			wp_enqueue_style( 'meta_box', CUSTOM_METABOXES_DIR . '/css/meta_box.css', $deps );
		}
	}

	/*
	 * adds scripts to the head for special fields with extra js requirements
	 */
	function admin_head() {
		if ( in_array( get_post_type(), $this->page ) && ( meta_box_find_field_type( 'date', $this->fields ) || meta_box_find_field_type( 'slider', $this->fields ) ) ) {

			echo '<script type="text/javascript">
						jQuery(function( $) {';

			foreach ( $this->fields as $field ) {
				switch( $field['type'] ) {
					// date
					case 'date' :
						echo '$("#' . $field['id'] . '").datepicker({
								dateFormat: \'yy-mm-dd\'
							});';
					break;
					// slider
					case 'slider' :
					$value = get_post_meta( get_the_ID(), $field['id'], true );
					if ( $value == '' )
						$value = $field['min'];
					echo '
							$( "#' . $field['id'] . '-slider" ).slider({
								value: ' . $value . ',
								min: ' . $field['min'] . ',
								max: ' . $field['max'] . ',
								step: ' . $field['step'] . ',
								slide: function( event, ui ) {
									$( "#' . $field['id'] . '" ).val( ui.value );
								}
							});';
					break;
				}
			}

			echo '});
				</script>';

		}
	}

	/*
	 * adds the meta box for every post type in $page
	 */
	function add_box() {
		foreach ( $this->page as $page ) {
			add_meta_box( $this->id, $this->title, array( $this, 'meta_box_callback' ), $page, 'normal', 'high' );
		}
	}

	/*
	 * outputs the meta box
	 */
	function meta_box_callback() {
		// Use nonce for verification
		wp_nonce_field( 'custom_meta_box_nonce_action', 'custom_meta_box_nonce_field' );

		// Begin the field table and loop
		echo '<table class="form-table meta_box">';
		foreach ( $this->fields as $field) {
			if ( $field['type'] == 'section' ) {
				echo '<tr>
						<td colspan="2">
							<h2>' . $field['label'] . '</h2>
						</td>
					</tr>';
			}
			else {
				echo '<tr>
						<th style="width:20%"><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
						<td>';

						$meta = get_post_meta( get_the_ID(), $field['id'], true);
						echo custom_meta_box_field( $field, $meta );

				echo     '<td>
					</tr>';
			}
		} // end foreach
		echo '</table>'; // end table
	}

	/*
	 * saves the captured data
	 */
	function save_box( $post_id ) {
		$post_type = get_post_type();

		// verify nonce
		if ( ! isset( $_POST['custom_meta_box_nonce_field'] ) )
			return $post_id;
		if ( ! ( in_array( $post_type, $this->page ) || wp_verify_nonce( $_POST['custom_meta_box_nonce_field'],  'custom_meta_box_nonce_action' ) ) )
			return $post_id;
		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		// check permissions
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;


		// loop through fields and save the data
		foreach ( $this->fields as $field ) {
			if( $field['type'] == 'section' ) {
				$sanitizer = null;
				continue;
			}
			if( in_array( $field['type'], array( 'tax_select', 'tax_checkboxes', 'tax_chosen' ) ) ) {
				// save taxonomies
				if ( isset( $_POST[$field['id']] ) ) {
					$term = $_POST[$field['id']];
					wp_set_object_terms( $post_id, $term, $field['id'] ); // this needs looked at
				}
			}
			else {
				// save the rest
				$new = false;
				$old = get_post_meta( $post_id, $field['id'], true );
				if ( isset( $_POST[$field['id']] ) )
					$new = $_POST[$field['id']];
				if ( '' == $new && $old ) {
					delete_post_meta( $post_id, $field['id'], $old ); // This needs looked at
				} elseif ( isset( $new ) && $new != $old ) {
					$sanitizer = isset( $field['sanitizer'] ) ? $field['sanitizer'] : 'sanitize_text_field';
					if ( is_array( $new ) )
						$new = meta_box_array_map_r( 'meta_box_sanitize', $new, $sanitizer );
					else
						$new = meta_box_sanitize( $new, $sanitizer );
					update_post_meta( $post_id, $field['id'], $new );
				}
			}
		} // end foreach
	}
}

$prefix = 'MD_';

$storiesFields = array(
	array(
		'label' => 'Featured Section',
		'desc' => 'Featured Section of Story',
		'id' => $prefix.'featured',
		'type' => 'textarea',
	),
	array(
		'label' => 'Associated Service',
		'desc' => 'Service that is related to the experience',
		'id' => $prefix.'service',
		'type' => 'chosen',
		'options' => array ( // array of options
			'one' => array ( // array key needs to be the same as the option value
				'label' => 'Health &amp; Wellness Center', // text displayed as the option
				'value'	=> 'health-wellness' // value stored for the option
			),
			'two' => array (
				'label' => 'Mom\'s First',
				'value'	=> 'momsFirst'
			),
			'three' => array (
				'label' => 'Education Resources Center',
				'value'	=> 'educationCenter'
			),
			'four' => array (
				'label' => 'Counseling',
				'value'	=> 'counseling'
			),
			'four' => array (
				'label' => 'Basic Needs',
				'value'	=> 'basicNeeds'
			)
		)
	),
	array( // Taxonomy Select box
		'label'	=> 'Story Type', // <label>
		// the description is created in the callback function with a link to Manage the taxonomy terms
		'id'	=> 'storyType', // field id and name, needs to be the exact name of the taxonomy
		'type'	=> 'tax_chosen'
	)
);

/*
 * Instantiate the class with all variables to create a meta box
 * var $id string meta box id
 * var $title string title
 * var $fields array fields
 * var $page string|array post type to add meta box to
 * var $js bool including javascript or not
 */

$stories_box = new custom_add_meta_box( 'stories_box', 'Additional Post Information', $storiesFields, 'story', true );

?>