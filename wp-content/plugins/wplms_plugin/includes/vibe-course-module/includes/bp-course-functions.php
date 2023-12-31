<?php

/**
 * The -functions.php file is a good place to store miscellaneous functions needed by your plugin.
 *
 * @package BuddyPress_Course_Component
 * @since 1.6
 */

/**
 * bp_course_load_template_filter()
 *
 * You can define a custom load template filter for your component. This will allow
 * you to store and load template files from your plugin directory.
 *
 * This will also allow users to override these templates in their active theme and
 * replace the ones that are stored in the plugin directory.
 *
 * If you're not interested in using template files, then you don't need this function.
 *
 * This will become clearer in the function bp_course_screen_one() when you want to load
 * a template file.
 */

 if ( ! defined( 'ABSPATH' ) ) exit;

 if (!function_exists('write_log')) {

  function write_log($log) {
      if (true === WP_DEBUG) {
          if (is_array($log) || is_object($log)) {
              error_log(print_r($log, true));
          } else {
              error_log($log);
          }
      }
  }

}

  function update_question_correct_percentage($question_id,$increment_value=null){
    $correct_count = apply_filters('get_question_correct_percentage',get_post_meta($question_id,'correct_count',true),$question_id);
    if(empty($correct_count)){
      $correct_count = 0;
    }
    $correct_count = intval($correct_count);
    if(empty($increment_value)){
      $increment_value = 1;
    }
    $correct_count = $correct_count+$increment_value;
    update_post_meta($question_id,'correct_count',$correct_count);
  }

  function get_question_correct_percentage($question_id){
    $correct_count = apply_filters('get_question_correct_percentage',get_post_meta($question_id,'correct_count',true),$question_id);
    return $correct_count;
  }

  function update_question_incorrect_percentage($question_id,$increment_value=null){
    $incorrect_count = apply_filters('get_question_incorrect_percentage',get_post_meta($question_id,'incorrect_count',true),$question_id);
    if(empty($incorrect_count)){
      $incorrect_count = 0;
    }
    $correct_count = intval($incorrect_count);
    if(empty($increment_value)){
      $increment_value = 1;
    }
    $incorrect_count = $incorrect_count+$increment_value;
    update_post_meta($question_id,'incorrect_count',$incorrect_count);
  }

  function get_question_incorrect_percentage($question_id){
    $incorrect_count = apply_filters('get_question_incorrect_percentage',get_post_meta($question_id,'incorrect_count',true),$question_id);
    return $incorrect_count;
  }

  function update_question_tag_correct_percentage($term_id,$increment_value=null){
    if(!empty($term_id)){
      $correct_count = apply_filters('get_question_tag_correct_percentage',get_term_meta($term_id,'correct_count',true),$term_id);
      if(empty($correct_count)){
        $correct_count = 0;
      }
      $correct_count = intval($correct_count);
      if(empty($increment_value)){
        $increment_value = 1;
      }
      $correct_count = $correct_count+$increment_value;
      update_term_meta($term_id,'correct_count',$correct_count);
    }
    
  }

  function update_question_tag_incorrect_percentage($term_id,$increment_value=null){
    if(!empty($term_id)){
      $correct_count = apply_filters('get_question_tag_incorrect_percentage',get_term_meta($term_id,'incorrect_count',true),$term_id);
      if(empty($correct_count)){
        $correct_count = 0;
      }
      $correct_count = intval($correct_count);
      if(empty($increment_value)){
        $increment_value = 1;
      }
      $correct_count = $correct_count+$increment_value;
      update_term_meta($term_id,'incorrect_count',$correct_count);
    }
    
  }

  function get_question_tag_incorrect_percentage($term_id){
    $incorrect_count = apply_filters('get_question_tag_incorrect_percentage',get_term_meta($term_id,'incorrect_count',true),$term_id);
    return $incorrect_count;
  }

  function get_question_tag_correct_percentage($term_id){
    $incorrect_count = apply_filters('get_question_tag_correct_percentage',get_term_meta($term_id,'correct_count',true),$term_id);
    return $incorrect_count;
  }

  function get_quiz_marked_answer($user_id,$quiz_id){
    return apply_filters('get_quiz_marked_answer',get_user_meta($user_id,'quiz_saved_answers'.$quiz_id,true),$user_id,$quiz_id);
  }

  function save_quiz_marked_answer($user_id,$quiz_id,$value){
    return update_user_meta($user_id,'quiz_saved_answers'.$quiz_id,$value);
  }

     /*
      $item=null,$course=null not necessary just pass user id and quiz_id=> item_id
     */
 function bp_wplms_get_question_data($question_id){
        
    $question = bp_course_get_question_details($question_id,1);
    $question['marks'] = 1;
    $question['user_marks'] = 0;
    $question['id'] = $question_id;
    $question['status'] = 0;
    $question['show_hint'] = false;
    $question['explanation'] = apply_filters('the_content',get_post_meta($question_id,'vibe_question_explaination',true));
    $question['auto'] = 1;
    $question['show_correct_answer'] = 1;




    if($question['type'] && $question['type'] == 'truefalse'){
      $question['options'] = array(_x('False','','wplms'),_x('True','','wplms'));
    }

    $question['user_marks'] = 0;
    $key = wp_generate_password(8,false);
    $question['key'] = $key;
    $question['correct'] = vibecryptoJsAesEncrypt($key,get_post_meta($question_id,'vibe_question_answer',true));
    return $question;
    }


  function bp_wplms_get_quiz_data($user_id,$item_id,$item=null,$course=null,$status=null,$activity_id=null,$bypass=null){
    //Get all questions.
    if(!empty($user_id)){
        if(empty($status)){
            $status = bp_course_get_user_quiz_status($user_id,$item_id);
        }
    }
    
    //set question to raw if status is >= 3

    if($bypass){
        $status = 1;
    }


    if(class_exists('WPBMap')){
        WPBMap::addAllMappedShortcodes();
    }

    if(!$item){
        $item = get_post($item_id);
    }
    if(empty($course)){
        $course = get_post_meta($item_id,'vibe_quiz_course',true);
    }

    $quiz_negative_marking = $quiz_partial_marks = 0;

    $return['id']=$item_id;
    if(!$bypass){
        $quiz_access_flag=apply_filters('bp_course_api_check_quiz_lock',true,$item_id,$user_id,'api');
    }else{
        $quiz_access_flag = true;
    }

    $return['title']=$item->post_title;
    $return['content'] = apply_filters('the_content',$item->post_content,$item_id);
    
    $show_correct_answer = 1;

    $show_question_advanced_stats_in_quiz = apply_filters('show_question_advanced_stats_in_quiz',0,$user_id,$item_id);

    if($quiz_access_flag){
        
        $tips = WPLMS_tips::init();
        if(isset($tips) && isset($tips->settings)){
          
            empty($tips->settings['quiz_negative_marking'])?
            $tips->settings['quiz_negative_marking']=0:'';
          
            $quiz_negative_marking = $tips->settings['quiz_negative_marking'];

            empty($tips->settings['quiz_partial_marks'])?
            $tips->settings['quiz_partial_marks']=0:'';

            $quiz_partial_marks = $tips->settings['quiz_partial_marks'];

            empty($tips->settings['react_quizzes'])?
            $tips->settings['react_quizzes']=0:'';
            $vibe_question_number_react = $tips->settings['react_quizzes'];
          
            empty($tips->settings['quiz_passing_score'])?
            $tips->settings['quiz_passing_score']=0:'';
          
            $quiz_passing_score = $tips->settings['quiz_passing_score'];
            if(!empty($quiz_passing_score)){
                $quiz_passing_score = true;
                $passing_score = intval(get_post_meta($item_id,'vibe_quiz_passing_score',true));
                if(!empty($passing_score)){
                    $quiz_passing_score = $passing_score;
                }
            }else{
                $quiz_passing_score = false;
            }
            
            if(!empty($course) && !empty($tips->settings['quiz_correct_answers']) && function_exists('bp_course_get_user_course_status')){
                $course_status = bp_course_get_user_course_status($user_id,$course);

                if($course_status < 3){
                    $show_correct_answer = 0;
                }
            }
        }

        $all_questions = bp_course_get_quiz_questions($item_id,$user_id);

        if(empty($all_questions) || empty($all_questions['ques'])){
            if(!did_action('wplms_before_quiz_begining')){
                do_action('wplms_before_quiz_begining',$item_id,$user_id,$bypass);
                $all_questions = bp_course_get_quiz_questions($item_id,$user_id);
            }
        }

        $questions = $question = array();

        $progress = $user_marks = 0;

        $duration=get_post_meta($item_id,'vibe_duration',true);
        if(empty($duration)){$duration=1;}
      
        $quiz_duration_parameter = apply_filters('vibe_quiz_duration_parameter',60,$item_id);
        $new_duration = $quiz_duration_parameter*$duration;
        $auto = get_post_meta($item_id,'vibe_quiz_auto_evaluate',true);
        $non_logged_in_quiz = get_post_meta($item_id,'vibe_non_loggedin_quiz',true);

      
        if(!empty($non_logged_in_quiz) && $non_logged_in_quiz=='S'){
            $non_logged_in_quiz = 1;
        }
        $question_duration = intval(get_post_meta($item_id,'vibe_question_duration',true));


        $vibe_question_number_react = get_post_meta($item_id,'vibe_question_number_react',true);
        if(!empty($question_duration)){
            $question_duration = intval($question_duration);
            if(!empty($question_duration)){
                $question_duration_parameter = get_post_meta($item_id,'vibe_question_duration_parameter',true);
                $question_duration_parameter = intval($question_duration_parameter);

                $question_duration = $question_duration_parameter*$question_duration;
            }
            if(!empty($question_duration)){
        

                $vibe_question_number_react = 1;
            }
        }
        $vibe_question_number_react = apply_filters('wplms_react_quiz_default_question_numbers',$vibe_question_number_react,$item_id,$user_id);
        

        
        $all_marks = [];
        if(!empty($all_questions)){
                

            if(!empty($all_questions['marks']) && $all_questions['marks']){
                foreach($all_questions['marks'] as $i=>$marks){
                    $all_marks[$all_questions['ques'][$i]]=$marks;
                }

            }
        
            if(is_array($all_marks)){
                $max = array_sum($all_marks);
            }else{
                $max=1;
            }
            if(!empty($user_id)){
                $saved_answers = get_quiz_marked_answer($user_id,$item_id);
            }
      
            if(!empty($all_questions['ques'])){
                $all_questions = $all_questions['ques'];
            }
               
            foreach($all_questions as $k=>$question_id){
                 
                if($status  >= 3){
                    $results =  array();
                    if(function_exists('bp_is_active') && bp_is_active('activity')){
                        global $wpdb,$bp;

                        if(empty($activity_id)){
                            $activity_id = $wpdb->get_var($wpdb->prepare( "
                                    SELECT id 
                                    FROM {$bp->activity->table_name}
                                    WHERE secondary_item_id = %d
                                    AND type = 'quiz_evaluated'
                                    AND user_id = %d
                                    ORDER BY date_recorded DESC
                                    LIMIT 0,1
                                    " ,$item_id,$user_id));
                            if(!empty($activity_id)){
                                $results = bp_course_get_quiz_results_meta($item_id,$user_id,$activity_id);
                            }
                        }else{

                            $results = bp_course_get_quiz_results_meta($item_id,$user_id,$activity_id,true);
            
                        }
                        if(is_serialized($results)){
                            $results = unserialize($results);
                        }
                        if(!empty($results) && is_array($results)){
                            $questions = $results;
                        }
                    }
                    $tags_data =  get_user_meta($user_id,'tags_data'.$item_id,true);
                    break;
                }else{
                    if(!empty($question_id)){
                        $question = bp_course_get_question_details($question_id,1);
                        if(!empty($all_marks) && !empty($all_marks[$question_id])){
                            $question['marks'] = $all_marks[$question_id];
                            
                        }else{
                            if(!empty($all_questions) && !empty($all_questions['marks'])){
                                $question['marks'] =intval($all_questions['marks'][$k]);
                            }
                            
                        }

                        $question['user_marks'] = 0;
                        $question['id'] = $question_id;
                        $question['status'] = 0;
                        $question['show_hint'] = false;
                        $question['explanation'] = apply_filters('the_content',get_post_meta($question_id,'vibe_question_explaination',true));
                        $question['auto'] = (($auto == 'S')?1:0);
                        $question['show_correct_answer'] = $show_correct_answer;
                        if(!empty($question['marked'])){
                          $question['user_marks'] = bp_course_get_user_question_marks($item_id,$question_id,$user_id);
                          $user_marks += intval($question['user_marks']);
                          $progress++;
                          $question['status'] = 1;
                        }
                        $question['flagged'] = false;
                        $flagged = get_post_meta($question_id,'vibe_flagged_by',true);
                        if(empty($flagged) || !is_array($flagged)){
                            $flagged = array();
                        }
                        if(in_array($user_id, $flagged)){
                            $question['flagged'] = true;
                            $feedbacks = get_post_meta($question_id,'vibe_flagged_feedbacks',true);
                            if(!empty($feedbacks[$user_id])){
                                $question['flagged_feedback'] = $feedbacks[$user_id];
                            }
                        }
            
                        if($question['type'] && $question['type'] == 'truefalse'){
                            $question['options'] = array(_x('False','','wplms'),_x('True','','wplms'));
                        }

                        //check saved answers
                        if(!empty($saved_answers) && !empty($saved_answers[$question_id]) && isset($saved_answers[$question_id]['marked_answer'])){
                            $question = $saved_answers[$question_id];
                        }else{
                            $question['user_marks'] = 0;
                        }
            
                        $key = wp_generate_password(8,false);
                        $question['key'] = $key;
                        $question['correct'] = vibecryptoJsAesEncrypt($key,get_post_meta($question_id,'vibe_question_answer',true));
                        if(!empty($question_duration)){
                            $question['question_duration'] = apply_filters('wplms_question_question_duration',$question_duration,$question_id,$question,$user_id);
                        }
                        array_push($questions, $question);
                    }
                    
                }
            }
            
            if(!empty($all_questions)){
                $progress = round((100*$progress/count($all_questions)),2); 
            }else{
                $progress= 100;
            }
        
          
            if($status >= 3){
                $progress = 100;
                ob_start();
                bp_course_quiz_results($item_id,$user_id);
                $return['content'] .= ob_get_clean();
              
                $user_marks = get_post_meta($item_id,$user_id,true);
                $return['submitted'] = true;
                if(!empty($tags_data)){
                    $return['tags_data'] = $tags_data;  
                }
                $return['check_results_url'] = bp_core_get_user_domain( $user_id ).BP_COURSE_SLUG.'/'.BP_COURSE_RESULTS_SLUG.'/?action='.$item_id;
                $return['start'] = false;
            }
        
        }
      
      $retakes=apply_filters('wplms_quiz_retake_count',get_post_meta($item_id,'vibe_quiz_retakes',true),$item_id,$course,$user_id);
        if(empty($user_id)){
            $retake_count=$retakes;
        }else{
            if(function_exists('bp_course_fetch_user_quiz_retake_count') && bp_is_active('activity')){ 
                $retake_count = bp_course_fetch_user_quiz_retake_count($item_id,$user_id);
                if(!empty($retakes) && $retakes > $retake_count){
                    $retake_count = $retakes - intval($retake_count);
                }else{
                    $retake_count = 0;
                }
            }
        }
      
      
        $retake_count = intval($retake_count);
        $return['start'] = false;
        $check_answer = get_post_meta($item_id,'vibe_quiz_check_answer',true);
        $check_answer = (!empty($check_answer) && $check_answer == 'S')?1:0;
        $return['check_answer']=$check_answer;
        $vibe_show_print_results = get_post_meta($item_id,'vibe_show_print_results',true);
        if(vibe_validate($vibe_show_print_results) || apply_filters('wplms_show_print_results',false,$item_id,$user_id)){
            $return['show_print_results']=true;
        }

        $return['start_time'] = intval(get_post_meta($item_id,'vibe_start_time',true));
        $return['end_time'] = intval(get_post_meta($item_id,'vibe_end_time',true));
      
        $show_results = get_post_meta($item_id,'vibe_results_after_quiz_message',true);
        $show_results = (!empty($show_results) && $show_results == 'S')?1:0;
        $return['show_results']=true;

        $hide_submit_button = get_post_meta($item_id,'vibe_hide_submit_button',true);
        if(vibe_validate($hide_submit_button)){
            $return['hide_submit_button']=true;
        }
        $completion_message = '';
        $quiz_completion_complete = get_post_meta($item_id,'vibe_quiz_message',true);
        $quiz_completion_complete = str_replace(
            array('id="'.$item_id.'"',
              'id='.$item_id,
              'id=\''.$item_id.'\'',
            )
            , 'id="'.$item_id.'" key="'.$user_id.'"'
            , $quiz_completion_complete
          );

      
        ob_start();
            echo do_shortcode($quiz_completion_complete);
        if($status > 2){
            do_action('wplms_after_quiz_message',$item_id,$user_id);
        }
        $completion_message = ob_get_clean();
        if(apply_filters('wplms_show_instructor_remarks_in_results',(empty($auto) || $auto!=='S'),$item_id,$user_id)){
            $remarks = get_instructor_quiz_remarks($item_id,$user_id);
            if(!empty($remarks)){
                $completion_message .= '<div class="instructor_remarks"><h3 class="subtitle heading">'._x('Instructor Remarks','','wplms').'</h3><p>'.do_shortcode($remarks).'</p></div>';
            }
        }
      
        $return['meta'] = array(
        'access' => 1,
        'status' => intval($status),
        //'progress' => $progress,
        'marks'=> $user_marks,
        'max' => $max,
        'questions' => apply_filters('wplms_user_quiz_questions_array',$questions,$item_id,$user_id),
        'auto'=>(($auto == 'S')?1:0),
        'retakes' => $retake_count,
        'completion_message'=>  $completion_message,
        'duration'=>$new_duration,
        
        );
      
      

      
      if(!empty($quiz_negative_marking)){
        $negative_marks = get_post_meta($item_id,'vibe_quiz_negative_marks_per_question',true);
        
      }

      

      $return['partial_marking'] = !empty($quiz_partial_marks)?$quiz_partial_marks:0;
      $return['negative_marking'] = !empty($quiz_negative_marking)?$quiz_negative_marking:0;
      $return['negative_marks'] = !empty($negative_marks)?$negative_marks:0;
      $return['question_number'] = !empty($vibe_question_number_react)?$vibe_question_number_react:1;
      
      $return['quiz_passing_score'] = !empty($quiz_passing_score)?$quiz_passing_score:0;
      $return['show_advance_stats'] = !empty($show_question_advanced_stats_in_quiz)?$show_question_advanced_stats_in_quiz:0;
      
      $return['quiz_type'] = get_post_meta($item_id,'vibe_type',true);
      if($return['quiz_type'] == 'live_contest'){
        $return['vibe_minimum_live_user'] = (int)get_post_meta($item_id,'vibe_minimum_live_user',true);
      }
      $return['non_logged_in_quiz'] = !empty($non_logged_in_quiz)?true:false;

      
      if($status < 3){
        $t = get_user_meta($user_id,$item_id,true);
        if(!empty($t)){
          $return['remaining'] = $t - time();
          $return['start'] = true;
          $return['expiry'] = $t;
        }
      } 

    }else{
      $return['content'] = _x('Quiz already in progress, contact site, please retry after sometime.','quiz lock flag check for App and Site','wplms');
      $return['meta'] = array(
        'access' => 0
      );
    }
    return $return;
}

function get_instructor_quiz_remarks($item_id,$user_id){
  if(!empty($item_id) && !empty($user_id)){

   return get_user_meta($user_id,'quiz_remarks'.$item_id,true);
  }
  return false;
}

function update_instructor_quiz_remarks($item_id,$user_id,$remarks){
  if(!empty($item_id) && !empty($user_id) && !empty($remarks)){

   return update_user_meta($user_id,'quiz_remarks'.$item_id,$remarks);
  }
  return false;
}


function delete_instructor_quiz_remarks($item_id,$user_id){
  if(!empty($item_id) && !empty($user_id)){

   return delete_user_meta($user_id,'quiz_remarks'.$item_id);
  }
  return false;
}

function bp_course_load_template_filter( $found_template, $templates ) {
	global $bp;

	/**
	 * Only filter the template location when we're on the course component pages.
	 */
	if ( $bp->current_component != $bp->course->slug )
		return $found_template;

	foreach ( (array) $templates as $template ) {
		if ( file_exists( get_stylesheet_directory(). '/' . $template ) )
			$filtered_templates[] = get_stylesheet_directory() . '/' . $template;
    elseif ( file_exists( get_template_directory() . '/' . $template ) )
            $filtered_templates[] = get_template_directory() . '/' . $template;
		else
			$filtered_templates[] = dirname( __FILE__ ) . '/templates/' . $template;
	}

	$found_template = $filtered_templates[0];

	return apply_filters( 'bp_course_load_template_filter', $found_template );
}
add_filter( 'bp_located_template', 'bp_course_load_template_filter', 10, 2 );

function all_course_page_title(){
    echo '<h1>'.__('Course Directory','wplms').'</h1>
          <h5>'.__('All Courses by all instructors','wplms').'</h5>';
}

function bp_user_can_create_course() { 
  // Bail early if super admin 
  if ( is_super_admin() ) 
          return true; 

  if ( current_user_can('edit_posts') ) 
          return true;     

  // Get group creation option, default to 0 (allowed) 
  $restricted = (int) get_site_option( 'bp_restrict_course_creation', 0 ); 

  // Allow by default 
  $can_create = true; 

  // Are regular users restricted? 
  if ( $restricted ) 
          $can_create = false; 
	
	return apply_filters( 'bp_user_can_create_course', $can_create ); 
} 
/**
 * bp_course_nav_menu()
 * Navigation menu for BuddyPress course
 */

function bp_course_nav_menu(){

    $nav = bp_course_get_nav_permalinks();
    $defaults = array(
      '' => array(
                        'id' => 'home',
                        'label'=>__('Home','wplms'),
                        'action' => '',
                        'link'=>bp_get_course_permalink(),
                    ),
      'curriculum' => array(
                        'id'     => 'curriculum',
                        'label'  =>__('Curriculum','wplms'),
                        'can_view' => 1,
                        'action' => (empty($nav['curriculum_slug'])?__('curriculum','wplms'):$nav['curriculum_slug']),
                        'link'   => bp_get_course_permalink(),
                    ),
      'members' => array(
                        'id'    => 'members',
                        'label' =>__('Members','wplms'),
                        'can_view' => 1,
                        'action'=> (empty($nav['members_slug'])?__('members','wplms'):$nav['members_slug']),
                        'link'  =>bp_get_course_permalink(),
                    ),
      );


    if(bp_is_active('activity')){
      $defaults['activity']= array(
                'id'    => 'activity',
                'label' =>__('Activity','wplms'),
                'can_view' => 1,
                'action'=> (empty($nav['activity_slug'])?__('activity','wplms'):$nav['activity_slug']),
                'link'  =>bp_get_course_permalink(),
            );
    }
    global $post;
    if($post->post_type == 'course'){
        if(!empty(get_post_meta($post->ID,'vibe_course_package',true))){
           unset($defaults['curriculum']);
        }
        if(function_exists('bp_is_active') && bp_is_active('groups')){
          $vgroup=get_post_meta(get_the_ID(),'vibe_group',true);
          if(!empty($vgroup)){
            $group=groups_get_group(array('group_id'=>$vgroup));

            $defaults['group'] = array(
                          'id' => 'group',
                          'label'=>__('Group','wplms'),
                          'action' => 'group',
                          'can_view' => 1,
                          'link'=> bp_get_group_permalink($group),
                          'external'=>true,
                      );
          }
      }
      if ( in_array( 'bbpress/bbpress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || (function_exists('is_plugin_active_for_network') && is_plugin_active_for_network( 'bbpress/bbpress.php'))) {
        $forum=get_post_meta(get_the_ID(),'vibe_forum',true);
        if(!empty($forum) && bp_course_get_post_type($forum) == 'forum'){
          $defaults['forum'] = array(
                        'id' => 'forum',
                        'label'=>__('Forum','wplms'),
                        'action' => 'forum',
                        'can_view' => 1,
                        'link'=> get_permalink($forum),
                        'external'=>true,
                    );
        }
      }
    }
    
    $nav_menu = apply_filters('wplms_course_nav_menu',$defaults);
    
    global $bp;
    $action = bp_current_action(); 
    if(empty($action)){
      (!empty($_GET['action'])?$action=$_GET['action']:$action='');
    }

    /*== ACTION DEFAULT ==*/
    $empty_action_first = 0;

    foreach($nav_menu as $key => $menu_item){
      if($key == $action){$empty_action_first = 1;}
    }
    if(empty($empty_action_first)){$empty_action_first = 1;}else{$empty_action_first = 0;}
    /*=== END HOME SELECTION == */

    if(is_array($nav_menu)){
        
        foreach($nav_menu as $key => $menu_item){
          $menu_item['action'] = str_replace('/','',$menu_item['action']);
          if($key == $action || $empty_action_first){
            $class = 'class="current"';
            $empty_action_first = 0;
          }else{
            $class='';
          }
          
          global $wp_query;

          if(!empty($nav[$menu_item['id'].'_slug'])){
            echo '<li id="'.$menu_item['id'].'" '.$class.'><a href="'.$menu_item['link'].''.((isset($menu_item['action']) && !isset($menu_item['external']))?$menu_item['action']:'').'">'.$menu_item['label'].'</a></li>';
          }else{

            echo '<li id="'.$menu_item['id'].'" '.$class.'><a href="'.$menu_item['link'].''.((!empty($menu_item['action']) && !isset($menu_item['external']))?(strpos($menu_item['link'],'?')?'&':'?').'action='.$menu_item['action']:'').'">'.$menu_item['label'].'</a></li>';
          }
        }
    }

    if(is_super_admin() || is_instructor()){ 
      $admin_slug = (empty($nav['admin_slug'])?_x('admin','course admin slug','wplms'):$nav['admin_slug']);
      $admin_slug = apply_filters('wplms_course_admin_slug',str_replace('/','',$admin_slug));
      ?>
      <li id="admin" class="<?php echo ((!empty($action) && ( $action == 'admin' || $action == 'submission' || $action == 'stats'))?'selected current':''); ?>"><a href="<?php bp_course_permalink(); echo $admin_slug; ?>"><?php  _e( 'Admin', 'wplms' ); ?></a></li>
      <?php
    }
}

/**
 * bp_course_remove_data()
 *
 * It's always wise to clean up after a user is deleted. This stops the database from filling up with
 * redundant information.
 */
function bp_course_remove_data( $user_id ) {
	/* You'll want to run a function here that will delete all information from any component tables
	   for this $user_id */

	/* Remember to remove usermeta for this component for the user being deleted */
	delete_user_meta( $user_id, 'bp_course_some_setting' );

	do_action( 'bp_course_remove_data', $user_id );
}
add_action( 'wpmu_delete_user', 'bp_course_remove_data', 1 );
add_action( 'delete_user', 'bp_course_remove_data', 1 );

function bp_directory_course_search_form() {

	$default_search_value = bp_get_search_default_text( BP_COURSE_SLUG );
	$search_value         = !empty( $_REQUEST['s'] ) ? stripslashes( $_REQUEST['s'] ) : $default_search_value;

	$search_form_html = '<form action="" method="get" id="search-course-form">
		<label><input type="text" name="s" id="course_search" placeholder="'. esc_attr( $search_value ) .'" /></label>
		<input type="submit" id="course_search_submit" name="course_search_submit" value="'. __( 'Search', 'wplms' ) .'" />
	</form>';

	echo apply_filters( 'bp_directory_course_search_form', $search_form_html );

}

if(!function_exists('the_course_button')){
function the_course_button($id=NULL,$no_current_user_id=null){
  global $post;$extra='';
  if(isset($id) && $id)
    $course_id=$id;
   else 
    $course_id=get_the_ID();
    do_action('wplms_4_the_course_button',$course_id);

   $blog_id = '';
    if(function_exists('get_current_blog_id')){
        $blog_id = get_current_blog_id();
    }
    $open_login_popup = false;
    $tips = WPLMS_tips::init();
    if(!empty($tips->settings['open_popup_for_non_logged_users'])){
      $open_login_popup = true;
    }

    if(!empty($tips->settings['show_course_status']) && $tips->settings['show_course_status'] =='on'){
     
       $data = WPLMS_Course_Component_Init::init();
        
        if(!empty($tips->lms_settings['general']['advanced_video_format_dash'])){
            wp_enqueue_script('wplms-video-format-dash',plugins_url('../../../assets/js/dash.all.min.js',__FILE__),array(),WPLMS_PLUGIN_VERSION,true);
        }
        if(!empty($tips->lms_settings['general']['advanced_video_format_hls'])){
            wp_enqueue_script('wplms-video-format-hls',plugins_url('../../../assets/js/hls.min.js',__FILE__),array(),WPLMS_PLUGIN_VERSION,true);
        }
        if(!empty($tips->lms_settings['general']['advanced_video_format_360'])){
            wp_enqueue_script('wplms-video-format-360',plugins_url('../../assets/js/plyr-vr.min.js',__FILE__),array('plyr'),WPLMS_PLUGIN_VERSION,true);
            wp_enqueue_style('wplms-video-format-360',plugins_url('../../assets/css/plyr-vr.css',__FILE__),array('plyr'),WPLMS_PLUGIN_VERSION);
        }
        if(class_exists('VibeBP_Register')){
            $vbpregister = VibeBP_Register::init();
            if(method_exists($vbpregister,'vibebp_editor_data')){
                wp_enqueue_style('vibe_editor',VIBEBP_PLUGIN_URL.'/assets/css/editor.css',array(),VIBEBP_VERSION);
                wp_enqueue_script('vibe_editor',VIBEBP_PLUGIN_URL.'/assets/js/editor.js',array(),VIBEBP_VERSION,true);
                $editor_script_Args = $vbpregister->vibebp_editor_data();
                wp_localize_script('vibe_editor','vibeEditor',$editor_script_Args);
                
            }
        }
        
        wp_enqueue_script('dragabillyjs',VIBEBP_PLUGIN_URL.'/assets/js/draggabilly.pkgd.min.js',array(),VIBEBP_VERSION,true);
        
        wp_enqueue_script('chartjs-js',plugins_url('/../../../assets/js/Chart.min.js',__FILE__),array('wp-element'),WPLMS_PLUGIN_VERSION,true);
       wp_enqueue_script('courseButton',plugins_url('../../../assets/js/course_button_loaded.js',__FILE__),array('wp-element','wp-data'),WPLMS_PLUGIN_VERSION,true);
       
       add_action('wp_footer',function(){
            echo '<div id="quiz_popup"></div>';
            echo '<div id="wplms_the_course_button"></div><style>.the_course_button.is-loading{opacity:0.5}</style>';

        });
      
        

       wp_localize_script('courseButton','wplms_course_data',apply_filters('wplms_course_button_script_args',$data->get_wplms_course_data())); 
       wp_enqueue_script('wplms-custom-support-js',WPLMS_PLUGIN_INCLUDES_URL.'/../assets/js/custom-support.js',array('courseButton'),WPLMS_PLUGIN_VERSION,true);
        wp_localize_script('courseButton','courseButton',apply_filters('wplms_course_button_script_args',array(
        'api'=>apply_filters('vibebp_rest_api',get_rest_url($blog_id,WPLMS_API_NAMESPACE)),
        'login_popup'=>$open_login_popup,
        'security'=>function_exists('vibebp_get_setting')?vibebp_get_setting('client_id'):'',
          'translations'=>array(
            'take_this_course'=>_x('Take this Course','course button status','wplms'),
            'apply_to_course' => _x('Apply for course?','','wplms'),
            'ok' => _x('ok','','wplms'),
            'yes' => _x('Yes','','wplms'),
            'cancel' => _x('Cancel','','wplms'),
          )
       )));
       wp_enqueue_style('course_status',plugins_url('../../../assets/css/course_status.css',__FILE__),array(),WPLMS_PLUGIN_VERSION);
      wp_enqueue_script('wplms-scorm',plugins_url('../../vibe-shortcodes/js/scorm2.js',__FILE__),array('wp-element','wp-data'),WPLMS_PLUGIN_VERSION);

     }else{
      add_action('wp_footer',function(){
        echo '<style>.the_course_button.is-loading{opacity:0.5}</style>';
      });
        wp_enqueue_script('courseButton',plugins_url('../../../assets/js/course_button.js',__FILE__),array('wp-element','wp-data'),WPLMS_PLUGIN_VERSION,true);
        $data = WPLMS_Course_Component_Init::init();
        $cdata  = $data->get_wplms_course_data();
       
         wp_localize_script('courseButton','wplms_course_data',apply_filters('wplms_course_button_script_args',$cdata));

     }

   add_action('wp_footer',function(){

      $init = WPLMS_4_Init::init();
      if(empty($init->footer_course_button_scripts)){
        $init->footer_course_button_scripts=1;
        ?><script>
            document.addEventListener('DOMContentLoaded',function(){
              if(document.querySelectorAll('.course_button')){
                document.querySelectorAll('.course_button').forEach(function(el){
                  if(el.querySelector('a')){
                    el.querySelector('a').addEventListener('click',function(event){
                      if(window.wplms_course_data.hasOwnProperty('login_popup') && window.wplms_course_data.login_popup){
                        
                        let user = sessionStorage.getItem('bp_user');
                        if (typeof user!=='undefined' && user && user.hasOwnProperty('id') && user.id){
                        }else{
                          event.preventDefault();
                          const nevent = new Event('vibebp_show_login_popup');
                          document.dispatchEvent(nevent);
                        }
                      }else{
                        if(!el.classList.contains('paid_course')){
                          event.preventDefault();
                          const nevent = new Event('vibebp_show_login_popup');
                          document.dispatchEvent(nevent);
                        }
                      }
                      
                    });
                  }
                });
              }
              if(document.querySelectorAll('.course_button .is-loading,.course_button.is-loading')){
                setTimeout(function(){  document.querySelectorAll('.course_button .is-loading,.course_button.is-loading').forEach(function(el){
                    el.classList.remove('is-loading');},2000); 
                  });
              }
            });</script>
            <style>.course_button.is-loading{opacity:0.4;}</style>
        <?php
        }
    });

   $free_course= get_post_meta($course_id,'vibe_course_free',true);

   $init = WPLMS_4_Init::init();
    
  if(!(is_user_logged_in() && !$no_current_user_id) && vibe_validate($free_course)){

    $default_link = '#';
    if(function_exists('vibebp_get_setting') && !empty(vibebp_get_setting('bp_single_page'))){
      $default_link = get_permalink(vibebp_get_setting('bp_single_page'));
    }
    echo '<span class="the_course_button" data-id="'.$course_id.'"><strong class="course_button  is-loading button full '.((function_exists('vibe_get_option') && vibe_get_option('enable_ajax_registration_login'))?'auto_trigger':'').'">'.apply_filters('wplms_course_non_loggedin_user','<a href="'.(is_wplms_4_0()?(empty($init->is_block)?$default_link:get_permalink($course_id)):get_permalink($course_id).'?error=login').'">'.apply_filters('wplms_take_this_course_button_label',__('TAKE THIS COURSE','wplms'),$course_id).'</a>',$course_id).'</strong></span>'; 
    
    return;
  }

    
   if((is_user_logged_in() && !$no_current_user_id)){

    $take_course_page_id=vibe_get_option('take_course_page');

    if(function_exists('icl_object_id'))
      $take_course_page_id = icl_object_id($take_course_page_id, 'page', true);

   $take_course_page=get_permalink($take_course_page_id);

     $user_id = get_current_user_id();

     do_action('wplms_the_course_button',$course_id,$user_id);
     $coursetaken = bp_course_get_user_expiry_time($user_id,$course_id);
     $auto_subscribe = 0; 

     if(vibe_validate($free_course) && is_user_logged_in() && (!isset($coursetaken) || !is_numeric($coursetaken))){ 
        $auto_subscribe = 1;
     }

     $auto_subscribe = apply_filters('wplms_auto_subscribe',$auto_subscribe,$course_id);
     if($auto_subscribe){  
        $t = bp_course_add_user_to_course($user_id,$course_id);

        if($t){
            $new_duration = apply_filters('wplms_free_course_check',$t);
            $coursetaken = $new_duration;
        }      
     }
   }
   
   if(!empty($coursetaken) && (is_user_logged_in() && !$no_current_user_id)){   // COURSE IS TAKEN & USER IS LOGGED IN

         if($coursetaken > time()){  // COURSE ACTIVE
            $course_user= bp_course_get_user_course_status($user_id,$course_id); // Validates that a user has taken this course

            if((isset($course_user) && is_numeric($course_user)) || (isset($free_course) && $free_course && $free_course !='H' && is_user_logged_in())){ // COURSE PURCHASED SECONDARY VALIDATION
             echo '<div class="the_course_button" data-id="'.$course_id.'"><form action="'.apply_filters('wplms_take_course_page',$take_course_page,$course_id).'" method="post">';

                    switch($course_user){
                    case 1:
                      echo  apply_filters('wplms_start_course_button','<input type="submit" class="'.((isset($id) && $id )?'':'course_button full ').'button" value="'.__('START COURSE','wplms').'"  data-id="'.$course_id.'">',$course_id); 
                      wp_nonce_field('start_course'.$user_id,'start_course');
                    break;
                    case 2:  
                      echo  apply_filters('wplms_continue_course_button','<input type="submit" class="'.((isset($id) && $id )?'':'course_button full ').'button" value="'.__('CONTINUE COURSE','wplms').'">',$course_id);
                      wp_nonce_field('continue_course'.$user_id,'continue_course');
                    break;
                    case 3:
                      echo  apply_filters('wplms_evaluation_course_button','<a href="#" class="full course_button">'.__('COURSE UNDER EVALUATION','wplms').'</a>',$course_id);
                    break;
                    case 4:

                      $finished_course_access = vibe_get_option('finished_course_access');
                      if(isset($finished_course_access) && $finished_course_access){
                        echo apply_filters('finish_course_button_access_html','<input type="submit" class="'.((isset($id) && $id )?'':'course_button full ').'button" value="'.__('FINISHED COURSE','wplms').'" data-id="'.$course_id.'">',$user_id,$course_id,$course_user);
                        wp_nonce_field('continue_course'.$user_id,'continue_course');
                      }else{
                        echo apply_filters('finish_course_button_html','<a href="'.apply_filters('wplms_finished_course_link','#',$course_id).'" class="full course_button"  data-id="'.$course_id.'">'.__('COURSE FINISHED','wplms').'</a>',$user_id,$course_id,$course_user);
                      }
                    break;
                    default:
                      $course_button_html = '<a class="course_button button" data-id="'.$course_id.'">'.__('COURSE ENABLED','wplms').'<span>'.__('CONTACT ADMIN TO ENABLE','wplms').'</span></a>';
                      echo apply_filters('wplms_default_course_button',$course_button_html,$user_id,$course_id,$course_user);
                    break;
                  }  

             echo  '<input type="hidden" name="course_id" value="'.$course_id.'" />';
             
             echo  '</form></div>';
             do_action('wplms_after_course_button_form',$user_id,$course_id,$course_user); 
            }else{ 
                  $pid=get_post_meta($course_id,'vibe_product',true); // SOME ISSUE IN PROCESS BUT STILL DISPLAYING THIS FOR NO REASON.
                  echo '<a href="'.get_permalink($pid).'" class="'.((isset($id) && $id )?'':'course_button full  is-loading ').'button ">'.__('COURSE ENABLED','wplms').'<span>'.__('CONTACT ADMIN TO ENABLE','wplms').'</span></a>';   
            }
      }else{
            $pid=get_post_meta($course_id,'vibe_product',true);
            $pid=apply_filters('wplms_course_product_id',$pid,$course_id,-1); // $id checks for Single Course page or Course page in the my courses section
            if(is_numeric($pid)){
              $pid=get_permalink($pid);
              $check=vibe_get_option('direct_checkout');
              $check =intval($check);
              if(isset($check) &&  $check){
                $pid .= '?redirect';
              }
              echo apply_filters('wplms_expired_course_button','<div class="the_course_button" data-id="'.$course_id.'"><a href="'.$pid.'" class="'.((isset($id) && $id )?'course_button':'course_button full  is-loading paid_course').' button">'.__('Course Expired','wplms').'&nbsp;<span>'.__('Click to renew','wplms').'</span></a></div>',$course_id);  
            }else{
              echo apply_filters('wplms_take_course_button_html','<div class="the_course_button" data-id="'.$course_id.'"><div class="course_button full button  is-loading">'.apply_filters('wplms_course_non_loggedin_user','<a href="'.$pid.'">'.apply_filters('wplms_take_this_course_button_label',__('TAKE THIS COURSE','wplms'),$course_id).'</a>',$course_id).($extra?'<div class="extra_details">'.$extra.'</div>':'').'</div></div>',$course_id);
            }
             
      }
    
   }else{
      $pid=get_post_meta($course_id,'vibe_product',true);
      $pid=apply_filters('wplms_course_product_id',$pid,$course_id,0);

      if(is_numeric($pid) && $pid){
        $pid=get_permalink($pid);
        $check=vibe_get_option('direct_checkout');
        $check =intval($check);
        if(isset($check) &&  $check){
          $pid .= '?redirect';
        }
      }
      if(strpos($pid, 'applycourse')!==false){
        $extra = apply_filters('wplms_course_button_extra',$extra,$course_id);
            echo apply_filters('wplms_take_course_button_html','<div class="the_course_button" data-id="'.$course_id.'"><div class="course_button full button  is-loading">'.apply_filters('wplms_course_non_loggedin_user','<a href="'.$pid.'">'.apply_filters('wplms_take_this_course_button_label',__('TAKE THIS COURSE','wplms'),$course_id).'</a>',$course_id).($extra?'<div class="extra_details">'.$extra.'</div>':'').'</div></div>',$course_id);
      }else{
        $extra ='';
        if(isset($pid) && $pid){
          //Check Partial free course setting.
          $partial_free_course = get_post_meta($course_id,'vibe_partial_free_course',true);
          if( vibe_validate($partial_free_course) && is_user_logged_in() && !is_wplms_4_0()){
            echo apply_filters('wplms_take_course_button_html','<a href="'.get_permalink($course_id).'?subscribe" class="course_button full button paid_course is-loading">'.apply_filters('wplms_take_this_course_button_label',__('SUBSCRIBE FOR FREE','wplms'),$course_id).apply_filters('wplms_course_button_extra',$extra,$course_id).'</a>',$course_id);
          }else{
           $extra = apply_filters('wplms_course_button_extra',$extra,$course_id);
            echo apply_filters('wplms_take_course_button_html','<div class="the_course_button" data-id="'.$course_id.'"><div class="course_button full button paid_course is-loading">'.apply_filters('wplms_course_non_loggedin_user','<a href="'.$pid.'">'.apply_filters('wplms_take_this_course_button_label',__('TAKE THIS COURSE','wplms'),$course_id).'</a>',$course_id).($extra?'<div class="extra_details">'.$extra.'</div>':'').'</div></div>',$course_id);
          }
          
        }else{
          echo apply_filters('wplms_private_course_button_html','<span class="the_course_button" data-id="'.$course_id.'"><a href="'.apply_filters('wplms_private_course_button','#',$course_id).'" class="course_button full button">'. apply_filters('wplms_private_course_button_label',__('PRIVATE COURSE','wplms'),$course_id).'</a></span>',$course_id); 
        }
      }
      
   }
   do_action('wplms_4_after_the_course_button',$course_id);
}

}

function the_course_details($args=NULL){
  echo get_the_course_details($args);
}

function get_the_course_details($args=NULL){
  $defaults=array(
    'course_id' =>get_the_ID(),
    );
  $r = wp_parse_args( $args, $defaults );
  extract( $r, EXTR_SKIP );

  $precourse=get_post_meta($course_id,'vibe_pre_course',true);
  $maximum = bp_course_get_max_students($course_id); 
  $badge=get_post_meta($course_id,'vibe_course_badge',true);
  $certificate=get_post_meta($course_id,'vibe_course_certificate',true);

  $level = vibe_get_option('level');
  if(isset($level) && $level)
    $levels=get_the_term_list( $course_id, 'level', '', ', ', '' );

  $location = vibe_get_option('location');
  if(isset($location) && $location)
    $location=get_the_term_list( $course_id, 'location', '', ', ', '' );

  $pre_course_html = '';
  if(!empty($precourse)){
    if(is_numeric($precourse)){
      $pre_course_html = '<a href="'.get_permalink($precourse).'">'.get_the_title($precourse).'</a>';
    }else if(is_array($precourse)){
       foreach($precourse as $k => $pre_course_id){
          $pre_course_html .= (empty($k)?'':' , ').'<a href="'.get_permalink($pre_course_id).'">'.get_the_title($pre_course_id).'</a>';
       }
    }
  }

  //Check Partial free course setting.
  $partial = 0;
  $partial_free_course = get_post_meta($course_id,'vibe_partial_free_course',true);
  if( vibe_validate($partial_free_course) ){
    if( is_user_logged_in() ){
      $partial = 1;
    }else{
      $partial = 0;
    }
  }

  // Display Course Details
  $course_details = array(
    'price' => '<li class="course_price">'.bp_course_get_course_credits(array('id'=>$course_id,'partial'=>$partial)).'</li>',
    'precourse'=>(empty($precourse)?'':'<li class="course_precourse"><i class="icon-clipboard-1"></i> '.__('* REQUIRES','wplms').' '.$pre_course_html.' </li>'),
    'time' => '<li class="course_time"><i class="icon-clock"></i>'.get_the_course_time('course_id='.$course_id).'</li>',
    'location' => ((isset($location) && $location && strlen($location)>5)?'<li class="course_location"><i class="icon-map-pin-5"></i> '.$location.'</li>':''),
    'level' => ((isset($level) && $level && strlen($levels)>5)?'<li class="course_level"><i class="icon-bars"></i> '.$levels.'</li>':''),
    'seats' => ((isset($maximum) && is_numeric($maximum) && $maximum < 9999 )?'<li class="course_seats"><i class="icon-users"></i> '.$maximum.' '.__('SEATS','wplms').'</li>':''),
    'badge' => ((isset($badge) && $badge && $badge !=' ')?apply_filters('wplms_show_badge_popup_in_course_details','<li class="course_badge"><i class="icon-award-stroke"></i> '.__('Course Badge','wplms').'</li>',$course_id):''),

    'certificate'=> (vibe_validate($certificate)?apply_filters('wplms_show_certificate_popup_in_course_details','<li class="course_certificate"><i class="icon-certificate-file"></i>  '.__('Course Certificate','wplms').'</li>',$course_id):''),
    );

  $course_details = apply_filters('wplms_course_details_widget',$course_details,$course_id);

  global $post;
  $return ='<div class="course_details">
              <ul>'; 
  foreach($course_details as $course_detail){
    if(isset($course_detail) && strlen($course_detail) > 5)
      $return .=$course_detail;
  }
  $return .=  '</ul>
            </div>';
   return apply_filters('wplms_course_front_details',$return);
}

if(!function_exists('the_question')){
  function the_question($id=null,$quiz_id=null){
    if(!empty($id)){
      $post = get_post($id);
    }
    global $post;
    $hint = get_post_meta($post->ID,'vibe_question_hint',true);
    $type = get_post_meta($post->ID,'vibe_question_type',true);
    echo '<div id="question" data-ques="'.$post->ID.'">';
    echo '<div class="question '.$type.'">';
   
    the_content();

    if(isset($hint) && strlen($hint)>5){
      echo '<div class="question_hint_wrapper">
          <input type="checkbox" id="question_hint_'.$post->ID.'" />
          <label for="question_hint_'.$post->ID.'" class="show_hint tip vicon vicon-help-alt" tip="'.__('SHOW HINT','wplms').'"></label>';
      echo '<div class="hint"><span class="left">'.__('HINT','wplms').' : </span>'.do_shortcode($hint).'</div>
      </div><style>.question_hint_wrapper input,.question_hint_wrapper .hint{display:none;}.question_hint_wrapper .show_hint{position:absolute;right:0;top:0;}.question_hint_wrapper input:checked+label+.hint{display:block;padding: 0.5rem 1rem; background: var(--sidebar); border-radius: 5px;}</style>';
    }

    echo '</div>';

    switch($type){
      case 'truefalse': 
        the_options('truefalse');
      break;
      case 'survey':
      case 'single': 
        the_options('single');
      break;  
      case 'multiple': 
        the_options('multiple');
      break;
      case 'match': 
        the_options('match');
        echo '<style>.question_options{display:flex;flex-wrap:wrap;}.question_options .match_option{padding:5px;flex: 1 0 120px;display:flex;align-items:center;}.matchgrid_options li { list-style: none; padding: 10px; border: 1px solid var(--border); }</style>';
      break;
      case 'sort': 
        the_options('sort');
      break;
      case 'smalltext': 
        the_text();
      break;
      case 'largetext': 
        the_textarea();
      break;
      case 'fillblank': 
        echo '<style>.question.fillblank { display: flex; flex-wrap: wrap; } p.live-edit { min-width: 180px; margin: -0.5rem 0.5rem 0.1rem; padding: 0; display: flex; } p.live-edit > .vibe_fillblank { border-bottom: 2px solid; flex: 1; }</style>';
      break;
      case 'select': 
        echo '<style>.question.select { display: flex;flex-wrap: wrap;}</style>';
      break;
      default:
        do_action('wplms_generate_question_html');
      break;
    }
    
    do_action('wplms_after_question_options',$type,get_the_ID());
    the_marked_question_answer($quiz_id);
    

    echo '</div><div id="ajaxloader" class="disabled"></div>';
  }
}

if(!function_exists('the_options')){
  function the_options($type){
      global $post,$wpdb;
      $options = vibe_sanitize(get_post_meta(get_the_ID(),'vibe_question_options',false));
      
      if($type == 'truefalse')
        $options = array( 0 => __('FALSE','wplms'),1 =>__('TRUE','wplms'));

    if(isset($options) || $options){  
      $content=array();

      echo '<ul class="question_options '.$type.'">';
      if($type=='single'){
        foreach($options as $key=>$value){

          $k=$key+1;
          echo '<li>
                  <div class="radio">
                    <input type="radio" id="'.$post->post_name.$key.'" name="'.$post->post_name.'" value="'.$k.'" '.(in_array($k,$content)?'checked':'').'/>
                    <label for="'.$post->post_name.$key.'"><span></span> '.apply_filters('vibebp_the_content',do_shortcode($value)).'</label>
                  </div>  
                </li>';
        }
      }else if($type == 'sort'){
        foreach($options as $key=>$value){
          echo '<li id="'.($key+1).'" class="sort_option">
                      <label for="'.$post->post_name.$key.'"><span></span> '.apply_filters('vibebp_the_content',do_shortcode($value)).'</label>
                  </li>';
        }        
      }else if($type == 'match'){
        foreach($options as $key=>$value){
          echo '<li id="'.($key+1).'" class="match_option">
                      <label for="'.$post->post_name.$key.'"><i class="vicon vicon-move"></i> '.do_shortcode($value).'</label>
                  </li>';
        }        
      }else if($type == 'truefalse'){
        foreach($options as $key=>$value){

          echo '<li>
                  <div class="radio">
                    <input type="radio" id="'.$post->post_name.$key.'" name="'.$post->post_name.'" value="'.$key.'" '.(in_array($key,$content)?'checked':'').'/>
                    <label for="'.$post->post_name.$key.'"><span></span> '.$value.'</label>
                  </div>  
                </li>';
        }       
      }else{
        foreach($options as $key=>$value){
          $k=$key+1;
          echo '<li>
                  <div class="checkbox">
                    <input type="checkbox" id="'.$post->post_name.$key.'" name="'.$post->post_name.$key.'" value="'.$k.'" '.(in_array($k,$content)?'checked':'').'/>
                    <label for="'.$post->post_name.$key.'">'.do_shortcode($value).'</label>
                  </div>  
                </li>';
        }
      }  
      echo '</ul>';
    }
  }
}

function the_marked_question_answer($quiz_id=null){
  global $post,$wpdb;
  $user_id = get_current_user_id();
  if(empty($quiz_id)){
    $answer = $wpdb->get_var($wpdb->prepare("SELECT comment_content FROM {$wpdb->comments} WHERE comment_post_ID = %d and user_id = %d LIMIT 0,1",$post->ID,$user_id));
  }else{
    $answer = bp_course_get_question_marked_answer($quiz_id,$post->ID,$user_id);
  }
  if(isset($answer) && $answer != ''){
    echo '<input type="hidden" id="question_marked_answer'.$post->ID.'" value="'.$answer->comment_content.'" />';
  }
}

if(!function_exists('the_text')){
  function the_text(){
      global $post;
      echo '<div class="single_text">';
      echo '<input type="text" class="form_field" placeholder="'.__('Type answer','wplms').'" />';
      echo '</div>';
  }
}

if(!function_exists('the_textarea')){
  function the_textarea(){
      echo '<div class="essay_text">';
      echo '<textarea class="form_field" placeholder="'.__('Type answer','wplms').'"></textarea>';
      echo '</div>';
  }
}

if(!function_exists('the_question_tags')){
  function the_question_tags($before,$saperator,$after){
    global $post;
    echo get_the_term_list($post->ID,'question-tag',$before,$saperator,$after);
  }
}

function bp_course_user_time_left($args){
  echo bp_get_course_user_time_left($args);
}

if(!function_exists('bp_get_course_user_time_left')){
  function bp_get_course_user_time_left($args=NULL){
    $defaults=array(
    'course' =>get_the_ID(),
    'user'=> get_current_user_id()
    );

    $r = wp_parse_args( $args, $defaults );
    extract( $r, EXTR_SKIP );
    $course_duration_parameter = apply_filters('vibe_course_duration_parameter',86400,$course);
    $expiry = bp_course_get_user_expiry_time($user,$course);

    $time_left = 0;
    if(!empty($expiry)){
      $time = time();
      $time_left = intval($expiry) - $time;
    }

    if($time_left > 0){
      if($time_left > 863913600){
        return __('Unlimited Time','wplms');
      }
      return round(($time_left/$course_duration_parameter),0).' '.calculate_duration_time($course_duration_parameter);
    }else{
      return __('EXPIRED','wplms');
    }
  }
}

if(!function_exists('the_quiz')){
  function the_quiz($args=NULL){

  $defaults=array(
  'quiz_id' =>get_the_ID(),
  'ques_id'=> ''
  );

  $r = wp_parse_args( $args, $defaults );
  extract( $r, EXTR_SKIP );

    $user_id = get_current_user_id();
    $questions = bp_course_get_quiz_questions($quiz_id,$user_id);

    if(isset($questions['ques']) && is_array($questions['ques']))
      $key=array_search($ques_id,$questions['ques']);

    if($ques_id){
      $the_query = new WP_Query(array(
        'post_type'=>'question',
        'p'=>$ques_id
        ));
      while ( $the_query->have_posts() ) : $the_query->the_post(); 
        the_question('',$quiz_id);
        do_action('wplms_quiz_question',$ques_id,$quiz_id);
        echo '<div class="quiz_bar">';
        if($key == 0){ // FIRST QUESTION
          if($key != (count($questions['ques'])-1)) // First But not the Last
            echo '<a href="#" class="ques_link right quiz_question nextq" data-quiz="'.$quiz_id.'" data-qid="'.$questions['ques'][($key+1)].'">'.__('Next Question','wplms').' &rsaquo;</a>';

        }elseif($key == (count($questions['ques'])-1)){ // LAST QUESTION

          echo '<a href="#" class="ques_link left quiz_question prevq" data-quiz="'.$quiz_id.'" data-qid="'.$questions['ques'][($key-1)].'">&lsaquo; '.__('Previous Question','wplms').'</a>';

        }else{
          echo '<a href="#" class="ques_link left quiz_question prevq" data-quiz="'.$quiz_id.'" data-qid="'.$questions['ques'][($key-1)].'">&lsaquo; '.__('Previous Question','wplms').'</a>';
          echo '<a href="#" class="ques_link right quiz_question nextq" data-quiz="'.$quiz_id.'" data-qid="'.$questions['ques'][($key+1)].'">'.__('Next Question','wplms').' &rsaquo;</a>';
        }

        echo '</div>';
      endwhile;
      wp_reset_postdata();
    }else{
        
        $quiz_taken=get_user_meta($user_id,$quiz_id,true);
        if(isset($quiz_taken) && $quiz_taken && ($quiz_taken < time())){

          $message=get_post_meta($quiz_id,'vibe_quiz_message',true);
          echo '<div class="main_content">';
          echo apply_filters('the_content',$message);
          do_action('wplms_after_quiz_message',$quiz_id,$user_id);
          echo '</div>';
        }else{
          echo '<div class="main_content">';
          the_content();
          echo '</div>';
        }
    }
  }
}

if(!function_exists('the_quiz_timer')){
  function the_quiz_timer($args=NULL){
    global $post;

    $defaults = array( 'start'=>'','quiz_id'=>$post->ID);
    $args = wp_parse_args( (array)$args, $defaults );
    extract($args);

      $user_id = get_current_user_id();
      $quiztaken=get_user_meta($user_id,$quiz_id,true);
      $minutes=intval(get_post_meta($quiz_id,'vibe_duration',true));
      
      if($minutes > 9998)
        return true;
      
      if(isset($quiztaken) && is_numeric($quiztaken) && $quiztaken){ 
          if($quiztaken>time()){
            $minutes=$quiztaken-time();
            $start=1;
          }else{
            $minutes=0;
          }  
      }else{
          if(!$minutes) {$minutes=1; echo __("Duration not Set","vibe");}else $start=0;
          $quiz_duration_parameter = apply_filters('vibe_quiz_duration_parameter',60,$quiz_id);
          $minutes= $minutes*$quiz_duration_parameter;
      } 

      echo '<div class="quiz_timer '.(($start)?'start':'').'" data-time="'.$minutes.'">
      <span class="timer" data-timer="'.$minutes.'"></span>
      <span class="countdown">'.minutes_to_hms($minutes).'</span>
      <span>'.__('Time Remaining','wplms').'</span>'.
      '<span '.(($minutes >= 10800)?'':'style="display:none;"').' class="timer_hours_labels"><strong>'.__('Hour','wplms').'</strong> '.__('Mins','wplms').'</span>'.
      '<span '.(($minutes >= 10800)?'style="display:none;"':'').' class="timer_mins_labels"><strong>'.__('Mins','wplms').'</strong> '.__('Secs','wplms').'</span>'.'
      </div>';
  }
}


if(!function_exists('minutes_to_hms')){
  function minutes_to_hms($sec){
    if($sec >= 10800){
       $hours = floor($sec/3600);
        $mins = floor(($sec%3600)/60);
        if($mins < 10) $mins = '0'.$mins;
        return $hours.':'.$mins;
    }else if($sec > 60){
        $minutes = floor($sec/60);
        $secs = $sec%60;
        if($secs < 10) $secs = '0'.$secs;
        return $minutes.':'.$secs;
    }else{
      $secs = $sec;
      if($secs == 0){
        return  _x( 'ENDED','displayed to user when quiz times out.','wplms' );
      }else{
        return '00:'.$secs;  
      }
    }
  }
}

if(!function_exists('tofriendlytime')){
  function tofriendlytime($seconds,$force = null) {
  $measures = array(
    array('label'=>__('year','wplms'),'multi'=>__('years','wplms'), 
          'value'=>12*30*24*60*60),
    array('label'=>__('month','wplms'),'multi'=>__('months','wplms'), 
          'value'=>30*24*60*60),
    array('label'=>__('week','wplms'),'multi'=>__('weeks','wplms'), 
          'value'=>7*24*60*60),
    array('label'=>__('day','wplms'),'multi'=>__('days','wplms'), 
          'value'=>24*60*60),
    array('label'=>__('hour','wplms'),'multi'=>__('hours','wplms'), 
          'value'=>60*60),
    array('label'=>__('minute','wplms'),'multi'=>__('minutes','wplms'), 
          'value'=>60),
    array('label'=>__('second','wplms'),'multi'=>__('seconds','wplms'), 
          'value'=>1),
    );

    if($seconds <= 0)
      return __('EXPIRED','wplms');
  
    foreach($measures as $key => $measure){
      if(!empty($force)){
          if($measure['value'] <= $force){
            $count = floor($seconds/$force);
            break;
          }
      }else{
          if($measure['value'] < $seconds && empty($force)){
            $count = floor($seconds/$measure['value']);
            break;
          }
      }
    }

    if(empty($force))
      $time_labels = $count.' '.(($count > 1)?$measure['multi']:$measure['label']);
    else
      $time_labels = (($count > 1)?$count:'').' '.(($count > 1)?$measure['multi']:$measure['label']);

    if($measure['value'] > 1){ // Ensure we're not on last element
      $small_measure = $measures[$key+1];  
      $small_count = floor(($seconds%$measure['value'])/$small_measure['value']);
      if($small_count)
        $time_labels .= ', '.$small_count.' '.(($small_count > 1)?$small_measure['multi']:$small_measure['label']);
    }

  return $time_labels;
  } 
}

if(!function_exists('the_course_timeline')){
    
    function the_course_timeline($course_id=NULL,$uid=NULL){
       $user_id = get_current_user_id(); 
       $class='';

       if(class_exists('WPLMS_tips')){
        $settings = WPLMS_tips::init();
         if(!empty($settings->settings['curriculum_accordion']))
            $class="accordion"; 
       }

       $return ='<div class="course_timeline '.$class.'">
                    <ul>';
        $course_curriculum= bp_course_get_curriculum($course_id); 

        if(isset($course_curriculum) && is_array($course_curriculum)){
            $first_unit = 1;
            $nextunit_access = apply_filters('bp_course_next_unit_access',true,$course_id);
            $active_flag=0; // For duplicate active check.

            foreach($course_curriculum as $key => $unit_id){
                
                if(is_numeric($unit_id)){
                    if(bp_course_get_post_type($unit_id) == 'unit'){
                        $unittaken = bp_course_check_unit_complete($unit_id,$user_id,$course_id);
                    }else{
                        $unittaken = bp_course_check_quiz_complete($unit_id,$user_id,$course_id);
                    }

                    $class='';$flag=0;

                    if(!empty($uid)){
                        if($uid == $unit_id || $uid == $first_unit){
                            if(empty($active_flag)){
                                $active_flag = 1;
                                $class .=' active';
                            }
                            $flag = 1;
                        }
                    }else{
                        if(!empty($first_unit)){
                            if(empty($active_flag)){
                                $active_flag = 1;
                                $class .=' active';
                            }
                        }
                    }

                    $first_unit=0;

                    if(isset($unittaken) && $unittaken ){
                        $class .=' done';
                        $flag = 1;
                    } 

                    if(empty($nextunit_access)){ 
                        if($flag){
                            $return .= '<li id="unit'.$unit_id.'" class="unit_line '.$class.'"><span></span> <a class="unit" data-unit="'.$unit_id.'">'.get_the_title($unit_id).'</a></li>';
                        }else{
                            $return .= '<li id="unit'.$unit_id.'" class="unit_line '.$class.'"><span></span> <a>'.get_the_title($unit_id).'</a></li>';        
                        }
                    }else{
                        $return .= '<li id="unit'.$unit_id.'" class="unit_line '.$class.'"><span></span> <a class="unit" data-unit="'.$unit_id.'">'.get_the_title($unit_id).'</a></li>';
                    }
                }else{
                    
                    $return .='<li class="section"><h4>'.$unit_id.'</h4></li>';

                }
            } // End For
        }else{
            $return .= '<li><h3>';
            $return .=__('Course Curriculum Not Set.','wplms');
            $return .= '</h3></li>';
        }      

        $return .='</ul></div>';             
        return $return;
    }
}


if(!function_exists('the_unit')){
  function the_unit($id=NULL){
    if(!isset($id))
      return;
    $react_quizzes = apply_filters('wplms_use_react_quizzes',1);
    do_action('wplms_before_every_unit',$id);
    $post_type = bp_course_get_post_type($id);
    $the_query = new WP_Query( 'post_type='.$post_type.'&p='.$id );
    $user_id = get_current_user_id();

    while ( $the_query->have_posts() ):$the_query->the_post();
      $unit_class = 'unit_class';
      $unit_class=apply_filters('wplms_unit_classes',$unit_class,$id);
      echo '<div class="main_unit_content '.$unit_class.'">';
      
      if($post_type == 'quiz'){ 
        
        if(!$react_quizzes){
          $expiry = get_user_meta($user_id,$id,true);
          if(is_numeric($expiry) && $expiry < time()){
            $message = get_post_meta($id,'vibe_quiz_message',true);
            echo apply_filters('the_content',$message);
            do_action('wplms_after_quiz_message',$id,$user_id);
          }else{
            the_content();  
          }
        }else{
          do_action('wplms_inside_quiz_main_unit_content',$id);
        }
      }else{
        if($post_type != 'wplms-assignment')
         the_content();  
      }
      
      wp_link_pages(apply_filters('wplms_unit_pre_next',array(
        'before'=>'<div class="unit-page-links page-links"><div class="page-link">',
        'link_before' => '<span>',
        'link_after'=>'</span>',
        'after'=> '</div></div>')));

      echo '</div>';
    endwhile;
    wp_reset_postdata();

    $attachments = apply_filters('wplms_unit_attachments',1,$id);
    if($attachments){
      echo bp_course_get_unit_attachments($id);
    }


    if(bp_course_get_post_type($id) == 'unit'){
      do_action('wplms_after_every_unit',$id);
    }
    if($post_type == 'quiz'){
      do_action('wplms_front_end_quiz_controls',$id);
    }
    do_action('wplms_after_every_course_curriculum_lesson',$id);

    $forum=get_post_meta($id,'vibe_forum',true);
    if(!empty($forum) && bp_course_get_post_type($forum) == 'forum'){
      echo '<div class="unitforum"><a href="'.get_permalink($forum).'" target="_blank">'.__('Have Questions ? Ask in the Unit Forums','wplms').'</a></div>';
    }
  }
}

if(!function_exists('bp_course_get_unit_attachments')){

  function bp_course_get_unit_attachments($id=NULL){
      
        if(!is_numeric($id)){
          global $post;
          $id=$post->ID;
          if($post->post_type != 'unit')
            return;

        }else{
            if(bp_course_get_post_type($id) != 'unit')
                return;
        }

        $return='';
        $attachments = get_post_meta($id,'vibe_unit_attachments',true);
        
        if(!empty($attachments)){

            $return ='<div class="unitattachments"><h4>'.__('Attachments','wplms').'<span><i class="icon-download-3"></i>'.count($attachments).'</span></h4><ul id="attachments">';
          
            foreach($attachments as $attachment_id){
                $type=get_post_mime_type($attachment_id);
                $type = bp_course_get_attachment_type($type);
                $return .='<li><i class="'.$type.'"></i>'.wp_get_attachment_link($attachment_id).'</li>';
            }
         
            $return .= '</ul></div>';
            return $return;  
        }

      return $return;

      //Fallback removed more than 2 yeara now

      //IF Attachments are not set
      $attachments = get_children( 'post_type=attachment&output=ARRAY_N&orderby=menu_order&order=ASC&post_parent='.$id);
       if($attachments && count($attachments)){
            $att= '';

            $count=0;
          foreach( $attachments as $attachmentsID => $attachmentsPost ){
          $type=get_post_mime_type($attachmentsID);

          if($type != 'image/jpeg' && $type != 'image/png' && $type != 'image/gif'){
                $type = bp_course_get_attachment_type($type);
                $count++;
              $att .='<li><i class="'.$type.'"></i>'.wp_get_attachment_link($attachmentsID).'</li>';
            }
          }

        if($count){
          $return ='<div class="unitattachments"><h4>'.__('Attachments','wplms').'<span><i class="icon-download-3"></i>'.$count.'</span></h4><ul id="attachments">';
          $return .= $att;
          $return .= '</ul></div>';
        }
      }
      return $return;
    }
}

if(!function_exists('bp_course_get_attachment_type')){
  function bp_course_get_attachment_type($type){

        if($type == 'application/zip')
            $type='fa fa-file-archive-o';
        else if($type == 'video/mpeg' || $type== 'video/mp4' || $type== 'video/quicktime')
            $type='fa fa-file-video-o';
        else if($type == 'text/csv' || $type== 'text/plain' || $type== 'text/xml')
            $type='fa fa-excel-o';
        else if($type == 'audio/mp3' || $type== 'audio/ogg' || $type== 'audio/wmv')
            $type='fa fa-audio-o';
        else if($type == 'application/pdf')
            $type='fa fa-file-pdf-o';
        else if($type == 'image/jpeg' || $type == 'image/jpg' || $type == 'image/png' && $type == 'image/gif')
            $type='fa fa-picture-o';
        else    
            $type='fa fa-file-text-o';

        return $type;
    }
}

if(!function_exists('the_unit_tags')){
  function the_unit_tags($id){
    $list = get_the_term_list($id,'module-tag','<ul class="tags"><li>','</li><li>','</li></ul>');
    if(strlen($list)>32){
      echo $list;
    }
  }
}

if(!function_exists('the_unit_instructor')){
  function the_unit_instructor($id){
    global $post,$bp;

    $enable_instructor = apply_filters('wplms_display_instructor',true,$post->ID);
    if( !$enable_instructor ){
      return;
    }

    if(isset($id)){
      $author_id = get_post_field( 'post_author', $id );
    }else{
      $author_id = get_the_author_meta('ID');
    }
   
    echo '<div class="instructor">
            <a href="'.bp_core_get_user_domain($author_id).'" title="'.bp_core_get_user_displayname( $author_id) .'"> '.get_avatar($author_id).' <span><strong>'.__('Instructor','wplms').'</strong><br />'.bp_core_get_user_displayname( $author_id) .'</span></a>
          </div>';
       
  }
}

function wplms_user_course_check($user_id = null,$course_id = null){

  if(!isset($user_id) || !$user_id )
    $user_id = get_current_user_id();
  if(!isset($course_id) || !$course_id || !is_numeric($course_id)){
    global $post;
    if($post->post_type == 'course'){
      $course_id = $post->ID;
    }
  }

  $check = get_user_meta($user_id,$course_id,true);
  if(isset($check) && $check && is_numeric($check))
    return true;

  return false;
}



function wplms_user_course_active_check($user_id = null,$course_id = null){

  if(!isset($user_id) || !$user_id)
    $user_id = get_current_user_id(); 

  if(!is_numeric($course_id)){
    global $post;
    if($post->post_type == 'course'){
      $course_id = $post->ID;
    }
  }

  $check = get_user_meta($user_id,$course_id,true);
  if(isset($check) && $check > time()){
    $course_check = bp_course_get_user_course_status($user_id,$course_id);
    if(isset($course_check) && $course_check < 4 ) // Check status of the Course 0 : Start, 1: Continue, 2: Finished and under evaluation, >2: Evaluated
      return true;
  }  
  return false;
}

function the_course_time($args){
  echo '<strong>'.__('Time Remaining','wplms').' : <span>'.get_the_course_time($args).'</span></strong>';
}

function get_the_course_time($args){
  $defaults=array(
    'course_id' =>get_the_ID(),
    'user_id'=> get_current_user_id()
    );
  $r = wp_parse_args( $args, $defaults );

    extract( $r, EXTR_SKIP );

    $start_date = get_post_meta($course_id,'vibe_start_date',true);
 
    if(!empty($start_date) && strtotime($start_date) >= time()){
        $seconds = bp_course_get_course_duration($course_id);
    }else{
      $seconds=get_user_meta($user_id,$course_id,true);

      if(!isset($seconds) || !$seconds){
        $seconds = bp_course_get_course_duration($course_id);
      }else{
        $seconds = $seconds - time();
      }
    }

    if($seconds<0)
      $seconds = 0;
    $time = tofriendlytime($seconds);
    return apply_filters('course_friendly_time',$time,$seconds,$course_id);      
}

/*
    BADGE FUNCTIONS
 */
function bp_get_course_badge($id=NULL){
  if(!isset($id))
      $id=get_the_ID();

  $badge=get_post_meta($id,'vibe_course_badge',true);
  return $badge;
}

// USER BADGES
function bp_course_get_user_badges($user_id = null){
  if(empty($user_id))
      $user_id = get_current_user_id();

  $badges = apply_filters('bp_course_get_user_badges','',$user_id);
  if(empty($badges))
      $badges=get_user_meta($user_id,'badges',true); 

  return $badges;
}

function bp_course_get_badge($badge_id,$title_id){
    if(empty($badge_id))
        return;
  
    $badge=wplms_plugin_wp_get_attachment_info($badge_id); 
    $badge_url=wp_get_attachment_image_src($badge_id,'full');
    return '<a class="tip ajax-badge" data-course="'.get_the_title($title_id).'" title="'.get_post_meta($title_id,'vibe_course_badge_title',true).'"><img src="'.$badge_url[0].'" title="'.$badge['title'].'"/></a>';
}

/*
END  BADGE FUNCTIONS
 */
/*
 CERTIFICATE FUNCTIONS
 */

function bp_course_get_user_certificates($user_id = null){
    if(empty($user_id))
        $user_id = get_current_user_id();

    $certificates = apply_filters('bp_course_get_user_certificates','',$user_id);
    if(empty($certificates))
        $certificates=get_user_meta($user_id,'certificates',true); 

    return $certificates;
}

function bp_get_course_certificate($args){
  $defaults=array(
    'course_id' =>get_the_ID(),
    'user_id'=> get_current_user_id()
    );

  $r = wp_parse_args( $args, $defaults );
  extract( $r, EXTR_SKIP );

    $url = apply_filters('bp_get_course_certificate_url',0,$course_id,$user_id);
    if(empty($url)){
        $certificate_template_id=get_post_meta($course_id,'vibe_certificate_template',true);
        if(!empty($certificate_template_id) && is_numeric($certificate_template_id)){
            $pid = $certificate_template_id;
        }else{
            if(function_exists('vibe_get_option')){
                $pid=vibe_get_option('certificate_page');
            }
        }
        $url = get_permalink($pid).'?c='.$course_id.'&u='.$user_id;
    }
    return $url;
}

/*
    END  CERTIFICATE FUNCTIONS
*/

function bp_get_total_instructor_count(){
  $args =  array(
    'role' => 'Instructor',
    'count_total' => true
    );
  $users = new WP_User_Query($args);
  return count($users->results);
  
}

//Evaluate individual question function
function bp_course_evaluate_question($args,$marked_answer){
    $correct = 1; $incorrect = 0; 
    //Args must include question_id
    extract($args);
    if(empty($question_id))
        return $incorrect;

    if(empty($type))
        $type = get_post_meta($question_id,'vibe_question_type',true); 

    if(!isset($correct_answer))
        $correct_answer = get_post_meta($question_id,'vibe_question_answer',true);

    if(!isset($marked_answer) || !isset($correct_answer) || !isset($type))
        return $incorrect;

    
    $partial_marking = apply_filters('bp_course_evaluate_question_partial_marking',0);
    switch($type){
        case 'multiple':
            $marked_answers = explode(',',$marked_answer);
            if(!is_array($marks_answers)){ // Force Array Form
                $marks_answers=array($marks_answers);
            } 
                
            $correct_answers = explode(',',$correct_answer);
            if(!is_array($correct_answers)){ // Force Array Form
                $correct_answers=array($correct_answers);
            }
            foreach($marked_answers as $k=>$v){
              if($v==''){unset($marked_answers[$k]);}
            }
            sort($marked_answers);
            sort($correct_answers);

            if($partial_marking){
              $marked_answers_by_user = 0;

              foreach($marked_answers as $k=>$v){
                if(in_array($v,$correct_answers)){
                  $marked_answers_by_user++;
                }else{
                  $marked_answers_by_user--;
                }
              }
              if( $marked_answers_by_user < 0 ){
                $marked_answers_by_user = 0;
              }

              return ($marked_answers_by_user/count($correct_answers));
              
            }else{
              if(array_diff($marked_answers,$correct_answers) == array_diff($correct_answers,$marked_answers)){
                  return $correct;
              }
            }
            
        break;
        case 'smalltext':
        case 'fillblank':
        case 'select':
            //IF multiple Fill blanks
           
            $marked_answer = rtrim($marked_answer,'|');
            if(strpos($correct_answer, '|') !== false){
                $correct_answers = explode('|',$correct_answer);
                if(!empty($marked_answer)){
                    if(strpos($marked_answer, '|') !== false){
                      $marked_answers = explode('|',$marked_answer);
                    }else{
                      $marked_answers = array($marked_answer);
                    }
                    
                    $marked_answers_by_user = count($correct_answers);
                    foreach($correct_answers as $ci=>$c_answer){

                        if(!isset($marked_answers[$ci]) && !$partial_marking){
                          return $incorrect;
                        }

                        if($partial_marking && !isset($marked_answers[$ci])){
                          $marked_answers[$ci] = '';
                        }

                        $k = apply_filters('wplms_text_correct_answer',strtolower($c_answer),$c_answer);
                        
                        if(strpos($k, ',') !== false){
                            $c_arr= explode(',',$k);
                            if(!empty($c_arr)){
                              foreach($c_arr as $x=>$v){
                                $c_arr[$x]=trim($v,' ');
                              }
                            }
                        }else{
                          $k = trim($k,' ');
                          $c_arr = array($k);  
                        }
                        
                        $marked_answers[$ci] = trim($marked_answers[$ci],' ');

                        $marked_answers[$ci] = apply_filters('wplms_text_correct_answer',strtolower($marked_answers[$ci]),$marked_answers[$ci]);
                        if(!in_array($marked_answers[$ci],$c_arr)){ // Match sequentially
                          if($partial_marking){
                            $marked_answers_by_user--;
                          }else{
                            return $incorrect;
                          }
                        }
                    }
                    if($partial_marking){
                      return ($marked_answers_by_user/count($correct_answers));
                    }
                    return $correct;
                }
            }else{
                if(strpos($correct_answer, ',') !== false){
                    $correct_answers_array = explode(',',$correct_answer);
                    foreach($correct_answers_array as $c_answer){
                        $c_answer = apply_filters('wplms_text_correct_answer',strtolower($c_answer),$c_answer);
                        $marked_answer = apply_filters('wplms_text_correct_answer',strtolower($marked_answer),$marked_answer);
                            if( $c_answer == $marked_answer){
                                return $correct;
                            
                        }
                    }
                }else{
                    $correct_answer = apply_filters('wplms_text_correct_answer',strtolower($correct_answer),$correct_answer);
                    $marked_answer = apply_filters('wplms_text_correct_answer',strtolower($marked_answer),$marked_answer);
                    if($correct_answer == $marked_answer){
                        return $correct;
                    }
                }
            }
        break;
        case 'sort':
        case 'match':
            $marked_answers = explode(',',$marked_answer);
            if(!is_array($marks_answers)){ // Force Array Form
                $marks_answers=array($marks_answers);
            } 
                
            $correct_answers = explode(',',$correct_answer);
            if(!is_array($correct_answers)){ // Force Array Form
                $correct_answers=array($correct_answers);
            }
            foreach($marked_answers as $k=>$v){
              if($v==''){unset($marked_answers[$k]);}
            }

            if($partial_marking){
              $marked_answers_by_user = 0;

              foreach($marked_answers as $k=>$v){
                if($v == $correct_answers[$k]){
                  $marked_answers_by_user++;
                }
              }
              if( $marked_answers_by_user < 0 ){
                $marked_answers_by_user = 0;
              }

              return ($marked_answers_by_user/count($correct_answers));
              
            }else{
              if($marked_answer == $correct_answer){
                  return $correct;
              }
            }
        break;
        default:
            $correct_answer = apply_filters('bp_course_evaluate_question',$correct_answer,$args,$marked_answer);
            if($marked_answer == $correct_answer){
                return $correct;
            }
        break;
    }

    return $incorrect;
}
// End function

function bp_course_validate_certificate($args){
  $defaults=array(
    'course_id' =>get_the_ID(),
    'user_id'=> get_current_user_id()
    );
  $r = wp_parse_args( $args, $defaults );
  extract( $r, EXTR_SKIP );
  
  if(!is_numeric($course_id)){
      $course_id = explode('-',$course_id);
      $course_id = $course_id[0];
    }
    
  $meta = vibe_sanitize(get_user_meta($user_id,'certificates',false));

  if(isset($meta)){ 
    if((in_array($course_id,$meta) && is_array($meta)) || (!is_array($meta) && $course_id==$meta)){
      return;
    }else{
      wp_die(__('Certificate not valid for user','wplms'));
    }
  }else{
    wp_die(__('Certificate not valid for user','wplms'));
  }
}

function bp_course_add_user_to_course($user_id,$course_id,$duration = NULL,$force = NULL,$args=null){
  
    if(empty($args)){$args=array();}
    
    $seats = bp_course_get_max_students($course_id,$user_id); 
    $students = bp_course_count_students_pursuing($course_id);

    if(!empty($seats) && $seats < 9999 && empty($force)){
      if($seats <= $students){ 
            $GLOBALS['wplms_course_enroll_error'] = sprintf(_x('(%s) Seats full','','wplms'),$seats);
         return false;
      }
    }
    $total_duration = 0;
    if(empty($duration)){
      $total_duration = bp_course_get_course_duration($course_id,$user_id);
    }else{
      $total_duration = $duration;
    }
   
    $time=0;
    $existing = get_user_meta($user_id,$course_id,true);

    if(empty($existing)){
        $start_date = bp_course_get_start_date($course_id,$user_id); 
        if(isset($start_date) && $start_date){
          $time=strtotime($start_date);
        }
    }else{
        $time = $existing;
    }

    if($time<time())
      $time=time();

    if(empty($total_duration)){
      $total_duration=0;
    }

    $t=intval($time)+intval($total_duration);

    update_post_meta($course_id,$user_id,0);
    
    if(empty($existing)){
      update_user_meta($user_id,'course_status'.$course_id,1);
      $accuracy = vibe_get_option('sync_student_count');
      if(empty($accuracy) || $accuracy == '0'){ 
        $students = get_post_meta($course_id,'vibe_students',true);
      }
      $students++;
      update_post_meta($course_id,'vibe_students',$students);
    }else{
      update_user_meta($user_id,'course_status'.$course_id,2);
    }

    update_user_meta($user_id,$course_id,$t);

    $group_id=get_post_meta($course_id,'vibe_group',true);
    if(!empty($group_id) && function_exists('groups_join_group')){
      groups_join_group($group_id, $user_id );  
    }else{
      $group_id = '';
    }

    $auto_forum_subscribe = apply_filters('bp_course_add_user_to_course_enable_forum_subscription',1);
    if($auto_forum_subscribe){
      $forum_id = get_post_meta($course_id,'vibe_forum',true);
      if(!empty($forum_id) && function_exists('bbp_add_user_forum_subscription')){
        bbp_add_user_forum_subscription( $user_id, $forum_id);
      }
    }

    do_action('wplms_course_subscribed',$course_id,$user_id,$group_id,$args);

    return $t;
}

function bp_course_remove_user_from_course($user_id,$course_id){
    
    delete_post_meta($course_id,$user_id);
    delete_user_meta($user_id,$course_id);
    delete_user_meta($user_id,'course_status'.$course_id);

    if(function_exists('groups_leave_group')){
      $group_id=get_post_meta($course_id,'vibe_group',true);
      if(!empty($group_id)){
        groups_leave_group($group_id, $user_id );  
      }
    }
    if(function_exists('bbp_remove_user_forum_subscription')){
      $forum_id = get_post_meta($course_id,'vibe_forum',true);
      if(!empty($forum_id) && function_exists('bbp_remove_user_forum_subscription')){
        bbp_remove_user_forum_subscription( $user_id, $forum_id);
      }    
    }
    if ( class_exists( 'WooCommerce' ) ) {
      $product_id = get_post_meta($course_id,'vibe_product',true);
    }
    do_action('wplms_course_unsubscribed',$course_id,$user_id);

}

function bp_course_instructor_controls(){
  global $bp,$wpdb;
  $user_id=$bp->loggedin_user->id;
  $course_id = get_the_ID();

  $curriculum=bp_course_get_curriculum($course_id);
  $course_quizes=array();
  if(!empty($curriculum)){
      foreach($curriculum as $c){
        if(is_numeric($c)){
          if(bp_course_get_post_type($c) == 'quiz'){
              $course_quizes[]=$c;
            }
        }
    }
  }else{

  }

  echo '<ul class="instructor_action_buttons">';

  $course_query = $wpdb->get_results($wpdb->prepare("SELECT COUNT(meta_key) as num FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_value = %d",$course_id,2));
  $num=0;
  if(isset($course_query) && $course_query !='')
    $num=$course_query[0]->num;
  else
    $num=0;

  $admin_slug = '/?action=admin';
  $extend_submissions = '/?action=admin&submissions';
  $extend_stats = '/?action=admin&stats';
  $extend_activity = '/?action=activity';

  if(class_exists('Vibe_CustomTypes_Permalinks')){
    $permalinks = Vibe_CustomTypes_Permalinks::init();
    $tips = WPLMS_tips::init();
    
    if(!empty($permalinks) && empty($tips->settings['revert_permalinks'])){
      $admin_slug = $permalinks->permalinks['admin_slug'];
      $extend_submissions = $permalinks->permalinks['admin_slug'].$permalinks->permalinks['submissions_slug'];
      $extend_stats = $permalinks->permalinks['admin_slug'].$permalinks->permalinks['stats_slug'];
      $extend_activity = $permalinks->permalinks['activity_slug'];
    }
  }
  echo '<li><a href="'.untrailingslashit(get_permalink($course_id)).$extend_submissions.'" class="action_icon tip" title="'.__('Evaluate course submissions','wplms').'"><i class="icon-task"></i><span>'.$num.'</span></a></li>';  

  if(isset($course_quizes) && !empty($course_quizes) && is_array($course_quizes) && count($course_quizes)){
    if(is_array($course_quizes))
      $course_quizes = join(',',$course_quizes);  
      
      $num = $wpdb->get_var($wpdb->prepare("SELECT COUNT(meta_key) FROM {$wpdb->postmeta} WHERE post_id IN ({$course_quizes}) AND meta_key REGEXP '^[0-9]+$' AND meta_value = %d",0));

    
    if(!is_numeric($num))
      $num=0;

    echo '<li><a href="'.untrailingslashit(get_permalink($course_id)).$extend_submissions.'" class="action_icon tip"  title="'.__('Evaluate Quiz submissions','wplms').'"><i class="icon-check-clipboard-1"></i><span>'.$num.'</span></a></li>';

  } 

  $n=get_post_meta($course_id,'vibe_students',true);
  if(isset($n) && $n !=''){$num=$n;}else{$num=0;}
  echo '<li><a href="'.untrailingslashit(get_permalink($course_id)).$admin_slug.'" class="action_icon tip"  title="'.__('Manage Students','wplms').'"><i class="icon-users"></i><span>'.$num.'</span></a></li>';
  echo '<li><a href="'.untrailingslashit(get_permalink($course_id)).$extend_stats.'" class="action_icon tip"  title="'.__('See Stats','wplms').'"><i class="icon-analytics-chart-graph"></i></a></li>';
  echo '<li><a href="'.untrailingslashit(get_permalink($course_id)).$extend_activity.'" class="action_icon tip"  title="'.__('See all Activity','wplms').'"><i class="icon-atom"></i></a></li>';
  echo '</ul>';
}


function bp_wplms_get_theme_color(){
  $option = get_option('vibe_customizer');
  if(isset($option) && is_Array($option)){
    if(isset($option['primary_bg']))
     return $option['primary_bg'];
  }
  return '#78c8c9';
}

function bp_wplms_get_theme_single_dark_color(){
  $option = get_option('vibe_customizer');
  if(isset($option) && is_Array($option)){
    if(isset($option['single_dark_color']))
     return $option['single_dark_color'];
  }
  return '#232b2d';
}

if(!function_exists('calculate_duration_time')){
  function calculate_duration_time($seconds) {
    switch($seconds){
      case 1: $return = __('Seconds','wplms');break;
      case 60: $return = __('Minutes','wplms');break;
      case 3600: $return = __('Hours','wplms');break;
      case 86400: $return = __('Days','wplms');break;
      case 604800: $return = __('Weeks','wplms');break;
      case 2592000: $return = __('Months','wplms');break;
      case 31104000: $return = __('Years','wplms');break;
      default:
      $return = apply_filters('vibe_calculation_duration_default',$return,$seconds);
      break;
    }
    return $return;
  } 
}

if(!function_exists('pmpro_wplms_renew_course')){
 add_filter('wplms_course_product_id','pmpro_wplms_renew_course',10,2);
 function pmpro_wplms_renew_course($pid,$course_id){
   if(!is_numeric($pid)){
     if ( in_array( 'paid-memberships-pro/paid-memberships-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || (function_exists('is_plugin_active') && is_plugin_active( 'paid-memberships-pro/paid-memberships-pro.php'))) {
        $membership_ids = get_post_meta($course_id,'vibe_pmpro_membership',true);
        if(!empty($membership_ids)){
          $pmpro_levels_page_id = get_option('pmpro_levels_page_id');
          $pid = get_permalink($pmpro_levels_page_id);
        }
     } 
   }
   return $pid;
 }
}

// Submission functions
function bp_course_get_course_submission_count($course_id,$status=3){
  global $wpdb;
  $count = $wpdb->get_var(apply_filters('wplms_usermeta_direct_query',"SELECT count(*) FROM {$wpdb->usermeta} WHERE meta_key = 'course_status$course_id' AND meta_value = $status"));
  return (empty($count)?0:$count);
}

function bp_course_get_quiz_submission_count($quiz_id,$status=3){
  global $wpdb;
  $count = $wpdb->get_var(apply_filters('wplms_usermeta_direct_query',"SELECT count(*) FROM {$wpdb->usermeta} WHERE meta_key = 'quiz_status$quiz_id' AND meta_value = $status"));
  return (empty($count)?0:$count);
}


function bp_course_member_userview($student,$course_id = null){

  if(empty($course_id)){
    $course_id = get_the_ID();
  }

  if (function_exists('bp_get_profile_field_data')) {
    $bp_name = bp_core_get_userlink( $student );
    $sfield=vibe_get_option('student_field');
    if(!isset($sfield) || $sfield =='')
      $sfield = 'Location';

    $bp_location ='';
    if(bp_is_active('xprofile'))
    $bp_location = bp_get_profile_field_data('field='.$sfield.'&user_id='.$student);
    
    if ($bp_name) {
      echo '<li>';
      echo get_avatar($student);
      echo '<h6>'. $bp_name . '</h6>';
      if ($bp_location) {
        echo '<span>'. $bp_location . '</span>';
      }

      echo '<div class="action">';
      $check_meta = vibe_get_option('members_activity');
      if(bp_is_active('friends') && $check_meta){
        if(function_exists('bp_add_friend_button')){
          bp_add_friend_button( $student );
        }
      }
      echo '</div></li>';
    }  
  }
}
/*
USER VIEW in COURSE ADMIN AREA
 */
function bp_course_admin_userview($student,$course_id = null){
    if (function_exists('bp_core_get_userlink')) {
        $bp_name = bp_core_get_userlink( $student );

        $bp_location='';
        if(empty($course_id)){
          $course_id = get_the_ID();
        }
        if(function_exists('vibe_get_option'))
            $ifield = vibe_get_option('student_field');

        if(!isset($field) || $field =='')$field='Location';

        if(bp_is_active('xprofile'))
            $bp_location = bp_get_profile_field_data('field='.$field.'&user_id='.$student);
        
        if ($bp_name) {
            echo '<li id="s'.$student.'"><input type="checkbox" class="member" value="'.$student.'"/>';
            echo get_avatar($student);
            echo '<h6>'. $bp_name . '</h6><span>';
            if ($bp_location) {
                echo $bp_location;
            }
            
            if(function_exists('bp_course_user_time_left')){
                echo ' ( '; bp_course_user_time_left(array('course'=>$course_id,'user'=>$student));
                echo ' ) ';
            }

            echo '</span>';
            do_action('wplms_user_course_admin_member',$student,$course_id);
            // PENDING AJAX SUBMISSIONS
            echo '<ul> 
                    <li><a class="tip reset_course_user" data-course="'.$course_id.'" data-user="'.$student.'" title="'.__('Reset Course for User','wplms').'"><i class="icon-reload"></i></a></li>
                    <li><a class="tip course_stats_user" data-course="'.$course_id.'" data-user="'.$student.'" title="'.__('See Course stats for User','wplms').'"><i class="icon-bars"></i></a></li>';
            if(class_exists('WPLMS_tips')){
                $tips = WPLMS_tips::init();
                if(!empty($permalinks) && empty($tips->settings['revert_permalinks'])){
                    $permalinks = Vibe_CustomTypes_Permalinks::init();      
                    if(empty($permalinks) || empty($permalinks->permalinks) || empty($permalinks->permalinks['activity_slug'])){
                        $activity_slug = '/activity';
                        $activity_slug = str_replace('/','',$activity_slug).'?';
                    }else{
                        $activity_slug = $permalinks->permalinks['activity_slug'];
                        $activity_slug = str_replace('/','',$activity_slug).'?';
                    }   
                }else{
                    $activity_slug = '?action='.BP_ACTIVITY_SLUG.'&';
                }
            }                           
            
            echo '<li><a href="'.get_permalink($course_id).$activity_slug.'student='.$student.'" class="tip" title="'.__('See User Activity in Course','wplms').'"><i class="icon-atom"></i></a></li>
                    <li><a class="tip remove_user_course" data-course="'.$course_id.'" data-user="'.$student.'" title="'.__('Remove User from this Course','wplms').'"><i class="icon-x"></i></a></li>
                    '.do_action('wplms_course_admin_members_functions',$student,$course_id).'
                  </ul>';
            echo '</li>';
        }
    }
}
  
function bp_course_reset_course_for_user($user_id,$course_id){
  //delete_user_meta($user_id,$course_id) // DELETE ONLY IF USER SUBSCRIPTION EXPIRED
    $status = bp_course_get_user_course_status($user_id,$course_id);
    
    if(isset($status) && is_numeric($status)){  // Necessary for continue course
      
      bp_course_update_user_course_status($user_id,$course_id,1); // New function
    
      $course_curriculum = bp_course_get_curriculum($course_id);
    
      bp_course_update_user_progress($user_id,$course_id,0);
    
      //NEw drip feed use case
      delete_user_meta($user_id,'start_course_'.$course_id);
      do_action('wplms_student_course_reset',$course_id,$user_id);

      foreach($course_curriculum as $c){
        if(is_numeric($c)){
          if(bp_course_get_post_type($c) == 'quiz'){
            do_action('before_wplms_quiz_course_retake_reset',$c,$user_id);      
            bp_course_remove_user_quiz_status($user_id,$c);
            bp_course_reset_quiz_retakes($c,$user_id);

            $questions = bp_course_get_quiz_questions($c,$user_id);
            if(isset($questions) && is_array($questions) && is_Array($questions['ques'])){
              foreach($questions['ques'] as $question){
                global $wpdb;
                if(isset($question) && $question !='' && is_numeric($question)){
                  bp_course_reset_question_marked_answer($c,$question,$user_id);
                }
              }
            }
            do_action('wplms_quiz_course_retake_reset',$c,$user_id);
          }else{
            bp_course_reset_unit($user_id,$c,$course_id);
          }
        }
      }
      
      /*=== Fix in 1.5 : Reset  Badges and CErtificates on Course Reset === */
      $user_badges = vibe_sanitize(get_user_meta($user_id,'badges',false));
      $user_certifications = vibe_sanitize(get_user_meta($user_id,'certificates',false));

      if(isset($user_badges) && is_Array($user_badges) && in_array($course_id,$user_badges)){
          $key=array_search($course_id,$user_badges);
          unset($user_badges[$key]);
          $user_badges = array_values($user_badges);
          update_user_meta($user_id,'badges',$user_badges);
      }

      if(isset($user_certifications) && is_Array($user_certifications) && in_array($course_id,$user_certifications)){
          $key=array_search($course_id,$user_certifications);
          unset($user_certifications[$key]);
          $user_certifications = array_values($user_certifications);

          global $wpdb;
          $certificate_name = 'certificate_'.$course_id.'_'.$user_id;
          $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_name = %s AND post_parent = %d AND post_author = %d",$certificate_name,$course_id,$user_id));
          if(is_numeric($attachment_id)){
            wp_delete_attachment($attachment_id);
          }
          
          update_user_meta($user_id,'certificates',$user_certifications);
      }
            /*==== End Fix ======*/
      do_action('wplms_course_reset',$course_id,$user_id);
    }
}

/* RECORD COMMISSIONS */
if(!function_exists('bp_course_record_instructor_commission')){
    function bp_course_record_instructor_commission($instructor_id,$commission,$course_id,$meta){

        $commission = apply_filters('bp_course_record_instructor_commission',$commission,$instructor_id,$course_id,$meta);

        $commission_html = $secondary_item_id= '';
        switch($meta['origin']){
            case 'woocommerce':
                if(function_exists('wc_update_order_item_meta')){
                    wc_update_order_item_meta( $meta['item_id'], '_commission'.$instructor_id,$commission);
                }else{
                    woocommerce_update_order_item_meta( $meta['item_id'], '_commission'.$instructor_id,$commission);
                }

                $commission_html = '';
                if(function_exists('wc_price')){
                    $price = round($commission,2);
                    if($meta['currency']){
                      $commission_html = wc_price($price,array(
                        'ex_tax_label'       => false,
                        'currency'           => $meta['currency'],
                        'decimal_separator'  => wc_get_price_decimal_separator(),
                        'thousand_separator' => wc_get_price_thousand_separator(),
                        'decimals'           => wc_get_price_decimals(),
                        'price_format'       => get_woocommerce_price_format(),
                      ));
                    }else{
                      $price = round($commission,2);
                      $commission_html = wc_price($price);
                    }
                }
                $secondary_item_id = $meta['item_id'];
            break;
            default:
                do_action('bp_course_record_instructor_commission_custom',$instructor_id,$commission,$meta,$course_id);
            break;
        }
        if(!empty($instructor_id) && !empty($commission_html) && !empty($course_id)){
            if($commission > 0){
                $activity_id = bp_course_record_activity(apply_filters('bp_course_record_instructor_commission_activity',array(
                    'user_id' => $instructor_id,
                    'action' => _x('You earned commission','Instructor earned commission activity','wplms'),
                    'content' => sprintf(_x('%s commission earned for course %s','Instructor earned commission activity','wplms'),$commission_html,get_the_title($course_id)),
                    'component' => 'course',
                    'type' => 'course_commission',
                    'item_id' => $course_id,
                    'secondary_item_id' => $secondary_item_id,
                    'hide_sitewide' => true,
                )));
                if(!empty($activity_id)){
                  bp_course_record_activity_meta(array('id'=>$activity_id,'meta_key'=>'_commission'.$instructor_id,'meta_value'=>$commission));
                  bp_course_record_activity_meta(array('id'=>$activity_id,'meta_key'=>'_currency'.$instructor_id,'meta_value'=>$meta['currency']));
                }
            }else{
                $activity_id = bp_course_record_activity(apply_filters('bp_course_record_instructor_commission_activity',array(
                    'user_id' => $instructor_id,
                    'action' => _x('Commission reversed.','Instructor earned commission activity','wplms'),
                    'content' => sprintf(_x('%s commission reversed for course %s  for order ID %d as order cancelled/refunded','Instructor earned commission activity','wplms'),$commission_html,get_the_title($course_id),$meta['order_id']),
                    'component' => 'course',
                    'type' => 'course_commission',
                    'item_id' => $course_id,
                    'secondary_item_id' => $secondary_item_id,
                    'hide_sitewide' => true,
                )));
                if(!empty($activity_id)){
                  bp_course_record_activity_meta(array('id'=>$activity_id,'meta_key'=>'_commission'.$instructor_id,'meta_value'=>$commission));
                  bp_course_record_activity_meta(array('id'=>$activity_id,'meta_key'=>'_currency'.$instructor_id,'meta_value'=>$meta['currency']));
                }
            }
        }
 
    } 
}


function bp_course_get_setting($setting,$from,$type=null){
    // Check Vibe options panel or LMS Setting
    if(class_exists('wplms_miscellaneous_settings')){
      
        $misc = wplms_miscellaneous_settings::init();
        
        if(!empty($misc) && !empty($misc->settings)){
            
            if(!isset($misc->settings[$from]))
              return false;
            
            $settings = $misc->settings[$from];
            if(isset($settings[$setting])){
                if(isset($type)){
                    switch($type){
                        case 'bool':
                            return true;
                        break;
                        default:
                          if(isset($settings[$setting])){
                            return $settings[$setting];
                          }                          
                        break;
                    }
                }else{
                    return $settings[$setting];    
                }
            }else{
                return false;
            }  
        }
    }
    return false;
}

/*
 FUNCTIONS FOR API
*/
function bp_course_get_course_announcements_for_user($user_id){
    if(function_exists('wplms_dashboards_get_user_annoncements')){
      return wplms_dashboards_get_user_annoncements($user_id);
    }
  return array();
}

function bp_course_get_total_quiz_count_for_user($user_id){
    global $wpdb;
    $count = $wpdb->get_var($wpdb->prepare("
      SELECT count(*) 
      FROM {$wpdb->posts} as p
      LEFT JOIN {$wpdb->postmeta} as m
      ON p.ID = m.post_id
      WHERE p.post_type = %s
      AND p.post_status = %s
      AND m.meta_key = %d
      ",'quiz','publish',$user_id));

    return $count;
}

function bp_course_api_get_user_badges($user_id){
    $badges = array();
    $course_badges = bp_course_get_user_badges($user_id);
    if(!empty($course_badges)){
        foreach($course_badges as $course_id){
            $badge_id = bp_get_course_badge($course_id);
            $badge=wplms_plugin_wp_get_attachment_info($badge_id); 
            $badge_url=wp_get_attachment_image_src($badge_id,'full');
            if(is_array($badge_url)){$badge_url=$badge_url[0];}
            $badges[] = array('key'=>$course_id,'type'=>'badge','label'=>get_post_meta($course_id,'vibe_course_badge_title',true),'value'=>$badge_url);
        }
    }
    return $badges;
}

function bp_course_api_get_user_certificates($user_id){
    
    $certificates = array();
    $course_certificates = bp_course_get_user_certificates($user_id);
    if(!empty($course_certificates)){
        foreach($course_certificates as $course_id){
            $url = bp_get_course_certificate(Array('course_id'=>$course_id,'user_id'=>$user_id));
            $certificates[] = array(
                'key' => $course_id,
                'type' => 'certificate',
                'label' =>  get_the_title($course_id),
                'value' => $url
                );
        }
    }
    return $certificates;
}

/*
* QUIZ RETAKES REVAMP
* 
*/

/**
 * Initiates Student Quiz retakes
 *
 * Takes quiz id and Student id/user id in Arguments array
 * and processes quiz retakes. Also runs hook for recording activity and other touch points
 *
 * @since 3.3
 *
 * @param array
 */

function bp_course_student_quiz_retake($args){
    $defaults = array(
      'quiz_id' => get_the_ID(),
      'user_id' => get_current_user_id()
      );
    $params = wp_parse_args( $args, $defaults );
    extract( $params, EXTR_SKIP );
    
    if ( !isset($user_id) || !$user_id){
        wp_die(__(' Incorrect User selected.','wplms'),__('Security Error','wplms'),array('back_link' => true));
    }

    bp_course_remove_user_quiz_status($user_id,$quiz_id);
    bp_course_remove_quiz_questions($quiz_id,$user_id);
    
    $retake_count = bp_course_fetch_user_quiz_retake_count($quiz_id,$user_id);
    if(empty($retake_count)){$retake_count=0;}
    
    bp_course_update_user_quiz_retake_count($quiz_id,$user_id,($retake_count+1));
    delete_instructor_quiz_remarks($quiz_id,$user_id);
    
    $course_id = get_post_meta($quiz_id,'vibe_quiz_course',true);
    if(!empty($course_id)){ // Course progressbar fix for single quiz
      
      $curriculum = bp_course_get_curriculum_units($course_id);
      $per = round((100/count($curriculum)),2);
      $progress = get_user_meta($user_id,'progress'.$course_id,true);
      if(empty($progress))
        $progress = 0;

      $new_progress = $progress - $per;
      if($new_progress < 0){
        $new_progress = 0;
      }
      update_user_meta($user_id,'progress'.$course_id,$new_progress);
    }
    do_action('wplms_quiz_retake',$quiz_id,$user_id);
}

/**
 * Initiates Student Quiz retakes
 *
 * Takes quiz id in Arguments array
 * and processes quiz retakes. Also runs hook for recording activity and other touch points
 *
 *
 * @param array
 */
if(!function_exists('student_quiz_retake')){
  function student_quiz_retake($args=NULL){
      $defaults = array(
        'quiz_id' => get_the_ID(),
        'user_id' => get_current_user_id()
        );
      $params = wp_parse_args( $args, $defaults );
      extract( $params, EXTR_SKIP );
      
      if ( !isset($user_id) || !$user_id){
          wp_die(__(' Incorrect User selected.','wplms'),__('Security Error','wplms'),array('back_link' => true));
      }

      bp_course_remove_user_quiz_status($user_id,$quiz_id);
      bp_course_remove_quiz_questions($quiz_id,$user_id);
      
      $course_id = get_post_meta($quiz_id,'vibe_quiz_course',true);
      if(!empty($course_id)){ // Course progressbar fix for single quiz
        
        $curriculum = bp_course_get_curriculum_units($course_id);
        if(!empty($curriculum)){
          $per = round((100/count($curriculum)),2);
        }else{
          $per = 0;
        }
        $progress = get_user_meta($user_id,'progress'.$course_id,true);
        if(empty($progress))
          $progress = 0;
 
        $new_progress = $progress - $per;
        if($new_progress < 0){
          $new_progress = 0;
        }
        update_user_meta($user_id,'progress'.$course_id,$new_progress);
      }
      $retake_count = bp_course_fetch_user_quiz_retake_count($quiz_id,$user_id);
      $retake_count = intval($retake_count);
      bp_course_update_user_quiz_retake_count($quiz_id,$user_id,($retake_count+1));
      do_action('wplms_quiz_retake',$quiz_id,$user_id);
  }
}

//Number of times the user has retaken the quiz
function bp_course_fetch_user_quiz_retake_count($quiz_id,$user_id){

  $retake_count = get_user_meta($user_id,'quiz_retakes_'.$quiz_id,true);
  
  $quiz_course_id = get_post_meta($quiz_id,'vibe_quiz_course',true);
  if(!empty($quiz_course_id)){
     $status = bp_course_get_user_course_status($user_id,$quiz_course_id);
     if($status > 2)
      return 0;
  }
  
    if(empty($retake_count) && $retake_count != 0 ){
      global $wpdb,$bp;
      $retake_count = $wpdb->get_var($wpdb->prepare( "
                SELECT count(activity.content) FROM {$bp->activity->table_name} AS activity
                WHERE   activity.component  = 'course'
                AND   activity.type   = 'retake_quiz'
                AND   user_id = %d
                AND   ( item_id = %d OR secondary_item_id = %d )
                ORDER BY date_recorded DESC
              " ,$user_id,$quiz_id,$quiz_id));
      
      $retake_count = intval($retake_count);
      bp_course_update_user_quiz_retake_count($quiz_id,$user_id,$retake_count);
    }
  
  return apply_filters('bp_course_fetch_user_quiz_retake_count',$retake_count,$quiz_id,$user_id);
}

//Number of times the user has retaken the quiz
function bp_course_update_user_quiz_retake_count($quiz_id,$user_id,$value){
  $flag = apply_filters('bp_allow_update_user_quiz_retake_count',1,$quiz_id,$user_id,$value);
  if($flag){
    update_user_meta($user_id,'quiz_retakes_'.$quiz_id,$value);
  }
}

//Number of times the user has retaken the quiz
function bp_course_reset_quiz_retakes($quiz_id,$user_id){
  update_user_meta($user_id,'quiz_retakes_'.$quiz_id,0);
}


function wplms_get_course_schema_details($course_id){
       
    $course = get_post($course_id);
    
    $pre_courses = get_post_meta($course_id,'vibe_pre_course',true);
    $pre_courses_schemas = array();$thumbnail = '';$desc = '';$title = get_the_title($course);$course_link = get_permalink($course_id);
    $show_aggregate_rating = 0;
    $rating_count = 0;$rating=0;

    $desc = get_the_excerpt($course);
    $desc = ((!empty($desc))?$desc:$title);
    if(!empty($pre_courses)){
        if(is_numeric($pre_courses)){
            $pre_courses_schemas[] = wplms_get_course_schema_details($pre_courses);
        }elseif(is_array($pre_courses)){
            foreach ($pre_courses as $key => $pre_course) {
                $pre_courses_schemas[] = wplms_get_course_schema_details($pre_course);
            }
        }
    }
    $thumbnail = wp_get_attachment_url( get_post_thumbnail_id($course_id,'full') );
    
    $rating_count = get_post_meta($course_id,'rating_count',true);
    if(!empty($rating_count)){
        $show_aggregate_rating = 1;
        $rating = get_post_meta($course_id,'average_rating',true);
        if(!empty($rating)){
            $show_aggregate_rating = 1;
        }else{
            $show_aggregate_rating = 0;
        }
    }
    $bloginfo = get_bloginfo();

    $course_data = array(
        "@context" => "https://schema.org",
        "@type" => "Course",
        "courseCode" => $course_id,
        "name"=> $title,
        "description"=>$desc
        );
    $certificate_set = get_post_meta($course_id,'vibe_course_certificate',true);
    if(!empty($certificate_set)){
        $course_data["educationalCredentialAwarded"] = array(
            "@context"=> "http://schema.org",
            "@type"=>"EducationalOccupationalCredential",
            "name" =>sprintf(_x('Certificate for %s','','wplms'),$title),
            "educationalLevel" => array(
                "@type"=> "DefinedTerm",
                "name"=> sprintf(_x('Certification in %s','','wplms'),$title),
                "inDefinedTermSet"=> $course_link
            )
                
            
        );
    }

    $course_comments =array();
    if(!empty($course->comment_count)){
        $course_comments=get_comments( array('status' => 'approve', 'number'=>5,'post_id'=>$course_id) );
    }

    if(!empty($course_comments)){
        foreach ($course_comments as  $course_comment) {
            $comment_rating = get_comment_meta($course_comment->comment_ID,'review_rating',true);
            if(!empty($comment_rating)){
                $course_data["review"][]= array (
                    "@type"=> "Review",
                    "reviewRating"=>array(
                        "@type"=> "Rating",
                        "ratingValue"=>$comment_rating,
                        "bestRating"=> "5"
                    ),
                   "author"=>array(
                        "@type"=> "Person",
                        "name"=>((!empty($course_comment->user_id)?bp_core_get_user_displayname($course_comment->user_id):((!empty($course_comment->comment_author))?$course_comment->comment_author:_x('Anonymous','','wplms'))))
                   )
                ); 
            }
            
        }
    }

    $course_author = $course->post_author;
    if(!empty($course_author) && function_exists('bp_core_get_user_displayname')){
        $course_author_name = bp_core_get_user_displayname($course_author);
        if(!empty($course_author_name)){
            $field = 'Speciality';
            if(function_exists('vibe_get_option'))
            $field = vibe_get_option('instructor_field');
            $field_value = (bp_is_active('xprofile')?bp_get_profile_field_data('field='.$field.'&user_id='.$course->post_author):'');
            $course_data["provider"]= array(
                    "@type"=> "Person",
                    "name"=> $course_author_name,
                    
                 );
            if(!empty($field_value)){
                $course_data["provider"]["knowsAbout"] =$field_value;
            }
            

        }
        
    }

    $product_id = get_post_meta($course_id,'vibe_product',true);
    $offers_array = array();
    if(function_exists('get_woocommerce_currency')){
        $product_link = get_permalink($product_id);
        if(!empty($product_id)){
            if(function_exists('wc_get_product')){
                $product_object = wc_get_product($product_id);
                $currency = get_woocommerce_currency();

                if(is_object($product_object) && $product_object->is_type( 'variable' )){
                    $variations = $product_object->get_available_variations();
                    if(!empty($variations)){
                        $i = 0;
                        
                        foreach ($variations as $key => $variation) {
                            $price = 0;
                            $variable_is_wplms = get_post_meta($variation['variation_id'],'variable_is_wplms',true);
                            if(!empty($variable_is_wplms) && $variable_is_wplms == 'on'){
                                $sale = get_post_meta( $variation['variation_id'], '_sale_price', true);
                                
                                if(!empty($sale)){
                                    $price = $sale;
                                }else{
                                    $regular = get_post_meta( $variation['variation_id'], '_regular_price', true);
                                    if(!empty($regular)){
                                        $price = $regular;
                                    }
                                }
                                
                                if(!empty($price)){
                                    $offers_array[$i] = array(
                                        "@type"=> "Offer",
                                        "url"=> $product_link,
                                        "priceCurrency"=>$currency,
                                        "price"=> $price,
                                        

                                        );
                                    if(!empty($variation['is_in_stock'])){
                                        $offers_array[$i]["availability"]= "https://schema.org/InStock";
                                    }
                                    if(!empty($bloginfo) && !empty($bloginfo['name'])){
                                        $offers_array[$i]["seller"]= array(
                                            "@type"=> "Organization",
                                            "name"=> $bloginfo['name']
                                        );
                                    }
                                    $i++;
                                }

                            }

                        }
                        
                    }
                    
                    

                }else{
                    $i = 0;
                    $price = 0;
                    $sale = get_post_meta( $product_id, '_sale_price', true);
                    if(!empty($sale)){
                        $price = $sale;
                    }else{
                        $regular = get_post_meta( $product_id, '_regular_price', true);
                        if(!empty($regular)){
                            $price = $regular;
                        }
                    }
                    if(!empty($price)){
                        $offers_array[$i] = array(
                            "@type"=> "Offer",
                            "url"=> $product_link,
                            "priceCurrency"=>$currency,
                            "price"=> $price,
                            

                            );
                        if(!empty($product_object) && is_object($product_object) && $product_object->get_stock_quantity() > 0 ){
                            $offers_array[$i]["availability"]= "https://schema.org/InStock";
                        }
                        if(!empty($bloginfo) && !empty($bloginfo['name'])){
                            $offers_array[$i]["seller"]= array(
                                "@type"=> "Organization",
                                "name"=> $bloginfo['name']
                            );
                        }
                    }
                }
            }else{
                $i = 0;
                $price = 0;
                $sale = get_post_meta( $product_id, '_sale_price', true);
                if(!empty($sale)){
                    $price = $sale;
                }else{
                    $regular = get_post_meta( $product_id, '_regular_price', true);
                    if(!empty($regular)){
                        $price = $regular;
                    }
                }
                if(!empty($price)){
                    $offers_array[$i] = array(
                        "@type"=> "Offer",
                        "url"=> $product_link,
                        "priceCurrency"=>$currency,
                        "price"=> $price,
                        

                        );
                    if(!empty($product_object) && is_object($product_object) && $product_object->get_stock_quantity() > 0 ){
                        $offers_array[$i]["availability"]= "https://schema.org/InStock";
                    }
                    if(!empty($bloginfo) && !empty($bloginfo['name'])){
                        $offers_array[$i]["seller"]= array(
                            "@type"=> "Organization",
                            "name"=> $bloginfo['name']
                        );
                    }
                }
            }
        }
    }

    if(!empty($offers_array)){
        $course_data["offers"]=$offers_array;
    }
    if(!empty($thumbnail)){
        $course_data["image"] = array($thumbnail);
    }
    if(!empty($pre_courses_schemas)){
        $course_data["coursePrerequisites"] = $pre_courses_schemas;
    }
    if($show_aggregate_rating){
        $course_data["aggregateRating"]=array(
            "@type"=> "AggregateRating",
            "ratingValue"=> $rating,
            "reviewCount"=> $rating_count,
         );
    }

    
    return apply_filters('wplms_get_course_schema_details',$course_data,$course_id);
}

function vibecryptoJsAesDecrypt($passphrase, $jsonString){
    $jsondata = json_decode($jsonString, true);
    try {
        $salt = hex2bin($jsondata["s"]);
        $iv  = hex2bin($jsondata["iv"]);
    } catch(Exception $e) { return null; }
    $ct = base64_decode($jsondata["ct"]);
    $concatedPassphrase = $passphrase.$salt;
    $md5 = array();
    $md5[0] = md5($concatedPassphrase, true);
    $result = $md5[0];
    for ($i = 1; $i < 3; $i++) {
        $md5[$i] = md5($md5[$i - 1].$concatedPassphrase, true);
        $result .= $md5[$i];
    }
    $key = substr($result, 0, 32);
    $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
    return json_decode($data, true);
}

function vibecryptoJsAesEncrypt($passphrase, $value){
    $salt = openssl_random_pseudo_bytes(8);
    $salted = '';
    $dx = '';
    while (strlen($salted) < 48) {
        $dx = md5($dx.$passphrase.$salt, true);
        $salted .= $dx;
    }
    $key = substr($salted, 0, 32);
    $iv  = substr($salted, 32,16);
    $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
    $data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));
    return json_encode($data);
}

function wplms_get_question_ids_from_question_tags($alltags){
    $ques_ids = [];
    if(is_array($alltags) && !empty($alltags) && isset($alltags['tags']) && isset($alltags['numbers'])){
        foreach($alltags['tags'] as $key=>$tags){
            if(!is_array($tags)){
                $tags = unserialize($tags);
            }
            $number = $alltags['numbers'][$key];
            if(isset($alltags['marks'][$key]))
                $marks = $alltags['marks'][$key];

            if(empty($number)){
                $number = 0;
            }
            $args = apply_filters('bp_course_dynamic_quiz_tag_questions',array(
                'post_type' => 'question',
                'orderby' => 'rand', 
                'posts_per_page' => $number,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'question-tag',
                        'field' => 'id',
                        'terms' => $tags,
                        'operator' => 'IN'
                    ),
                )
            ),$alltags);

            if($number){
                $the_query = new WP_Query( $args );
                if($the_query->have_posts()){
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();

                        $ques_ids[]=get_the_ID();
                    }
                }
                wp_reset_postdata();
            }
        }

    }
    return $ques_ids;
}