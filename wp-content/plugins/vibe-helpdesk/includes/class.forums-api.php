<?php
/**
 * API\
 *
 * @class       Vibe_Helpdesk_API
 * @author      VibeThemes
 * @category    Admin
 * @package     vibebp
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Vibe_HelpDesk_Forums_API{

    public static $instance;
    public static function init(){
        if ( is_null( self::$instance ) )
            self::$instance = new Vibe_HelpDesk_Forums_API();
        return self::$instance;
    }

    private function __construct(){
        add_action('rest_api_init',array($this,'register_routes'));
    }

    public function register_routes() {

        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/forums', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'get_forums' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );

        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/componentForum', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'get_component_forum' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );
        
        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/subforums', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'get_sub_forums' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );
        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/forums/create_fields', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'get_create_forum_fields' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );
        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/forums/create', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'create_new_forum' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );
    }


     function get_user_permissions_check($request){
        $body = json_decode($request->get_body(),true);
        
        if(!empty($body['token'])){
            global $wpdb;
            $this->user = apply_filters('vibebp_api_get_user_from_token','',$body['token']);
            if(!empty($this->user)){
                wp_set_current_user($this->user->id);
                return true;
            }
        }
        return false;
    }

    function get_component_forum($request){
        $args = json_decode($request->get_body(),true);

        $forum_id = apply_filters('vibe_helpdesk_get_component_forum',0,$args['detail']);

        if(!empty($forum_id)){
            
            if(is_numeric($forum_id)){
                $this->subscriptions = vibe_helpdesk_user_subscribed_forum_ids( $this->user->id );
                $forum = array(
                    'id'=>$forum_id,
                    'title'=>get_the_title($forum_id),
                    'description'=>html_entity_decode(get_the_content($forum_id)),
                    'private'=>bbp_is_forum_private( $forum_id ),
                    'subscribed'=>in_array($forum_id,$this->subscriptions)?true:false,
                    'access'=> apply_filters('vibebp_forum_access',true,$forum_id ,$this->user->id),
                    'topic_count'=>bbp_get_forum_topic_count( $forum_id , false, true ),
                    'forums_count'=>bbp_get_forum_subforum_count( $forum_id , true ),
                    'last_active_time'=>bbp_get_forum_last_active_time( $forum_id , false ),
                    'post_count'=>bbp_get_forum_reply_count( $forum_id ,false ),

                );
            }
              
            return new WP_REST_Response(['status'=>empty($forum)?0:1,'forum'=>$forum], 200); 
        }

        return new WP_REST_Response(['status'=>0,'message'=>__('No component forum','vibe-helpdesk')], 200); 
    }

    function get_forums($request){
        $args = json_decode($request->get_body(),true);
        unset($args['token']);
        if(empty($args['s'])){
            unset($args['s']);
        }
        $user_id = $this->user->id;
        $forums = array();
        $return = array(
            'status'=>0,
            'message'=>_x('Forums not found!','Forums not found!','vibe-helpdesk')
        );
        $args['post_type'] = bbp_get_forum_post_type();
        $this->subscriptions = vibe_helpdesk_user_subscribed_forum_ids( $user_id );
        if(!empty($args['type'])){
            switch($args['type']){
                case 'subscribed':
                case 'subscriptions':
                    $args['post__in']= $this->subscriptions;
                break;
            }   
        }

        
        $args = apply_filters('vibe_helpdesk_forums_args',$args,$this->user);
        if(empty($args['post_parent'])){
            $args['post_parent'] = 0;    
        }
        
        $ids = [];
        if(function_exists('bbp_has_forums')){
            if(!empty($user_id)){
                $args['post__not_in'] = $this->subscriptions;
            }

            if ( bbp_has_forums($args) ) :
                while ( bbp_forums() ) : bbp_the_forum();
                    global $post;
                    $ids[]=$post->ID;
                    $forums[] = array(
                        'id'=>$post->ID,
                        'title'=>$post->post_title,
                        'description'=>html_entity_decode($post->post_content),
                        'private'=>bbp_is_forum_private( $post->ID ),
                        'subscribed'=>in_array($post->ID,$this->subscriptions)?true:false,
                        'access'=> apply_filters('vibebp_forum_access',true,$post->ID,$user_id),
                        'topic_count'=>bbp_get_forum_topic_count( $post->ID, false, true ),
                        'forums_count'=>bbp_get_forum_subforum_count( $post->ID, true ),
                        'last_active_time'=>bbp_get_forum_last_active_time( $post->ID, false ),
                        'post_count'=>bbp_get_forum_reply_count( $post->ID,false ),

                    );
                endwhile;
            endif;


            // set message from topics
            if(!empty($forums)){
                $bbp = bbpress();
                $return=array(
                    'status' => 1,
                    'forums' => $forums,
                    'total'=>$bbp->forum_query->found_posts
                );
            }else{
                $return=array(
                    'status' => 0,
                    'message' => __('No forums found.','vibe-helpdesk')
                );
            }
        }
        $return = apply_filters('VibeBbp_get_forums_api',$return,$args);
        return new WP_REST_Response($return, 200); 
    }

    function get_sub_forums($request){

        $args = json_decode($request->get_body(),true);
        
        $sub_forums = bbp_forum_get_subforums( $args['forum_id'] );
         $user_id = $this->user->id;
        $this->subscriptions = vibe_helpdesk_user_subscribed_forum_ids( $user_id );
        $forums = [];
        if(!empty($sub_forums)){

            foreach($sub_forums as $post){
                $forums[] = array(
                    'id'=>$post->ID,
                    'title'=>$post->post_title,
                    'description'=>html_entity_decode($post->post_content),
                    'private'=>bbp_is_forum_private( $post->ID ),
                    'subscribed'=>in_array($post->ID,$this->subscriptions)?true:false,
                    'access'=> apply_filters('vibebp_forum_access',true,$post->ID,$user_id),
                    'topic_count'=>bbp_get_forum_topic_count( $post->ID, false, true ),
                    'forums_count'=>bbp_get_forum_subforum_count( $post->ID, true ),
                    'last_active_time'=>bbp_get_forum_last_active_time( $post->ID, false ),
                    'post_count'=>bbp_get_forum_reply_count( $post->ID,false ),
                );
            }
        }
        if(empty($forums)){$status=0;}else{$status=1;}
        return new WP_REST_Response(['status'=>$status,'forums'=>$forums], 200); 
    }

    function get_create_forum_fields($request){
        $args = json_decode($request->get_body(),true);
        $forum_id = 0;
        if(!empty($args['forum_id'])){
            $forum_id = esc_attr($args['forum_id']);
        }
        
        return new WP_REST_Response(['status'=>1,'fields'=>vibehelpdesk_get_forum_creation_fields($forum_id)], 200); 
    }

    function create_new_forum($request){
        $args = json_decode($request->get_body(),true);


        $anonymous_data=[];

        $forum_content = $forum_title = $forum_parent_id = '';
        if ( ! empty( $args['post_title'] ) ) {
            $forum_title = sanitize_text_field( $args['post_title'] );
        }

        // Filter and sanitize
        $forum_title = apply_filters( 'bbp_new_forum_pre_title', $forum_title );

        // No forum title
        if ( empty( $forum_title ) ) {
            return new WP_REST_Response(['status'=>0,'message'=>__('Your forum needs a title.','vibe-helpdesk')], 200); 
        }

        // Title too long
        if ( bbp_is_title_too_long( $forum_title ) ) {
            return new WP_REST_Response(['status'=>0,'message'=>__('Your title is too long.','vibe-helpdesk')], 200); 
        }


        if ( ! empty( $args['post_content'] ) ) {
            $forum_content = $args['post_content'];
        }

        // Filter and sanitize
        $forum_content = apply_filters( 'bbp_new_forum_pre_content', $forum_content );

        // No forum content
        if ( empty( $forum_content ) ) {
            return new WP_REST_Response(['status'=>0,'message'=>__('Your forum description cannot be empty.','vibe-helpdesk')], 200); 
        }

        /** Forum Parent **********************************************************/

        // Forum parent was passed (the norm)
        if ( ! empty( $args['post_parent'] ) ) {
            $forum_parent_id = bbp_get_forum_id( $args['post_parent'] );
        }

        // Filter and sanitize
        $forum_parent_id = apply_filters( 'bbp_new_forum_pre_parent_id', $forum_parent_id );

        // No forum parent was passed (should never happen)
        if ( empty( $forum_parent_id ) ) {
            return new WP_REST_Response(['status'=>0,'message'=>__('Your forum must have a parent.','vibe-helpdesk')], 200); 
        } elseif ( ! empty( $forum_parent_id ) ) {

            // Forum is a category
            if ( bbp_is_forum_category( $forum_parent_id ) ) {
                return new WP_REST_Response(['status'=>0,'message'=>__('This forum is a category. No forums can be created in this forum.','vibe-helpdesk')], 200); 
            }

            // Forum is closed and user cannot access
            if ( bbp_is_forum_closed( $forum_parent_id ) && ! user_can( $this->user->id,'edit_forum', $forum_parent_id ) ) {
                 return new WP_REST_Response(['status'=>0,'message'=>__('This forum has been closed to new forums.','vibe-helpdesk')], 200); 
            }

            // Forum is private and user cannot access
            if ( bbp_is_forum_private( $forum_parent_id ) && ! user_can( $this->user->id, 'read_forum', $forum_parent_id ) ) {
                return new WP_REST_Response(['status'=>0,'message'=>__('This forum is private and you do not have the capability to read or create new forums in it.','vibe-helpdesk')], 200); 
            }

            // Forum is hidden and user cannot access
            if ( bbp_is_forum_hidden( $forum_parent_id ) && ! user_can( $this->user->id, 'read_forum', $forum_parent_id ) ) {
                 return new WP_REST_Response(['status'=>0,'message'=>__('This forum is hidden and you do not have the capability to read or create new forums in it.','vibe-helpdesk')], 200); 
            }
        }

        if ( ! bbp_check_for_flood( $anonymous_data, $this->user->id ) ) {
            return new WP_REST_Response(['status'=>0,'message'=>__('Slow down; you move too fast.','vibe-helpdesk')], 200); 
        }


        // remove_filter( 'bbp_new_forum_pre_title',   'wp_filter_kses'      );
        // remove_filter( 'bbp_new_forum_pre_content', 'bbp_encode_bad',  10 );
        // remove_filter( 'bbp_new_forum_pre_content', 'bbp_filter_kses', 30 );


        $dupe_args = array(
            'post_type'      => bbp_get_forum_post_type(),
            'post_author'    => $this->user->id,
            'post_content'   => $forum_content,
            'post_parent'    => $forum_parent_id,
            'anonymous_data' => $anonymous_data
        );

        if ( ! bbp_check_for_duplicate( $dupe_args ) ) {
            return new WP_REST_Response(['status'=>0,'message'=>__('This forum already exists.','vibe-helpdesk')], 200); 
        }

        /** Forum Bad Words *******************************************************/
        $forum_author = $this->user->id;

        if ( ! bbp_check_for_moderation( $anonymous_data, $this->user->id, $forum_title, $forum_content, true ) ) {
            return new WP_REST_Response(['status'=>0,'message'=>__('Your forum cannot be created at this time.','vibe-helpdesk')], 200); 
        }

        /** Additional Actions (Before Save) **************************************/

        do_action( 'bbp_new_forum_pre_extras', $forum_parent_id );

        // Add the content of the form to $forum_data as an array
        // Just in time manipulation of forum data before being created
        $forum_data = apply_filters( 'bbp_new_forum_pre_insert', array(
            'post_author'    => $forum_author,
            'post_title'     => $forum_title,
            'post_content'   => $forum_content,
            'post_parent'    => $forum_parent_id,
            'post_status'    => $args['post_status'],
            'post_type'      => bbp_get_forum_post_type(),
            'comment_status' => 'closed'
        ) );

        // Insert forum
        $forum_id = bbp_insert_forum( $forum_data, ['forum_id'=>$forum_parent_id] );
        if(is_wp_error( $forum_id ) ) {
            return new WP_REST_Response(['status'=>0,'message'=>sprintf( __( 'The following problem(s) occurred: %s', 'vibe-heldesk' ), $forum_id->get_error_message() )], 200); 
        }

        do_action( 'bbp_new_forum', array(
            'forum_id'           => $forum_id,
            'post_parent'        => $forum_parent_id,
            'forum_author'       => $forum_author,
            'last_topic_id'      => 0,
            'last_reply_id'      => 0,
            'last_active_id'     => 0,
            'last_active_time'   => 0,
            'last_active_status' => bbp_get_public_status_id()
        ) );

        if(!empty($args['meta'])){
            foreach($args['meta'] as $meta){
                update_post_meta($forum_id,$meta['meta_key'],$meta['meta_value']);
            }
        }

        if(!empty($args['raw'])){
            update_post_meta($forum_id,'raw',$args['raw']);
        }
        /** Additional Actions (After Save) ***********************************/

        do_action( 'bbp_new_forum_post_extras', $forum_id );

        $return =['status'=>1,'message'=>__('New forum created','vibe-helpdesk')];

        return new WP_REST_Response($return, 200); 
    }

    
}


Vibe_HelpDesk_Forums_API::init();

