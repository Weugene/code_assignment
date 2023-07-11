<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 *
 * @package WPLMSChild
 */

if ( !defined( 'VIBE_URL' ) )
define('VIBE_URL',get_template_directory_uri());

// security access
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


// require_once plugin_dir_path( __FILE__ ).'/code_assignment/custom-elementor.php';
/**
 * Add custom functions here
 */

// Function to add prism.css and prism.js to the site
function add_prism() {

    // if ( is_single() && has_tag( 'code' ) ) {
        
        // Register prism.css file
        wp_register_style(
            'prismCSS', // handle name for the style 
            get_stylesheet_directory_uri() . '/prism.css' // location of the prism.css file
        );

        // Register prism.js file
        wp_register_script(
            'prismJS', // handle name for the script 
            get_stylesheet_directory_uri() . '/prism.js' // location of the prism.js file
        );

        // Enqueue the registered style and script files
        wp_enqueue_style('prismCSS');
        wp_enqueue_script('prismJS');

    // }
}

function add_postscribe(){
	// Register not local postscribe.min.js file
	wp_register_script(
		'postscribeJS', // handle name for the script 
		'https://cdnjs.cloudflare.com/ajax/libs/postscribe/2.0.8/postscribe.min.js' // location of the prism.js file
	);
	// Register local postscribe.min.js file
	wp_register_script(
		'postscribeJSlocal', // handle name for the script 
		get_stylesheet_directory_uri() . '/postscribe.min.js' // location of the postscribe.min.js file
	);
	// Enqueue the registered style and script files
	wp_enqueue_script('postscribeJS');
}
add_action('wp_enqueue_scripts', 'add_prism');
// add_action('wp_enqueue_scripts', 'add_postscribe');

?>
