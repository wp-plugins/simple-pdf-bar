<?php
/**
* Plugin Name: Simple PDF bar
* Plugin URI: http://adapt.dk
* Description: Add a simple lead generation bar to your PDF-files
* Version: 1.0.0
* Author: Andreas Butze (Adapt A/S)
* Author URI: http://adapt.dk
* License: GPL2
*/

/** Create custom post type function */
function create_posttype() {

	register_post_type( 'pdfbar',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Simple PDF bar' ),
				'singular_name' => __( 'PDF bar' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'view-pdf'),
		)
	);
}
/** Hooking up our function to theme setup */
add_action( 'init', 'create_posttype' );


/** Remove default body field (not used for pdfbar) */
add_action('init', 'pdfbar_init_remove_support',100);
function pdfbar_init_remove_support()
{
   $post_type = 'pdfbar';
   remove_post_type_support( $post_type, 'editor');
}


/** Use custom template in plugin-folder to display pdf */
add_filter('single_template', 'my_custom_template');

function my_custom_template($single) {
    global $wp_query, $post;

	/** Checks for single template by post type */
	if ($post->post_type == "pdfbar"){
			$plugin_dir_path = dirname(__FILE__);
	    if(file_exists($plugin_dir_path. '/templates/pdf_lead_template.php'))
	        return $plugin_dir_path . '/templates/pdf_lead_template.php';
	}
    return $single;
}


/** Add JS to pdfbar admin page */
add_action( 'admin_print_scripts-post-new.php', 'portfolio_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'portfolio_admin_script', 11 );

function portfolio_admin_script() {
    global $post_type;
    if( 'pdfbar' == $post_type ){
    	/** Add the color picker css file */       
       wp_enqueue_style( 'wp-color-picker' );
       /** Include pdfbar jQuery file with WordPress Color Picker dependency */
        wp_enqueue_script( 'pdf-admin-settings', plugins_url( '/js/pdf-admin-settings.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}

/** Includes - defines fields and settings */
include( plugin_dir_path( __FILE__ ) . 'define-fields-and-settings.php');


/** If valid PDF-file, output file in object-tag */
add_action( 'the_content', 'output_pdf' );

function output_pdf($content) {
	global $post;
	if(get_post_type() == 'pdfbar'){
		$filearray = get_post_meta( get_the_ID(), 'wp_custom_attachment', true );
		if(!empty($filearray)){
			$pdf_file = $filearray['url'];
			if($pdf_file != ""){
				echo '<div class="object-wrapper"><object id="pdf-main" width="100%" type="application/pdf" data="' . $pdf_file . '">It appears you dont have Adobe Reader or PDF support in your web browser. <a style="text-decoration: underline;" href="' . $pdf_file . '">Click to download PDF-file</a></object></div>';
			}
		}
	}
	return $content;
}


?>