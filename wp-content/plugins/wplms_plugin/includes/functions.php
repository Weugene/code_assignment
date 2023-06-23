<?php
/**
 * Functions for WPLMS 4/5
 *
 * @author      VibeThemes
 * @category    Admin
 * @package     WPLMS Plugin
 * @version     5
 */

 if ( ! defined( 'ABSPATH' ) ) exit;


function wplms_vibebp_carousel_blocks(){

	$blocks=[];
	$blocks['blog_card']=__('Blog Card','wplms'); 
    $blocks['general']=__('General Card','wplms'); 
    $blocks['simple']=__('Simple Card','wplms'); 
    $blocks['generic_card']=__('Generic Card','wplms'); 
    $blocks['generic']=__('Generic block','wplms'); 
    $blocks['blogpost']=__('Blog Post','wplms'); 
    $blocks['images_only']=__('Feature Image','wplms'); 
    $blocks['postblock']=__('Post Block','wplms'); 
    $blocks['course10']=__('Course 10','wplms'); 
    $blocks['course9']=__('Course 9','wplms'); 
    $blocks['course8']=__('Course 8','wplms'); 
    $blocks['course7']=__('Course 7','wplms'); 
    $blocks['course6']=__('Course 6','wplms'); 
    $blocks['course5']=__('Course 5','wplms'); 
    $blocks['course4']=__('Course 4','wplms'); 
    $blocks['course3']=__('Course 3','wplms'); 
    $blocks['course2']=__('Course 2','wplms'); 
    $blocks['course']=__('Course 1','wplms'); 
    $blocks['course_card']=__('Course Card','wplms'); 

    return $blocks;
}

function bp_get_sample_course_certificate_url($course_id){
    $url = apply_filters('bp_get_sample_course_certificate_url','',$course_id);
    if(empty($url)){
        $template_id = get_post_meta($course_id,'vibe_certificate_template',true);
        $url = get_permalink($template_id);
    }
    
    return $url;
}