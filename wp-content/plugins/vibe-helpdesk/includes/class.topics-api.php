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


class Vibe_HelpDesk_Topics_API{

    public static $instance;
    public static function init(){
        if ( is_null( self::$instance ) )
            self::$instance = new Vibe_HelpDesk_Topics_API();
        return self::$instance;
    }

    private function __construct(){
        add_action('rest_api_init',array($this,'register_routes'));
    }

    public function register_routes() {
        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/topics', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'get_topics' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );

        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/topics/notes', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'get_topic_notes' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );

        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/topics/notes/create', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'create_topic_notes' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );

        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/topics/notes/delete', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'delete_not_notes' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );


        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/topics/subscribe', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'subscribe_topics' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );
        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/topic', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'get_topic' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );

        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/topics/favorite', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'set_topic_my_favourite' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );

        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/topics/unfavorite', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'unset_topic_my_favourite' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );

        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/topics/delete', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'delete_topic' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );
        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/topics/create_fields', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'get_create_topic_fields' ),
            'permission_callback' => array( $this, 'get_user_permissions_check' ),
        ) );

        register_rest_route( VIBE_HELPDESK_API_NAMESPACE, '/'. Vibe_BP_API_FORUMS_TYPE .'/topics/create', array(
            'methods'                   =>   'POST',
            'callback'                  =>  array( $this, 'create_topic' ),
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

    function get_topics($request){
        $args = json_decode($request->get_body(),true);
        $topics = array();
        $return = array(
            'status'=>0,
            'message'=>_x('Topics not found!','Topics not found!','vibe-helpdesk')
        );
        $favorites = bbp_get_user_favorites_topic_ids( $this->user->id );
        if(empty($favorites)){$favorites=array(0);} //force zero results
        $subscriptions = bbp_get_user_subscribed_topic_ids( $this->user->id );
        if(empty($subscriptions)){$subscriptions=array(0);}//force zero results
        $type = '';
        if(!empty($args['type'])){
            switch($args['type']){
                case 'mine':
                    $args['author'] = $this->user->id;
                break;
              
                case 'topics':
                    $args['author'] = $this->user->id;
                break;
                case 'favorites':
                    $args['post__in'] = $favorites;
                break;
                case 'subscriptions':
                    $args['post__in'] = $subscriptions;
                break;
                case 'unassigned': //supervisor
                    $args['meta_query'] = array(
                        array(
                            'key'=>'assigned_agent',
                            'compare'=>'NOT EXISTS'
                        )
                    ); 
                break;
                case 'recent_assigned': //supervisor
                    $args['meta_query'] = array(
                        array(
                            'key'=>'assigned_agent',
                            'compare'=>'EXISTS'
                        )
                    );
                break;
                case 'assigned': //agent
                    $args['meta_query'] = array(
                        array(
                            'key'=>'assigned_agent',
                            'value'=>$this->user->id,
                            'compare'=>'='
                        ),
                        array(
                            'key'=>'resolved',
                            'compare'=>'NOT EXISTS'
                        )
                    );
                break; 
                case 'resolved': //agent
                    $args['meta_query'] = array(
                        array(
                            'key'=>'resolved',
                            'value'=>1,
                            'compare'=>'='
                        ),
                        array(
                            'key'=>'assigned_agent',
                            'value'=>$this->user->id,
                            'compare'=>'='
                        )
                    );
                break;
            }
        }
        // Labels based meta search
        if(!empty($args['label'])){
            $args['meta_query'] = array(
                array(
                    'key'=>'assigned_topic_label',
                    'value'=>$args['label'],
                    'compare'=>'='
                )
            ); 
        }

        if(!empty($args['priorities'])){
            $tax[] = array(
                'taxonomy' => VIBEHELPDESK_TOPIC_PRIORITY,
                'field'    => 'term_id',
                'terms'    => $args['priorities'],
                'operator' => 'IN',
            );
            $args['tax_query'][] = $tax;
        }

        $args = apply_filters('vibe_helpdesk_topic_args',$args,$this->user);
        unset($args['token']);
        unset($args['s']);
        unset($args['sorter']);
        if(function_exists('bbp_has_topics')){
            //fetch all topic by parent
            $index = -1;

            if ( bbp_has_topics($args) ) :
                while ( bbp_topics() ) : bbp_the_topic();
                    global $post;
                    $topic_id = bbp_get_topic_id();
                    $index++;
                    $topics[] = array(

                        'id'=> $topic_id,
                        'post_title'=>bbp_get_topic_title(),
                        'permalink'=>bbp_get_topic_permalink(),
                        'last_update'=>bbp_get_topic_freshness_link($topic_id),
                        'reply_count'=>bbp_get_topic_reply_count(bbp_get_topic_id()),
                        'author'=> $post->post_author,
                        'post_content'=>bbp_get_topic_content($topic_id),
                        'forum_id'=>$post->post_parent,
                        'favorite'=>in_array($topic_id,$favorites)?true:false,
                        'subscribed'=>in_array($topic_id,$subscriptions)?true:false,
                        'is_resolved' => (int)get_post_meta($topic_id,'resolved',true),
                        'priorities' => wp_get_post_terms($topic_id,VIBEHELPDESK_TOPIC_PRIORITY,array('fields'=>'ids'))
                    );
                    if(!empty($args['type'])){
                        switch ($args['type']) {
                            case 'recent_assigned':
                            case 'unassigned':
                                $topics[$index]['assigned_agents'] = $this->get_assigned_user($topic_id);
                            break;
                            case 'resolved':
                            case 'assigned':
                                $topics[$index]['resolved'] = $this->get_resolved($topic_id);
                            break;
                        }
                    }
                endwhile;
            endif;

            // set message from topics
            if(!empty($topics)){
                $bbp = bbpress();
                $return = array(
                    'status'=>1,
                    'topics'=>$topics,
                    'total'=>$bbp->topic_query->found_posts
                );
            }
        }
        $return = apply_filters('VibeBbp_get_topics_api',$return,$args);
        return new WP_REST_Response($return, 200); 
    }

    function get_topic_notes($request){
        $args = json_decode($request->get_body(),true);
        $data = array('status'=>0);
        if(!empty($args['id']) && ($this->is_topic_agent($args['id']) || $this->can_assign_topic($args['id'])) ){
            global $wpdb;
            $query = $wpdb->prepare ("SELECT meta_id,meta_value FROM {$wpdb->postmeta} WHERE post_id = %d  AND  meta_key='topic_notes'",$args['id']);
            $results = $wpdb->get_results($query,'ARRAY_A');
            if(!empty($results)){
                $data = array(
                    'status' => 1,
                    'data' => $results
                );
            }
        }
        return new WP_REST_Response($data, 200); 
    }

    function create_topic_notes($request){
        $args = json_decode($request->get_body(),true);
        $data = array('status'=>0 ,'message' => __('Note not added!','vibe-helpdesk'));
        if(!empty($args['id']) && isset($args['post_content']) && ($this->is_topic_agent($args['id']) || $this->can_assign_topic($args['id'])) ){
            $meta_id = add_post_meta($args['id'],'topic_notes',$args['post_content']);
            $data = array(
                'status' => 1,
                'message' => __('Note added!','vibe-helpdesk'),
                'data' => array(
                    'meta_id' => $meta_id,
                    'meta_value' => $args['post_content']
                )
            ); 
        }
        return new WP_REST_Response($data, 200); 
    }

    function delete_not_notes($request){
        $args = json_decode($request->get_body(),true);
        $data = array('status'=>0 ,'message' => __('Note not deleted!','vibe-helpdesk'));
        if(!empty($args['meta_id']) && $this->is_agent()) {
            delete_metadata_by_mid('post',$args['meta_id']);
            $data = array(
                'status' => 1,
                'message' => __('Note deleted!','vibe-helpdesk')
            ); 
        }
        return new WP_REST_Response($data, 200); 
    }

    function subscribe_topics($request){
        $body = json_decode($request->get_body(),true);
        $return = array(
            'status'=>0,
            'message'=>__('Unable to chage topic subscription status.','vibe-helpdesk')
        );

        if($body['subscribe']){
            if(bbp_add_user_subscription( $this->user->id, $body['topic_id'])){
                $return = array('status'=>1);
            }else{
                $return['message'] = __('Unable to add subscription','vibe-helpdesk');
            }
        }else{
            if(bbp_remove_user_subscription( $this->user->id, $body['topic_id'])){
                $return = array('status'=>1);
            }else{
                $return['message'] = __('Unable to remove subscription','vibe-helpdesk');
            }
        }
        return new WP_REST_Response($return, 200); 
    }

    function get_topic($request){
        $args = json_decode($request->get_body(),true);
        $topic_id = intval($args['topic_id']);
        $return = array(
            'status'=>0,
            'message'=>_x('Topics not found!','Topics not found!','vibe-helpdesk')
        );
        if($topic_id){
            $topic = $this->get_topic_by_id($topic_id);
            $return = array(
                'status'=>1,
                'topic'=>$topic
            );
        }
        return new WP_REST_Response($return, 200); 
    }

    function get_topic_by_id($topic_id){
        $favorites = bbp_get_user_favorites_topic_ids( $this->user->id );
        $subscriptions = bbp_get_user_subscribed_topic_ids( $this->user->id );
        $topic = get_post( $topic_id,ARRAY_A);
        global $post;
        $arr  = array(
            'id' => $topic_id,
            'post_title'=>$topic['post_title'],
            'permalink'=>bbp_get_topic_permalink($topic_id),
            'last_update' => mysql2date( 'D, d M Y H:i:s +0000', get_post_time( 'Y-m-d H:i:s', true ,$topic_id), false ),
            'author' => $topic['post_author'],
            'post_content'=>$topic['post_content'],
            'reply_count' => (int) get_post_meta( $topic_id, '_bbp_reply_count', true ),
            'forum_id' => $topic['post_parent'],
            'favorite' => in_array($topic_id,$favorites)?true:false,
            'subscribed' => in_array($topic_id,$subscriptions)?true:false,
            'is_resolved' => get_post_meta($topic_id,'resolved',true),
            'priorities' => wp_get_post_terms($topic_id,VIBEHELPDESK_TOPIC_PRIORITY,array('fields'=>'ids'))
        );
        return $arr;
    }

    function set_topic_my_favourite($request){
        $body = json_decode($request->get_body(),true);
        $topic_id = $body['topic_id'];
        $user_id = (int)$this->user->id;
        $data = array(
            'status' => 0,
            'data' => false,
            'message' => _x('Unable to set Fovorite','Fovorite','vibe-helpdesk')
        );
        if(!empty($user_id) && !empty($topic_id)){
            $flag = bbp_add_user_favorite( $user_id, $body['topic_id']);
            if($flag){
                $data = array(
                    'status' => 1,
                    'data' => true,
                    'message' => _x('Topic Set as Fovorite','Topic Set as Fovorite','vibe-helpdesk')
                );
            }
        }
        $data = apply_filters('VibeBbp_set_topic_my_favorite',$data,$request);
        return new WP_REST_Response($data, 200); 
    }

    function unset_topic_my_favourite($request){
        $body = json_decode($request->get_body(),true);
        $topic_id = $body['topic_id'];
        $user_id = (int)$this->user->id;
        $data = array(
            'status' => 0,
            'data' => false,
            'message' => _x('Unable to set Unfavorite','Unfavorite','vibe-helpdesk')
        );
        if(!empty($user_id) && !empty($topic_id)){
            $flag = bbp_remove_user_favorite( $user_id, $body['topic_id']);
            if($flag){
                $data = array(
                    'status' => 1,
                    'data' => true,
                    'message' => _x('Topic Set as Unfavorite','Topic Set as Unfavorite','vibe-helpdesk')
                );
            }
        }
        $data = apply_filters('VibeBbp_unset_topic_my_favorite',$data,$request);
        return new WP_REST_Response($data, 200); 
    }

    function subscribe($request){
        //bbp_add_user_subscription( $user_id = 0, $object_id = 0 )
        //bbp_remove_user_subscription
    }

    function delete_topic($request){
        $args = json_decode($request->get_body(),true);
        $sub_action = $args['sub_action']?$args['sub_action']:'trash';
        $topic_id = $args['topic_id'];
        $user_id = (int)$this->user->id;
        /* validate here user to delete topic..  */
        if(!empty($user_id)){
            if(function_exists('bbp_get_topic')){
                $topic = bbp_get_topic( $topic_id );
                if ( empty( $topic ) ){
                    $data=array(
                        'status' => 0,
                        'data' => false,
                        'message' => _x('Topic not Exist.','Topic not Exist','vibe-helpdesk')
                    );
                }else{
                    if($user_id == $topic->post_author || user_can($user_id,'edit_posts')){
                        switch ( $sub_action ) {
                            case 'trash':
                            $success  = wp_trash_post( $topic_id );
                            if($success){
                                $message = _x('Topic trash successfull','Topic trash successfull','vibe-helpdesk');
                            }
                            break;
                        case 'untrash':
                            $success = wp_untrash_post( $topic_id );
                            if($success){
                                $message = _x('Topic untrash successfull','Topic untrash successfull','vibe-helpdesk');
                            }
                            break;
                        case 'delete':
                            $success = wp_delete_post( $topic_id );
                            if($success){
                                $message = _x('Topic delete successfull','Topic delete successfull','vibe-helpdesk');
                            }
                            break;
                        }
                        if($success){
                            $data=array(
                                'status' => 1,
                                'data' => $success,
                                'message' => $message?$message:''
                            );
                        }else{
                            $data=array(
                                'status' => 0,
                                'data' => $success,
                                'message' =>  _x('Not success','Not success','vibe-helpdesk')
                            );
                        }
                    }else{
                        $data=array(
                            'status' => 0,
                            'data' => false,
                            'message' =>  _x('You are not a valid user to delete this topic','Not success','vibe-helpdesk')
                        );
                    }   
                }
            }else{
                $data=array(
                    'status' => 0,
                    'data' => false,
                    'message' => _x('BB-Press Plugin not active!','BB-Press Plugin not active!','vibe-helpdesk')
                );
            }
        }else{
            $data=array(
                'status' => 0,
                'data' => false,
                'message' => _x('Authorization error!','Authorization error!','vibe-helpdesk')
            );
        }
        $data = apply_filters('VibeBbp_delete_topic_api',$data,$args);
        return new WP_REST_Response($data, 200); 
    }

    function get_create_topic_fields($request){
        $args = json_decode($request->get_body(),true);
        $topic_id = 0;
        if(!empty($args['topic_id'])){
            $topic_id = esc_attr($args['topic_id']);
        }
        
        return new WP_REST_Response(['status'=>1,'fields'=>vibehelpdesk_get_topic_creation_fields($topic_id),'raw'=>get_post_meta($topic_id,'raw',true)], 200); 
    }

    function create_topic($request){
        $args = json_decode($request->get_body(),true);
        $user_id = (int)$this->user->id;
        // necessary data to pass in bbp_insert_topic( $topic_data, $topic_meta )
        $topic_data = array(
            'post_content' => $args['post_content'],
            'post_title'  =>  $args['post_title'],
            'post_parent' =>  $args['post_parent'],
            'post_author' => $user_id
        );
        $topic_meta = array(
            'forum_id'  =>  $args['post_parent'],
        );

        if(!empty($user_id)){
            $args['post_author'] = $user_id;
            if(!empty($args['topic_id'])){
                // Update the post into the database
                wp_update_post( array(
                    'ID'           => $args['topic_id'],
                    'post_type'    => 'topic',
                    'post_title'   => $args['post_title'],
                    'post_content' => $args['post_content'],
                ) );
                bbp_update_topic( $args['topic_id'], $args['forum_id'], array(), $user_id, true );

                if(!empty($args['meta'])){
                    foreach($args['meta'] as $meta){
                        update_post_meta( $args['topic_id'],$meta['meta_key'],$meta['meta_value']);
                    }
                }
                if(!empty($args['raw'])){
                    update_post_meta($opic_id,'raw',$args['raw']);
                }
                $data=array(
                    'status' => 1,
                    'data' => $this->get_topic_by_id( $args['topic_id'] ),
                    'message' => _x('Topic Updated','Topic Updated','vibe-helpdesk')
                );
            }else{
                if(function_exists('bbp_insert_topic') ){
                    if(!empty($topic_data['post_content'])&& !empty($topic_data['post_title']) && !empty($topic_data['post_parent']) && !empty($topic_data['post_author']) && !empty($topic_meta['forum_id'])){
                        
                        $flag = bbp_insert_topic( $topic_data, $topic_meta );
                        $topic_id = $flag;

                        if(!empty($args['meta'])){
                            foreach($args['meta'] as $meta){
                                update_post_meta( $topic_id,$meta['meta_key'],$meta['meta_value']);
                            }
                        }

                        if(!empty($args['raw'])){
                            update_post_meta($topic_id,'raw',$args['raw']);
                        }
                        do_action( 'bbp_new_topic', $topic_id, $topic_meta['forum_id'], array(), $user_id );
                        
                        if(!empty($flag)){
                            if(isset($args['priorities']) && is_array($args['priorities'])){
                                wp_set_post_terms( $topic_id, $args['priorities'], VIBEHELPDESK_TOPIC_PRIORITY);
                            }
                            $status = 1;
                            $data = $this->get_topic_by_id( $topic_id );
                            $message = _x('Topic Created','Topic Created','vibe-helpdesk');
                        }else{
                            $status = 0;
                            $data = false;
                            $message = _x('Topic not Created','Topic not Created','vibe-helpdesk');
                        }
                        $data=array(
                            'status' => $status,
                            'data' => $data,
                            'message' => $message
                        );
                    }else{
                        $data=array(
                            'status' => 0,
                            'data' => [],
                            'message' => _x('Passing Arguments not valid!','Passing Arguments not valid!','vibe-helpdesk')
                        );
                    } 
                }else{
                    $data=array(
                        'status' => 0,
                        'data' => [],
                        'message' => _x('BB-Press Plugin not active!','BB-Press Plugin not active!','vibe-helpdesk')
                    );
                }
            }
        }else{
            $data=array(
                'status' => 0,
                'data' => [],
                'message' => _x('Authorization error!','Authorization error!','vibe-helpdesk')
            );
        }   
        $data = apply_filters('VibeBbp_create_topic_api',$data,$args);
        return new WP_REST_Response($data, 200); 
    }   
}

Vibe_HelpDesk_Topics_API::init();