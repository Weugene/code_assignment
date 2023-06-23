<?php
/**
 * Functions
 *
 * @author      VibeThemes
 * @category    Admin
 * @package     VibeKb
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vibe_helpdesk_user_subscribed_forum_ids($user_id){
    $ids = [];
    global $wpdb;
    $results = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} as p LEFT JOIN {$wpdb->postmeta} as pm ON pm.post_id=p.ID WHERE pm.meta_key='_bbp_subscription' AND meta_value={$user_id} AND (post_status!='draft' || post_status!='trash')");
    if(!empty($results)){
        foreach ($results as $key => $va) {
            $ids[] = $va->ID;
        }
    }
    return $ids;
}

function vibehelpdesk_get_forum_creation_fields($forum_id = 'null'){

    global $wpdb;
    $forums = $wpdb->get_results("SELECT ID as value,post_title as label FROM {$wpdb->posts} WHERE post_type = 'forum' AND post_status != 'trash'");

    return apply_filters('vibe_helpdesp_create_forum',array(
        array(
            'label'=> __('Forum title','vibe-helpdesk' ),
            'type'=> 'title',
            'id' => 'post_title',
            'from'=>'post',
            'value_type'=>'single',
            'style'=>'full',
            'default'=> __('Enter a Forum title','vibe-helpdesk' ),
            'desc'=> __('This is the title of the forum, the most relevant detail to recognise the forum.','vibe-helpdesk' ),
            'value'=>(empty($forum_id)?'':get_the_title($forum_id))
        ),
        array(
            'label'=> __('Forum Type','vibe-helpdesk' ),
            'type'=> 'select',
            'id' => '_bbp_forum_type',
            'from'=>'meta',
            'value_type'=>'single',
            'default'=>'publish',
            'options'=>[['value'=>'forum','label'=>__('Forum','vibe-helpdesk')],['value'=>'category','label'=>__('Category of Forums/Topics','vibe-helpdesk')]],
            'desc'=> __('This is the status of the forum','vibe-helpdesk' ),
            'value'=>(empty($forum_id)?'':bbp_get_forum_status($forum_id))
        ),
        array(
            'label'=> __('Forum Status','vibe-helpdesk' ),
            'type'=> 'select',
            'id' => '_bbp_status',
            'from'=>'meta',
            'value_type'=>'single',
            'default'=>'publish',
            'options'=>[['value'=>'open','label'=>__('Open','vibe-helpdesk')],['value'=>'closed','label'=>__('Closed','vibe-helpdesk')]],
            'desc'=> __('This is the status of the forum','vibe-helpdesk' ),
            'value'=>(empty($forum_id)?'':bbp_get_forum_type($forum_id))
        ),
        array(
            'label'=> __('Forum Visbility','vibe-helpdesk' ),
            'type'=> 'select',
            'id' => 'post_status',
            'from'=>'post',
            'value_type'=>'single',
            'default'=>'publish',
            'options'=>[['value'=>'public','label'=>__('Public','vibe-helpdesk')],['value'=>'private','label'=>__('Private','vibe-helpdesk')],['value'=>'hidden','label'=>__('Hidden','vibe-helpdesk')]],
            'desc'=> __('This is the status of the forum','vibe-helpdesk' ),
            'value'=>(empty($forum_id)?'':bbp_get_forum_visibility($forum_id))
        ),
        array(
            'label'=> __('Parent Forum','vibe-helpdesk' ),
            'type'=> 'select',
            'id' => 'post_parent',
            'from'=>'post',
            'value_type'=>'single',
            'default'=>'publish',
            'options'=>$forums,
            'desc'=> __('Select a parent forum for this forum','vibe-helpdesk' ),
            'value'=>(empty($forum_id)?'':bbp_get_forum_visibility($forum_id))
        ),
        array(
            'label'=> __('Detailed Description of the Forum','vibe-helpdesk' ),
            'type'=> 'editor',
            'style'=>'full',
            'value_type'=>'single',
            'id' => 'post_content',
            'from'=>'post',
            'noscript'=>true,
            'raw'=> empty($forum_id)? '':get_post_meta($forum_id,'raw',true),
            'desc'=> __('Enter full description for the forum.','vibe-helpdesk' ),
            'value' => (empty($forum_id)? '':get_the_content('','',$forum_id))
        )
    ),$forum_id);
}


function vibehelpdesk_get_topic_creation_fields($topic_id){
    global $wpdb;
    $forums = $wpdb->get_results("SELECT ID as value,post_title as label FROM {$wpdb->posts} WHERE post_type = 'forum' AND post_status != 'trash'");

    
    return apply_filters('vibe_helpdesp_create_forum',array(
        array(
            'label'=> __('Topic title','vibe-helpdesk' ),
            'type'=> 'title',
            'id' => 'post_title',
            'from'=>'post',
            'value_type'=>'single',
            'style'=>'full',
            'default'=> __('Enter a Forum title','vibe-helpdesk' ),
            'desc'=> __('This is the title of the forum, the most relevant detail to recognise the forum.','vibe-helpdesk' ),
            'value'=>(empty($topic_id)?'':get_the_title($topic_id))
        ),
        array(
            'label'=> __('Topic Type','vibe-helpdesk' ),
            'type'=> 'select',
            'id' => '_bbp_forum_type',
            'from'=>'meta',
            'value_type'=>'single',
            'default'=>'publish',
            'options'=>[['value'=>'normal','label'=>__('Normal Topic','vibe-helpdesk')],['value'=>'sticky','label'=>__('Sticky Topic','vibe-helpdesk')],['value'=>'supersticky','label'=>__('Super Sticky Topic','vibe-helpdesk')]],
            'desc'=> __('This is the type of the forum','vibe-helpdesk' ),
            'value'=>(empty($topic_id)?'':bbp_get_forum_status($topic_id))
        ),
        array(
            'label'=> __('Topic Status','vibe-helpdesk' ),
            'type'=> 'select',
            'id' => '_bbp_status',
            'from'=>'meta',
            'value_type'=>'single',
            'default'=>'publish',
            'options'=>[['value'=>'open','label'=>__('Open','vibe-helpdesk')],['value'=>'closed','label'=>__('Closed','vibe-helpdesk')],['value'=>'spam','label'=>__('Span','vibe-helpdesk')],['value'=>'trash','label'=>__('Trash','vibe-helpdesk')],['value'=>'pending','label'=>__('Pending','vibe-helpdesk')]],
            'desc'=> __('This is the status of the topic','vibe-helpdesk' ),
            'value'=>(empty($topic_id)?'':bbp_get_topic_status($topic_id))
        ),
        array(
            'label'=> __('Topic Forum ','vibe-helpdesk' ),
            'type'=> 'select',
            'id' => 'post_parent',
            'from'=>'post',
            'value_type'=>'single',
            'default'=>'publish',
            'options'=>$forums,
            'value'=>(empty($topic_id)?'':bbp_get_topic_forum_id($topic_id))
        ),
        array(
            'label'=> __('Detailed Description of the Topic','vibe-helpdesk' ),
            'type'=> 'editor',
            'style'=>'full',
            'value_type'=>'single',
            'id' => 'post_content',
            'from'=>'post',
            'noscript'=>true,
            'raw'=> empty($topic_id)? '':get_post_meta($topic_id,'raw',true),
            'desc'=> __('Enter full description for the forum.','vibe-helpdesk' ),
            'value' => (empty($topic_id)? '':get_the_content('','',$topic_id))
        )
    ),$topic_id);
}