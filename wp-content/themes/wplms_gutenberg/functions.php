<?php

if ( !defined( 'VIBE_URL' ) )
define('VIBE_URL',get_template_directory_uri());

if(!defined('WPLMS_GUTENBERG_VERSION')){
	define('WPLMS_GUTENBERG_VERSION',rand(0,99999));
}

include_once('customisations.php');


function wplms_site_header_attributes(){

  $classes = apply_filters('micronet_site_header_classes',['site-header']);

  if(!empty(vibe_get_option('header_fix'))){
    $classes[]='fixed_header';
  }

  echo ' class="'.implode(' ',$classes).'"';
}

function main_class(){

    if(is_page_template('elementor_header_footer')){
        return '';
    }
    return 'flex flex-wrap gap-6';
}