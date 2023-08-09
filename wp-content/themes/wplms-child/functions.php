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

// Function to add files to the site:
// prism.css
// prism.js
// postscribe.min.js
function add_external_files() {
	static $is_added = false;

    // if ( !is_single() && has_tag( 'code' ) ) {
        
        // Register prism.css file
        wp_register_style(
            'prismCSS', // handle name for the style 
            get_stylesheet_directory_uri() . '/prism.css', // location of the prism.css file
			array(), '1.29.0', false
        );

        // Register prism.js file
        wp_register_script(
            'prismJS', // handle name for the script 
            get_stylesheet_directory_uri() . '/prism.js', // location of the prism.js file
			array(), '1.29.0', true
        );

        // Enqueue the registered style and script files
        wp_enqueue_style('prismCSS');
        wp_enqueue_script('prismJS');

    // }
	// if ( !is_single() ) {
		// Register not local postscribe.min.js file
		wp_register_script(
			'postscribeJS', // handle name for the script 
			'https://cdnjs.cloudflare.com/ajax/libs/postscribe/2.0.8/postscribe.min.js', 
			array(), '2.0.8', false  // location of the prism.js file
		);
		// Register local postscribe.min.js file
		// wp_register_script(
		// 	'postscribeJSlocal', // handle name for the script 
		// 	get_stylesheet_directory_uri() . '/postscribe.min.js' // location of the postscribe.min.js file
		// );
		// Enqueue the registered style and script files
		wp_enqueue_script('postscribeJS');
	// }

    // Register tsparticles-confetti script
    wp_register_script('tsparticles-confetti', 'https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js', array(), '2.12.0', true);
    // Register tsparticles-preset-fireworks script
    wp_register_script('tsparticles-preset-fireworks', 'https://cdn.jsdelivr.net/npm/tsparticles-preset-fireworks@2.7.0/tsparticles.preset.fireworks.bundle.js', array('tsparticles-confetti'), '2.7.0', true);

    // Enqueue scripts and styles
    wp_enqueue_script('tsparticles-confetti');
    wp_enqueue_script('tsparticles-preset-fireworks');

	if ( !is_single() ) {
		// 	Register local style file
		wp_register_style( 'codeAssignmentCSSlocal', plugins_url( 'code_assignment/code_assignment.css'));
		// Register local code_assignment.js file
		wp_register_script(
			'codeAssignmentJSlocal', // handle name for the script 
			plugins_url( 'code_assignment/code_assignment.js', array('jquery'), '1.0.0', true )// location of the code_assignment.js file
		);
		// Enqueue the registered style and script files
		wp_enqueue_style('codeAssignmentCSSlocal');
		wp_enqueue_script('codeAssignmentJSlocal');
	}
}

add_action('wp_enqueue_scripts', 'add_external_files');




// add_filter("script_loader_tag", "add_module_to_my_script", 10, 3);
// function add_module_to_my_script($tag, $handle, $src)
// {
//     if ("codeAssignmentJSlocal" === $handle) {
//         $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
//     }

//     return $tag;
// }

?>
