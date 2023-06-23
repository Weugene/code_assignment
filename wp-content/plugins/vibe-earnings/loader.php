<?php
/**
 * Plugin Name: Vibe Earnings
 * Plugin URI: https://wplms.io
 * Description: Vibe Earnings 
 * Author: VibeThemes
 * Author URI: https://wplms.io
 * Version: 2.0
 * Text Domain: vibe-earnings
 * Domain Path: /languages
 * Tested up to: 6.1.1
 *
 * @package WPLMS
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'VIBE_EARNINGS_PLUGIN_VERSION', '2.0' );


define( 'VIBE_EARNINGS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'VIBE_EARNINGS_PLUGIN_URL', untrailingslashit(plugin_dir_url( __FILE__ )) );
define( 'VIBE_EARNINGS_PLUGIN_INCLUDES_URL', untrailingslashit(plugin_dir_url( __FILE__ )).'/includes' );
define( 'VIBE_EARNINGS_PLUGIN_FILE', __FILE__ );
define( 'VIBE_EARNINGS_PLUGIN_BASE', plugin_basename( __FILE__ ) );



if(function_exists('bp_is_active')){
	require_once(VIBE_EARNINGS_PLUGIN_DIR.'/includes/class.init.php');
	require_once(VIBE_EARNINGS_PLUGIN_DIR.'/includes/class.settings.php');
    add_action('plugins_loaded',function(){

        require_once(VIBE_EARNINGS_PLUGIN_DIR.'/includes/class.api.php');
        require_once(VIBE_EARNINGS_PLUGIN_DIR.'/includes//widgets/earningwidget.php');

    });
}


add_action('plugins_loaded','vibe_earnings_load_translations');
function vibe_earnings_load_translations(){
    $locale = apply_filters("plugin_locale", get_locale(), 'vibebp');
    $lang_dir = dirname( __FILE__ ) . '/languages/';
    $mofile        = sprintf( '%1$s-%2$s.mo', 'vibe-earnings', $locale );
    $mofile_local  = $lang_dir . $mofile;
    $mofile_global = WP_LANG_DIR . '/plugins/' . $mofile;
    if ( file_exists( $mofile_global ) ) {
       load_textdomain( 'vibe-earnings', $mofile_global );
       
    } else {
        load_textdomain( 'vibe-earnings', $mofile_local );
    }  
}


add_action( 'admin_init', 'vibebp_earnings_plugin_update' );
function vibebp_earnings_plugin_update() {
    /* Load Plugin Updater */
    require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/autoupdate.php' );

    /* Updater Config */
    $config = array(
        'base'      => plugin_basename( __FILE__ ), //required
        'dashboard' => true,
        'repo_uri'  => 'https://wplms.io/',  //required
        'repo_slug' => 'vibe-earnings',  //required
    );

    /* Load Updater Class */
    new Vibe_Earnings_Auto_Update( $config );
}