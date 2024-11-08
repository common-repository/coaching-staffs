<?php
/*
Plugin Name: Coaching Staffs
Plugin URI: http://wordpress.org/extend/plugins/coaching-staffs/
Description: Manage and display coaching staffs. Front end displays include  coaching staff tables, a coaching staff galleries, and single coach profiles.
Version: 1.4
Author: Mark O'Donnell
Author URI: http://shoalsummitsolutions.com
*/

/*
 *	Coaching Staffs (Wordpress Plugin)
 *	Copyright (C) 2013-20 Mark O'Donnell
 *	Contact me at mark@shoalsummitsolutions.com
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

// ----------------------------------------------------------------
// If an admin, load the admin functions (once)

	if ( is_admin( ) ) {
		require_once ( dirname( __FILE__ ) . '/includes/mstw-coaching-staffs-admin.php' );
    }

// ----------------------------------------------------------------
// Load the MSTW & CS utility functions (once)

	require_once ( dirname( __FILE__ ) . '/includes/mstw-cs-utility-functions.php' );
	
	require_once ( dirname( __FILE__ ) . '/includes/mstw-utility-functions.php' );

// ----------------------------------------------------------------
// Add the CSS code to the header

	add_filter( 'wp_head', 'mstw_cs_add_css');
		
	function mstw_cs_add_css( ) {
		
		$options = get_option( 'mstw_cs_options' );
		
		echo '<style type="text/css">';
		
		echo "h1.staff-head-title { \n";
			echo mstw_cs_build_css_rule( $options, 'table_title_color', 'color', '' );
		echo "} \n";
		
		echo "th.mstw-cs-table-head { \n";
			echo mstw_cs_build_css_rule( $options, 'table_header_text_color', 'color' );
			echo mstw_cs_build_css_rule( $options, 'table_header_bkgd_color', 'background-color' );
			echo mstw_cs_build_css_rule( $options, 'table_border_color', 'border-color' );
			echo mstw_cs_build_css_rule( $options, 'table_border_width', 'border-width', 'px' );
		echo "} \n";
		
		echo "td.mstw-cs-odd { \n";
			echo mstw_cs_build_css_rule( $options, 'table_odd_text_color', 'color' );
			echo mstw_cs_build_css_rule( $options, 'table_odd_bkgd_color', 'background-color' );
			echo mstw_cs_build_css_rule( $options, 'table_border_color', 'border-color' );
			echo mstw_cs_build_css_rule( $options, 'table_border_width', 'border-width', 'px' );
		echo "} \n";
		
		echo "tr.mstw-cs-odd  td.mstw-cs-odd a { \n";
			echo mstw_cs_build_css_rule( $options, 'table_odd_link_color', 'color' );
		echo "} \n";
		
		echo "td.mstw-cs-even { \n";
			echo mstw_cs_build_css_rule( $options, 'table_even_text_color', 'color' );
			echo mstw_cs_build_css_rule( $options, 'table_even_bkgd_color', 'background-color' );
			echo mstw_cs_build_css_rule( $options, 'table_border_color', 'border-color' );
			echo mstw_cs_build_css_rule( $options, 'table_border_width', 'border-width', 'px' );
		echo "} \n";
		
		echo "tr.mstw-cs-even td.mstw-cs-even a { \n";
			echo mstw_cs_build_css_rule( $options, 'table_even_link_color', 'color' );
		echo "} \n";
		
		
		//Rules for Single Coach
		echo "div.coach-header { \n";
			echo mstw_cs_build_css_rule( $options, 'profile_header_bkgd_color', 'background-color' );
		echo "} \n";
		
		echo "#coach-name h1 { \n";
			echo mstw_cs_build_css_rule( $options, 'profile_header_name_color', 'color' );
		echo "} \n";
		
		echo "#coach-name h2 { \n";
			echo mstw_cs_build_css_rule( $options, 'profile_header_position_color', 'color' );
		echo "} \n";
		
		echo "div.coach-header table { \n";
			echo mstw_cs_build_css_rule( $options, 'profile_header_text_color', 'color' );
		echo "} \n";
		 
		//bio_heading_color
		echo ".coach-bio h1 { \n";
			echo mstw_cs_build_css_rule( $options, 'profile_bio_heading_color', 'color' );
		echo "} \n";
		//bio_text_color
		echo ".coach-bio p { \n";
			echo mstw_cs_build_css_rule( $options, 'profile_bio_text_color', 'color' );
		echo "} \n";
		//bio_bkgd_color
		echo ".coach-bio { \n";
			echo mstw_cs_build_css_rule( $options, 'profile_bio_bkgd_color', 'background-color' );
		//echo "} \n";
		//bio_border_color
		//echo ".coach-bio { \n";
			echo mstw_cs_build_css_rule( $options, 'profile_bio_border_color', 'border-color' );
		//echo "} \n";
		//bio_border_width
		//echo ".coach-bio { \n";
			echo mstw_cs_build_css_rule( $options, 'profile_bio_border_width', 'border-width', 'px' );
		echo "} \n";
		
		// Rules for Coaches Galleries
		echo ".coach-tile { \n";
			echo mstw_cs_build_css_rule( $options, 'profile_header_bkgd_color', 'background-color' );
			echo mstw_cs_build_css_rule( $options, 'profile_header_text_color', 'color' );
			//echo mstw_cs_build_css_rule( $options, 'gallery_tile_radius', 'border-radius', 'px' );
			//echo mstw_cs_build_css_rule( $options, 'gallery_tile_radius', '-moz-border-radius', 'px' );
			echo 'border-radius: ' . $options['gallery_tile_radius'] . "px; \n";
			echo '-moz-border-radius: ' . $options['gallery_tile_radius'] . "px; \n";
			echo mstw_cs_build_css_rule( $options, 'gallery_tile_border_color', 'border-color' );
			echo mstw_cs_build_css_rule( $options, 'gallery_tile_border_width', 'border-width', 'px' );
			//echo 'border-width: ' . $options['gallery_tile_border_width'] . "px; \n";
			echo mstw_cs_build_css_rule( $options, 'gallery_tile_border_width', 'border-width', 'px' );
		echo "} \n";
		
		echo "h1.staff-head-title { \n";
			echo mstw_cs_build_css_rule( $options, 'gallery_title_color', 'color' );
		echo "} \n";
		
		echo ".coach-photo img, #coach-photo img { \n";
			echo mstw_cs_build_css_rule( $options, 'gallery_photo_width', 'width', 'px' );
			echo mstw_cs_build_css_rule( $options, 'gallery_photo_height', 'height', 'px' );
		echo "} \n";
		
		echo ".coach-name-position a { \n";
			echo mstw_cs_build_css_rule( $options, 'profile_header_name_color', 'color' );
		echo "} \n";
		
		echo ".coach-name-position h2 { \n";
			echo mstw_cs_build_css_rule( $options, 'profile_header_position_color', 'color' );
		echo "} \n";
		
		echo '</style>';
		
	}
		
	/*  This should move to mstw_utils
	 *	rules_array - an array of rules for the specific css identifier
	 *		rules_array['attrib'] = css attribute - something like "color" or "background"
	 *		rules_array['option_name'] = element from $options that will provide the attrib's value
	 *		rules_array['suffix'] = end of rule - something like "px" or "rem"
	 */
	
	
	function mstw_cs_build_css_rule( $options_array, $option_name, $css_rule, $suffix='' ) {
		if ( isset( $options_array[$option_name] ) and !empty( $options_array[$option_name] ) ) {
			return $css_rule . ":" . $options_array[$option_name] . "$suffix; \n";	
		} 
		else {
			return "";
		}
	}
		
// ----------------------------------------------------------------
// Set up localization (internationalization)
	add_action( 'init', 'mstw_cs_load_localization' );
		
	function mstw_cs_load_localization( ) {
		
		load_plugin_textdomain( 'mstw-loc-domain', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
		
	}

// ----------------------------------------------------------------
// Want to show coach post type on category pages
	add_filter( 'pre_get_posts', 'mstw_cs_get_posts' );

	function mstw_cs_get_posts( $query ) {
		// Need to check the need for this first conditional ... someday

		if ( !is_admin() && is_tax( 'staffs' ) && $query->is_main_query() ) {
			// We are on the coach gallery page ...
			// So set the sort order based on the admin settings
			//$options = get_option( 'mstw_cs_options' );
			
			// Need the team slug to set query
			$uri_array = explode( '/', $_SERVER['REQUEST_URI'] );	
			$staff_slug = $uri_array[sizeof( $uri_array )-2];
			
			// sort alphabetically by title ascending by default
			$query->set( 'post_type', 'staff_position' );
			$query->set( 'staffs' , $staff_slug );
			$query->set( 'orderby', 'meta_value_num' );  
			$query->set( 'meta_key', 'mstw_cs_display_order' );
			$query->set( 'order', 'ASC' );
			
		}
	}  

// ----------------------------------------------------------------
// Add the custom Staffs taxonomy ... will act like tags	
	add_action( 'init', 'mstw_cs_create_taxonomy' );

	function mstw_cs_create_taxonomy( ) {
	
		$labels = array( 
					'name' 				   		   => __( 'Staffs', 'mstw-loc-domain' ),
					'singular_name' 			   =>  __( 'Staff', 'mstw-loc-domain' ),
					'search_items' 				   => __( 'Search Staffs', 'mstw-loc-domain' ),
					'popular_items' 			   => null, //__( 'Popular Staffs', 'mstw-loc-domain' ),
					'all_items' 				   => __( 'All Staffs', 'mstw-loc-domain' ),
					'parent_item' 				   => null,
					'parent_item_colon' 		   => null,
					'edit_item' 				   => __( 'Edit Staff', 'mstw-loc-domain' ), 
					'update_item'                  => __( 'Update Staff', 'mstw-loc-domain' ),
					'add_new_item'                 => __( 'Add New Staff', 'mstw-loc-domain' ),
					'new_item_name'                => __( 'New Staff Name', 'mstw-loc-domain' ),
					'separate_items_with_commas'   => __( 'Separate Staffs with commas', 'mstw-loc-domain' ),
					'add_or_remove_items'          => __( 'Add or Remove Staffs', 'mstw-loc-domain' ),
					'choose_from_most_used'        => __( 'Choose from the most used Staffs', 'mstw-loc-domain' ),
					'not_found'                    => __( 'No Staffs found', 'mstw-loc-domain' ),
					'menu_name'                    => __( 'Staffs', 'mstw-loc-domain' ),
				  );
				  
		$args = array( 
			'labels' 				=> $labels,
			'public'				=> true,
			'show_ui'				=> true,
			'show_in_nav_menus'		=> true, //\\
			'show_tagcloud'			=> false,
			'show_admin_column'		=> true,
			'hierarchical' 			=> false, 
			'query_var' 			=> true, 
			'rewrite' 				=> true 
			);
			
		register_taxonomy( 'staffs', 'staff_position', $args );
				
	}


// ----------------------------------------------------------------
// Deactivate, request upgrade, and exit if WP version is not right
//
	add_action( 'admin_init', 'mstw_cs_requires_wp_ver' );

	function mstw_cs_requires_wp_ver() {
		global $wp_version;
		$plugin = plugin_basename( __FILE__ );
		$plugin_data = get_plugin_data( __FILE__, false );

		if ( version_compare($wp_version, "3.5", "<" ) ) {
			if( is_plugin_active($plugin) ) {
				deactivate_plugins( $plugin );
				wp_die( "'" . $plugin_data['Name'] . "' requires WordPress 3.5 or higher, and has been deactivated! 
					Please upgrade WordPress and try again.<br /><br />Back to <a href='".admin_url() . "'>WordPress admin</a>." );
			}
		}
	}

// ----------------------------------------------------------------
// Load the CSS
//
	add_action( 'wp_enqueue_scripts', 'mstw_cs_enqueue_styles' );

	function mstw_cs_enqueue_styles () {
		//mstw_log_msg( "mstw_cs_enqueue_styles:" );
		
		/*
		 *  First find the plugin's stylesheet and enqueue it
		 */
		 
		// Find the full path to the css file 
		$mstw_cs_style_file = dirname( __FILE__ ) . '/css/mstw-cs-styles.css';
		
		// If stylesheet exists, enqueue the style 
		if ( file_exists( $mstw_cs_style_file ) ) {	
			wp_register_style( 'mstw-cs-styles', plugins_url( '/css/mstw-cs-styles.css', __FILE__ ) );
			//mstw_log_msg( "enqueing " . plugins_url( '/css/mstw-cs-styles.css', __FILE__ ) );
			wp_enqueue_style( 'mstw-cs-styles' );				
		} 

		$mstw_cs_custom_stylesheet = get_stylesheet_directory( ) . '/mstw-cs-custom-styles.css';
		//mstw_log_msg( 'custom stylesheet path: ' . $mstw_cs_custom_stylesheet );
		
		if ( file_exists( $mstw_cs_custom_stylesheet ) ) {
			$mstw_cs_custom_stylesheet_url = get_stylesheet_directory_uri( ) . '/mstw-cs-custom-styles.css';
			//error_log( 'custom stylesheet uri: ' . $mstw_cs_custom_stylesheet_url );
			wp_register_style( 'mstw_cs_custom_style', $mstw_cs_custom_stylesheet_url );
			wp_enqueue_style( 'mstw_cs_custom_style' );
		}

	}

// --------------------------------------------------------------------------------------
// CUSTOM POST TYPE STUFF
// --------------------------------------------------------------------------------------
// Set-up Action Hooks & Filters for the coach & staff_position CPT
// ACTIONS
// 		'init'											mstw_cs_register_post_types
//		'add_metaboxes'									mstw_cs_add_meta
//		'save_posts'									mstw_cs_save_meta
//		'manage_game_schedule_posts_custom_column'		mstw_cs_manage_columns

// FILTERS
// 		'manage_edit-game_schedule_columns'				mstw_cs_edit_columns
//		'post_row_actions'								mstw_cs_remove_the_view
//		
// --------------------------------------------------------------------------------------

// --------------------------------------------------------------------------------------
// First want to make sure thumbnails are active in the theme before adding them via the 
//	register_post_type call in the 'init' action
	add_action( 'after_setup_theme', 'mstw_cs_add_feat_img' );
	
	function mstw_cs_add_feat_img( ) {
		if ( function_exists( 'add_theme_support' ) and function_exists( 'get_theme_support' ) ) {
			if ( get_theme_support( 'post-thumbnails' ) === false ) {
				add_theme_support( 'post-thumbnails' );
			}
		}
	}

// --------------------------------------------------------------------------------------
// Add the coach and staff_position custom post types
	add_action( 'init', 'mstw_cs_register_post_types' );

	function mstw_cs_register_post_types( ) {

		// Set up the arguments for the coach post type. 
		$coach_args = array(
			'public'	=> true,
			'query_var'	=> 'coach',
			'rewrite' 	=> array(
								'slug'       => 'coaches',
								'with_front' => false,
							),
			'supports' => array( 'title',
								 'editor',
								 'thumbnail',
								 'excerpt',
								),
			// Labels used when displaying the posts.
			'labels' => array(
				'name'               => __( 'Coaches', 'mstw-loc-domain' ),
				'singular_name'      => __( 'Coach', 'mstw-loc-domain' ),
				'menu_name'          => __( 'MSTW Coaches', 'mstw-loc-domain' ),
				'all_items'			     => __( 'Coaches', 'mstw-loc-domain' ),
				'name_admin_bar'     => __( 'Coaches', 'mstw-loc-domain' ),
				'add_new'            => __( 'Add New Coach', 'mstw-loc-domain' ),
				'add_new_item'       => __( 'Add New Coach', 'mstw-loc-domain' ),
				'edit_item'          => __( 'Edit Coach', 'mstw-loc-domain' ),
				'new_item'           => __( 'New Coach', 'mstw-loc-domain' ),
				'view_item'          => __( 'View Coach', 'mstw-loc-domain' ),
				'search_items'       => __( 'Search Coaches', 'mstw-loc-domain' ),
				'not_found'          => __( 'No coach found', 'mstw-loc-domain' ),
				'not_found_in_trash' => __( 'No coach found in trash', 'mstw-loc-domain' ),
				'all_items'          => __( 'Coaches', 'mstw-loc-domain' ),
				),
			//'taxonomies' => array( 'teams' ),
			//'show_in_nav_menus'   => true,
			//'show_in_admin_bar'   => true,
			//'exclude_from_search' => false,
			//'show_ui'             => true,
			'show_in_menu'        	=> 'mstw-cs-main-menu', //=> true,
			//'menu_position'       => null,
			//'menu_icon'           => null,
			//'can_export'          => true,
			//'delete_with_user'    => false,
			//'hierarchical'        => false,
			//'has_archive'         => 'players',
		);

		// Register the coach CPT 
		register_post_type( 'coach', $coach_args );
		
		// Set up the arguments for the staff_position post type. 
		$staff_args = array(
			'public'	=> true,
			'query_var'	=> true, //'staff_position',
			'rewrite' 	=> array(
								'slug'       => 'staff_positions',
								'with_front' => false,
							),
			'supports' => array( 'title',
								),
			// Labels used when displaying the posts.
			'labels' => array(
				'name'               => __( 'Staff Positions', 'mstw-loc-domain' ),
				'singular_name'      => __( 'Staff Position', 'mstw-loc-domain' ),
				'menu_name'          => __( 'MSTW Staff Positions', 'mstw-loc-domain' ),
				'all_items'			     => __( 'Staff Positions', 'mstw-loc-domain' ),
				'name_admin_bar'     => __( 'Staff Positions', 'mstw-loc-domain' ),
				'add_new'            => __( 'Add New Staff Position', 'mstw-loc-domain' ),
				'add_new_item'       => __( 'Add New Staff Position', 'mstw-loc-domain' ),
				'edit_item'          => __( 'Edit Staff Position', 'mstw-loc-domain' ),
				'new_item'           => __( 'New Staff Position', 'mstw-loc-domain' ),
				'view_item'          => __( 'View Staff Position', 'mstw-loc-domain' ),
				'search_items'       => __( 'Search Staff Positions', 'mstw-loc-domain' ),
				'not_found'          => __( 'No staff position found', 'mstw-loc-domain' ),
				'not_found_in_trash' => __( 'No staff position found in trash', 'mstw-loc-domain' ),
				'all_items'          => __( 'Staff Positions', 'mstw-loc-domain' ),
				),
			'taxonomies' => array( 'staffs' ),
			
			//'show_in_nav_menus'   => true,
			//'show_in_admin_bar'   => true,
			//'exclude_from_search' => false,
			//'show_ui'             => true,
			'show_in_menu'        	=> 'mstw-cs-main-menu', //=> true,
			//'menu_position'       => null,
			//'menu_icon'           => null,
			//'can_export'          => true,
			//'delete_with_user'    => false,
			//'hierarchical'        => false,
			//'has_archive'         => 'players',
		);

		// Register the staff_position CPT 
		register_post_type( 'staff_position', $staff_args );
		
	}
	
// ----------------------------------------------------------------
// find the single-coach template in the plugin's directory
//
add_filter( "single_template", "mstw_cs_single_coach_template" );

function mstw_cs_single_coach_template( $single_template ) {
	//mstw_log_msg( "mstw_cs_single_coach_template: $single_template" );
	global $post;

	if ($post->post_type == 'coach') {
		//$single_template = dirname( __FILE__ ) . '/templates/single-coach.php';  
		$custom_coach_template = get_stylesheet_directory( ) . '/single-coach.php';
		$plugin_coach_template = dirname( __FILE__ ) . '/theme-templates/single-coach.php';
		//mstw_log_msg( "plugin template: $plugin_coach_template" );
		
		if ( file_exists( $custom_coach_template ) ) {
			$single_template = $custom_coach_template;
			//mstw_log_msg( "using custom template: $custom_coach_template" );
		}
		else if ( file_exists( $plugin_coach_template ) ) {
			$single_template = $plugin_coach_template;
			//mstw_log_msg( "using plugin template: $plugin_coach_template" );
		}	
	}
	
	return $single_template;
	 
} //End: mstw_cs_single_coach_template( )
	
//-----------------------------------------------------------------
// find the taxonomy_staffs template in the plugin's directory
//
add_filter( "taxonomy_template", "mstw_cs_taxonomy_staffs_template" );
	
function mstw_cs_taxonomy_staffs_template( $template ) {
	//mstw_log_msg( "mstw_cs_taxonomy_staffs_template: $template" );
	//mstw_log_msg( "taxonomy: " . get_query_var( 'taxonomy' ) );
	
	if ( 'staffs' == get_query_var( 'taxonomy' ) ) {	
		$custom_taxonomy_template = get_stylesheet_directory( ) . '/taxonomy-staffs.php';
		$plugin_taxonomy_template = dirname( __FILE__ ) . '/theme-templates/taxonomy-staffs.php';
		
		if ( file_exists( $custom_taxonomy_template ) ) {
			$template = $custom_taxonomy_template;
			//mstw_log_msg( "using custom template: $custom_taxonomy_template" );
		}
		else if ( file_exists( $plugin_taxonomy_template ) ) {
			$template = $plugin_taxonomy_template;
			//mstw_log_msg( "using plugin template: $plugin_taxonomy_template" );
		}
		else {
			//mstw_log_msg( "could not find a taxonomy template?? $custom_taxonomy_template or $plugin_taxonomy_template " );
		} //End: if ( file_exists( $custom_taxonomy_template ) ) {
			
	} //End: if ( file_exists( $custom_taxonomy_template ) ) {
		
	//mstw_log_msg( "returning template: $template" );	 
	return $template;
		 
 } //End: mstw_cs_taxonomy_staffs_template( )	

// --------------------------------------------------------------------------------------
// Add the shortcode handler, which will create the a Coaching Staff table on the user side.
// 	Handles the shortcode parameters, if there were any, 
// 	then calls mstw_cs_build_staff_table() to create the output
// --------------------------------------------------------------------------------------
add_shortcode( 'mstw-cs-table', 'mstw_cs_shortcode_handler' );

function mstw_cs_shortcode_handler( $atts ){
	// get the options set in the admin screen
	$options = get_option( 'mstw_cs_options' );
	//mstw_log_msg( 'in mstw_cs_shortcode_handler ...' );
	//mstw_log_msg( '$options:' );
	//mstw_log_msg( $options );
	
	// and merge them with the defaults
	$args = wp_parse_args( $options, mstw_cs_get_defaults( ) );
	//$output .= '<pre>ARGS:' . print_r( $args, true ) . '</pre>';
	
	// then merge the parameters passed to the shortcode with the result									
	$attribs = shortcode_atts( $args, $atts );
	//$output .= '<pre>ATTS:' . print_r( $atts, true ) . '</pre>';
	//$output .= '<pre>ATTRIBS:' . print_r( $attribs, true ) . '</pre>';
	
	$mstw_cs_staff_table = mstw_cs_build_staff_table( $attribs );
	//$mstw_cs_staff_table = mstw_cs_build_staff_table( $atts );
	
	//return $output;
	
	return $mstw_cs_staff_table;
}

// --------------------------------------------------------------------------------------
// Called by:	mstw_cs_shortcode_handler
// Builds a Coaching Staff table as a string (to replace the [shortcode] in a page or post).
// Loops through the Staff Positions Custom posts in the "staff" category and formats them 
// into a pretty table.
// --------------------------------------------------------------------------------------
function mstw_cs_build_staff_table( $attribs ) {	
	
	extract( $attribs );
	
	if ( !isset( $staff ) or $staff == '' ) {
		$output = '<h3>' . __( 'No Staff Specified', 'mstw-loc-domain' ) . '</h3>';
		return $output;
	}
	
	$output = "";
	
	// Settings from the admin page
	//$options = get_option( 'mstw_cs_options' );
	//extract( $options );
	
	// Show the table title = Name of Staff
	if ( $show_title ) {
		$term_array = get_term_by( 'slug', $staff, 'staffs' );
		//mstw_log_msg( $staff );
		//mstw_log_msg( $term_array );
		$staff_name = $term_array->name;
		
		$staff_class = 'staff-head-title staff-head-title-' . $staff;
		
		$output .= '<h1 class="' . $staff_class . '">' . $staff_name . '</h1>';
	}
	
	// Get the staff roster		
	$posts = get_posts(array( 'numberposts' => -1,
							  'post_type' => 'staff_position',
							  'staffs' => $staff, 
							  'orderby' => 'meta_value_num', 
							  'meta_key' => 'mstw_cs_display_order',
							  'order' => 'ASC' 
							));						
	
   if( $posts ) {
		// Make table of coaches
		// Start with the table header

		$staff_class = 'mstw-cs-table-' . $staff;
        $output .= '<table class="mstw-cs-table ' . $staff_class . '">';
		
		// leave this open and check on styles from the admin settings
		$output .= '<thead><tr class="mstw-cs-table-head">';
	
		$th_temp = '<th class="mstw-cs-table-head" > ';
		
		// Check the PHOTO Column
		if ( $show_photos ) {
			$output .= $th_temp . $photo_label . '</th>';
		}
		
		// Always show the NAME column
		$output .= $th_temp . $name_label . '</th>';
		
		// show the POSITION column
		if ( $show_position ) {
			$output .= $th_temp . $position_label . '</th>';
		}
		
		// Check the EXPERIENCE column
		if ( $show_experience ) {
			$output .= $th_temp . $experience_label . '</th>';
		}
		
		// Check the ALMA MATER column
		if ( $show_alma_mater ) {
			$output .= $th_temp . $alma_mater_label . '</th>';
		}
		
		// show the DEGREE column
		if ( $show_degree ) {
			$output .= $th_temp . $degree_label . '</th>';
		}
		
		// Check the BIRTH DATE column
		if ( $show_birth_date ) {
			$output .= $th_temp . $birth_date_label . '</th>';
		}
		
		// Check the HOMETOWN column
		if ( $show_home_town ) {
			$output .= $th_temp . $home_town_label . '</th>';
		}
		
		// Check the HIGH SCHOOL column
		if ( $show_high_school ) {
			$output .= $th_temp . $high_school_label . '</th>';
		}
		
		// Check the FAMILY column
		if ( $show_family ) {
			$output .= $th_temp . $family_label . '</th>';
		}
		
        $output = $output . '</tr></thead>';
        
		// Keeps track of even and odd rows. Start with row 1 = odd.
		$even_and_odd = array('even', 'odd');
		$row_cnt = 1; 
		
		// Loop through the posts and make the rows
		foreach( $posts as $post ){
			// set up some housekeeping to make styling in the loop easier
			// NEEDS TO BE UPDATED
			$even_or_odd_row = $even_and_odd[$row_cnt]; 
			$row_class = 'mstw-cs-' . $even_or_odd_row;
			
			$row_tr = '<tr class="' . $row_class . '">'; 
			$row_td = '<td class="' . $row_class . '">'; 
			
			// create the row
			$row_string = $row_tr;
			
			// GET the corresponding coach post ID; this is used to plug the coaches data
			$coach_id = get_post_meta( $post->ID, 'mstw_cs_position_coach', true );

			// Check to see if a single_coach.php template exists in 
			// the active theme directory, or in the plugin directory 
			// if so add the links to the table
			$custom_taxonomy_template = get_stylesheet_directory( ) . '/taxonomy-staffs.php';
			$plugin_taxonomy_template = dirname( __FILE__ ) . '/theme-templates/taxonomy-staffs.php';
		
			if ( file_exists( $custom_taxonomy_template ) or file_exists( $plugin_taxonomy_template ) ) {
				$single_coach_template = true;
			} else {
				$single_coach_template = false;
			}

			if ( $show_photos ) {
				$row_string .= $row_td;
				
				if ( has_post_thumbnail( $coach_id ) ) {
					if ( $single_coach_template ) {
						$row_string .= '<a href="' .  get_permalink( $coach_id ) . '?position='. $post->ID . '">';
						$row_string .= get_the_post_thumbnail( $coach_id, array($table_photo_width, $table_photo_height) ) .  '</a></td>'; 
					}
					else {  //No profile to link to
						$row_string .= get_the_post_thumbnail( $coach_id, array($table_photo_width, $table_photo_height) ) .  '</a></td>';
					}	
				}
				else {
					$photo_file = plugin_dir_path( __FILE__ ) . 'images/default-photo-'. $staff . '.jpg';
					if (file_exists( $photo_file ) ) {
						$photo_file_url = plugins_url() . '/coaching-staffs/images/default-photo-' . $staff . '.jpg';
					}
					else {
						$photo_file_url = plugins_url() . '/coaching-staffs/images/default-photo.jpg';	
					}
					$row_string .=  '<img width="' . $table_photo_width . '" height="' . $table_photo_height . '" src="' . $photo_file_url . '" class="attachment-64x64 wp-post-image" alt="' . __( 'No photo available.', 'mstw-loc-domain' ) . '"/></td>';
				}
			}
			
			// ALWAYS add the coach's name
			$coach_name = get_the_title( $coach_id );
			
			if ( $single_coach_template ) {
				//$coach_html = '<a href="' .  get_permalink( $coach_id ) . '" ';
				$coach_html = '<a href="' .  get_permalink( $coach_id ) . '?position='. $post->ID . '">';
				$coach_html .= $coach_name . '</a>';
			}
			else {
				$coach_html = $coach_name;
			}
			
			$row_string =  $row_string . $row_td . $coach_html . '</td>';
			
			// column 3: Add the coach's postition
			if ( $show_position ) {
				$row_string .= $row_td . get_the_title( $post->ID ) . '</td>';
			}
			
			// Add the coach's experience
			if ( $show_experience ) {
				$row_string .= $row_td . get_post_meta( $coach_id, 'mstw_cs_experience', true ) . '</td>';
			}
			
			// Add the coach's alma mater
			if ( $show_alma_mater ) {
				$row_string .= $row_td . get_post_meta( $coach_id, 'mstw_cs_alma_mater', true ) . '</td>';
			}
			
			// Add the coach's degree
			if ( $show_degree ) {
				$row_string .= $row_td . get_post_meta( $coach_id, 'mstw_cs_degree', true ) . '</td>';
			}
			
			// Add the coach's birth date
			if ( $show_birth_date ) {
				$row_string .= $row_td . get_post_meta( $coach_id, 'mstw_cs_birth_date', true ) . '</td>';
			}
			
			// Add the coach's home town
			if ( $show_home_town ) {
				$row_string .= $row_td . get_post_meta( $coach_id, 'mstw_cs_home_town', true ) . '</td>';
			}
			
			// Add the coach's high school
			if ( $show_high_school ) {
				$row_string .= $row_td . get_post_meta( $coach_id, 'mstw_cs_high_school', true ) . '</td>';
			}
			
			// Add the coach's family
			if ( $show_family ) {
				$row_string .= $row_td . nl2br( get_post_meta( $coach_id, 'mstw_cs_family', true ) ) . '</td>';
			}
			
			// Add the row to the output string
			$output = $output . $row_string;
			
			// Keep the styles right
			$row_cnt = 1- $row_cnt;  
			
		} // end of foreach post or end of table content
		
		$output = $output . '</table>';
	}
	else { // No posts were found
	
		$output =  $output . '<h3>' . __( 'Sorry, No coaches found for staff: ' . $staff, 'mstw-loc-domain' ) . '</h3>';
		
	}
	
	return $output;
	
}
?>