<?php
 /**
 * MSTW Taxonomy Staffs Template for displaying staff galleries.
 *
 * 	NOTE: This is the "theme's framing". This template has been tested in the WordPress 
 * 	Twenty Eleven Theme. Plugin users will probably have to modify this template 
 * 	to fit their individual themes. 
 *
 *	MSTW Wordpress Plugins (http://shoalsummitsolutions.com)
 *	Copyright 2015-20 Mark O'Donnell (mark@shoalsummitsolutions.com)
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.

 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program. If not, see <http://www.gnu.org/licenses/>..
 *-------------------------------------------------------------------------*/
 
	//if ( !function_exists( 'mstw_cs_set_fields_by_format' ) ) {
		//echo '<p> mstw_text_ctrl does not exist. </p>';
		//echo '<p> path:' . WP_CONTENT_DIR . '/plugins/coaching-staff/includes/mstw-cs-utility-functions.php</p>';
		//require_once  WP_CONTENT_DIR . '/plugins/coaching-staff/includes/mstw-cs-utility-functions.php';
	//};
 
	get_header(); 
	
	// Get the settings from the admin page
	$options = get_option( 'mstw_cs_options' );
	
	//$sp_main_text_color = $options['sp_main_text_color'];
	//$sp_main_bkgd_color = $options['sp_main_bkgd_color'];
	//$hide_weight = $options['tr_hide_weight'];
	
	
	// Get the right settings for the format
	//$settings = mstw_cs_set_fields_by_format( $format );
	
	//echo '<h2>REVISED OPTIONS</h2>';
	//$options = wp_parse_args( $settings, $options );
	//print_r( $options );
	
	//$show_title = 1; /* this will come from a setting */
	
	//$use_coach_links = $options['pg_use_coach_links'];
	
	// figure out the staff name - for the title (if shown) and for staff-based styles
	$uri_array = explode( '/', $_SERVER['REQUEST_URI'] );	
	$staff_slug = $uri_array[sizeof( $uri_array )-2];
	$term = get_term_by( 'slug', $staff_slug, 'staffs' ); 
	$staff_name = '';
	if( isset( $term->name ) )
		$staff_name = $term->name;
	
	?>
	
	<section id="primary">
	<div id="content-coach-gallery" role="main" >

	<header class="page-header page-header-<?php echo $staff_slug ?>">
		<?php if( $options['show_gallery_title'] == 1 ) {
			echo '<h1 class="staff-head-title staff-head-title-' . $staff_slug . '">' . $staff_name . '</h1>'; 
		} ?>
	</header>

	<?php /* Start the Loop */ 
	// set the coach photo size based on admin settings, if any
	
	$cs_image_width = isset( $options['gallery_photo_width'] ) ? $options['gallery_photo_width'] : '';
	$cs_image_height = isset( $options['gallery_photo_height'] ) ? $options['gallery_photo_height'] : '';
	
	$img_width = ( $cs_image_width == '' ) ? 150 : $cs_image_width;
	$img_height = ( $cs_image_height == '' ) ? 150 : $cs_image_height;
	
	while ( have_posts() ) : the_post(); 
		$coach_id = get_post_meta( $post->ID, 'mstw_cs_position_coach', true );
		$name = get_the_title( $coach_id );
		$position = get_the_title( $post->ID );
		
		$experience = get_post_meta( $coach_id, 'mstw_cs_experience', true );
		$alma_mater = get_post_meta( $coach_id, 'mstw_cs_alma_mater', true );
		$degree = get_post_meta( $coach_id, 'mstw_cs_degree', true );
		$birth_date = get_post_meta( $coach_id, 'mstw_cs_birth_date', true );
		$home_town = get_post_meta( $coach_id, 'mstw_cs_home_town', true );
		$high_school = get_post_meta( $coach_id, 'mstw_cs_high_school', true );
		$family = nl2br( get_post_meta( $coach_id, 'mstw_cs_family', true ) );	
		?> 
		
		<div class="coach-tile coach-tile-<?php echo( $staff_slug ) ?>">
		
			<div class = "coach-photo">
				<?php 
				
				// check if the post has a Post Thumbnail assigned to it.
				 if ( has_post_thumbnail( $coach_id ) ) { 
					//Get the photo file;
					$photo_file_url = wp_get_attachment_thumb_url( get_post_thumbnail_id( $coach_id ) );
					$alt = __( 'Photo of', 'mstw-loc-domain' ) . ' ' . $name;
				} else {
					// Default image is tied to the staff taxonomy. 
					// Try to load default-photo-staff-slug.jpg, If it does not exst,
					// Then load default-photo.jpg from the plugin -->
					$photo_file = WP_PLUGIN_DIR . '/coaching-staffs/images/default-photo' . '-' . $staff_slug . '.jpg';
					if ( file_exists( $photo_file ) ) {
						$photo_file_url = plugins_url() . '/coaching-staffs/images/default-photo' . '-' . $staff_slug . '.jpg';
						$alt = __( 'Default image for', 'mstw-loc-domain' ) . ' ' . $staff_slug;
					}
					else {
						$photo_file_url = plugins_url() . '/coaching-staffs/images/default-photo' . '.jpg';
						$alt = __( 'Photo not found.', 'mstw-loc-domain' );
					}
				}
				// See if the single-coach.php template is in the theme directory
				// If so, add a link to the coach's profile to the photo
				
				$custom_coach_template = get_stylesheet_directory( ) . '/single-coach.php';
				$plugin_coach_template = dirname( __DIR__ ) . '/theme-templates/single-coach.php';
				//mstw_log_msg( "plugin template: $plugin_coach_template" );
				
				if ( file_exists( $custom_coach_template ) ) {
					$single_coach_template = $custom_coach_template;
					//mstw_log_msg( "using custom template: $custom_coach_template" );
					
				} else if ( file_exists( $plugin_coach_template ) ) {
					$single_coach_template = $plugin_coach_template;
					//mstw_log_msg( "using plugin template: $plugin_coach_template" );
					
				}	else {
					$single_coach_template = '';
					//mstw_log_msg( "No coach template found" );
					
				}
				
				if ( $single_coach_template ) {
					echo( '<a href="' . get_permalink( $coach_id ) . '?position='. $post->ID . '">' . '<img src="' . $photo_file_url . '" alt="' . $alt . '" width="' . $img_width . '" height="' . $img_height . '" /></a>' );
				}
				else {
					echo( '<img src="' . $photo_file_url . '" alt="' . $alt . '" width="' . $img_width . '" height="' . $img_height . '" />' );
				}
				?>
				
			</div> <!-- .coach-photo -->
			
			<div class = "coach-info-container">
				<?php
				// See if the single-coach.php template is in the theme directory
				// If so, add a link to the coach's name
				if ( $single_coach_template ) {
					$coach_html = '<a href="' .  get_permalink( $coach_id ) . '?position='. $post->ID . '">';
					$coach_html .= get_the_title( $coach_id ) . '</a>';
				}
				else {
					$coach_html = get_the_title( $coach_id );
				}
			
				?>
				
				<div class="coach-name-position"> 
					<h1><?php echo $coach_html ?></h1>
					<?php if ( $options['show_position'] == 1 ) { ?>
						<h2><?php echo $position ?></h2>
					<?php } ?>
				</div>
				
			
				<table class="coach-info">
				<tbody>
					<?php 
					$row_start = '<tr><td class="lf-col">';
					$new_cell = ':</td><td class="rt-col">'; //colon is for the end of the title
					$row_end = '</td></tr>';
					
					//EXPERIENCE
					if( $options['show_experience'] ) {
						echo $row_start . $options['experience_label'] . $new_cell .  $experience . $row_end;
					}
					
					//ALMA MATER
					if( $options['show_alma_mater'] ) {
						echo $row_start . $options['alma_mater_label'] . $new_cell .  $alma_mater . $row_end;
					}
					
					// DEGREE
					if( $options['show_degree'] ) {
						echo $row_start . $options['degree_label'] . $new_cell .  $degree . $row_end;
					}
					
					// BIRTH DATE
					if( $options['show_birth_date'] ) {
						echo $row_start . $options['birth_date_label'] . $new_cell .  $birth_date . $row_end;
					}
					
					// HOMETOWN
					if( $options['show_home_town'] ) {
						echo $row_start . $options['home_town_label'] . $new_cell .  $home_town . $row_end;
					}
					
					// HIGH SCHOOL
					if( $options['show_high_school'] ) {
						echo $row_start . $options['high_school_label'] . $new_cell .  $high_school . $row_end;
					}
					
					// FAMILY
					if( $options['show_family'] ) {
						echo $row_start . $options['family_label'] . $new_cell .  $family . $row_end;
					}
					
					?>
					
				</tbody>
				</table>
			</div><!-- .coach-info-container --> 	
		</div><!-- .coach-tile -->

	<?php endwhile; ?>

	</div><!-- #content -->
	</section><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>