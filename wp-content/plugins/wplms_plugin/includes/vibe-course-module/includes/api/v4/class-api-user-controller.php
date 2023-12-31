<?php
defined( 'ABSPATH' ) or die();

use Elementor\Plugin;

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

if ( ! class_exists( 'BP_Course_New_Rest_User_Controller' ) ) {
	
	class BP_Course_New_Rest_User_Controller extends BP_Course_New_Rest_Controller {

		
		/**
		 * Register the routes for the objects of the controller.
		 *
		 * @since 3.0.0
		 */
		public function register_routes() {



			//$this->token = '2tz745fwp6d7z1d50euboegms7pgvglbnn5biilw';
			

			$this->type = 'user';
			register_rest_route( $this->namespace, '/'. $this->type .'/', array(
				array(
					'methods'                   =>  "POST",
					'callback'                  =>  array( $this, 'get_user' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/profile/', array(
				array(
					'methods'                   =>  "POST",
					'callback'                  =>  array( $this, 'get_user_profile' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/profile/(?P<tab>\w+)?(&P<per_page>\d+)?(&P<paged>\d+)', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'get_user_profile_tab' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_string( $param );
												}
					),
				),

			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/coursestatus/(?P<course>\d+)?', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'get_course_status' ),
				'permission_callback' => array( $this, 'get_user_course_status_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );
			register_rest_route( $this->namespace, '/'. $this->type .'/coursestatus/(?P<course>\d+)/item/(?P<id>\d+)?', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'get_course_status_item' ),
				'permission_callback' => array( $this, 'get_user_course_status_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );
			register_rest_route( $this->namespace, '/'. $this->type .'/getyoutubeurl/', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'getyoutubeurl' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),

			) );
			register_rest_route( $this->namespace, '/'. $this->type .'/deletemedia/', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'deletemediaupload' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),

			) );


			register_rest_route( $this->namespace, '/'. $this->type .'/coursestatus/(?P<course>\d+)/checkcomplete?', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'check_course_status_complete' ),
				'permission_callback' => array( $this, 'get_user_course_status_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'course'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );
			

			register_rest_route( $this->namespace, '/'. $this->type .'/coursestatus/(?P<course>\d+)/item/(?P<id>\d+)?/markcomplete', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'get_course_status_item_complete' ),
				'permission_callback' => array( $this, 'get_user_course_status_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/coursestatus/(?P<course>\d+)/gamification?', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'get_course_status_gamification' ),
				'permission_callback' => array( $this, 'get_user_course_status_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/coursestatus/(?P<course>\d+)/item/(?P<id>\d+)?/assignbadges', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'assign_badges' ),
				'permission_callback' => array( $this, 'get_user_course_status_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );
			
			register_rest_route( $this->namespace, '/'. $this->type .'/check_course_member/(?P<course>\d+)', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'check_course_member' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				

			) );
			register_rest_route( $this->namespace, '/'. $this->type .'/check_code/(?P<course>\d+)', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'check_code' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				

			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/quiz/(?P<id>\d+)?', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'get_single_quiz_data' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );
			
			register_rest_route( $this->namespace, '/'. $this->type .'/quiz/previousresults/(?P<id>\d+)?', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'get_quiz_previousresults' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );
			register_rest_route( $this->namespace, '/'. $this->type .'/quiz/previousresult/(?P<id>\d+)?', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'get_quiz_previous_result' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );


			register_rest_route( $this->namespace, '/'. $this->type .'/coursestatus/(?P<course>\d+)/retake_quiz/(?P<id>\d+)?', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'init_retake_quiz' ),
				'permission_callback' => array( $this, 'get_user_course_status_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );


			register_rest_route( $this->namespace, '/'. $this->type .'/question/flag/(?P<id>\d+)?', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'flag_question' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );

			
			register_rest_route( $this->namespace, '/'. $this->type .'/coursestatus/retake_single_quiz/(?P<id>\d+)?', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'init_single_retake_quiz' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/retake_course/(?P<id>\d+)?', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'init_course_retake' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/course/pmprochecklevel/(?P<course>\d+)/level/(?P<level>\d+)', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'pmpro_check_level' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );


			register_rest_route( $this->namespace, '/'. $this->type .'/course/mycredcheckpoints/(?P<course>\d+)/points/(?P<points>\d+)', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'mycred_check_points' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );
			register_rest_route( $this->namespace, '/'. $this->type .'/finishcourse', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'finish_course' ),
				'permission_callback' => array( $this, 'get_user_course_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/updatecourse/progress', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'update_course_progress' ),
				'permission_callback' => array( $this, 'get_user_course_permissions_check' ),
			) );

			
			register_rest_route( $this->namespace,'/'. $this->type .'/getreview/(?P<course>\d+)', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'get_review' ),
				'permission_callback' => array( $this, 'get_user_course_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/updatecourse/addreview', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'add_review' ),
				'permission_callback' => array( $this, 'get_user_course_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/activity/add', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'add_activity' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/submitresult', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'add_user_result' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/saveuserquestion', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'save_user_question' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/savequiz', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'save_user_quiz' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));
			
			register_rest_route( $this->namespace,  '/'. $this->type .'/signin/', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'signin_user' ),
				'permission_callback' 		=> array( $this, 'get_verify_permissions_check' ),
			) );

			register_rest_route( $this->namespace,  '/'. $this->type .'/logout/', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'logout_user' ),
				'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
			) );

			register_rest_route( $this->namespace,  '/'. $this->type .'/register/', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'register_user' ),
				'permission_callback' 		=> array( $this, 'get_verify_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/verify/', array(
				array(
					'methods'                   =>  "POST",
					'callback'                  =>  array( $this, 'verfify_user' ),
				),
			));

			register_rest_route( $this->namespace,  '/'. $this->type .'/activity/', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'add_activity' ),
				'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
			) );

			register_rest_route( $this->namespace,  '/'. $this->type .'/subscribe/', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'add_to_course' ),
				'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
			) );
			register_rest_route( $this->namespace,  '/'. $this->type .'/subscribepartial/', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'add_to_course_partial' ),
				'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
			) );

			register_rest_route( $this->namespace,  '/'. $this->type .'/course/renew/', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'renew_course' ),
				'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
			) );
			/* Quiz Functions */
			register_rest_route( $this->namespace,  '/'. $this->type .'/quiz/start', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'start_quiz' ),
				'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
			) );

			register_rest_route( $this->namespace,  '/'. $this->type .'/quiz/submit', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'submit_quiz' ),
				'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/profile/image/', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'submit_quiz' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/profile/fields', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'set_field' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/chart/course', array(
				array(
					'methods'                   =>  "POST",
					'callback'                  =>  array( $this, 'get_course_chart' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/chart/quiz', array(
				array(
					'methods'                   =>  "POST",
					'callback'                  =>  array( $this, 'get_quiz_chart' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));

			/*
			In App Purchases
			 */
			register_rest_route( $this->namespace, '/'. $this->type .'/wallet', array(
				array(
					'methods'                   =>  "POST",
					'callback'                  =>  array( $this, 'get_user_wallet' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));
			register_rest_route( $this->namespace, '/'. $this->type .'/wallet/transactions', array(
				array(
					'methods'                   =>  "POST",
					'callback'                  =>  array( $this, 'get_transactions' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));
			register_rest_route( $this->namespace, '/'. $this->type .'/wallet/update', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'update_wallet' ),
					'permission_callback' 		=> array( $this, 'get_user_permissions_check' ),
				),
			));
		
			register_rest_route( $this->namespace, '/'. $this->type .'/unitcomments/(?P<unit>\d+)/', array(
				'methods'                   =>  "POST",
				'callback'                  =>  array( $this, 'get_unit_comments' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),

			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/unitcomments/(?P<unit>\d+)/(?P<type>(new|edit|reply|trash))/(?P<commentID>\d+)/', array(
				'methods'                   =>   'POST',
				'callback'                  =>  array( $this, 'add_edit_new_unit_comments' ),
				 'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/unitcomments/delete/(?P<commentID>\d+)/', array(
				'methods'                   =>   'POST',
				'callback'                  =>  array( $this, 'remove_unit_comment' ),
				 'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'commentID'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/upload/assignmentId/(?P<assignment_id>\d+)', array(
				'methods'                   =>   'POST',
				'callback'                  =>  array( $this, 'uploadAssignments' ),
				 'permission_callback' => array( $this, 'get_user_post_permissions_check' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );

		register_rest_route( $this->namespace, '/'. $this->type .'/content/assignmentId/(?P<assignment_id>\d+)', array(
				'methods'                   =>   'POST',
				'callback'                  =>  array( $this, 'contentAssignment' ),
				 'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );	
		register_rest_route( $this->namespace, '/'. $this->type .'/start/assignmentId/(?P<assignment_id>\d+)', array(
				'methods'                   =>   'POST',
				'callback'                  =>  array( $this, 'startAssignment' ),
				 'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );	
		register_rest_route( $this->namespace, '/'. $this->type .'/result/assignmentId/(?P<assignment_id>\d+)', array(
				'methods'                   =>   'POST',
				'callback'                  =>  array( $this, 'AssignmentResult' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );
		register_rest_route( $this->namespace, '/'. $this->type .'/alluser', array(
				'methods'                   =>   'POST',
				'callback'                  =>  array( $this, 'search_users_in_chat' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/firebase/attachment', array(
				'methods'                   =>   'POST',
				'callback'                  =>  array( $this, 'upload_chat_attachment' ),
				'permission_callback' => array( $this, 'get_user_permissions_check' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );


			register_rest_route( $this->namespace, '/'. $this->type .'/getallmembers', array(
				'methods'                   =>   'POST',
				'callback'                  =>  array( $this, 'members_directory' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/getmemberbyid', array(
				'methods'                   =>   'POST',
				'callback'                  =>  array( $this, 'get_member_profile_details' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/forums', array(
				'methods'                   =>   'POST',
				'callback'                  =>  array( $this, 'get_forums' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );

			register_rest_route( $this->namespace, '/'. $this->type .'/topics', array(
				'methods'                   =>   'POST',
				'callback'                  =>  array( $this, 'get_topics' ),
				'args'                     	=>  array(
					'id'                       	=>  array(
						'validate_callback'     =>  function( $param, $request, $key ) {
													return is_numeric( $param );
												}
					),
				),
			) );

									


			register_rest_route( $this->namespace, '/'. $this->type .'/getmycredpoints', array(
				array(
					'methods'                   =>  'GET',
					'callback'                  =>  array( $this, 'getmycredpoints' ),
					'permission_callback' => array( $this, 'get_user_permissions_check' ),
				),
			));	

			// for push notification update update user_meta : wplms_push_id
			register_rest_route( $this->namespace, '/'. $this->type .'/add-registrationId', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'set_registrationId_push_notification' ),
					'permission_callback' => array( $this, 'get_user_permissions_check' ),
				),
			));	
			register_rest_route( $this->namespace, '/'. $this->type .'/delete-registrationId', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'delete_registrationId_push_notification' ),
					'permission_callback' => array( $this, 'get_user_permissions_check' ),
				),
			));	

			register_rest_route( $this->namespace, '/'. $this->type .'/fetch_media', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'fetch_media' ),
					'permission_callback' => array( $this, 'get_user_permissions_check' )
				),
			));
			register_rest_route( $this->namespace, '/'. $this->type .'/upload_media', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'upload_media' ),
					'permission_callback' => array( $this, 'get_user_permissions_check' ),
				),
			));				
	
	    }

	    public function getmycredpoints($request){
	    	if(!function_exists('mycred') ){
	    		$data=array(
	    			'status'=>0,
	    			'points'=>0,
	    			'message'=>_x('MyCred Not Available','api','wplms')
	    		);
	    	}else{
	    		$mycred = mycred();
	    		$types =  mycred_get_types();
	    		$points_by_type = array();
	    		foreach ($types as $key => $value) {
	    			$points_by_type[$key] = array(
	    				'name' => $value,
	    				'points' => $mycred->get_users_balance( $this->user_id, $key )
	    			);	
	    		}
				$balance = $mycred->get_users_cred( $this->user_id );
				$data=array(
					'status'=>1,
					'points'=>$balance,
					'message'=>_x('MyCred Available','api','wplms'),
					'points_by_type' => $points_by_type
				);
	    	}
	    	return new WP_REST_Response( $data, 200 );
	    }


		public function get_user_permissions_check($request){

			$body = json_decode($request->get_body(),true);
        
	        if (empty($body['token'])){
	            $client_id = $request->get_param('client_id');
	            if($client_id == vibebp_get_setting('client_id')){
	                return true;
	            }
	        }else{
	            $token = $body['token'];
	        }

	        if(!empty($body['token'])){
	            
	            $this->user = apply_filters('vibebp_api_get_user_from_token','',$body['token']);
	            if(!empty($this->user)){
	            	$this->user_id = $this->user->id;
	                return true;
	            }
	        }

			//$headers = $request->get_headers();
			$headers = vibe_getallheaders();
			if(isset($headers['Authorization'])){
				$token = $headers['Authorization'];
				$this->user_id = $this->get_user_from_token($token);
				if($this->user_id){
					return true;
				}
			}
			return false;
		}


		public function get_user_post_permissions_check($request){

			$body = json_decode(stripslashes($_POST['body']),true);
			
	        if (empty($body['token'])){
	            $client_id = $request->get_param('client_id');
	            if($client_id == vibebp_get_setting('client_id')){
	                return true;
	            }
	        }else{
	            $token = $body['token'];
	        }

	        if(!empty($body['token'])){
	            
	            $this->user = apply_filters('vibebp_api_get_user_from_token','',$body['token']);
	            if(!empty($this->user)){
	            	$this->user_id = $this->user->id;
	                return true;
	            }
	        }

			//$headers = $request->get_headers();
			$headers = vibe_getallheaders();
			if(isset($headers['Authorization'])){
				$token = $headers['Authorization'];
				$this->user_id = $this->get_user_from_token($token);
				if($this->user_id){
					return true;
				}
			}
			return false;
		}

		public function get_user($request){

			$token = $this->token;

			//$user = $this->get_user_from_token($token);
			
			/**
			 * Filter the response.
			 *
			 * @since 3.0.0
			 *
			 * @param array $element_data
			 * @param WP_REST_Request $request
			 */
			
			if(isset($request['full'])){
				$user_data = apply_filters( 'bp_course_api_get_user',$this->fetch_user($this->user_id), $request );
			}else{
				$user_data = apply_filters( 'bp_course_api_get_user', $this->fetch_user($this->user_id), $request );
			}
			

			return new WP_REST_Response( $user_data, 200 );
		}


		function get_user_from_token($token){


	        if(!empty($token)){
	            
	            $this->user = apply_filters('vibebp_api_get_user_from_token','',$token);
	            if(!empty($this->user)){
	            	$this->user_id = $this->user->id;
	                return $this->user_id;
	            }
	        }

			global $wpdb;
			$user_id = $wpdb->get_var(apply_filters('wplms_usermeta_direct_query',"SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = '$token'"));

			if(is_numeric($user_id)){
				$this->user_id = $user_id;
				return $user_id;
			}

			return false;
			
		}


		function fetch_user($user_id){
			$user = array();
			$field = 'Location';
			if(function_exists('vibe_get_option')){$field = vibe_get_option('student_about');}
		
			$sub = bp_get_profile_field_data('field='.$field.'&user_id='.$user_id);

			$u = get_userdata($user_id);
			$user['id']	  = $user_id;
			$user['name'] = bp_core_get_user_displayname($user_id);
			$user['sub']  = ($sub?$sub:'');
			$user['email']= $u->user_email;
			$user['avatar'] = bp_core_fetch_avatar(array(
								'item_id' => $user_id,
								'object'  => 'user',
								'html'	  => false
							));

			return $user;
		}

		function get_user_profile($request){


			$tab = $request['tab'];	
			if(empty($tab)){
				$user = $this->get_user_profile_details();
			}else{
				$user = $this->get_user_profile_tab_value($tab,$request);	
			}
			
			
			/**
			 * Filter the response.
			 *
			 * @since 3.0.0
			 *
			 * @param array $element_data
			 * @param WP_REST_Request $request
			 */
			$user_data = apply_filters( 'bp_course_api_get_user_profile_tab', $user, $request );
			
			
			
			if(empty($user_data)){$user_data=array();}
			if($tab == 'courses'){
				global $items_template;
				$user_data=array('data'=>$user_data,'total'=>$items_template->query->found_posts);
			}
			
			return new WP_REST_Response( $user_data, 200 );
		}
		
		function deletemediaupload($request){
			$args = json_decode($request->get_body(),true);
	    	$data = array('status'=>false);
	    	if(!empty($args['media']) ){
	    		wp_delete_file( $args['media']['file'] );$data = array('status'=>true,'media'=>$args['media']);
	    	}
	    	return new WP_REST_Response( $data, 200 );
		}

	    function getyoutubeurl($request){
	    	$args = json_decode($request->get_body(),true);
	    	$data = array('status'=>false);
	    	if(!empty($args['url']) && class_exists('VibeYouTubeDownloader')){
	    		$handler = new VibeYouTubeDownloader();
	    		$downloader = $handler->getDownloader($args['url']);	
	    		$downloader->setUrl($args['url']);
	    		if($downloader->hasVideo()){
	    			$details = $downloader->getVideoDownloadLink();
	    			if(!empty($details)){
	    				if(!empty($details[count($details)-1]['url'])){
	    					$upload_dir_base = wp_upload_dir();
	    					
	    					$fileName =vibe_url_to_string($details[count($details)-1]['title']);
	    					$folderpath = $upload_dir_base['basedir']."/".VIBEYOUTUBE_VIDEO_FOLDER_NAME."/".$this->user_id."/".$fileName;
	    					$post_data= [];
	    					$post_data['upload_date'] = date( 'Y/m', time() );
	    					$extension = vibe_get_ext_from_mime($details[count($details)-1]['mime']);
							$upload = vibe_fetch_remote_file( $details[count($details)-1]['url'], $post_data ,$fileName.'.mp4');
							
	    					if (  !empty( $upload ) && !is_wp_error( $upload ) ) {
		                        $data = array('status'=>true,'link'=>$upload);
		                    }
	    				}

	    				
	    			}
	    		}
	    	}
	    	return new WP_REST_Response( $data, 200 );
	    }

		function get_user_profile_details(){
			global $wpdb;
			$user_id = $this->user_id;
			if(is_numeric($user_id)){
				$data = apply_filters('bp_course_api_get_user_profile_data',array(
							array(
								'key'=>'announcements',
								'label'=>_x('Announcements','api','wplms'),
								'type' => 'objects',
								'value'=>bp_course_get_course_announcements_for_user($user_id),
							),
							array(
								'key'=>'courses',
								'label'=>_x('Courses','api','wplms'),
								'type' => 'number',
								'value'=>bp_course_get_total_course_count_for_user($user_id),
							),
							array(
								'key'=>'quizzes',
								'label'=>_x('Quizzes','api','wplms'),
								'type' => 'number',
								'value'=>bp_course_get_total_quiz_count_for_user($user_id),
							),
							array(
								'key'=>'badges',
								'type' => 'objects',
								'label'=>_x('Badges','api','wplms'),
								'value'=>  bp_course_api_get_user_badges($user_id),
							),
							array(
								'key'=>'certificates',
								'type' => 'objects',
								'label'=>_x('Certificates','api','wplms'),
								'value'=>  bp_course_api_get_user_certificates($user_id),
							),
						)
					);
				$tabs = apply_filters('bp_course_api_get_user_profile_tabs',array(
						array(
							'key'=>'dashboard',
							'type'=> 'tab',
							'label'=>_x('Dashboard','api','wplms'),
							'value'=>'md-analytics',
						),
						array(
							'key'=>'profile',
							'type'=> 'tab',
							'label'=>_x('Profile','api','wplms'),
							'value'=>'md-contact',
						),
						array(
							'key'=>'courses',
							'type'=> 'tab',
							'label'=>_x('My Courses','api','wplms'),
							'value'=>'md-book',
						),
						array(
							'key'=>'results',
							'type'=> 'tab',
							'label'=>_x('Results','api','wplms'),
							'value'=>'md-bookmarks',
						),
						/*array(
							'key'=>'gradebook',
							'type'=> 'tab',
							'label'=>_x('Gradebook','api','wplms'),
							'value'=>'md-checkmark-circle-outline',
						),
						array(
							'key'=>'notifications',
							'type'=> 'tab',
							'label'=>_x('Notifications','api','wplms'),
							'value'=>'md-alert',
						),*/
						array(
							'key'=>'activity',
							'type'=> 'tab',
							'label'=>_x('Activity','api','wplms'),
							'value'=>'md-alarm',
						),
						array(
							'key'=>'settings',
							'type'=> 'tab',
							'label'=>_x('Settings','api','wplms'),
							'value'=>'md-settings',
						),
				));
			

				return array('data'=>$data,'tabs'=>$tabs);
			}
			return false;
		}


		function get_user_profile_tab_value($tab,$request){
			global $wpdb;
			$data = array();
			$user_id = $this->user->id;
			
			$args = json_decode($request->get_body(),true);
			$per_view = $args['per_view'];
			$paged = $args['paged'];
			if(is_numeric($user_id)){

				$data = apply_filters('bp_course_api_get_user_profile_tab_'.$tab,array(),$user_id,$per_view,$paged);
				
				if(empty($data)){
					
					switch($tab){
						case 'profile':
							$data = $this->generate_profile_data($user_id);
						break;
						case 'courses':
							$data = $this->get_my_courses($user_id,$args);
						break;
						case 'results':
							$data = $this->get_my_results($user_id,$per_view,$paged);
						break;
						case 'result':
							$data = $this->get_my_result($user_id,$request['result'],$request['activity_id']);
						break;
						case 'gradebook':
							$data = $this->get_my_grades($user_id,$per_view,$paged);
						break;
						case 'notifications':
							$data = $this->get_my_notifications($user_id,$per_view,$paged);
						break;
						case 'activity':
							$data = $this->get_my_activity($user_id,$per_view,$paged);
						break;
						case 'settings':
							$data = $this->get_my_settings($user_id);
						break;
					}	
				}
				
				$data = apply_filters('bp_course_api_get_user_profile_tab_'.$tab.'_after',$data,$user_id,$per_view,$paged);	
			}

			return $data;
		}

		function wdw_bp_get_field_options( $field_id ){
			global $bp, $wpdb;
			return $wpdb->get_col( $wpdb->prepare( "SELECT name FROM {$bp->profile->table_name_fields} WHERE parent_id=%d AND type='option'", $field_id ) );
		}

		function generate_profile_data($user_id){
			$data = array();

			if(function_exists('bp_xprofile_get_groups')){
				$groups = bp_xprofile_get_groups( array(
					'fetch_fields' => true
				) );

				if(!empty($groups)){
					foreach($groups as $group){
						$field_group = array();
						$field_group['id'] = $group->id;
						$field_group['name'] = $group->name;
						$field_group['description'] = $group->description;
						if ( !empty( $group->fields ) ) {

							foreach($group->fields as $field){
								if($field->type == 'url'){
									$field_value = bp_get_profile_field_data(array('field'=>$field->id,'user_id'=>$user_id));
									$field_value =	wp_extract_urls($field_value);
									if(empty($field_value)){
										$field_value = '';
									}else{
										$field_value = $field_value[0];
									}
								}else{
									$field_value = bp_get_profile_field_data(array('field'=>$field->id,'user_id'=>$user_id));
								}
								$f = array(
									'id' => $field->id,
									'type' => $field->type,
									'name' => $field->name,
									'value' => $field_value,
								);
								$options_fields = apply_filters('wplms_options_fields_api',array('checkbox','selectbox','multiselectbox','radio'));
								if(!empty($field->type) && in_array($field->type,$options_fields)){
									$options = $this->wdw_bp_get_field_options($field->id);
									if(!empty($options)){
										$f['options']=$options;
									}
								}
								if($field->field_order){
									$field_group['fields'][$field->field_order] = $f;
								}else{
									$field_group['fields'][] = $f;
								}
							}
						}
						if($group->group_order){
							$data[$group->group_order] = $field_group;
						}else{
							$data[] = $field_group;	
						}
						
					}
				}
			}
			
			return $data;
		}

		function get_my_courses($user_id,$args){
			// Prepare the element data
			$posts_data = array();
			$courses = bp_course_get_user_courses($user_id);
			$defaults = array(
				'post_type'  	=> 'course',
				'post_status'	=> 'publish',
				'orderby' 		=> 'alphabetical',
				'order'			=> 'ASC',
				'per_page'		=>	12,
				'paged'			=>	1,
				'post__in'  	=> $courses
			);


			$args = wp_parse_args($args,$defaults);
			if ( bp_course_has_items( $args ) ):
				while ( bp_course_has_items() ) : bp_course_the_item();
					global $post;
					$course = $post;
					$posts[]= array(
						'id'                    => $course->ID,
						'name'                  => $course->post_title,
						'date_created'          => strtotime( $course->post_date_gmt ),
						'user_progress'         => $this->get_user_progress($course,$user_id),
						'user_status'           => $this->get_user_status($course,$user_id),
						'user_expiry'           => bp_course_get_user_expiry_time($user_id,$course->ID),
						'start_date'            => $this->get_course_start_date($course,$user_id),
						'featured_image'		=> $this->get_course_featured_image($course),	
						'instructor'            => $this->get_course_instructor($course->post_author),	
						'menu_order'            => $course->menu_order,	
					);
				endwhile;	
			endif;
			
			/**
			 * Filter the response.
			 *
			 * @since 3.0.0
			 *
			 * @param array $element_data
			 * @param WP_REST_Request $request
			 */
			$posts_data = apply_filters( 'bp_course_api_get_courses', $posts, $request );

			return $posts_data;
		}
	

		function get_course_start_date($course,$user_id){
			$start_date = bp_course_get_start_date($course->ID,$user_id);
			return strtotime($start_date);
		}

		function get_user_progress($course,$user_id){
			if(is_numeric($course)){$course_id = $course;}else{$course_id = $course->ID;}
			$p = bp_course_get_user_progress($user_id,$course_id);
			return empty($p)?0:$p;
		}

		function get_user_status($course,$user_id){
			if(is_numeric($course)){$course_id = $course;}else{$course_id = $course->ID;}
			return bp_course_get_user_course_status($user_id,$course_id);
		}

		function get_course_featured_image($course){

			if(!is_numeric($course)){
				$course = $course->ID;
			}

			$post_thumbnail_id = get_post_thumbnail_id( $course );
			if(!empty($post_thumbnail_id)){
				$image = wp_get_attachment_image_src($post_thumbnail_id,'medium');
				$image = $image[0];
			}

			if(empty($image)){
	            $image = vibe_get_option('default_course_avatar');
	            if(empty($image)){
	                //$image = VIBE_URL.'/assets/images/avatar.jpg';
	            }
	        }

	        return $image;
		}

		function get_course_instructor($instructor_id){
			$field = 'Speciality';
			if(function_exists('vibe_get_option'))
			$field = vibe_get_option('instructor_field');

			return array(
				'id'     => $instructor_id, 
				'name'   => bp_core_get_user_displayname($instructor_id),
				'avatar' => bp_course_get_instructor_avatar_url($instructor_id),
				'sub'    => (bp_is_active('xprofile')?bp_get_profile_field_data('field='.$field.'&user_id='.$instructor_id):''),
			);
		}


		function get_my_results($user_id,$per_view,$paged){
			$data = array();

			global $wpdb,$bp;
			if(function_exists('bp_is_active') && bp_is_active('activity')){
			    $activity_ids = $wpdb->get_results($wpdb->prepare( "
					SELECT a.secondary_item_id,MAX(a.id) AS id
					FROM {$bp->activity->table_name} AS a
					LEFT JOIN {$bp->activity->table_name_meta}  AS am
					ON a.id = am.activity_id
					WHERE a.type = 'quiz_evaluated'
					AND a.user_id = %d
					AND am.meta_value IS NOT NULL
					GROUP BY a.secondary_item_id
					ORDER BY a.date_recorded DESC
					LIMIT %d,%d
				" ,$user_id,(($paged-1)*$per_view),$per_view));
		
			    if(!empty($activity_ids)){
			    	foreach($activity_ids as $activity_id){
			    		$questions = bp_course_get_quiz_questions($activity_id->secondary_item_id,$user_id);
			    		$data[] = array(
			    			'activity_id' =>$activity_id->id,
			    			'quiz'=> $activity_id->secondary_item_id,
			    			'title'=> get_the_title($activity_id->secondary_item_id),
			    			'marks'=> intval(get_post_meta($activity_id->secondary_item_id,$user_id,true)),
			    			'max' => array_sum($questions['marks'])
		    			);	
			    	}
			    }
			}
			return $data;
		}

		function get_my_result($user_id,$quiz_id,$activity_id){
			$data = array();
			$qdata=bp_course_get_quiz_results_meta($quiz_id,$user_id,$activity_id );
			$qdata = unserialize($qdata);
			if(is_array($qdata)){
				foreach($qdata as $key=>$value){
					if(is_numeric($key)){
						$data[] = array(
							'id'=>"answer",
							'value'=>$value
						);
					}
					
				}	
			}
				
			return $data;
		}

		function get_my_grades($user_id,$per_view,$paged){
			$data = array();
			$courses = bp_course_get_user_courses($user_id,4);

			if(!empty($courses)){
				foreach($courses as $course_id){
					$data[] = array(
						'id'                    => $course_id,
						'name'                  => get_the_title($course_id),
						'featured_image'		=> $this->get_course_featured_image($course_id),
						'score'					=> get_post_meta($course_id,$user_id,true),	
						'retakes'				=> bp_course_get_course_retakes($course_id,$user_id),
						'finish_access'			=> (vibe_get_option('finished_course_access')?vibe_get_option('finished_course_access'):0),
					);
				}
			}

			return $data;
		}


		function get_my_notifications($user_id,$per_view,$paged){
			$data = array();
			if(bp_has_notifications(array('user_id'=>$user_id,'page'=>$paged,'per_page'=>$per_view))){
				while ( bp_the_notifications() ) {
					bp_the_notification();	
					$data[] = array(
						'component'=>bp_get_the_notification_component_name(),
						'time'	=> strtotime(bp_get_the_notification_date_notified()),
						'action' => bp_get_the_notification_component_action(),
						'content'=> wp_strip_all_tags(bp_get_the_notification_description())
					);
				} 
			}

			return $data;
		}

		function get_my_activity($user_id,$per_view,$paged){
			$data = array();
			if ( bp_has_activities(array('user_id'=>$user_id,'page'=>$paged,'per_page'=>$per_view)) ){
				while ( bp_activities() ) {
					bp_the_activity();	
					$data[] = array(
						'date'	=> strtotime(bp_get_activity_feed_item_date()),
						'content'=> wp_strip_all_tags(bp_get_activity_content_body())
					);
				} 
			}

			return $data;
		}

		/**
		 * My Settings for User
		 *
		 * @since 3.0.0
		 */
		function get_my_settings($user_id){
			$data = array();
		}


		/**
		 * COURSE STATUS for User
		 *
		 * @since 3.0.0
		 */
		function get_user_course_status_permissions_check($request){

			$body = json_decode($request->get_body(),true);
        

	        if(!empty($body['token']) && is_numeric($request['course'])){
	            
	            $this->user = apply_filters('vibebp_api_get_user_from_token','',$body['token']);
	            if(!empty($this->user)){
	            	$this->user_id = $this->user->id;
	            	$course_id = $request['course'];
	                if(function_exists('bp_course_is_member') && bp_course_is_member($course_id,$this->user->id))
						return true;
	            }
	        }

			return false;
		}

		function check_course_status_complete($request){

			$user_id = $this->user->id;
			$course_id = $request['course'];
			$flag = 1;
			global $wpdb;
		  	$user_retakes = $wpdb->get_var($wpdb->prepare("SELECT sum(meta_value) from {$wpdb->usermeta} where user_id = %d AND meta_key in ( SELECT CONCAT('quiz_retakes_',post_id) from {$wpdb->postmeta} where meta_key=%s and meta_value=%d)",$user_id ,'vibe_quiz_course',$course_id));
		  	if(empty($user_retakes)){
		    	$user_retakes = 0;
		  	}
		  	$quiz_retakes = $wpdb->get_var($wpdb->prepare("SELECT sum(meta_value) from {$wpdb->postmeta} where meta_key=%s AND post_id IN (select post_id from {$wpdb->postmeta} WHERE meta_key=%s AND meta_value=%d)",'vibe_quiz_retakes','vibe_quiz_course',$course_id));
		  	if(empty( $quiz_retakes)){
		     	$quiz_retakes = 0;
		  	}
		  	$remaining =  $quiz_retakes - $user_retakes;
		  	if(!empty($quiz_retakes) && $remaining >= 0 ){
		  		$flag = 0;
		  	}
		  	$curriculum = bp_course_get_curriculum($course_id);
		  	$last_id = 0;
		  	if(!empty($curriculum) && count($curriculum) > 1){
		  		for($i=(count($curriculum)-1);$i>=0;$i--){
			  		if(!empty($curriculum[$i]) && is_numeric($curriculum[$i])){
			  			$last_id = $curriculum[$i];
			  			break;
			  		}
			  	}
			  	if(!empty($last_id)){
			  		$complete_time = bp_course_get_user_unit_completion_time($user_id,$last_id,$course_id);
			  		if(empty($complete_time)){
			  			$flag = 0;
			  		}
			  		
			  	}
		  	}
		  	
		  	return new WP_REST_Response( array('status'=>$flag), 200 );

		}

		/**
		 * COURSE STATUS for User
		 *
		 * @since 3.0.0
		 */
		function get_course_status($request){

			$user_id = $this->user->id;
			$course_id = $request['course'];	

			$course_status = bp_course_get_user_course_status($user_id,$course_id);
			do_action('wplms_before_course_status_hit',$course_id,$user_id);
			if($course_status == 1){
				do_action('wplms_start_course',$course_id,$user_id);
				bp_course_update_user_course_status($user_id,$course_id,($course_status+1));
			}
			$assignment_locking = 0;
			if(function_exists('vibe_get_option')){
				if(!empty(vibe_get_option('assignment_locking'))){
					$assignment_locking= 1;
				}
			}

			
			$unit_media_lock = 0;
			if(function_exists('vibe_get_option')){
				if(!empty(vibe_get_option('unit_media_lock'))){
					$unit_media_lock= 1;
				}
			}

			$assignment_locking = apply_filters('wplms_assignment_lock',$assignment_locking,$course_id,$user_id);
			$finish_course_auto_trigger = 0;
			if(class_exists('WPLMS_tips')){
				$tips = WPLMS_tips::init();
			    if(isset($tips) && isset($tips->settings)){
			          $finish_course_auto_trigger = empty($tips->settings['finish_course_auto_trigger'])?'':$tips->settings['finish_course_auto_trigger'];
			    }
			}
			$comments_open = apply_filters('wplms_course_comments_open',comments_open($course_id),$course_id,$user_id);
			//check  before_course_status
			$stop_course_status = apply_filters('wplms_before_course_status_api',false,$course_id,$user_id);

			if($stop_course_status){
				$return = $stop_course_status;
				$data = apply_filters( 'bp_course_api_get_user_course_status',$return, $request );
				return new WP_REST_Response( $data, 200 );
			}

			$curriculum = bp_course_get_curriculum($course_id,$this->user->id); 
			if(empty($curriculum)){
			 	$package = get_post_meta($course_id,'vibe_course_package',true);
				if(!empty($package)){

		            if(!empty($package)){
		                if(!empty($package['package_type'])){
		                    $pack =  do_shortcode('[iframe package_type="'.$package['package_type'].'" no_script="1"]'.$package['path'].'[/iframe]');
		                }else{
		                    $pack = do_shortcode('[iframe]'.$package['path'].'[/iframe]');
		                }
		            }
					$return = array('status'=>1,'package' => $pack,'package_type' =>$package['package_type'],'package_details' => $package);
				}else{
					return new WP_REST_Response( array('status'=>0,'message'=>__('Missing Course structure','wplms')), 200 );
				}
			 }else{

				$curriculum_arr = array();
				$first_unit_id = '';

				$section_duration = 0;
				$unit_id = wplms_plugin_get_course_unfinished_unit($course_id,$user_id );

				$curr_unit_key = 0;
				$i = 0;
				$first_curriculum_item_key = -1;
			
				foreach($curriculum as $key => $item){
					
					if(is_numeric($item)){
						$item = intval($item);
						if($unit_id==$item){
							$curr_unit_key = $i;
						}
						if($first_curriculum_item_key <0 )
							$first_curriculum_item_key = $i;
						if(bp_course_get_post_type($item) == 'unit'){
							if(empty($first_unit_id)){$first_unit_id = $item;}

							$d = bp_course_get_unit_duration($item);
							$section_duration += $d;

							$complete = 1;
							
							$assignment_ids=get_post_meta($item,'vibe_assignment',true);
							if(!empty($assignment_ids) && !empty($assignment_locking)){
								if(intval($assignment_locking)>1){
									foreach ($assignment_ids as  $assignment) {
										$meta = get_post_meta($assignment,$user_id,true);
										$assignment_start_time = get_user_meta($user_id,$assignment_id,true);
										if(empty($assignment_start_time)){
											$complete = 0;
											break;
										}
										if($meta=''){
											$complete = 0;
											break;
										}
										if(!empty($assignment_start_time) && intval($meta)==0){
											$args = array(
									            'status' => 'approve',
									            'user_id' => $user_id, // use user_id
									            'count' => true ,//return only the count
									            'post_id' =>$assignment,
									        );
									        $comments = get_comments($args);
									        if(empty($comments)){
									        	$complete = 0;
												break;
									        }
										}
										
									}
								}elseif($assignment_locking == 1){
									foreach ($assignment_ids as  $assignment) {
										$meta = get_post_meta($assignment,$user_id,true);
										if(empty($meta)){
											$complete = 0;
											break;
										}
									}
								}

								if($complete){
									$data = $this->mark_unit_complete($item,$user_id,$course_id);
									//progress ye to be updated
								}
							}else{
								if(bp_course_check_unit_complete($item,$user_id,$course_id)){
									$complete = 1;
								}else{
									$complete = 0;
								}
							}
							$unit_type = wplms_get_element_type($item,'unit');
							$curriculum_arr[] = apply_filters('bp_course_api_course_curriculum_unit',array(
								'key'		=> $i,
								'id'		=> $item,
								'type'		=> 'unit', 
								'title'		=> get_the_title($item),
								'duration'	=> $d,
								'unit_type' => $unit_type,
								'content'   => '',
								'status'    => $complete,
								'icon'		=> wplms_get_element_icon($unit_type),
								'meta'		=> array()
							));
						}else if(bp_course_get_post_type($item) == 'quiz'){
							$d = bp_course_get_quiz_duration($item);
							$section_duration += $d;

							$complete = 0;
							if(bp_course_check_unit_complete($item,$user_id,$course_id)){
								$stop_progress = apply_filters('bp_course_stop_course_progress',true,$course_id);
						      	$next_unit = null;
						      	$flag = apply_filters('wplms_next_unit_access',true,$item,$user_id);
						      	if(is_numeric($course_id) && $stop_progress && $flag){
						      		$complete = 1;
						      	}
								
							}
							$quiz_data = array(
								'key'		=> $i,
								'id'		=> $item,
								'type'		=> 'quiz',
								'title'		=> get_the_title($item),
								'duration'	=> $d,
								'icon'		=>wplms_get_element_icon(wplms_get_element_type($item,'quiz')),
								'content'   => '',
								'status'    => $complete,
								'meta'		=> array(),
							);
							$quiz_type = wplms_get_element_type($item,'quiz');
							if($quiz_type=='scorm'){
								$quiz_data['quiz_type'] = $quiz_type;
								$package = get_post_meta($item,'vibe_upload_package',true);
								if(!empty($package)){
									$pack =  do_shortcode('[iframe package_type="'.$package['package_type'].'" no_script="1"]'.$package['path'].'[/iframe]');
									$quiz_data['content_id'] = $pack ;
								}
								
							}
							$curriculum_arr[] = apply_filters('bp_course_api_course_curriculum_quiz',$quiz_data);
							
						}else if(bp_course_get_post_type($item) == 'wplms-assignment'){
							$data = $this->get_assignment_data($item);
							$apost = get_post($item);
							$curriculum_arr[] = apply_filters('bp_course_api_course_curriculum_assignment',array(
								'key'		=> $i,
								'id'		=> $item,
								'type'		=> 'wplms-assignment',
								'title'		=> get_the_title($item),
								'duration'	=> $data['duration'],
								'content'   => '',
								'icon'		=>wplms_get_element_icon(wplms_get_element_type($item,'wplms-assignment')),
								'status'    => $data['assignment_status'],
								'meta'		=> $data,
							));
						}

					}else{
						$curriculum_arr[] = apply_filters('bp_course_api_course_curriculum_section',array(
							'key'		=> $i,
							'id'		=> 0,
							'type'		=> 'section',
							'title'		=> $item,
							'duration'	=> $section_duration,
							'content'   => '',
							'meta'		=> array()
						));
						$section_duration = 0;
					}
					$i++;
				}
				
				
				if(empty($unit_id)){
					$unit_id = $first_unit_id;
					$curr_unit_key = $first_curriculum_item_key;
				}
				
				/*$current_key = 0;
				foreach($curriculum_arr as $key => $item){
					if($item['id'] == $unit_id){
						$current_key = $key;
						//Fetch the API
						//$content = get_post_field('post_content',$unit_id);
						//$content = apply_filters('the_content',$content);
						//
						//$curriculum_arr[$key]['content'] = $content;
						//$curriculum_arr[$key]['meta'] = array('access'=>1);
					}
				}*/
				$version =  bp_course_get_setting( 'app_version', 'api','number' ); 
				//Get content
				if(!empty($version) && $version > 2){
					$return = array('current_unit_key'=>$curr_unit_key,'status'=> $this->get_user_status($course_id,$user_id),'courseitems'=>$curriculum_arr) ;
				}else{
					$return = array('current_unit_key'=>$curr_unit_key,'courseitems'=>$curriculum_arr) ;
				}
				$lock = get_post_meta($course_id,'vibe_course_prev_unit_quiz_lock',true);
				$return['lock'] = ((!empty($lock) && $lock == 'S')?1:0);
			}
			// check package here for scorm or packages: 
			// $package = get_post_meta($course_id,'vibe_course_package',true);
			// if(!empty($package)){
			// 	$return['package']  = $package;
			// }
			
			/**
			 * Filter the response.
			 *
			 * @since 3.0.0
			 *
			 * @param array $element_data
			 * @param WP_REST_Request $request
			 */

			if(!empty($finish_course_auto_trigger)){
				$return['auto_finish'] = $finish_course_auto_trigger;
			}
			if(!empty($unit_media_lock)){
				$return['unit_media_lock'] = $unit_media_lock;
			}
			
			if(!empty($comments_open)){
				$return['comments_open'] = $comments_open;
			}
			if(!empty($assignment_locking)){
				$return['assignment_locking'] = $assignment_locking;
			}
			$return['disablescrollprogress'] = apply_filters('wplms_disable_scroll_progress',false,$course_id,$user_id,$return,$request);

			$return['course_status'] = $course_status;
			$instructions = get_post_meta($course_id,'vibe_course_instructions',true);
			if(!empty($instructions) && !empty(strip_tags($instructions))){
				$instructions = apply_filters('the_content',$instructions);
				$return['instructions'] = $instructions;
			}

			$is_gamification_active = get_post_meta($course_id,'vibe_gamification',true);
			if( $is_gamification_active == 'S'){
				$return['gamification'] =  get_post_meta($course_id,'gamification',true);
			}

			$data = apply_filters( 'bp_course_api_get_user_course_status',$return, $request );
			do_action('wplms_after_course_status_hit',$course_id,$user_id);
			return new WP_REST_Response( $data, 200 );
		}
		/**
		 * COURSE STATUS for User
		 *
		 * @since 3.0.0
		 */
		function get_course_status_item($request,$bypassed=false){
			$user_id =0;
			if(!empty($this->user_id)){
				$user_id = $this->user_id;
			}
			if(!$bypassed && empty($user_id)){
				return new WP_REST_Response( array('status'=>false,'message'=>__('User not found!','wplms')), 200 );
			}
			$course_id = 0;
			if($bypassed){ //Course creation view
				$item_id = $bypassed['item_id'];
			}else{

				
				$course_id = $request['course'];	
				$item_id = $request['id'];	

				if(!bp_course_is_member($course_id,$user_id))
					return new WP_REST_Response( array('status'=>false,'message'=>__('User not enrolled in course!','wplms')), 200 );

				$course_status=bp_course_get_user_course_status($user_id,$course_id);
				
				
				$version =  bp_course_get_setting( 'app_version', 'api','number' );
			}
			$item = apply_filters('get_course_status_item',get_post($item_id),$request,$user_id);

			$GLOBALS['post'] = $item;
			
			$return = array('title'=>$item->post_title,'instructor_id'=>$item->post_author);
			$meta=array('access'=>0);

			
			

			$is_new_editor = get_post_meta($item_id,'raw',true);
			if(!empty($is_new_editor)){
				remove_filter( 'the_content', 'wpautop' );
			}
			if($item->post_type == 'unit'){
				$return['duration'] = bp_course_get_unit_duration($item_id);
				
				$fetch_item = true;
				if(!$bypassed){
					$drip_check = bp_course_get_drip_status($course_id,$user_id,$item_id);
					if($drip_check['status']){
						$return['content'] = $drip_check['message'];
						$meta['access'] = 0; // do not cache in app
						if(isset($drip_check['time'])){
							$meta['drip_time'] = $drip_check['time'];
						}
						$fetch_item = false;
					}
				}
				

				if($fetch_item){

					$meta['comments'] = (comments_open($item_id)?get_comments_number($item_id):-1);
					$unit_type =  wplms_get_element_type($item_id,'unit');

					$tabs=get_wplms_create_course_tabs();
					$unit_types= array();
					foreach($tabs['course_curriculum']['fields'][0]['curriculum_elements'][1]['types'] as $type){
						$unit_types[]=$type['id'];
					}
					$unit_types[] = 'text';
					if(in_array($unit_type,$unit_types)){

						switch($unit_type){
							case 'video':
								$meta['video']=get_post_meta($item_id,'vibe_post_video',true);
								if(!empty($video)){$meta['video']=$video;}
    							if(!empty($iframes)){$meta['iframes']=$iframes;}
							break;
							case 'audio':
								$meta['audio']=get_post_meta($item_id,'vibe_post_audio',true);
							break;
							case 'upload':
								$meta['iframes']=array();
								
								$package = get_post_meta($item_id,'vibe_upload_package',true);
							
								if(!empty($package)){
					                if(!empty($package['package_type'])){
					                	if($package['package_type']=='1.1'){
					                		$meta['scorm_type'] = true;
					                	}
					                    $pack =  do_shortcode('[iframe package_type="'.$package['package_type'].'" no_script="1"]'.$package['path'].'[/iframe]');
					                }else{
					                    $pack = do_shortcode('[iframe]'.$package['path'].'[/iframe]');
					                }
					            }
								$item->post_content = $pack;
							break;
							case 'multimedia':
								$multimedia=get_post_meta($item_id,'vibe_post_multimedia',true);
							break;
							case 'text':
							case 'general':
								if(class_exists('WPBMap')){
									
									WPBMap::addAllMappedShortcodes();
								}

								$item->post_content = apply_filters('the_content',$item->post_content);
								$item->post_content = do_shortcode($item->post_content);
								
								$vccss = get_post_meta($item_id, '_wpb_shortcodes_custom_css', true);
								if(!empty($vccss)) 
								{
								    $vccss = strip_tags($vccss);
								    $item->post_content.='<style type="text/css" data-type="vc_shortcodes-custom-css">';
								    $item->post_content.=$vccss;
								    $item->post_content.='</style>';
								}
								if(function_exists('vc_asset_url')){  
									$front_css_file = vc_asset_url( 'css/js_composer.min.css' );
									$upload_dir = wp_upload_dir();
									$vc_upload_dir = vc_upload_dir();
									if ( '1' === vc_settings()->get( 'use_custom' ) && is_file( $upload_dir['basedir'] . '/' . $vc_upload_dir . '/js_composer_front_custom.css' ) ) {
										$front_css_file = $upload_dir['baseurl'] . '/' . $vc_upload_dir . '/js_composer_front_custom.css';
										$front_css_file = vc_str_remove_protocol( $front_css_file );
									}
									$item->post_content .= '<link rel="stylesheet" id="js_composer_front-css"  href="'.$front_css_file.'" type="text/css" media="all"/>';
									$item->post_content .= '<link rel="stylesheet" id="js_composer_front-css"  href="'.vc_asset_url( 'css/js_composer_tta.min.css' ).'" type="text/css" media="all"/>';
									$return['scripts']=apply_filters('wplms_api_wp_bakery_unit_scripts',array(
											array('key'=>'wpb_composer_front_js','src'=>vc_asset_url( 'js/dist/js_composer_front.min.js' )),
											array('key'=>'wpb_composer_accordion_js','src'=>vc_asset_url( 'lib/vc_accordion/vc-accordion.min.js' )),
											array('key'=>'wpb_composer_tabs_js','src'=>vc_asset_url( 'lib/vc_tabs/vc-tabs.min.js' )),
											array('key'=>'wpb_composer_tta_autoplay_js','src'=>vc_asset_url( 'lib/vc-tta-autoplay/vc-tta-autoplay.min.js' )),
									),$item);

								}
								

							break;
							case 'elementor':
								if(class_exists('\Elementor\Plugin')){

									$item->post_content =  \Elementor\Plugin::$instance->frontend->get_builder_content($item_id, true );

									$return['scripts']=apply_filters('wplms_api_elementor_unit_scripts',array(
										
										array('key'=>'elementor-common-modules-js','src'=>plugins_url().'/elementor/assets/js/common-modules.min.js'),
										array('key'=>'elementor-common-js','src'=>plugins_url().'/elementor/assets/js/common.min.js'),
										
										
										
										array('key'=>'elementor-app-loader-js','src'=>plugins_url().'/elementor/assets/js/app-loader.min.js'),
										
										
										
									),$item);

								}else{
									$item->post_content = apply_filters('the_content',$item->post_content);
								}
								
							break;
							default:
								$item->post_content = apply_filters('the_content',$item->post_content,$this->user->id,$item_id,$course_id);
								$item->post_content = apply_filters('wplms_unit_the_content',$item->post_content,$this->user->id,$item_id,$course_id);
								
							break;
						}
					}
					$practice_ques = get_post_meta($item_id,'vibe_practice_questions',true);

					if(!empty($practice_ques) && !empty($practice_ques['type']) && is_array($practice_ques['value'])){

						if($practice_ques['type']=='tags'){
							
							$meta['pratice_questions'] = wplms_get_question_ids_from_question_tags($practice_ques['value']);
						}elseif($practice_ques['type']=='questions'){
							$meta['pratice_questions'] = $practice_ques['value'];
						}
					}else{

						//old practice ques
						$meta['pratice_questions'] = $practice_ques;
						

					}
					//Legacy code for Old Units

					if((($unit_type=='video' && empty($meta['video'])) || $unit_type == 'play' || $unit_type == 'music-file-1') && ( false !== strpos( $item->post_content, '[' ))){

						$supported_audio_formats = apply_filters('bp_course_api_supported_status_item_file_formats',array('mp3','m4a','ogg','wav'));
	                	
	                	preg_match_all( '/' . get_shortcode_regex(array('video','audio')) . '/', $item->post_content, $matches, PREG_SET_ORDER );

        				$video = array();$audio = array();$iframes =array();
        				$meta['iframes'] = array();
        				if ( !empty( $matches ) ){
        					
        					foreach ( $matches as $shortcode ) {
		                        if ( in_array($shortcode[2],array('audio','video'))) {
		                        	$paths = explode('"', $shortcode[3]);
		                        	if(is_array($paths)){
		                        		foreach($paths as $path){
		                        			if(!empty($path)){
		                        				if(strpos($path, ".mp4")){
			                        				$video[] = $path;
			                        			}
		                        				$audio_ext = '';
		                        				if(strpos($path, ".") !== false){
		                        					$audio_ext = explode(".",$path);
		                        					$audio_ext = end($audio_ext);
		                        				}
		                        				
		                        				
			                        			if(!empty($audio_ext) && in_array($audio_ext,$supported_audio_formats)){
			                        				$audio[] = $path;
			                        			}
		                        			}
		                        		}
		                        	}
		                        }
        					}	
        					
	    					$item->post_content  = str_replace('[/video]', '', $item->post_content );
	    					$item->post_content  = str_replace('[/audio]', '', $item->post_content );
							
							if(!empty($audio)){$meta['audio']=$audio;}
    					}
    				

    					//for iframes
    					if(false !== strpos($item->post_content,'iframe')){

	    					preg_match_all( '/' . get_shortcode_regex(array('iframe')) . '/', $item->post_content, $matches2, PREG_SET_ORDER );
	    					if ( !empty( $matches2 ) ){

	        					foreach ( $matches2 as $shortcode ) {
	        						if(!empty($shortcode[5])){
	        							if(!empty($version) && $version > 2){
	        								$iframes[] = array('shortcode'=>'iframe','value'=>$shortcode[5]);
	        							}else{
	        								$iframes[] = $shortcode[5];
	        							}
	        					 	}
	        					}	
	    					}
    					}
    					
    					//to avoid use unit type text
    					if(false !== strpos($item->post_content,'embed')){

	    					preg_match_all( '/' . get_shortcode_regex(array('embed')) . '/', $item->post_content, $matches2, PREG_SET_ORDER );
	    					if ( !empty( $matches2 ) ){

	        					foreach ( $matches2 as $shortcode ) {
	        						if(!empty($shortcode[5])){

	        							if(empty($meta['video'])){
	        								$meta['video'] = array('type'=>wplms_videoType($shortcode[5]),'url'=>$shortcode[5]);
	        							}
	        					 	}
	        					}	
	    					}
    					}

    					//for iframevideo
    					preg_match_all( "/\[iframevideo\](.*)\[\/iframevideo\]/", $item->post_content, $matches3 ,PREG_SET_ORDER);
    					if ( !empty( $matches3 ) ){
        					
        					foreach ( $matches3 as $shortcode2 ) {
        						preg_match('/src="([^"]+)"/', $shortcode2[1], $matchiframeurl);
        						if(!empty($matchiframeurl)){
        							if(!empty($version) && $version > 2){
        								$iframes[] = array('shortcode'=>'iframevideo','value'=>$matchiframeurl[1]);
        							}else{
        								$iframes[] = $matchiframeurl[1];
        							}
        						}
								
		                       
        					}	
    					}

    					//for wplms vimeo
    					if(false !== strpos($item->post_content,'wplms_vimeo')){
	    					preg_match_all( '/' . get_shortcode_regex(array('wplms_vimeo')) . '/', $item->post_content, $matches4, PREG_SET_ORDER );
	    					if ( !empty( $matches4 ) ){
	        					foreach ( $matches4 as $shortcode3 ) {
	        						preg_match('/[0-9]*[0-9]/',$shortcode3[3],$file_numeric);
	        						if(!empty($file_numeric[0])){
	        							if(!empty($version) && $version > 2){
	        								$iframes[] = array('shortcode'=>'wplms_vimeo','value'=>'https://player.vimeo.com/video/'.$file_numeric[0]);
	        							}else{
	        								$iframes[] = 'https://player.vimeo.com/video/'.$file_numeric[0];
	        							}
	        						}
	        					}	
	    					}
    					}

    					//for wplms s3
    					if(false !== strpos($item->post_content,'wplms_s3')){
    						
	    					preg_match_all( '/' . get_shortcode_regex(array('wplms_s3')) . '/', $item->post_content, $matches5, PREG_SET_ORDER );
	    					if ( !empty( $matches5 ) ){
	        					foreach ( $matches5 as $shortcode4 ) {
	        						preg_match('/link=[\'|"](.*?)[\'|"]/',$shortcode4[3],$link_s3);

	        						preg_match('/duration=[\'|"](.*?)[\'|"]/',$shortcode4[3],$duration);

	        						preg_match('/parameter=[\'|"](.*?)[\'|"]/',$shortcode4[3],$parameter);

	        						if(!empty($link_s3[1])){
	        							if(class_exists('Wplms_S3_Init')){
	        								$s3 =Wplms_S3_Init::init();
	        								$file_mime = $s3->getMimeType($link_s3[1]);
	        								$video_mimes = apply_filters('api_allowed_video_mime_types',array(
	        									'video/mp4','video/ogg','video/webm','video/flv',
	        									));
	        								$audio_mimes = apply_filters('api_allowed_audio_mime_types',array(
	        									'audio/mp4','audio/mp3','audio/mp4a-latm', 'audio/m4a', 'audio/mp4','audio/mpeg','audio/x-mpeg', 'audio/mp3', 'audio/x-mp3', 'audio/mpeg3','audio/x-mpeg3','audio/mpg','audio/x-mpg','audio/x-mpegaudio','audio/mp4a-latm', 'audio/m4a','audio/mp4'
	        									));
	        								if(in_array($file_mime,$video_mimes)){
	        									$duration =floatval($duration[1] );$parameter= floatval($parameter[1]);
	        									if(method_exists($s3, 'get_s3_url')){
	        										$url = $s3->get_s3_url($link_s3[1],$duration*$parameter);
	        									}else{
	        										if(class_exists('WPLMS_Amazon_S3')){
	        											$amazon_s3 = WPLMS_Amazon_S3::get_instance();
	        											if(method_exists($amazon_s3, 'get_s3_url')){
	        												$url = $amazon_s3->get_s3_url($link_s3[1],$duration*$parameter);
	        											}
	        										}
	        									}
	        									
		        								if(!empty($url)){
		        									if(empty($video)){
		        										$video = array($url);
		        									}else{
		        										$video[] = $url;
		        									}
		        								}
	        								}
	        								if(in_array($file_mime,$audio_mimes)){
	        									$duration =floatval($duration[1] );$parameter= floatval($parameter[1]);
	        									if(method_exists($s3, 'get_s3_url')){
	        										$url = $s3->get_s3_url($link_s3[1],$duration*$parameter);
	        									}else{
	        										if(class_exists('WPLMS_Amazon_S3')){
	        											$amazon_s3 = WPLMS_Amazon_S3::get_instance();
	        											if(method_exists($amazon_s3, 'get_s3_url')){
	        												$url = $amazon_s3->get_s3_url($link_s3[1],$duration*$parameter);
	        											}
	        										}
	        									}
		        								if(!empty($url)){
		        									if(empty($meta['audio'])){
		        										$meta['audio'] = array($url);
		        									}else{
		        										$meta['audio'][] = $url;
		        									}
		        								}
	        								}
	        								
	        							}
	        						}
	        					}	
	    					}
    					}
    					
    					//for h5p
    					if(false !== strpos($item->post_content,'wplms_h5p')){
							preg_match_all( '/' . get_shortcode_regex(array('wplms_h5p')) . '/', $item->post_content, $matches6, PREG_SET_ORDER );
	    					if ( !empty( $matches6 ) ){
	        					foreach ( $matches6 as $shortcode4 ) {
	        						preg_match('/id=[\'|"](.*?)[\'|"]/',$shortcode4[3],$id);

	        						if(!empty($id[1])){
	        							$url = admin_url('admin-ajax.php?action=h5p_embed&id=' .$id[1]) ;
	        							if(!empty($url)){
        									if(empty($iframes)){
        										if(!empty($version) && $version > 2){
			        								$iframes = array(array('shortcode'=>'wplms_h5p','value'=>$url));
			        							}else{
			        								$iframes = array($url);
			        							}
        										
        									}else{
        										if(!empty($version) && $version > 2){
			        								$iframes[] = array('shortcode'=>'wplms_h5p','value'=>$url);
			        							}else{
			        								$iframes[] = $url;
			        							}
        										
        									}
        								}
	        						}
	        					}	
	    					}
						}

    					if(!empty($video)){$meta['video']=$video;}
    					if(!empty($iframes)){$meta['iframes']=$iframes;}
    					$regex = get_shortcode_regex(array('audio','video','embed','iframevideo','iframe','wplms_s3','wplms_vimeo','wplms_h5p'));
        				$item->post_content = preg_replace("/$regex/s", " ", $item->post_content);
    					$item->post_content = preg_replace ( '/\[[video|audio](.*?)\]/s' , '' , $item->post_content );

						$return['content'] = apply_filters('the_content',$item->post_content);
						$meta['access'] = 1; // do not cache in app
						

					}else{
						$return['content'] = apply_filters('the_content',$item->post_content);
						$meta['access'] = 1; // do not cache in app
					}

					
					if(!empty($course_status) && $course_status < 3 ){
						/*$done_flag=bp_course_get_user_unit_completion_time($user_id,$item_id,$course_id);
						if(empty($done_flag)){

							$args = array(
								'action' => __('Student finished unit ','wplms'),
							    'content' => sprintf(__('Student %s finished the unit %s in course %s','wplms'),bp_core_get_userlink($user_id),get_the_title($item_id),get_the_title($course_id)),
							    'type' => 'unit_complete',
							    'user_id' => $user_id,
							    'primary_link' => get_permalink($item_id),
							    'item_id' => $course_id,
							    'secondary_item_id' => $item_id
							);
							bp_course_record_activity($args);
							bp_course_update_user_unit_completion_time($user_id,$item_id,$course_id,time());
						}
						
						$progress = bp_course_get_user_progress($user_id,$course_id);
						$course_curriculum=bp_course_get_curriculum_units($course_id);
						$progress = intval($progress) + round((100/(count($course_curriculum))),2);
						if($progress > 100){$progress = 100;}
						bp_course_update_user_progress($user_id,$course_id,$progress);
						$meta['progress']=$progress;*/
					}
					$return['meta'] = apply_filters('wplms_api_unit_meta',$meta);
				}//End Legacy unit code
				if(empty($course_id)){$course_id=0;}
				$return['meta'] = apply_filters('bp_course_api_get_user_course_status_item_unit_meta',$meta,$course_id,$item_id,$user_id);
				$return['meta']['assignments'] = $this->get_attached_assignments($item_id);  
				$return['meta']['attachments'] = $this->get_unit_attachments($item_id);
			}
			
			if($item->post_type == 'quiz'){

				//Get all questions.
				$status = bp_course_get_user_quiz_status($user_id,$item_id);

				if($status){
					$t = get_user_meta($user_id,$item_id,true);
					if(!empty($t)){
						$return['remaining']=$t - time();
					}
				}

				$quiz_access_flag=apply_filters('bp_course_api_check_quiz_lock',true,$item_id,$user_id,'api');

				if($quiz_access_flag){

					$return['content'] = apply_filters('the_content',$item->post_content);
					$all_questions = bp_course_get_quiz_questions($item_id,$user_id);
					if(empty($all_questions)){
						do_action('wplms_before_quiz_begining',$item_id,$user_id);
						$all_questions = bp_course_get_quiz_questions($item_id,$user_id);
					}

					$questions = $question = array();


					$progress = $user_marks = 0;
					if(!empty($all_questions)){

						$max = array_sum($all_questions['marks']);
						$auto = get_post_meta($item_id,'vibe_quiz_auto_evaluate',true);
						

						if($status < 3){
							foreach($all_questions['ques'] as $k=>$question_id){

								$question = bp_course_get_question_details($question_id,1);
								$question['marks'] = intval($all_questions['marks'][$k]);
								$question['user_marks'] = 0;
								$question['status'] = 0;
								$question['marked'] = bp_course_get_question_marked_answer($item_id,$question,$user_id);
								$question['explanation'] = do_shortcode(get_post_meta($question_id,'vibe_question_explaination',true));
								$question['auto'] = (($auto == 'S')?1:0);
								if(!empty($question['marked'])){
									$question['user_marks'] = bp_course_get_user_question_marks($item_id,$question_id,$user_id);
									$user_marks += intval($question['user_marks']);
									$progress++;
									$question['status'] = 1;
								}
								
								array_push($questions, $question);
							}
							$progress = round((100*$progress/count($all_questions['ques'])),2);	
						}else{
							$progress = 100;
							ob_start();
							bp_course_quiz_results($item_id,$user_id);
							$return['content'] .= ob_get_clean();
							$user_marks = get_post_meta($item_id,$user_id,true);
						}
						
					}
					
					$retakes=apply_filters('wplms_quiz_retake_count',get_post_meta($item_id,'vibe_quiz_retakes',true),$item_id,$course,$user_id);
					
					if(function_exists('bp_course_fetch_user_quiz_retake_count') && bp_is_active('activity')){
						
						$retake_count = bp_course_fetch_user_quiz_retake_count($item_id,$user_id);
						if(!empty($retakes) && $retakes > $retake_count){
							$retake_count = $retakes - intval($retake_count);
						}else{
							$retake_count = 0;
						}
					}
					
					$retake_count = intval($retake_count);
					$return['meta'] = array(
						'access' => 1,
						'status' => intval($status),
						'progress' => $progress,
						'marks'=> $user_marks,
						'max' => $max,
						'questions' => $questions,
						'auto'=>(($auto == 'S')?1:0),
						'retakes' => $retake_count,
						'completion_message'=>  do_shortcode(get_post_meta($item_id,'vibe_quiz_message',true)),
					);
				}else{
					$return['content'] = _x('Quiz already in progress, contact site admin, please retry after sometime.','quiz lock flag check for App and Site','wplms');
					$return['meta'] = array(
						'access' => 0
					);
				}
			}
			if(empty($course_id)){$course_id=0;}
			$return['meta']['link'] = get_permalink($item_id).'?id='.$course_id;
			/**
			 * Filter the response.
			 *
			 * @since 3.0.0
			 *
			 * @param array $element_data
			 * @param WP_REST_Request $request
			 */
			$data = apply_filters( 'bp_course_api_get_user_course_status_item',$return, $request );

			return new WP_REST_Response( $data, 200 );
		}

		function get_course_status_item_complete($request){
			
			$body = json_decode($request->get_body(),true);
			$user_id = $this->user->id; 
			$course_id = $request['course'];	
			$item_id = $request['id'];
			$progress = $body['progress'];
			$data = $this->mark_unit_complete($item_id,$user_id,$course_id,$progress);
			
			return new WP_REST_Response( $data, 200 );
		}

		function get_course_status_gamification($request){
			$body = json_decode($request->get_body(),true);
			$course_id = $request['course'];
			$data = array('status'=>0);
			$is_active = get_post_meta($course_id,'vibe_gamification',true);
			if($is_active == 'S'){
				$data = array('status'=>1,'active'=>true,'gamification'=>get_post_meta($course_id,'gamification',true),'message'=>_x('You can get badges to complete the modules','gamification','wplms'));
			}
			return new WP_REST_Response( $data, 200 );
		}

		function assign_badges($request){
			$body = json_decode($request->get_body(),true);
			$course_id = $request['course'];
			$item_id = $request['id'];
			$user_id = $this->user->id;
			$return = array('status'=>0);

			$tips = WPLMS_tips::init();
			if(function_exists('bp_course_record_activity') && !empty($tips->settings['gamification'])){
				$is_active = get_post_meta($course_id,'vibe_gamification',true);
				if($is_active == 'S'){
					$gamification = get_post_meta($course_id,'gamification',true);
					if($gamification['type'] === 'curriculum' && !empty($gamification['value'][$item_id])){
						$item_point = $gamification['value'][$item_id];
						if($this->is_item_completed($course_id,$item_id,$user_id)){

							$old_activities = bp_activity_get(array(
								'fields' => 'ids',
								'filter' => array(
									'action' => 'added_gamification_point',
									'primary_id' => $course_id,
									'secondary_id'=> $item_id,
									'user_id' => $user_id,
								)
							));
							if(empty($old_activities['activities'])){
								$user_link = bp_core_get_userlink( $user_id );
								$activity_args = array(
									'action' => sprintf(_x('Student %s got %s point','gamification','wplms'),$user_link,$item_point),
									'content' => sprintf(_x('Student %s got %s point for %s completion in course %s','gamification','wplms'),$user_link,$item_point,get_the_title($item_id),get_the_title($course_id)),
									'type' => 'added_gamification_point',
									'item_id' => $course_id,
									'primary_link'=>get_permalink($item_id),
									'secondary_item_id'=>$item_id,
									'user_id' => $user_id
								);
								$new_activity = bp_course_record_activity($activity_args);
								if($new_activity){

									$user_points = 	$this->add_user_gamification_point($user_id,$gamification['value'][$item_id]);
									bp_course_record_activity_meta(array('id'=>$new_activity,'meta_key'=>'points','meta_value'=>$gamification['value'][$item_id]));

									$badges_assigned_ids = $this->assign_badges_on_point($user_id,$user_points,$item_point);
									do_action('gamification_point_assign_add_activity',$activity_args,$user_points,$badges_assigned_ids);

									$badges_assigned_ids_details = array();
									foreach ($badges_assigned_ids as $id) {
										$badges_assigned_ids_details[] = $this->get_single_badge($id);
									}
									$return = array(
										'status' => 1,
										'badges' => $badges_assigned_ids_details,
										'message' => sprintf(_x('%s points added','gamification','wplms'),$gamification['value'][$item_id])
									);
								}
							}
						}
					}	
				}
			}
			return new WP_REST_Response( $return, 200 );
		}

		public static function get_single_badge($id){
			return apply_filters('wplms_single_badge_preview',array(
				'id' => $id,
				'name' => get_the_title($id),
				'image' => wp_get_attachment_url( get_post_thumbnail_id($id) ),
				'subtitle' => get_post_meta($id,'subtitle',true),
				'point' =>  floatval(get_post_meta($id,'points',true)),
			));
		}

		public static function is_item_completed($course_id,$item_id,$user_id){
			$post_type = bp_course_get_post_type($item_id);
			$is_completed = false;
			switch ($post_type) {
				case 'unit':
						$is_completed = bp_course_check_unit_complete($item_id,$user_id,$course_id);
					break;
				case 'quiz':
						$status = bp_course_get_user_quiz_status($user_id,$item_id);
						if($status > 2){
							$is_completed = true;
						}
					break;
				case 'wplms-assignment':
					$umeta = get_post_meta($item_id,$user_id,true);
					if($umeta == 0){
						$args = array(  
							'number' => '1',
							'user_id' => $user_id,
							'post_id' => $item_id,
						);
						$comments = get_comments($args);
						if(count($comments) > 0){
							$is_completed = true;
						}
					}
					break;
				default:
					break;
			}
			return $is_completed;
		}

		function add_user_gamification_point($user_id,$addable_point){
			$update_points = floatval(get_user_meta($user_id,'gamification_point',true)) + $addable_point;
			update_user_meta($user_id,'gamification_point',$update_points);
			return $update_points;
		}

		function assign_badges_on_point($user_id,$user_points,$item_point =0 ){
			$args = array(
				'post_type'=>'lmsbadge',
				'fields' => 'ids',
				'post_status' => 'publish',
				'meta_query'=>array(
					array(
						'key'=>'points',
						'value'=>$user_points,
						'type' => 'numeric',
						'compare'=>'<='
					),
				)
			);
			$query = new WP_Query( $args );
			$badge_ids = array();
			if(is_array($query->posts) && count($query->posts)){
				$badge_ids = $query->posts;
			}
			$badges_asssigned_ids = array();

			if(!empty($badge_ids)){
				$user_link = bp_core_get_userlink( $user_id );
				foreach ($badge_ids as $badge_id) {
					$old_activities = bp_activity_get(array(
						'fields' => 'ids',
						'filter' => array(
							'action' => 'gamification_badge',
							'primary_id' => $badge_id,
							'user_id' => $user_id,
						)
					));
					if(empty($old_activities['activities'])){
						$activity_args = array(
								'action' => sprintf(_x('Student %s got a badge','gamification','wplms'),$user_link),
								'content' => sprintf(_x('Student %s got badge %s','gamification','wplms'),$user_link,get_the_title($badge_id)),
								'type' => 'gamification_badge',
								'item_id' => $badge_id,
								'primary_link'=>get_permalink($badge_id),
								'secondary_item_id'=>'',
								'user_id' => $user_id
							);
						$new_activity = bp_course_record_activity($activity_args);
						if($new_activity){							
							bp_course_record_activity_meta(array('id'=>$new_activity,'meta_key'=>'onpoints','meta_value'=>$user_points)); //on user_points
							bp_course_record_activity_meta(array('id'=>$new_activity,'meta_key'=>'points','meta_value'=>$item_point)); // on item point
							$badges_asssigned_ids[] = $badge_id;
						}
					}
				}
			}
			return $badges_asssigned_ids;
		}

		function mark_unit_complete($item_id,$user_id,$course_id,$progress=null){
			$data = array();
			$type =get_post_type($item_id);
			$unit_title = get_the_title($item_id);
			$course_title = get_the_title($course_id);
			if(!empty($user_id) && !empty($item_id)){
				if($type == 'unit'){
					$done_flag=bp_course_get_user_unit_completion_time($user_id,$item_id,$course_id);
					
					if(empty($done_flag)){

						/*$args = array(
							'action' => __('Student finished unit ','wplms'),
						    'content' => sprintf(__('Student %s finished the unit %s in course %s','wplms'),bp_core_get_userlink($user_id),$unit_title,$course_title),
						    'type' => 'unit_complete',
						    'user_id' => $user_id,
						    'primary_link' => get_permalink($item_id),
						    'item_id' => $course_id,
						    'secondary_item_id' => $item_id
						);
						bp_course_record_activity($args);*/
						bp_course_update_user_unit_completion_time($user_id,$item_id,$course_id,time());
						
						do_action('wplms_unit_complete',$item_id,$progress,$course_id,$user_id );
					}
				}
				
				if($progress!==null){
					bp_course_update_user_progress($user_id,$course_id,$progress);
				}
				if($type=='unit'){
					$message = sprintf(_x('Unit %s  completed in Course %s','','wplms'),$unit_title,$course_title);
				}else{
					$message = sprintf(_x('%s %s completed in Course %s','new complete message','wplms'),$this->get_label_from_post_type($type),$unit_title,$course_title);
				}
				
				$data = array('status'=>true,'icon'=>wplms_get_element_icon(wplms_get_element_type($item_id,'unit')),'message'=>$message);
			}
			return $data;
		}

		function check_course_member($request){
			$this->get_user_id($request);
			$body = json_decode($request->get_body(),true);

			if(!$this->user_id){
				return false;
			}
			$data = [];
			$data['status'] = false;
			if(!empty($body['token']) && is_numeric($request['course'])){
	            
	           
	            if(!empty($this->user)){
	            	$course_id = $request['course'];
	                if(function_exists('bp_course_is_member') && bp_course_is_member($request['course'],$this->user->id)){
	                	$data['is_member'] = true;
						$data['status']=bp_course_get_user_course_status($this->user_id,$request['course']);
						$data['expiry']=bp_course_get_user_expiry_time($this->user_id,$request['course']);
	                }else{
	                	$data['status'] = true;
	                	$data['is_member'] = false;
	                }
						
	            }
	                
	        }
	        return new WP_REST_Response( $data, 200 );
		}

		function check_code($request){
			$this->get_user_id($request);
			$body = json_decode($request->get_body(),true);

			if(!$this->user_id){
				return false;
			}
			$data = [];
			if(!empty($body['token']) && is_numeric($request['course'])){
	            $course_id = $request['course'];
	           $user_id= $this->user_id;
	         
	           $code = $body['code'];
                $course_codes = get_post_meta($course_id,'vibe_course_codes',true);
                if(isset($code) && strlen($code)<2 || (strpos($code,'|') !== false)){
                    $message = '<p class="message">'.__('Code does not exist. Please check the code.','wplms').'</p>';
                    return new WP_REST_Response( array('status'=>false,'message'=>$message), 200 );
                }

                $x=preg_match("/(^|,)$code(\|([0-9]+)|(,|$))/", $course_codes, $matches);
                if(!$x){
                    $message =  '<p class="message">'.__('Code does not exist. Please check the code.','wplms').'</p>';
                    return new WP_REST_Response( array('status'=>false,'message'=>$message), 200 );
                }else{    
                    global $wpdb,$bp;
                    if(isset($matches[3]) && is_numeric($matches[3])){
                        $total_count = $matches[3];

                        $count = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$bp->activity->table_name} WHERE component = %s AND type = %s AND content = %s AND item_id = %d",'course','course_code',$code,$course_id));
                        //Added on 1st feb'16, remove above line in April'16
                        $addon_count = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$bp->activity->table_name_meta} WHERE meta_key = %d AND meta_value = %s",$course_id,$code));
                        $count = $count + $addon_count;
                        if($count < $total_count){
                            if(!wplms_user_course_active_check($user_id,$course_id)){
                                do_action('wplms_course_code',$code,$course_id,$user_id);
                                bp_course_add_user_to_course($user_id,$course_id);
                                $message = '<p class="message success">'.__('Congratulations! You are now added to the course.','wplms').'</p>';
                                return new WP_REST_Response( array('status'=>true,'message'=>$message), 200 );
                            }else{
                                $message = '<p class="message">'.__('User already in course.','wplms').'</p>';
                                return new WP_REST_Response( array('status'=>false,'message'=>$message), 200 );
                            }
                        }else{
                            $message = '<p class="message">'.__('Maximum number of usage for course code exhausted','wplms').'</p>';
                            return new WP_REST_Response( array('status'=>false,'message'=>$message), 200 );
                        }
                    }else{
                        if(!wplms_user_course_active_check($user_id,$course_id)){
                            do_action('wplms_course_code',$code,$course_id,$user_id);
                            bp_course_add_user_to_course($user_id,$course_id);
                            $message = '<p class="message success">'.__('Congratulations! You are now added to the course.','wplms').'</p>';
                            return new WP_REST_Response( array('status'=>true,'message'=>$message), 200 );
                        }else{
                            $message = '<p class="message">'.__('User already in course.','wplms').'</p>';
                            return new WP_REST_Response( array('status'=>true,'message'=>$message), 200 );
                        }
                    }
                }

	            
	        }
	        return new WP_REST_Response( array('status'=>false,'message'=>_x('something went wrong! data missing')), 200 );
		}

		function get_label_from_post_type($type){
			$obj = get_post_type_object( $type );
			if(!empty($obj)){
				return $obj->labels->singular_name;
			}
		}

		function get_single_quiz_data($request){
			$this->get_user_id($request);
			$body = json_decode($request->get_body(),true);

			if(!$this->user_id){
				return false;
			}

			$activity_id = 0;
			if(!empty($body['activity'])){$activity_id=$body['activity'];}
			$user_id = $this->user_id;
			$quiz_id = $request['id'];	
			if(!empty($activity_id)){
				$status = 4;
				$quiz_data =  bp_wplms_get_quiz_data($user_id,$quiz_id,null,null,$status,$activity_id);
			}else{
				if(!empty($body['course'])){
					$drip_check = bp_course_get_drip_status($body['course'],$user_id,$quiz_id);
					if($drip_check['status']){
						$quiz_data['drip_message'] = $drip_check['message'];
						if(isset($drip_check['time'])){
							$quiz_data['drip_time'] = $drip_check['time'];
						}
					}else{
						$quiz_data =  bp_wplms_get_quiz_data($user_id,$quiz_id);
					}
				}else{
					$quiz_data =  bp_wplms_get_quiz_data($user_id,$quiz_id);
				}
			}
			$data = apply_filters( 'bp_course_api_get_user_single_quiz_data',$quiz_data, $request ,$user_id);
			return new WP_REST_Response( $data, 200 );
		}

		function get_quiz_previousresults($request){
			$this->get_user_id($request);


			if(!$this->user_id){
				return false;
			}
			global $bp,$wpdb;
			$table_name=$bp->activity->table_name;
			$meta_table_name=$bp->activity->table_name_meta;
			$user_id = $this->user_id;
			$quiz_id = $request['id'];	
			$quiz_results = $wpdb->get_results($wpdb->prepare( "
						SELECT activity.content,activity.id FROM {$table_name} AS activity LEFT JOIN {$meta_table_name} as meta ON activity.id=meta.activity_id
						WHERE 	activity.component 	= 'course'
						AND 	( activity.type 	= 'quiz_evaluated' OR activity.type 	= 'evaluate_quiz' )
						AND 	activity.user_id = %d
						AND 	( activity.item_id = %d OR activity.secondary_item_id = %d )
						AND  meta.meta_key = 'old_quiz_results'
						ORDER BY activity.date_recorded DESC
					" ,$user_id,$quiz_id,$quiz_id));

			
			$data = array();
			if(count($quiz_results) > 0){
				$data = $quiz_results;
			}
			return new WP_REST_Response( $data, 200 );
		}

		function get_quiz_previous_result($request){
			$this->get_user_id($request);


			if(!$this->user_id){
				return false;
			}
			$body = json_decode($request->get_body(),true);
			$user_id = $this->user_id;
			$quiz_id = $request['id'];
			$status = 4;
			$activity_id = $body['activity_id'];
			$quiz_data =  bp_wplms_get_quiz_data($user_id,$quiz_id,null,null,$status,$activity_id);
			$data = apply_filters( 'bp_course_api_get_user_single_quiz_data',$quiz_data, $request ,$user_id);
			return new WP_REST_Response( $data, 200 );
			
		}

		function init_retake_quiz($request){
			$this->get_user_id($request);

			if(!$this->user_id){
				$data['status'] = false;
				$data['message']=_x('User id not set ,please loagout and try again.','','wplms');
			}

			$user_id = $this->user_id;
			$course_id = $request['course'];	
			$item_id = $request['id'];	
			
			if(!bp_course_is_member($course_id,$user_id)){

				$data['status'] = false;
				$data['message']=_x('Not a member of course','','wplms');
			}

			$retakes=apply_filters('wplms_quiz_retake_count',get_post_meta($item_id,'vibe_quiz_retakes',true),$item_id,$course_id,$user_id);
			
			if(function_exists('bp_course_fetch_user_quiz_retake_count') && bp_is_active('activity')){
				
				$retake_count = bp_course_fetch_user_quiz_retake_count($item_id,$user_id);
				if(!empty($retakes) && $retakes > $retake_count){
					
					$retake_args = array(
									'quiz_id' => $item_id,
		      						'user_id' => $user_id,
								);
					bp_course_student_quiz_retake($retake_args);
					$data['status'] = true;
				
					$data['message']=_x('Quiz Reset and retake','','wplms');
					do_action('wplms_quiz_retake',$quiz_id,$user_id,$course_id);
				}else{

					$data['status'] = false;
					$data['message']=_x('Not retakes left ,Contact instructor of course','','wplms');
				}
			}else{

				$data['status'] = false;
				$data['message']=_x('Something went wrong','','wplms');
			}
		   

			return new WP_REST_Response( $data, 200 );
		}

		function flag_question($request){
			$question_id = $request['id'];	
			$body =  json_decode($request->get_body(),true);
			$flagged = $body['flagged'];
			$feedback = $body['feedback'];
			$data = array();
			$data['status'] = false;
			
			if(!empty($question_id)){
				$data['status'] = true;
				$meta = get_post_meta($question_id,'vibe_flagged_by',true);
				$feedbacks = get_post_meta($question_id,'vibe_flagged_feedbacks',true);
				if(empty($feedbacks)){
					$feedbacks =[];
				}
				if(empty($meta) || !is_array($meta)){
					$meta = array();
				}
				$index = array_search($this->user_id, $meta);
				if($index>-1){
					$isFlagged = true;
				}else{
					$isFlagged = false;
				}
				
				if(!$isFlagged){
					$meta[] = $this->user_id;
					
				}
				$feedbacks[$this->user_id] =$feedback;
				$data['message'] = _x('Question flagged','','wplms');
				update_post_meta($question_id,'vibe_flagged_by',$meta);
				update_post_meta($question_id,'vibe_flagged_feedbacks',$feedbacks);
				$count = count($meta);
				update_post_meta($question_id,'vibe_flag_count',$count);
				do_action('question_feedback_given',$question_id,$this->user_id,$feedback);
			}
			
			
			return new WP_REST_Response( $data, 200 );
		}

		function init_course_retake($request){   
			$user_id = $this->user->id;
			$course_id = $request->get_param('id');
			if(!$user_id){
				$data['status'] = false;
				$data['message']=_x('User id not set ,please loagout and try again.','','wplms');
			}
			$status = bp_course_get_user_course_status($user_id,$course_id);

	        if(isset($status) && is_numeric($status)){  // Necessary for continue course
	        	
				
	            do_action('wplms_student_course_reset',$course_id,$user_id);
	            if(function_exists('bp_course_update_user_course_status'))
	                bp_course_update_user_course_status($user_id,$course_id,1); // New function

	            $course_curriculum = array();
	            if(function_Exists('bp_course_get_curriculum'))
	                $course_curriculum = bp_course_get_curriculum($course_id,$user_id);
	            if(!empty($course_curriculum)){
	            	foreach($course_curriculum as $c){
		                if(is_numeric($c)){
		              
		                    if(get_post_type($c) == 'quiz'){
		                        if(function_exists('bp_course_get_quiz_questions')){  
		                            bp_course_remove_quiz_questions($c,$user_id);
		                        }
		                        bp_course_remove_user_quiz_status($user_id,$c);
		                        bp_course_reset_quiz_retakes($c,$user_id);
		                        do_action('wplms_quiz_course_retake_reset',$c,$user_id);
		                        delete_instructor_quiz_remarks($c,$user_id);
		                    }

		                    if(get_post_type($c) == 'unit'){
		                        if(function_exists('bp_course_reset_unit')){  
		                            bp_course_reset_unit($user_id,$c,$course_id);
		                        }
		                    }
		                }
		            }
	            }
	            

	            /* Reset  Badges and CErtificates on Course Reset */
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
	                update_user_meta($user_id,'certificates',$user_certifications);
	            }
	            bp_course_update_user_progress($user_id,$course_id,0);
	            
	            /*==== End Fix ======*/
	            do_action('wplms_course_retake',$course_id,$user_id);
	            $data['status'] = true;
	            $data['message']=_x('Course retaken.','','wplms');

	        }else{
	        	$data['status'] = false;
	            $data['message']= __('There was issue in retaking this course for the user. Please contact admin.','wplms');
	        }
	        return new WP_REST_Response( $data, 200 );
		}

		function init_single_retake_quiz($request){
			$this->get_user_id($request);

			if(!$this->user_id){
				$data['status'] = false;
				$data['message']=_x('User id not set ,please loagout and try again.','','wplms');
			}

			$user_id = $this->user_id;
			$item_id = $request['id'];

			$retakes=apply_filters('wplms_quiz_retake_count',get_post_meta($item_id,'vibe_quiz_retakes',true),$item_id,get_post_meta($item_id,'vibe_quiz_course',true),$user_id);
			
			if(function_exists('bp_course_fetch_user_quiz_retake_count') && bp_is_active('activity')){
				
				$retake_count = bp_course_fetch_user_quiz_retake_count($item_id,$user_id);
				if(!empty($retakes) && $retakes > $retake_count){
					
					$retake_args = array(
									'quiz_id' => $item_id,
		      						'user_id' => $user_id,
								);
					bp_course_student_quiz_retake($retake_args);
					
					$data['status'] = true;
				
					$data['message']=_x('Quiz Reset and retake','','wplms');
				}else{

					$data['status'] = false;
					$data['message']=_x('Not retakes left ,Contact instructor of course','','wplms');
				}
			}else{

				$data['status'] = false;
				$data['message']=_x('Something went wrong','','wplms');
			}
		   

			return new WP_REST_Response( $data, 200 );
		}

		function pmpro_check_level($request){
			$data = array();
			if(!function_exists('pmpro_hasMembershipLevel'))
				$data['status'] = false;
				$data['message']=_x('Memberhsips module not active on site','','wplms');


			$this->get_user_id($request);

			if(empty($this->user_id)){
				$data['status'] = false;
				$data['message']=_x('User id not set ,please logout and try again.','','wplms');
			}

			$user_id = $this->user_id;
			$course_id = $request['course'];
			$level_id =$request['level'];

			$membership_ids=vibe_sanitize(get_post_meta($course_id,'vibe_pmpro_membership',false));
	        $flag = apply_filters('wplms_pmpro_connect_allow_course_subscription',1,$course_id,$user_id,$membership_ids);

	        if(pmpro_hasMembershipLevel($level_id,$user_id) && $flag){
	          	
	            $coursetaken=get_user_meta($user_id,$course_id,true);
	            if(!isset($coursetaken) || $coursetaken ==''){

	                $duration=get_post_meta($course_id,'vibe_duration',true);
	                $course_duration_parameter = apply_filters('vibe_course_duration_parameter',86400,$course_id);
	                $new_duration = time()+$course_duration_parameter*$duration;
	                $new_duration = apply_filters('wplms_pmpro_course_check',$new_duration);
	                if(function_exists('bp_course_add_user_to_course')){
	                  	bp_course_add_user_to_course($user_id,$course_id,$new_duration);
	                  	$data['status'] = true;
				
						$data['message']=_x('Course subscribed','','wplms');
	                }
	                
	            }else{
	            	$data['status'] = true;
				
					$data['message']=_x('Course already subscribed','','wplms');
	            }
	        }else{
	        	$data['status'] = false;
				$data['message']=_x('You do not have selected level.Please try other one OR visit site and purchase one.','','wplms');
	        }
	        return new WP_REST_Response( $data, 200 );
		}

		function mycred_check_points($request){
			$data = array();
			if(!function_exists('mycred')){


				$data['status'] = false;
				$data['message']=_x('mycred module not active on site','','wplms');


				$this->get_user_id($request);
				if(empty($this->user_id)){
					$data['status'] = false;
					$data['message']=_x('User id not set ,please logout and try again.','','wplms');
				}

				$user_id = $this->user_id;
				$course_id = $request['course'];
				$points =$request['points'];

				$mycred = mycred();
				$balance = $mycred->get_users_cred( $user_id );
				
				
				if($balance >= $points)
				{   
	
					$deduct = -1*$points;

					$subscription = get_post_meta($course_id,'vibe_mycred_subscription',true);
					if(isset($subscription) && $subscription && $subscription !='H'){

						$duration = get_post_meta($course_id,'vibe_mycred_duration',true);

					    $mycred_duration_parameter = get_post_meta($course_id,'vibe_mycred_duration_parameter',true);
					    if(empty($mycred_duration_parameter)){
					    	$mycred_duration_parameter = 86400;
					    }
					    $duration = $duration*$mycred_duration_parameter;
					    bp_course_add_user_to_course($user_id,$course_id,$duration);
					    
					}else{
						bp_course_add_user_to_course($user_id,$course_id);
					}	

					$mycred->update_users_balance( $user_id, $deduct);
					$mycred->add_to_log('take_course',
						$user_id,
						$deduct,
						sprintf(__('Student %s subscibed for course','wplms-mycred'),bp_core_get_user_displayname($user_id)),
						$course_id,
						__('Student Subscribed to course , ends on ','wplms-mycred').date("jS F, Y",$expiry));


					$durationtime = $duration.' '.calculate_duration_time($mycred_duration_parameter);

					bp_course_record_activity(array(
					      'action' => __('Student subscribed for course ','wplms').get_the_title($course_id),
					      'content' => __('Student ','wplms').bp_core_get_userlink( $user_id ).__(' subscribed for course ','wplms').get_the_title($course_id).__(' for ','wplms').$durationtime,
					      'type' => 'subscribe_course',
					      'item_id' => $course_id,
					      'primary_link'=>get_permalink($course_id),
					      'secondary_item_id'=>$user_id
				    ));   
				    $instructors=apply_filters('wplms_course_instructors',get_post_field('post_author',$course_id),$course_id);

				    // Commission calculation
				    
				    if(function_exists('vibe_get_option'))
				  	$instructor_commission = vibe_get_option('instructor_commission');
				  	if(isset($instructor_commission) && $instructor_commission == 0)
				  		return;

				  	if(!isset($instructor_commission))
				      $instructor_commission = 70;

				  	
				    $commissions = get_option('instructor_commissions');
				    if(isset($commissions) && is_array($commissions)){
				    } // End Commissions_array 

					if(is_array($instructors)){
						foreach($instructors as $instructor){
							if(!empty($commissions[$course_id]) && !empty($commissions[$course_id][$instructor])){
								$calculated_commission_base = round(($points*$commissions[$course_id][$instructor]/100),2);
							}else{
								$i_commission = $instructor_commission/count($instructors);
								$calculated_commission_base = round(($points*$i_commission/100),2);
							}
							$mycred->update_users_balance( $instructor, $calculated_commission_base);
							$mycred->add_to_log('instructor_commission',
							$instructor,
							$calculated_commission_base,
							__('Instructor earned commission','wplms-mycred'),
							$course_id,
							__('Instructor earned commission for student purchasing the course via points ','wplms-mycred')
							);
						}
					}else{
						if(isset($commissions[$course_id][$instructors])){
							$calculated_commission_base = round(($points*$commissions[$course_id][$instructors]/100),2);
						}else{
							$calculated_commission_base = round(($points*$instructor_commission/100),2);
						}

						$mycred->update_users_balance( $instructors, $calculated_commission_base);
						$mycred->add_to_log('instructor_commission',
							$instructor,
							$calculated_commission_base,
							__('Instructor earned commission','wplms-mycred'),
							$course_id,
							__('Instructor earned commission for student purchasing the course via points ','wplms-mycred')
							);
					}
					


				    do_action('wplms_course_mycred_points_puchased',$course_id,$user_id,$points);
       
					$data['status'] = true;
					$data['message'] = "You have enough balance for this course";
					$data['balance']=$balance;
				}
				else
				{
					$data['status'] = false;
					$data['message'] = "You have not enough balance for this course";
					$data['balance']=$balance;
				}
				
			}else{
				$data['status'] = false;
				$data['message'] = "Points system not available";
			}
			return $data;
		}

		/**
		 * Record Course Progress User
		 *
		 * @since 3.0.0
		 */
		function update_course_progress($request){
			
			$post = json_decode(file_get_contents('php://input'));
			
			$data = array();
			bp_course_update_user_progress($this->user_id,$post->course,$post->progress);

			return new WP_REST_Response( $data, 200 );
		}


		/**
		 * GET COURSE REVIEW BY USER
		 *
		 * @since 3.0.0
		 */
		function get_review($request){


			if(!$this->user_id){
				return false;
			}
			$course = $request['course'];
			global $wpdb;
			$comment_id = $wpdb->get_var("SELECT comment_ID FROM {$wpdb->comments} WHERE comment_post_ID = $course AND user_id = $this->user_id AND comment_approved = 1");
			
			$data = array('status'=>false);
			if(!empty($comment_id)){
				$comment = get_comment($comment_id);
				$data['comment_ID']= $comment->comment_ID;
				$data['review']= $comment->comment_content;
				$data['title']= get_comment_meta($comment->comment_ID,'review_title',true);
				$data['rating']= get_comment_meta($comment->comment_ID,'review_rating',true);
			}

			

			return new WP_REST_Response( $data, 200 );;
		}

		/**
		 * Record Course Review BY User
		 *
		 * @since 3.0.0
		 */
		function get_user_course_permissions_check($request){
			//Check if user part of course.


			$body =  json_decode($request->get_body(),true);
			if(!is_numeric($body['course_id']))
				return false;
			
			if(!empty($body['token'])){
	            
	            $this->user = apply_filters('vibebp_api_get_user_from_token','',$body['token']);
	            if(!empty($this->user)){
	            	$this->user_id = $this->user->id;
	            }
	        }

			if(empty($this->user_id)){
				return false;
			}


			if(bp_course_is_member($body['course_id'],$this->user_id))
				return true;


			return false;
		}

		function add_review($request){

			$post = json_decode(file_get_contents('php://input'));
			$review = wp_filter_nohtml_kses(stripslashes($post->review));	
			$comment_id = 0;
			$data = array(
    				'comment_post_ID' => $post->course_id,
    				'comment_content' => $review,
    				'user_id' => $this->user_id,
    				'status'=>'public',
    				'comment_approved' => 1,
				);
			
			if(strlen($review) < 10){
				$status = 0;
				$message = _x('Please add more words to the review message !','API message failure to add review','wplms');
			}else{
				global $wpdb;
				$comment_id = $wpdb->get_var("SELECT comment_ID FROM {$wpdb->comments} WHERE comment_post_ID = $post->course_id AND user_id = $this->user_id AND comment_approved = 1");

				if(is_numeric($comment_id)){
					$data['comment_ID']=$comment_id;
					wp_update_comment($data);
				}else{
					$comment_id = wp_insert_comment($data);	
				}
				
				if($comment_id){
					$status = 1;
					$title = wp_filter_nohtml_kses($post->title);
					update_comment_meta( $comment_id, 'review_title', $title );
          			$rating = wp_filter_nohtml_kses($post->rating);
          			update_comment_meta( $comment_id, 'review_rating', $rating );
					$message = _x('Review successfully added !','API message failure to add review','wplms');
					do_action('wplms_course_review',$post->course_id,$rating,$title,$this->user_id);

		          	if(function_exists('bp_course_get_course_reviews')){
		              	$calculate_reviews=bp_course_get_course_reviews('id='.$post->course_id);
		          	}
				}else{
					$status = 0;
					$message = _x('Failed to add review','API message failure to add review','wplms');
				}
			}

			
			

			$data = array('status'=>$status,'message'=>$message,'comment_id'=>$comment_id);

			return 	new WP_REST_Response( $data, 200 );
		}

		/*
		Add Quiz result
		 */
		function add_user_result($request){
			$post = json_decode(file_get_contents('php://input'),true);
			
			$max=$marks=0;
			$results = array();
			$qstatus = bp_course_get_user_quiz_status($this->user_id,$post['quiz_id']);
			$course_id = $post['course_id'];
			if(empty($course_id)){
				$course_id = get_post_meta($post['quiz_id'],'vibe_quiz_course',true);
			}
			$course_curriculum=bp_course_get_curriculum_units($course_id);
			if(!is_array($course_curriculum)){
      			$course_curriculum = array();
      		}
			$quiz_completion_complete = get_post_meta($post['quiz_id'],'vibe_quiz_message',true);
			$quiz_completion_complete = str_replace(
				array('id="'.$post['quiz_id'].'"',
					'id='.$post['quiz_id'],
					'id=\''.$post['quiz_id'].'\'',
				)
				, 'id="'.$post['quiz_id'].'" key="'.$this->user_id.'"'
				, $quiz_completion_complete
			);
	      	
            $correct_data = $tags_data = $tags = array();
			if(!empty($qstatus) && $qstatus > 2){
				$apimessage = _x('Quiz Already Submitted!','Quiz Already submitted to serve','wplms');
			}else{
				if(is_array($post['results'])){
					foreach($post['results'] as $res){
						if(empty($res['marks'])){
							$res['marks'] = 0;
						}
						$max += $res['marks'];		
						$marks += (empty($res['user_marks'])?0:$res['user_marks']);
						$question_content = $res['content'] ;
						if(is_object($question_content)){
							$question_content = (array)$question_content;
						}
						if(is_array($question_content)){
							foreach($question_content as $value){
								$question_content .= $value;
							}
						}
						$correct_count = 0;
						$incorrect_count = 0;
						if(!empty($res['id']) && is_numeric($res['id'])){
							if(!empty($res['usercorrect']) && $res['usercorrect'] > 0){
								update_question_correct_percentage($res['id']);
							}else{
								update_question_incorrect_percentage($res['id']);
							}
							$correct_count = get_question_correct_percentage($res['id']);
							$correct_count = intval($correct_count);
							$incorrect_count = get_question_incorrect_percentage($res['id']);
							$incorrect_count = intval($incorrect_count);
							if(empty(($incorrect_count+$correct_count))){
								$actual_percentage = 0;
							}else{
								$actual_percentage = round(($correct_count/($incorrect_count+$correct_count))*100);
							}
							
							$correct_data[$res['id']] = $actual_percentage;
							$res['correct_data'] = $correct_data[$res['id']];

							//tag data
							$terms = get_the_terms( $res['id'], 'question-tag' );
							if(!empty($terms) && !is_wp_error($terms)){
								foreach ($terms as $key => $term) {
									$index = $this->check_tag($term,$tags);
									if($index < 0){
										$term->count= 1;
										$tags[] = $term;
										$index = count($tags)-1;
									}else{
										$tags[$index]->count++;
									}

									if(!isset($tags[$index]->correct)){
										$tags[$index]->correct = 0;
									}
									if(!isset($tags[$index]->incorrect)){
										$tags[$index]->correct = 0;
									}
									if(!empty($res['usercorrect']) && $res['usercorrect'] > 0){
										$tags[$index]->correct++;
									}else{
										$tags[$index]->incorrect++;
									}

									
								}
							}
						}
						$result = array(
							'content'=>$question_content,
							'type'=>$res['type'],
							'marked_answer'=>(!empty($res['marked'])?$res['marked']:null),
							'correct_answer'=>(!empty($res['correct'])?$res['correct']:null),
							'explaination'=>$res['explanation'],
							'max_marks'=>(!empty($res['marks'])?$res['marks']:0),
							'marks'=>(!empty($res['user_marks'])?$res['user_marks']:0),
							'raw' => $res
						);
						$results[] = $result;
					}
				}
				$auto = get_post_meta($post['quiz_id'],'vibe_quiz_auto_evaluate',true);
				update_post_meta( $post['quiz_id'],$this->user_id,$marks);
				
				$progress = bp_course_get_user_progress($this->user_id,$course_id);
				$c_count = count($course_curriculum);
	      		if($c_count){
					$progress = intval($progress) + round((100/$c_count),2);
	      		}
				if($progress > 100){$progress = 100;}
				bp_course_update_user_progress($this->user_id,$course_id,$progress);
				if(!empty($auto) && function_exists('vibe_validate') && vibe_validate($auto)){
					bp_course_update_user_quiz_status($this->user_id,$post['quiz_id'],4);
				}else{
					bp_course_update_user_quiz_status($this->user_id,$post['quiz_id'],3);
				}
				
				update_user_meta($this->user_id,$post['quiz_id'],time());
				if(!empty($post->course)){
					do_action('wplms_submit_quiz',$post['quiz_id'],$this->user_id,$results,$course_id);
				}else{
					do_action('wplms_submit_quiz',$post['quiz_id'],$this->user_id,$results);
				}
				
				if(!empty($auto) && function_exists('vibe_validate') && vibe_validate($auto)){
					if(!empty($post->course)){
						do_action('wplms_evaluate_quiz',$post['quiz_id'],$marks,$this->user_id,$max,$course_id);
					}else{
						do_action('wplms_evaluate_quiz',$post['quiz_id'],$marks,$this->user_id,$max);
					}
					
					global $wpdb,$bp;
					$activity_id = $wpdb->get_var($wpdb->prepare( "
						            SELECT id
						            FROM {$bp->activity->table_name}
						            WHERE secondary_item_id = %d
						          AND type = 'quiz_evaluated'
						          AND user_id = %d
						          ORDER BY date_recorded DESC
						          LIMIT 0,1
						        " ,$post['quiz_id'],$this->user_id));
					if(!empty($activity_id)){
						bp_course_generate_user_result($post['quiz_id'],$this->user_id,$results,$activity_id);
					}
				}else{
					
					update_user_meta($this->user_id,'manual_intermediate_results'.$post['quiz_id'],$results);
				}
				
				
				$apimessage = _x('Quiz submitted!','Quiz submitted to serve','wplms');
			}
			
			$completion_message = '';
			ob_start();
			echo do_shortcode($quiz_completion_complete);
			do_action('wplms_after_quiz_message',$post['quiz_id'],$this->user_id);
			$completion_message = ob_get_clean();
			$stop_progress = apply_filters('bp_course_stop_course_progress',true,$course_id);
	      	$next_unit = null;
	      	$flag = apply_filters('wplms_next_unit_access',true,$post['quiz_id'],$this->user_id);
	      	$continue = 0;
	      	if( $stop_progress && $flag ){
	      		$continue = 1;
      			$key = array_search($post['quiz_id'],$course_curriculum);
	        	if($key <=(count($course_curriculum)-1) ){  // Check if not the last unit
	          		$key++;
	          		if(isset($course_curriculum[$key])){
	          			$next_unit =  $course_curriculum[$key];
	          		}
	        	}

	      	}
	      	/*ob_start();
            bp_course_quiz_retake_form($post->quiz_id,$this->user_id);
            $retake_html = ob_get_clean();*/
            $tag_threshold = apply_filters('wplms_tags_threshold',1,$post,$this->user_id);
            if(!empty($tags)){
            	foreach ($tags as $key => $tt) {
            		$tt->correct = intval($tt->correct);
            		$tt->incorrect = intval($tt->incorrect);
            		if(!empty($tt->correct)){
            			update_question_tag_correct_percentage($tt->term_id,$tt->correct);
            		}
            		if(!empty($tt->incorrect)){
            			update_question_tag_incorrect_percentage($tt->term_id,$tt->incorrect);
            		}
	            	if($tt->count >= $tag_threshold){
	            		$per = round((intval($tt->correct)/($tt->correct+$tt->incorrect))*100);
	            		$tags_data[] = array('label'=> $tt->name,'value'=> $per);
	            	}
	            }
            }
            
            if(!empty($tags_data)){
            	update_user_meta($this->user_id,'tags_data'.$post['quiz_id'],$tags_data);
            }
            $retakes=apply_filters('wplms_quiz_retake_count',get_post_meta($post['quiz_id'],'vibe_quiz_retakes',true),$post['quiz_id'],$course_id,$this->user_id);
            if(function_exists('bp_course_fetch_user_quiz_retake_count') && bp_is_active('activity')){
						
				$retake_count = bp_course_fetch_user_quiz_retake_count($post['quiz_id'],$this->user_id);
				if(!empty($retakes) && $retakes > $retake_count){
					$retake_count = $retakes - intval($retake_count);
				}else{
					$retake_count = 0;
				}
			}
			
			$retake_count = intval($retake_count);
			$data = array(
				'check_results_url'=>bp_core_get_user_domain( $this->user_id ).BP_COURSE_SLUG.'/'.BP_COURSE_RESULTS_SLUG.'/?action='.$post['quiz_id'],'status'=>true,
				'message'=>$apimessage,
				'progress'=>empty($progress)?0:$progress,
				'completion_message'=>  (!empty($qstatus) && $qstatus > 2)?$apimessage:$completion_message,
				'next_unit'=>$next_unit,
				//'retake_html'=>$retake_html,
				'ext_flag' => $flag,
				'continue' => $continue,
				'correct_data'=>$correct_data,
				'tags_data' => $tags_data,
				'tags' => $tags,
				'retakes' => $retake_count
			);
						
			return 	new WP_REST_Response( $data, 200 );
		}

		function check_tag($checkTag,$tags){
			if(!empty($tags)){
				foreach ($tags as $key => $tag) {
					if($tag->term_id===$checkTag->term_id){
						return $key;
					}
				}
			}	
			return -1;
		}

		function save_user_question($request){

			$post = json_decode(file_get_contents('php://input'));
			$this->get_user_id($request);

			if(!$this->user_id){
				return false;
			}
			$quiz_id =$question_id= 0;
			if(!empty($post) && !empty($post->quiz_id) && is_numeric($post->quiz_id)){
				$quiz_id = $post->quiz_id;
			}
			if(!empty($post) && !empty($post->question) && !empty($post->question->id)  && is_numeric($post->question->id)){
				$question_id = $post->question->id;
			}
			if(!empty($quiz_id ) && !empty($question_id)){
				$saved_answers = get_quiz_marked_answer($this->user_id,$quiz_id);
				if(empty($saved_answers)){
					$saved_answers = array();
				}
				$saved_answers[$question_id] = (array)$post->question;
			}
			save_quiz_marked_answer($this->user_id,$quiz_id,$saved_answers);
			$data = array('status'=>true,'message'=>_x('Marked answer saved','','wplms'));
			return 	new WP_REST_Response( $data, 200 );
		}

		function save_user_quiz($request){
			$post = json_decode(file_get_contents('php://input'));
			$this->get_user_id($request);

			if(!$this->user_id){
				return false;
			}
			$quiz_id =$question_id= 0;
			if(!empty($post) && !empty($post->quiz_id) && is_numeric($post->quiz_id)){
				$quiz_id = $post->quiz_id;
			}
			$questions = array();
			if(!empty($post->questions)){
				$questions = (array)$post->questions;
			}
			if(!empty($questions) && is_array($questions)){

				$saved_answers = get_quiz_marked_answer($this->user_id,$quiz_id);
				if(empty($saved_answers)){
					$saved_answers = array();
				}
				foreach ($questions as $question) {
					$question = (array)$question;
					if(!empty($question) && !empty($question['id'])  && is_numeric($question['id'])){
						$question_id = $question['id'];
					}
					if(!empty($quiz_id ) && !empty($question_id)){
						$saved_answers[$question_id] = $question;
					}
					save_quiz_marked_answer($this->user_id,$quiz_id,$saved_answers);
				}
			}
			$data = array('status'=>true,'message'=>_x('Marked answer saved','','wplms'));
			return 	new WP_REST_Response( $data, 200 );
		}

		/*
		VERIFY USER
		 */
		
		function get_verify_permissions_check($request){
		
			$post =  json_decode(file_get_contents('php://input'));
			
			$state = bp_course_get_setting( 'api_security_state', 'api','string' );;

			if($state == $post->state){

				if($this->verify_client($post->client_id)){
				
						return true;	
				}else{
					return false;
				}
				
			}

			return false;
		}
		/*
		USER LOGIN
		 */
		function signin_user($request){


			$post = json_decode(file_get_contents('php://input'));
			
			$data = array();
			$user_id = username_exists($post->username);
			if(!$user_id){
				$user_id = email_exists($post->username);
				if(!$user_id){
					$data['status'] = false;
					$data['message'] = _x('Invalid login username/email','incorrect credentials','wplms');
				}
			}

			if($user_id){
				$this->user_id = $user_id;

				if(isset($post->fbid)){
					//validate is user meta with fb login exists.
					$data['status'] = true;
					$data['token'] = $this->generate_token($this->user_id,$post->client_id);
					$current_user = $this->fetch_user($this->user_id);
					$data['user'] = apply_filters( 'bp_course_api_get_user', $current_user, $request );

				}else{
					$creds = array('user_login'=>$post->username,'user_password'=>$post->password);

					$user = wp_signon( $creds, false );

					if ( is_wp_error($user) ){
						$data['status'] = false;
						$data['message']=$user->get_error_message();
					}else{
						$data['status'] = true;
						$data['token'] = $this->generate_token($this->user_id,$post->client_id);
						$current_user = $this->fetch_user($this->user_id);
						$data['user'] = apply_filters( 'bp_course_api_get_user', $current_user, $request );
					}
				}
				
			}

			return new WP_REST_Response( $data, 200 );
		}

		function logout_user($request){
			$post = json_decode(file_get_contents('php://input'));
			if(empty($this->user_id) || (!empty($this->user_id) && !is_numeric($this->user_id))){
				return;
			}

			if($this->user_id){
				if(class_exists('WP_Session_Tokens')){
					$sessions = WP_Session_Tokens::get_instance($this->user_id);
					// we have got the sessions, destroy them all!
					$sessions->destroy_all();
				}
				
			}
		}

		/*
		USER REGISTRATION
		 */
		function register_user($request){
			$post = json_decode(file_get_contents('php://input'));
			
			$enable = bp_course_get_setting( 'api_registrations', 'api','boolean' );
			if(empty($enable )){
				$user_register_flag = false;
				$message = _x('Registrations disabled in API','registration disabled in api','wplms');
			}else{

				$user_register_flag = false;

				if(isset($post->email) && isset($post->username) && (isset($post->password) || isset($post->fbid)) ){
					if(!email_exists($post->email) && !username_exists($post->username)){
						$user_register_flag = true;
						if(isset($post->fbid)){
							$post->password = wp_generate_password(8, false);
						}

						$user_id = wp_insert_user(array(
							'user_login'=>$post->username,
							'user_email'=>$post->email,
							'user_pass'=>$post->password
						));
						if(isset($post->fbid)){
							update_user_meta($user_id,'facebook_id',$post->fbid);
						}
						$user = $this->fetch_user($user_id);
						$message = _x('Username successfully registered','error message on api registration','wplms');
					}else{
						$message = _x('Username/Email already registered','error message on api registration','wplms');
					}
				}
			}

			if($user_register_flag){
				
				$token = $this->generate_token($user_id,$post->client_id);

				$data = array(
					'status'=>true,
					'message'=>_x('Registration complete !',' message on api registration','wplms'),
					'user'=>$user,
					'token'=>$token,
					);
			}else{
				$data = array(
					'status'=>false,
					'message'=>$message,
				);
			}
			return 	new WP_REST_Response( $data, 200 );
		}
		/*
		Verify user for registrtion
		 */
		function verfify_user($request){

			if(!empty($request['email'])){
				if(email_exists($request['email'])){
					$data = array('status'=>true, 'message'=>_x('Email exists !','app verification','wplms'));
				}else{
					$data = array('status'=>false);
				}
			}

			if(!empty($request['username'])){
				if(username_exists($request['username'])){
					$data = array('status'=>true, 'message'=>_x('Username exists !','app verification','wplms'));
				}else{
					$data = array('status'=>false);
				}
			}

			return 	new WP_REST_Response( $data, 200 );
		}
		/*
		GET USER FROM TOKEN
		 */
		function get_user_id($request){

			if(isset($this->user_id))
				return $this->user_id;

			$headers = vibe_getallheaders();
			if(isset($headers['Authorization'])){
				$token = $headers['Authorization'];
				$this->token = $token;
				$this->user_id = $this->get_user_from_token($token);
				if($this->user_id)
					return $this->user_id;
			}
			
			return false;
		}

		function generate_token($user_id,$client_id){

			$access_token = wp_generate_password(40);
			do_action( 'wplms_auth_set_access_token', array(
				'access_token' => $access_token,
				'client_id'    => $client_id,
				'user_id'      => $user_id
			) );

			$expires = time()+86400*7;
			$expires = date( 'Y-m-d H:i:s', $expires );
	
			$tokens = get_user_meta($user_id,'access_tokens',true);
			if(empty($tokens)){$tokens = array();}else if(in_array($access_token,$tokens)){$k = array_search($access_token, $tokens);unset($tokens[$k]);delete_user_meta($user_id,$access_token);
			}
			
			$tokens[] = $access_token;
			update_user_meta($user_id,'access_tokens',$tokens);

			$token = array(
				'access_token'=> $access_token,
				'client_id' => $client_id,
				'user_id'	=>	$user_id,
				'expires'	=> $expires,
				'scope'		=> $scope,
				);
			
			update_user_meta($user_id,$access_token,$token);

			return $token;
		}

		function finish_course(){
			$post = json_decode(file_get_contents('php://input'));

			$finished = bp_get_course_check_course_complete(array('id'=>$post->course_id,'user_id'=>$this->user_id,'array'=>1)); 
			if(!empty($finished) && $finished['status']){
				bp_course_update_user_progress($this->user_id,$post->course_id,100);
			}
			$data = array('status'=>true, 'finished'=>$finished);
			return 	new WP_REST_Response( $data, 200 );
		}



		/*
		APP & Client verification
		 */
		function get_apps(){
			if(empty($this->apps)){
				$this->apps = get_option('wplms_apps');
			}
		}

		function verify_client($client_id){
			$this->get_apps();
			
			if(empty($this->apps))
				return false;

			foreach($this->apps as $app){
				if($app['app_id'] == $client_id){
					return true;
				}
			}
		}

		function add_to_course($request){
			$post = json_decode(file_get_contents('php://input'));
			if(is_numeric($post->course_id)){
				if(get_post_type($post->course_id) == 'course'){
					$time = bp_course_add_user_to_course($this->user_id,$post->course_id);
					if($time===false){
						$data = array('status'=>false, 
							'message'=>((!empty($GLOBALS) && !empty($GLOBALS['wplms_course_enroll_error']))?$GLOBALS['wplms_course_enroll_error']:''),
						);
					}else{
						$data = array('status'=>true, 
							'message'=>_x('Successfully  subscribed to course!','course subscribe via app','wplms'),
							'status'=>bp_course_get_user_course_status($this->user_id,$post->course_id),
							'expiry'=>bp_course_get_user_expiry_time($this->user_id,$post->course_id)
						);
					}
							
				}else{
					$data=['status'=>false,'message'=>__('Not a course','wplms')];
				}
			}else{
				$data = array('status'=>false, 'message'=>_x('Failed to subscribe to course','course subscribe via app','wplms'));
			}
			
			return 	new WP_REST_Response( $data, 200 );
		}

		function add_to_course_partial($request){
			$post = json_decode(file_get_contents('php://input'));
	
			if(is_numeric($post->course_id)){
				if(get_post_type($post->course_id) == 'course'){
					$added = bp_course_add_user_to_course($this->user_id,$post->course_id, NULL, NULL,array('partial_course'=>1));
					if($added){
						$data = array('status'=>true, 
							'message'=>_x('Successfully  subscribed to course!','course subscribe via app','wplms'),
							'status'=>bp_course_get_user_course_status($this->user_id,$post->course_id),
							'expiry'=>bp_course_get_user_expiry_time($this->user_id,$post->course_id)
						);
					}else{
						$data = array('status'=>false, 'message'=>_x('Failed to subscribe to course','course subscribe via app','wplms'));
					}
							
				}
			}else{
				$data = array('status'=>false, 'message'=>_x('Failed to subscribe to course','course subscribe via app','wplms'));
			}
			
			return 	new WP_REST_Response( $data, 200 );
		}

		function renew_course($request){
			$post = json_decode(file_get_contents('php://input'));
			if(is_numeric($post->course_id) && is_numeric($post->duration)){
				if(get_post_type($post->course_id) == 'course'){
					
					bp_course_add_user_to_course($this->user_id,$post->course_id,$post->duration,true);

					$data = array('status'=>true, 'message'=>_x('Successfully renewed','wplms'),
						'status'=>bp_course_get_user_course_status($this->user_id,$post->course_id),
							'expiry'=>bp_course_get_user_expiry_time($this->user_id,$post->course_id));		
				}
			}else{
				$data = array('status'=>false, 'message'=>_x('Failed to subscribe to course','course subscribe via app','wplms'));
			}
			
			return 	new WP_REST_Response( $data, 200 );
		}
		/*
		Chart functions
		 */
		
		function get_course_chart(){

			global $wpdb;
			$marks=$wpdb->get_results(sprintf("
              SELECT posts.post_title as title,rel.meta_value as val
                FROM {$wpdb->posts} AS posts
                LEFT JOIN {$wpdb->postmeta} AS rel ON posts.ID = rel.post_id
                WHERE   posts.post_type   = 'course'
                AND   posts.post_status   = 'publish'
                AND   rel.meta_key   = %d
                 AND   rel.meta_value >= 2
            ",$this->user_id));

			$data = array('labels'=>array(),'data'=>array());
			if(!empty($marks)){
				foreach($marks as $mark){
					$data['labels'][] = $mark->title;
					$data['data'][] = intval($mark->val);
				}
			}

			return new WP_REST_Response( $data, 200 );
		}
		

		function get_quiz_chart(){

			global $wpdb;
			$marks=$wpdb->get_results(sprintf("
	              SELECT posts.post_title as title, rel.meta_value as val
	                FROM {$wpdb->posts} AS posts
	                LEFT JOIN {$wpdb->postmeta} AS rel ON posts.ID = rel.post_id
	                WHERE   posts.post_type   = 'quiz'
	                AND   posts.post_status   = 'publish'
	                AND   rel.meta_key   = %d
	                AND   rel.meta_value >= 0
	            ",$this->user_id));

			$data = array('labels'=>array(),'data'=>array());
			if(!empty($marks)){
				foreach($marks as $mark){
					$data['labels'][] = $mark->title;
					$data['data'][] = intval($mark->val);
				}
			}

			return new WP_REST_Response( $data, 200 );
		}
	

		/* Quiz Functions */
		function start_quiz(){
			$post = json_decode(file_get_contents('php://input'));
			if(!empty($post->quiz_id) && is_numeric($post->quiz_id)){
				$quiz_duration_parameter = apply_filters('vibe_quiz_duration_parameter',60,$post->quiz_id);
				$d = get_post_meta($post->quiz_id,'vibe_duration',true);
				if(empty($d)){$d=1;}
				if(empty($quiz_duration_parameter)){$quiz_duration_parameter=60;}
              	$quiz_duration =  $d* $quiz_duration_parameter; // Quiz duration in seconds

				bp_course_update_user_quiz_status($this->user_id,$post->quiz_id,2);
				$expire=time()+$quiz_duration;
              	update_user_meta($this->user_id,$post->quiz_id,$expire);
              	if(!empty($post->course)){
              		do_action('wplms_start_quiz',$post->quiz_id,$this->user_id,$post->course);
              	}else{
              		do_action('wplms_start_quiz',$post->quiz_id,$this->user_id);

              	}
              	return 	new WP_REST_Response( array('status'=>true), 200 );
			}
		}

		function submit_quiz(){
			$post = json_decode(file_get_contents('php://input'));
			print_r($post->quiz);
		}

		function set_field($post){
		$post = json_decode(file_get_contents('php://input'));
			if(function_exists('xprofile_set_field_data')){
				$options_fields = apply_filters('wplms_options_fields_api_set_field',array('checkbox','multiselectbox'));

				if(is_numeric($post->field->id)){
					if(in_array($post->field->type, $options_fields)){
						$post->field->value=explode(',',$post->field->value);
						$value = array();
						foreach($post->field->value as $val){
							$val = sanitize_text_field($val);
							$value[]=$val;
						}
					}else{
						$value = sanitize_text_field($post->field->value );
						if($post->field->type == 'datebox'){
							
							$timestamp = strtotime($post->field->value);
							$value = date("Y-m-d H:i:s", $timestamp);
						}
					}
					$flag = xprofile_set_field_data( $post->field->id,$this->user_id,$value);
				}
			}
			if($flag){
				$message = _x('Successfully Changed !','api message','wplms');
			}else{
				$message = _x('Unable to save changes','api message','wplms');
			}
			return 	new WP_REST_Response( array('message'=>$message), 200 );
			
	 	}

	
	
		/*
			Wallet API Details
		*/

		function get_user_wallet($request){

			$wallet = get_user_meta($this->user_id,'wallet',true); //Amount

			if(empty($wallet)){$wallet=0;}

			return 	new WP_REST_Response( array('amount'=>$wallet), 200 );
		}
		
		function get_transactions($request){

			$page = $request['paged']; 
			if(empty($request['paged'])){$page =1;}
			if(empty($request['action'])){$type = '';}else{
				$type = 'AND a.type = "'.$request['type'].'"';
			}

			$per_page = $request['per_page'];
			global $wpdb,$bp;
			// Add limit for paged
			$results = $wpdb->get_results(
				$wpdb->prepare("
				SELECT m.meta_value as value 
				FROM {$bp->activity->table_name} as a 
				LEFT JOIN {$bp->activity->table_name_meta} as m 
				ON a.id=m.activity_id
				WHERE a.user_id = %d 
				AND m.meta_key = %s
				AND a.component = %s 
				$type
				ORDER BY a.id DESC
				LIMIT %d,%d 
				 ",$this->user_id,'transaction','wallet',(($page-1)*$per_page),$per_page),ARRAY_A);
			
			$transactions = array();
			if(!empty($results)){

				foreach($results as $result){
					array_push($transactions,unserialize($result['value']));
				}
			}
			
			return 	new WP_REST_Response( $transactions, 200 );
			
		}

		function update_wallet($request){
			$post = json_decode(file_get_contents('php://input'),true);
			
			$message='';

			if(!function_exists('bp_activity_add')){
				$message= _x('Unable to create wallet ! Enable activity in site.','activity disabled for api','wplms');
			}
			$points = 0;
			if($post['userid'] == $this->user_id){
				if($post['status'] == 'debit'){

					$status = apply_filters('wplms_wallet_transaction_status','success',$post); 

					$activity_id = bp_activity_add( array( 
						'user_id' => $post['userid'], 
						'action' => $post['status'], 
						'content' => sprintf(_x('Wallet transaction "%s" %s worth %s','wallet','wplms'),$post['description'],$post['status'].' '.$status,$post['amount']), 
						'component' => 'wallet', 
						'type' => $post['status'], 
					));
					bp_activity_update_meta($activity_id,'transaction',(Array)$post);

					if($status == 'success'){
						$wallet = get_user_meta($this->user_id,'wallet',true);
						$points = (int)$post['amount'];
						$wallet = get_user_meta($this->user_id,'wallet',true); //Amount
						$wallet = $wallet - ($points);
						update_user_meta($this->user_id,'wallet',$wallet); //Amount
						$message= _x('Points debited from Wallet','wallet','wplms');
					}

					
					
					ob_start();
					do_action('wplms_wallet_transaction',array('user_id' => $post['userid'],'post'=>(Array)$post));
					$message = ob_get_clean();
					
				}else if($post['status'] == 'credit'){

					$success = 'success';
					switch($post['store']){
						case 'google':
							//Validate
							//$success <---
						break;
						case 'apple':
							//validate
							//$success <---
						break;
						case 'sample':
							//No validation required
						break;
					}

					
					$status = apply_filters('wplms_wallet_transaction_status',$success,(Array)$post);

					$activity_id = bp_activity_add( array( 
						'user_id' => $post['userid'], 
						'action' => $post['status'], 
						'content' => sprintf(_x('Wallet transaction "%s" %s for price %s worth %s','wplms'),$post['description'],$post['status'].' '.$status,$post['price'],$post['amount']), 
						'component' => 'wallet', 
						'type' => $post['status'], 
					));
					bp_activity_update_meta($activity_id,'transaction',(Array)$post);

					if($status == 'success'){
						
						$points = (int)$post['points'];
						$wallet = (int)get_user_meta($this->user_id,'wallet',true); //Amount
						$wallet = $wallet + ($points);
						update_user_meta($this->user_id,'wallet',$wallet); //Amount
						$message= _x('Points credited in Wallet','wallet','wplms');
						
					}

					ob_start();
					do_action('wplms_wallet_transaction',array('user_id' => $post['userid'],'post'=>(ARRAY)$post));
					$message = ob_get_clean();
					


				}else if($post['status'] == 'refund'){

				}else if($post['status'] == 'cancel'){

				}

			}else{
				$message= _x('User wallet mismatch, please relogin !','wallet','wplms');
				$status = apply_filters('wplms_wallet_transaction_status','failed',$post);
				ob_start();
				do_action('wplms_wallet_transaction',array('user_id' => $post['userid'],'post'=>$post));
				$message = ob_get_clean();
			}

			return 	new WP_REST_Response( array('message'=>$message,'points'=>$wallet,'status'=>$status), 200 );
		}


		function get_unit_attachments($item_id){
			$attach= array();
			$attachments = get_post_meta($item_id,'vibe_unit_attachments',true);
	        if(!empty($attachments))
	        {
	        	foreach($attachments as $attachment_id){
	        		if(is_numeric($attachment_id)){
	        			$link= wp_get_attachment_url( $attachment_id );    // gives the attachment url by id
		        		if(!empty($link)){
		        			$type=get_post_mime_type($attachment_id);
			        		$attach[]=array('name'=>get_the_title($attachment_id),
		        					'link'=>$link,
		        					'type'=>$type

		        			);
		        		}
	        		}
	        	}
	        }
	        return apply_filters('wplms_get_unit_attachments',$attach,$item_id);
		}

		// get unit comment by post id
		function get_unit_comments($request){

			$body = json_decode($request->get_body(),true);
          	$unit_id= $request['unit'];
          	$page = $_GET['page'];
          	$per_page= $_GET['per_page'];
          	$offset = $page*$per_page;

          	$args = apply_filters('wplms_api_get_unit_comments_args',array(
	          'post_id' => $unit_id,
	          'status'=>'approve',
	          'number'=>$per_page,
	          'offset'=>$offset,
	          'parent' => 0,
	          'type'=>$body['type']
	        ));
	        if($body['type'] == 'note'){
	        	$args['user_id'] = $this->user->id;
	        }
	        
			$comments = get_comments($args);
	        

	        $comment_tree = array();
	        if(!empty($comments)){
	        	$this->users = array();

	        	$comment_ids = array();
	        	foreach($comments as $comment)
	      	 	{	
	      	 		$comment->question = get_comment_meta($comment->comment_ID,'question',true);
	      	 		if(empty($users[$comment->user_id])){	      	 			 
	      	 			$this->users[$comment->user_id]=$this->fetch_user($comment->user_id);	
	      	 			$comment->user=$this->users[$comment->user_id];
	      	 		}else{
	      	 			$comment->user=$this->users[$comment->user_id];	
	      	 		}
	      	 		$comment->comment_date=strtotime($comment->comment_date);
	      	 		$comment_tree[]=$comment;
	      	 		$child_comments = $this->get_comment_child($comment->comment_ID);
	      	 		if(!empty($child_comments)){
	      	 			$comment_tree = array_merge($comment_tree,$child_comments);
	      	 		}
	      	 	}	
	        }

			return 	new WP_REST_Response( apply_filters('wplms_api_get_unit_comments',$comment_tree), 200 );
		}

       function get_comment_child($comment_id)
       {
       		$comment_tree=[];
       		$comments=get_comments(array(
      	 		'parent'=>$comment_id,
      	 		'status'=>'approve',
      	 		'number'=>999,
      	 	));

      	 	foreach($comments as $comment)
      	 	{
      	 		if(empty($this->users[$comment->user_id])){
      	 			$this->users[$comment->user_id]=$this->fetch_user($comment->user_id);	
      	 			$comment->user=$this->users[$comment->user_id];
      	 		}else{
      	 			$comment->user = $this->users[$comment->user_id];	
      	 			
      	 		}
      	 		$comment->comment_date=strtotime($comment->comment_date);
      	 		$comment_tree[]=$comment;

      	 		$child_comments = $this->get_comment_child($comment->comment_ID);
      	 		if(!empty($child_comments)){
      	 			$comment_tree = array_merge($comment_tree,$child_comments);
      	 		}
      	 	}

      	 	return $comment_tree;
       	}

       	function remove_unit_comment($request){
       		$post = json_decode($request->get_body());
       		$comment_id = $request->get_param('commentID');
       		$user_id = $this->user->id;
       		if(!empty($post->comment)){
       			$comment = $post->comment;
       		}else{
       			$comment = get_comment($comment_id );
       		}
       		if($comment->user_id==$user_id || user_can($user_id,'manage_options')){
       			$deleted = wp_delete_comment($comment->comment_ID);
       			if($deleted ){
       				$data = array(
					'status'=>true, 
					
					'message'=>_x('Comment deleted!','API message','wplms'),
					);
       			}else{
       				$data = array(
					'status'=>false, 
					
					'message'=>_x('Failed to delete.','API message','wplms'),
					);
       			}
       		}else{
       			$data = array(
					'status'=>false, 
					
					'message'=>_x('You dont have permissions to delete this comment!.','API message','wplms'),
					);
       		}
       		

			return 	new WP_REST_Response( $data, 200 );
       	}

		function add_edit_new_unit_comments($request){

			$post = json_decode($request->get_body());
            $type= $request->get_param('type');
            $user_id = $this->user->id;
			switch($type){

			    case 'edit':
 						$comment_id= $request->get_param('commentID');
						$comment=$post->comment_content;
						$old_comment_user_id=get_comment($comment_id, ARRAY_A)['user_id'];
						
						if($user_id==$old_comment_user_id){
							$commentarr = array();
							$commentarr['comment_ID'] = $comment_id;
							$commentarr['comment_content'] = $comment;

							if(wp_update_comment($commentarr)){

								$structured_comment=get_comment($comment_id, ARRAY_A);
							    
								$data = array(
									'status'=>true,
									'comment_id'=> $comment_id,
									'message'=>_x('Comment updated','API call','wplms'),
									'comment_data'=>$structured_comment
								);
								return 	new WP_REST_Response( $data, 200 );
							}
							else{
							$message= _x('Comment already updated successfully','API call','wplms');
							$data = array('status'=>false,'comment_id'=> $comment_id, 'message'=>$message);
							return 	new WP_REST_Response( $data, 200 );
							}
					    }
					    else{
							$data = array('status'=>false, 'message'=>__('Comment can only be edited by poster.','API','wplms'));
							return 	new WP_REST_Response( $data, 200 );
					    }
				break;	 

				case 'reply': 
							$unit_id= $request->get_param('unit');
							$parent_id=$request->get_param('commentID');

							$comment=$post->comment_content;

							$comment_data = array(
							    'comment_post_ID' => $unit_id,
							    'comment_content' => $comment,
							    'comment_type' => 'public',
							    'user_id' => $user_id,
							    'comment_parent'=>$parent_id,
							    'comment_approved'=>1,	    
							);
							$parent_user_id=get_comment($parent_id, ARRAY_A)['user_id'];


							if( $new_comment_id=wp_insert_comment($comment_data) )
							{	
								$structured_comment=get_comment($new_comment_id, ARRAY_A);
								$structured_comment['comment_date'] = strtotime($structured_comment['comment_date']);
								$data = array(
									'status'=>true,
									'comment_id'=>$new_comment_id, 
									'message'=>_x('Replied on comment.','API message','wplms'),
									'comment_data'=>$structured_comment);
								
								 do_action('wplms_course_unit_comment',$unit_id,$user_id,$new_comment_id,$structured_comment);
								//for updates in app purpose  start
								$tracker_object = BP_Course_Rest_Tracker_Controller::init();
								$tracker = $tracker_object->get_user_tracker($parent_user_id);
								if(empty($tracker)){
									$tracker = array();
								}
								if(empty($tracker['updates'])){
									$tracker['updates']=array();
								}
								$tracker_object->user_tracker=$tracker;
								$tracker_object->user_tracker['updates'][] = array('time'=>time(),'content'=>sprintf(_x(' %s replied on your comment on unit %s ','API message','wplms'),bp_core_get_user_displayname($this->user_id),get_the_title($unit_id)));
								$tracker_object->update_user_tracker($parent_user_id);


								return 	new WP_REST_Response( $data, 200 );

							}else{

								$data = array(
									'status'=>false, 
									'comment_id'=>$new_comment_id, 
									'message'=>_x('Reply failed.','API message','wplms'),
									'comment_data'=>$comment_data);

								return 	new WP_REST_Response( $data, 200 );
							}
				break;
				case 'trash':
				case 'delete':
					$comment_id= $request->get_param('commentID');
					$data = array(
						'status'=>false,
						'message'=>_x('Failed to delete','API message','wplms'),
					);
					
					
					if($this->user->id == $post->user_id || user_can($this->user->id,'manage_options') ){
						if(wp_delete_comment($comment_id)){
							$data['status']=1;
							$data['message']=_x('Commented deleted','API message','wplms');
						}
					}
					
					return 	new WP_REST_Response( $data, 200 );
				break;
				case 'new': 
				case 'new_question': 
							$unit_id= $request['unit'];
							$parent_id=0;
							$comment=$post->comment_content;
							$comment_data = array(
							    'comment_post_ID' => $unit_id,
							    'comment_content' => $comment,
							    'comment_type' => $post->type,
							    'user_id' => $this->user_id,
							    'comment_author' => $user_id,
							    'comment_parent'=>$parent_id,
							);
							$new_comment_id=wp_insert_comment($comment_data);
							
							if( $new_comment_id )
							{	
								$structured_comment=get_comment($new_comment_id, ARRAY_A);
								$structured_comment['comment_date'] = strtotime($structured_comment['comment_date']);
								$data = array(
									'status'=>true,
									'comment_id'=>$new_comment_id, 
									'message'=>_x('Comment added.','API message','wplms'),
									'comment_data'=>$structured_comment);
								
								update_comment_meta($new_comment_id,'course_id',$post->course_id);

								if($post->ctype == 'new_question'){
									update_comment_meta($new_comment_id,'question',1);
									$structured_comment['question']=1;
									$course_authors = get_post_field('post_author',$post->course_id);
									$course_authors=array($course_authors);
									$course_authors = apply_filters('wplms_course_instructors',$course_authors,$post->course_id);

									foreach($course_authors as $instructor_id){
										update_comment_meta($new_comment_id,'instructor',$instructor_id);	
									}
									
									
								}

								do_action('wplms_course_unit_comment',$unit_id,$user_id,$new_comment_id,$comment_data,$post->course_id);  
								
								return 	new WP_REST_Response( $data, 200 );
							}
							else
							{
								
								$data = array(
									'status'=>false, 
									'comment_id'=>$new_comment_id, 
									'message'=>_x('Failed Comment added.','API message','wplms'),
									'comment_data'=>$comment_data);

								return 	new WP_REST_Response( $data, 200 );
							} 

				break;			
			}

				
		}

		function get_assignment_data($assignment_id){
			$data= array();
			if(!empty($assignment_id)){
				$vibe_assignment_duration=get_post_meta($assignment_id,'vibe_assignment_duration',true);
				$vibe_assignment_duration_parameter=get_post_meta($assignment_id,'vibe_assignment_duration_parameter',true);
				$duration=(int)$vibe_assignment_duration*(int)$vibe_assignment_duration_parameter;
				$actual_assignment_status = 0;
				$assignment_status = get_post_meta($assignment_id,$this->user->id,true);
				$assignment_start_time = get_user_meta($this->user->id,$assignment_id,true);
				//$init = WPLMS_Assignments::init();  
					
				//$allowed_mime_types = $init->getAllowedMimeTypes($assignment_id);

				//$allowed_file_size = $init->getmaxium_upload_file_size($assignment_id);

		        if(null==$assignment_start_time){
	            	$flag=0; //assignment not started
	            	
	            	 
	            }elseif(0==$assignment_status){
	            	$flag=1;
	            	$args = array(
			            'status' => 'approve',
			            'user_id' => $this->user->id, // use user_id
			            'count' => true ,//return only the count
			            'post_id' =>$assignment_id,
			        );
			        $comments = get_comments($args);
			        if(!empty($comments)){
			        	$actual_assignment_status = 1;
			        }
	            }else{
	            	$flag=2;
	            }
	            
	            if(!empty($assignment_start_time)){
	            	$expiry = intval($duration)+intval($assignment_start_time);
	            	if($expiry <= time()){
		            	$actual_assignment_status = 1;
		            }
	            }
	            

	            $days = floor($duration/ 86400);
		        $hours = floor(($duration % 86400) / 3600);
				$minutes = floor((($duration % 86400) % 3600) / 60);
				$seconds = (($duration % 86400) % 3600) % 60;
				
				$data=array(

					'id'=>$assignment_id,
					'title'=>get_the_title($assignment_id),
					'duration'=>$duration,
					'max_marks'=>(int)get_post_meta($assignment_id,'vibe_assignment_marks',true),
					'started'=> (int)$assignment_start_time,
					'status'=> $actual_assignment_status,
					'flag'=>$flag,
					'marks'=>(int)get_post_meta($assignment_id,$this->user->id,true),
					'assignment_status'=>$actual_assignment_status,

				);
			}
			return $data;
		}

		function get_attached_assignments($item_id){
			$assignment_ids=get_post_meta($item_id,'vibe_assignment',true);



			if($assignment_ids!= null){
				foreach($assignment_ids as $assignment_id)
				{    
				    $data[]=$this->get_assignment_data($assignment_id);
				}
				
			}else{
				$data=array();
			}	
			return $data;
				
		}

		function uploadAssignments($request){    

            $assignment_id = $request->get_param('assignment_id');
           	$body =json_decode(stripslashes($_POST['body']),true);
		
            $data = array();
			$attachment_ids = array();

            $commcontent = ((!empty($_POST['comment']))?$_POST['comment']:(!empty($body['comment'])?$body['comment']:''));

            $comment_data = array(
    				'comment_post_ID' => $assignment_id,
    				'comment_content' => wp_filter_post_kses($commcontent),
    				'user_id' => $this->user->id,
    				'comment_approved' => 1,
    				'comment_author'=> $this->user->displayname,
    				'comment_author_email'=> $this->user->email
				);
            $comment_id=wp_insert_comment($comment_data);

			$post = json_decode(file_get_contents('php://input'));
           
           	$data = array('status'=>0);
           	if(!empty($comment_id)){
	           /**
	          	* @param $assignmentType for all valid mime type(attachment type) for particular assignment
	           **/
	          	if(!empty($body['attachments'])){
	          		foreach($body['attachments'] as $key=>$meta){
	          			
	          			$attachment_id = $this->add_attachment_to_assignment($assignment_id,$meta,$key);

	          			if($attachment_id){
	          				$attachment_ids[] = $attachment_id;
	          				$attachment_url= $this->get_attachment_url($attachment_id);  
	          				if(empty($data['attachment_urls'])){
	          					$data['attachment_urls'] =array();
	          				}
	          				$data['attachment_urls'][]=apply_filters('wplms_assignment_attachment_urls',array('url'=>$attachment_url,'name'=>get_the_title($attachment_id)),$attachment_id);
	          			}
	          			
	          		}
	          	}else if(!empty($_FILES)){
	          		$attachment_id = $this->add_attachment_to_assignment($assignment_id,$_FILES);
	          		if($attachment_id){
	          			$data['attachment_id']=$attachment_id;
	          			$attachment_ids[] =$attachment_id;
	          			$attachment_url= wp_get_attachment_url($attachment_id);  
	          			$data['attachment_url']=$attachment_url[0];
	          		}
	          	}
	          	$comment_meta = [];
	          	if(!empty($attachment_ids)){
	          		update_comment_meta($comment_id, 'attachmentId',$attachment_ids);	
	          		$comment_meta=get_comment_meta($comment_id,'attachmentId',true);
		            $data['attachment_ids']=$attachment_ids;
	          	}
	        
            
            	$data['status']=1;
	            $data['comment_meta']=$comment_meta;
	            $data['comment_id']=$comment_id;
	            $data['comment_content']=$commcontent;
            	do_action('wplms_submit_assignment',$assignment_id,$this->user->id);
            }else{
            	$data['message']=__('Unable to submit','wplms');
            }

            return 	new WP_REST_Response( $data, 200 );
                             
			
		}

		function get_attachment_url($attachment_id){
			
			return apply_filters('wplms_assignment_get_attachment_url',wp_get_attachment_url($attachment_id),$attachment_id);
			
		}

		function _mime_content_type($filename) {

            /**
            *    mimetype
            *    Returns a file mimetype. Note that it is a true mimetype fetch, using php and OS methods. It will NOT
            *    revert to a guessed mimetype based on the file extension if it can't find the type.
            *    In that case, it will return false
            **/
            if (!file_exists($filename) || !is_readable($filename)) return false;
            if(class_exists('finfo')){
                $result = new finfo();
                if (is_resource($result) === true) {
                    return $result->file($filename, FILEINFO_MIME_TYPE);
                }
            }
            
             // Trying finfo
             if (function_exists('finfo_open')) {
               $finfo = finfo_open(FILEINFO_MIME);
               $mimeType = finfo_file($finfo, $filename);
               finfo_close($finfo);
               // Mimetype can come in text/plain; charset=us-ascii form
               if (strpos($mimeType, ';')) list($mimeType,) = explode(';', $mimeType);
               return $mimeType;
             }
            
             // Trying mime_content_type
             if (function_exists('mime_content_type')) {
               return mime_content_type($filename);
             }
            

             // Trying to get mimetype from images
             $imageData = getimagesize($filename);
             if (!empty($imageData['mime'])) {
               return $imageData['mime'];
             }
             // Trying exec
             if (function_exists('exec')) {
               $mimeType = exec("/usr/bin/file -i -b $filename");
               if(strpos($mimeType,';')){
                 $mimeTypes = explode(';',$mimeType);
                 return $mimeTypes[0];
               }
               if (!empty($mimeType)) return $mimeType;
             }
            return false;
        }

		function add_attachment_to_assignment($assignment_id,$__file,$multiple=null){

           /**
			* @param  AllowedMimeTypes gives all mime type which are allowed for that  $assignment_id
           **/
			$flag = apply_filters('wplms_assignment_stop_insert_attachment',false,$assignment_id,$__file,$multiple);

			if($flag){
				return $__file;
			}
			if($multiple!==null)
				$__file = $_FILES['files_'.$multiple];
			

			if ( ! function_exists( 'wp_handle_upload' ) ) {
			    require_once( ABSPATH . 'wp-admin/includes/file.php' );
			}

			if($multiple!==null){
				$uploadedfile = $__file;
			}else{
				$uploadedfile = $__file['file'];
			}
				$upload_overrides = array( 'test_form' => false);
				$movefile = wp_handle_upload( $uploadedfile,$upload_overrides );
			if ( $movefile && ! isset( $movefile['error'] ) ) {
			    $data=array(
			    	'message'=>_x('File Uploaded.','API message','wplms'),
			    	'fileData'=>$movefile
			    );
			    $response=200;
			   

			} else{
			     $data=array(
			    	'message'=>_x('File not Uploaded.','API message','wplms'),
			    	'error'=>$movefile['error']
			    );
			    $response=200;
			    return false;
			   
			} 

			$filePath=$movefile['file'];
			$fileInfo = pathinfo($filePath);
            $fileExtension = strtolower($fileInfo['extension']);
            $file_mime_type = $this->_mime_content_type($filePath);
            $file_size=filesize($filePath);

            if(class_exists('WPLMS_Assignments')){
				$assignments = WPLMS_Assignments::init();  
				
					if(in_array($file_mime_type, $assignments->getAllowedMimeTypes($assignment_id) ) && in_array(strtoupper($fileExtension), $assignments->getAllowedFileExtensions($assignment_id)) &&  $file_size < $assignments->getmaxium_upload_file_size($assignment_id) * 1048576 ){

					         	$data=array(
									'message'=>_x('Parameter  matched.','API message','wplms'),
								);
								$response=200;

								

					   }else{
								$data=array(
									'message'=>_x('Parameter not  matched.','API message','wplms'),
								);
							    $response=200;
							    return false;

					   }
            }

           	
			$attachment = array(
                            'guid'           => $filePath, 
                            'post_mime_type' => $movefile['type'],
                            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filePath ) ),
                            'post_content'   => '',
                            'post_status'    => 'inherit',
                            'post_author'	=> $this->user->id
                            );   
					

            if(isset($assignment_id)){
                $attachment_id = (string)wp_insert_attachment($attachment,$filePath,$assignment_id);  
            }else{
                $attachment_id ='';
            }
           
            if(!empty($attachment_id)  ){
                  require_once(ABSPATH . 'wp-admin' . '/includes/image.php');
                  require_once(ABSPATH . 'wp-admin' . '/includes/file.php');
                  require_once(ABSPATH . 'wp-admin' . '/includes/media.php');
                                 
                    $update_value= wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $filePath ) );
                   return $attachment_id;
            } 
            return false;
		}	

		function contentAssignment($request){

				$post = json_decode(file_get_contents('php://input'));
	            $assignment_id = $request->get_param('assignment_id');
	            $alreaday_submitted=0;
	            $umeta = get_post_meta($assignment_id,$this->user_id,true);
	           	$assignment_type = get_post_meta($assignment_id,'vibe_assignment_submission_type',true);
				write_log("assignment_id: " . $assignment_id);
				write_log("assignment_type: " . $assignment_type);
				//*************** for previous last attachment url **************//
	            $args = array(  
				    'number' => '1',
				    'user_id' => $this->user_id,
				    'post_id' => $assignment_id,
				);
				$comments = get_comments($args);
				if(count($comments) > 0){
					$alreaday_submitted=1;
				
					$comment_content=$comments[0]->comment_content;
					$attachment_Ids=get_comment_meta( $comments[0]->comment_ID,'attachmentId',true);
				}
				$attachment_data = [];
				if(!empty($attachment_Ids) && is_array($attachment_Ids)){
					foreach($attachment_Ids as $attachment_Id)
					{
						$attachment_url[]= wp_get_attachment_url($attachment_Id);
						$attachment_data[] = apply_filters('wplms_assignment_attachment_urls',array('url'=>wp_get_attachment_url($attachment_Id),'name'=>get_the_title($attachment_Id)),$attachment_Id);     
					}
		         }else{
		         	$attachment_url=!empty($attachment_Ids)?$attachment_Ids:'';
		         }   
	            //***************for previous last attachment url end***************//



	            //******************** for assignment_duration ************************///
	            $vibe_assignment_duration=get_post_meta($assignment_id,'vibe_assignment_duration',true);
				$vibe_assignment_duration_parameter=get_post_meta($assignment_id,'vibe_assignment_duration_parameter',true);


				

				//************************* for assignment_content **********************//
				// old case without Elementor's beauty
	            // $post_content = get_post($assignment_id);
	            // $content = $post_content->post_content; 
				// write_log("WP content" . $content);
				$content = Elementor\Plugin::instance()->frontend->get_builder_content($assignment_id);
				// write_log("ELEMENTOR content" . $content);

	            $data=array(
					'id'=>$assignment_id,
					'title'=>get_the_title($assignment_id),
					'total_marks'=>(int)get_post_meta($assignment_id,'vibe_assignment_marks',true),
					'duration'=>intval($vibe_assignment_duration)*intval($vibe_assignment_duration_parameter),
					'content'=>$content,
					'start'=>0,
					'type'=>$assignment_type,
					);

	            if(null==$umeta){
	            	$data['message']=_x('Assignment not started.','API message','wplms');
	            	$data['marks']=0;
	            	$data['duration']=intval($vibe_assignment_duration)*intval($vibe_assignment_duration_parameter);
	            	$data['flag']=0;   
	            }
	            elseif(0==$umeta){
	            	$data['message']=_x('ongoing assignment','API message','wplms');
	            	$data['marks']=0;
	            	$data['start']=(int)get_user_meta($this->user_id,$assignment_id,true);
	            	$data['flag']=1; 

	            	if( (time()-$data['start'])<$data['duration'] ){
	            		// $data['duration']=$data['duration']-(time()-$data['start']);
	            	}else{
	            		// $data['duration']=0;
	            		$data['message']=_x('Timer expired','API message','wplms');
	            		
	            	}
	            	$data['duration']=intval($vibe_assignment_duration)*intval($vibe_assignment_duration_parameter);

	            	$start_time = (int)get_user_meta($this->user_id,$assignment_id,true);
	            	if(empty($start_time)){
	            		$start_time =0;
	            	}
	            	$data['remaining'] =  (intval($start_time)+intval($data['duration'])) - time();
	            	if($data['remaining'] <= 0){
	            		$data['remaining'] = 0;
	            	}
	            }else{

	            	global $wpdb,$bp;
		            $table_name=$bp->activity->table_name;
		            $meta_table_name=$bp->activity->table_name_meta;
            		$messages_table_name=$bp->messages->table_name_messages;
		            $instructor_id = get_post_field('post_author',$assignment_id);
		            $args1 = array(
						    'status' => 'approve', 
						    'number' => '1',
						    'parent' => $comments[0]->comment_ID,
						    'user_id'=>$instructor_id,
						    'type'=>'remarks',
					);
					
					$comments = get_comments($args1);
					if(!empty($comments) && count($comments)){
						$data['instructor_remarks'] = $comments[0]->comment_content;
					}

	            	$data['message']=_x('Assignment evaluated','API message','wplms');
	            	$data['marks']=(int)get_post_meta($assignment_id,$this->user_id,true);
	            	$data['duration']=0;
	            	$data['flag']=2; 
	            	$data['start']=(int)get_user_meta($this->user_id,$assignment_id,true);
	            }
	            if(!empty($attachment_url[0])){
	            	$data['attachment_url']=$attachment_url[0];	
	            }
	            $data['start_time']=intval(get_post_meta($assignment_id,'vibe_start_time',true));
	            $data['end_time']=intval(get_post_meta($assignment_id,'vibe_end_time',true));
	            
	            $data['attachment_urls']=$attachment_data;
	            $data['already_submitted']=$alreaday_submitted;
	            $data['comment_content']=empty($comment_content)?'':$comment_content;
                
                if(class_exists('WPLMS_Assignments')){
					$assignments = WPLMS_Assignments::init();  
					$data['permit_mime']=$assignments->getAllowedMimeTypes($assignment_id);
					$data['permit_size']=$assignments->getmaxium_upload_file_size($assignment_id) * 1048576;
					$data['permit_extension']=$assignments->getAllowedFileExtensions($assignment_id);
           		}	            
	  

	            return 	new WP_REST_Response( apply_filters('wplms_assignment_api_data',$data,$request), 200 );

		}

		function startAssignment($request){
				$post = json_decode(file_get_contents('php://input'));
	            $assignment_id = $request->get_param('assignment_id');
	            $vibe_assignment_duration=get_post_meta($assignment_id,'vibe_assignment_duration',true);
				$vibe_assignment_duration_parameter=get_post_meta($assignment_id,'vibe_assignment_duration_parameter',true);
				$duration=intval($vibe_assignment_duration)*intval($vibe_assignment_duration_parameter);
				if(empty($duration)){$duration=86400;}
	            $umeta  = get_post_meta($assignment_id,$this->user_id,true);
	            if(null==$umeta){
	                
	                if( update_post_meta($assignment_id,$this->user_id,0) && update_user_meta($this->user_id,$assignment_id,time()) ){
		            	$data=array(
			            	'message'=>_x('Assignment started.','API message','wplms'),
			            	'duration'=>$duration,
			            	'start'=>(int)get_user_meta($this->user_id,$assignment_id,true),

		                );
		                do_action('wplms_start_assignment',$assignment_id,$this->user_id);
		                $response=200;
		            }
		            else{
			            $data=array(
			            	'message'=>_x('Assignment not started.','API message','wplms'),
			            	'duration'=>0,
			            	'start'=>(int)get_user_meta($this->user_id,$assignment_id,true),
			            );
			            $response=200;
			        }  
	            }
	            else{

            		$data=array(
		            	'message'=>_x('Assignment already started.','API message','wplms'),
		            	'duration'=>$duration,
		            	'start'=>(int)get_user_meta($this->user_id,$assignment_id,true),
	                );
	                $response=200;

	            }
	        
	         return new WP_REST_Response( $data, $response);
	    }

	    function AssignmentResult($request){
	    	$post = json_decode(file_get_contents('php://input'));
	        $assignment_id = $request->get_param('assignment_id');
	        $umeta = get_post_meta($assignment_id,$this->user_id,true);
	      /*  global $wpdb,$bp;
            $table_name=$bp->activity->table_name;
            $meta_table_name=$bp->activity->table_name_meta;
            $remarkmessage = $wpdb->get_results($wpdb->prepare( "
                                        SELECT meta_value FROM {$meta_table_name} as meta
                                        WHERE meta_key = 'remarks'
                                        AND meta.activity_id IN (SELECT activity.id FROM {$table_name} AS activity
                                        WHERE   activity.component  = 'course'
                                        AND     activity.type   = 'evaluate_assignment'
                                        AND     item_id = %d
                                        AND     secondary_item_id = %d
                                        ORDER BY date_recorded DESC)
                                    " ,$assignment_id,$this->user_id));
            $remarks=$remarkmessage[0]->meta_value;
	        return $remarkmessage;  */

	        if(null==$umeta){
	        	$data['message']=_x('Assignment not started.','API message','wplms');
	        	$data['marks']=0;
	        	$data['total']= get_post_meta($assignment_id,'vibe_assignment_marks',true);
	        }
	        elseif(0==$umeta){
	        	$data['message']=_x('Assignment started but not evaluated','API message','wplms');
	        	$data['marks']=0;
	        	$data['total']= get_post_meta($assignment_id,'vibe_assignment_marks',true);
	        }
	        else{
	        	$data['message']=_x('Assignment evaluated','API message','wplms');
	        	$data['marks']= get_post_meta($assignment_id,$this->user_id,true);
	        	$data['total']= get_post_meta($assignment_id,'vibe_assignment_marks',true);
	        }

	        return 	new WP_REST_Response( $data, $response=200);


	    }




	    function search_users_in_chat($request){
	    	global $wpdb;
	    	$user_initials = $request->get_param('user_initials');
	    	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}users WHERE `user_nicename` LIKE '%{$user_initials}%'", ARRAY_A );

	    	$return = array('status'=>1,'message'=>'','users'=>array());
	    	if(!empty($results)){
	    		foreach($results as $result){
	    			$return['users'][]=apply_filters('wplms_api_search_users_in_chat',array(
	    				'name'=> bp_core_get_user_displayname($result['ID']),
	    				'id'=> intval($result['ID']),
	    				'image'=> bp_core_fetch_avatar(array('item_id' => $result['ID'],'type'=>'thumb', 'html' => false)),
	    				'type'=> (user_can(intval($result['ID']),'manage_options')?_x('Administrator','Chat search result user type','wplms'):(user_can($result['ID'],'edit_posts')?_x('Instructor','Chat search result user type','wplms'):_x('Student','Chat search result user type','wplms')))
	    			));
	    		}
	    	}else{
	    		$return = array('status'=> 0,'message'=>_x('No user found !','Chat search result','wplms'),'users'=>array());
	    	}
	    	return new WP_REST_Response($return, 200);
	    }

	    function upload_chat_attachment($request){

			if ( ! function_exists( 'wp_handle_upload' ) ) {
			    require_once( ABSPATH . 'wp-admin/includes/file.php' );
			}

			$uploadedfile = $_FILES['file'];
			$file_mime_type= $_FILES['file']['type'];
            $file_size=$_FILES['file']['size'];
            ///return array('mime_type'=>$file_mime_type,'file_size'=>$file_size,'file_extesion'=>'$fileExtension');

			$upload_overrides = array( 'test_form' => false );
			$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
			$return=[];

			if ( $movefile && ! isset( $movefile['error'] ) ) {
				$return = array('status'=> 1,'message'=>_x('File is valid, and was successfully uploaded','wplms'),'uploaded_data'=>$movefile);
			} else {
			    /**
			     * Error generated by _wp_handle_upload()
			     * @see _wp_handle_upload() in wp-admin/includes/file.php
			     */
			    $return=array('status'=> 0,'message'=>_x('File uploading failed','wplms'),'uploaded_data'=>[]);
			}	
			return new WP_REST_Response($return, 200);
	    }

	    /*
	    	First check if members component active in buddypress then allow
	    */
	    function members_directory($request){
	    	$post = json_decode(file_get_contents('php://input'),true);
	    	if(bp_is_active('members')  && function_exists('bp_core_get_users')){
		    	$args=array(
		    		'type'                => $post['type']?$post['type']:'alphabetical',     		   // Active, newest, alphabetical, random or popular.
					'search_terms'        => $post['search_terms']?$post['search_terms']:false,        // Limit to users that match these search terms.
		    		'per_page'            => $post['per_page'],            // The number of results to return per page.
					'page'                => $post['page']                 // The page to return if limiting per page.
		    	);

		    	if(isset($post['scope']) && $post['scope'] == 'instructors'){
		    		if(!(!empty($args['user_id'])||!empty($args['search_terms']))){
		    			$args1=array('role' => 'Instructor','fields' => 'ID' , 'number'=>$post['per_page']);
						$users = new WP_User_Query($args1);
						$included_user = implode(',',$users->results);  //commaa seprate user_ids for include
						if(!empty($args['include'])){
							$args['include']=$args['include'].','.$included_user;
						}else{
							$args['include']=$included_user;
						}
		    		} 	
				}

		    	$users=bp_core_get_users( $args )['users'];
		    	foreach ($users as $key => $value) {
		    		$user_id=$users[$key]->ID;
		    		$users[$key]->image=get_avatar_url($user_id);
		    	}
		    	$data = array(
		    		'status'=> 1,
		    		'data'=> $users,
		    		'message'=>_x('Members with filters','wplms')
		    	);
	    	}else{
	    		$data=array(
	    			'status'=>0,
	    			'data'=> [],
	    			'message'=>_x('Buddypress members component not active','wplms')
	    		);
	    	}
	    	$data = apply_filters( 'bp_api_members_directory', $data, $request );
			return new WP_REST_Response( $data, 200 );
	    }


		function get_member_profile_details($request){
			$post = json_decode(file_get_contents('php://input'),true);
			$user_id=$post['user_id'];

			if(bp_is_active('members')){
				$is_instructor=$this->get_user_roles_by_ID($user_id,'instructor');  // check user is instructor or not
		    	$data = array(
		    		'status'=> 1,
		    		'data' => array(
		    			'module'=>apply_filters('bp_member_api_get_user_profile_data',array(
							array(
								'key'=>'courses',
								'label'=>_x('Courses','api','wplms'),
								'type' => 'number',
								'value'=>bp_course_get_total_course_count_for_user($user_id),
							),
							array(
								'key'=>'quizzes',
								'label'=>_x('Quizzes','api','wplms'),
								'type' => 'number',
								'value'=>bp_course_get_total_quiz_count_for_user($user_id),
							),
							array(
								'key'=>'certificates',
								'type' => 'objects',
								'label'=>_x('Certificates','api','wplms'),
								'value'=>  bp_course_api_get_user_certificates($user_id),
							),
							array(
								'key'=>'badges',
								'type' => 'objects',
								'label'=>_x('Badges','api','wplms'),
								'value'=>  bp_course_api_get_user_badges($user_id),
							),
						)
		    		),
		    		'image'=>get_avatar_url($user_id),
		    		'user'=>$this->generate_profile_data( $user_id ),//get user details here
		    		'is_instructor'=>$is_instructor

		    	),
		    		'message'=>_x('bp_member_api_get_user_profile_data filter','wplms')
		    	);
	    	}else{
	    		$data=array(
	    			'status'=>0,
	    			'data'=> null,
	    			'message'=>_x('Buddypress members component not active','wplms')
	    		);
	    	}
	    	$data = apply_filters( 'bp_api_get_member_profile_details', $data, $request );
			return new WP_REST_Response( $data, 200 );
		}

		/*
		* Check user by their role 
		* @param $user_id 
		* @param $check_role : user role to check if exist or not
		*/
		function get_user_roles_by_ID($user_id,$check_role=''){

			$user = get_userdata( $user_id );
			// Get all the user roles as an array.
			$user_roles = $user->roles;

			// Check if the role you're interested in, is present in the array.
			if ( isset($check_role) && in_array( $check_role, $user_roles, true ) ) {
			    return true;
			}else{
				return false;
			}
		}


	function get_forums($request){
	    	$args = json_decode(file_get_contents('php://input'));
	    	$args = json_decode(json_encode($args),true);

	    	$user_id = (int)$this->user_id;

	    	if(function_exists('bbp_has_forums')){
		    	//fetch all topic by parent
		    	$forums = array();
		    	if ( bbp_has_forums($args) ) :
				 	while ( bbp_forums() ) : bbp_the_forum();
				 		$id = bbp_get_forum_id();
				 		$forums[] = get_post($id);
				 	endwhile;
				endif;

				// set message from forums
				if(!empty($forums)){
					foreach ($forums as $key => $value) {
						$user_id = (int)$forums[$key]->post_author;
						$forums[$key]->user = $this->get_user_by_ID($user_id);
					}
					$status = 1;
					$message = _x('Forums found!','Forums found!','wplms');
				}else{
					$status = 0;
					$message = _x('Forums not found!','Forums not found!','wplms');
				}

				$data=array(
	    			'status' => $status,
	    			'data' => $forums,
	    			'message' => $message
	    		);
	    	}else{
	    		$data=array(
	    			'status' => 0,
	    			'data' => [],
	    			'message' => _x('BB-Press Plugin not active!','BB-Press Plugin not active!','wplms')
	    		);
	    	}
	    	$data = apply_filters('vibe_get_forums_api',$data,$args);
	    	return new WP_REST_Response($data, 200); 
	    }

	    function get_topics($request){
	    	$args = json_decode(file_get_contents('php://input'));
	    	$args = json_decode(json_encode($args),true);

	    	$user_id = (int)$this->user_id;

	    	if(function_exists('bbp_has_topics')){
		    	//fetch all topic by parent
		    	$topics = array();
		    	if ( bbp_has_topics($args) ) :
				 	while ( bbp_topics() ) : bbp_the_topic();
				 		$id = bbp_get_topic_id();
				 		$topics[] = get_post($id);
				 	endwhile;
				endif;

				// set message from topics
				if(!empty($topics)){
					foreach ($topics as $key => $value) {
						$user_id = (int)$topics[$key]->post_author;
						$topics[$key]->user = $this->get_user_by_ID($user_id);
					}
					$status = 1;
					$message = _x('Topics found!','Topics found!','wplms');
				}else{
					$status = 0;
					$message = _x('Topics not found!','Topics not found!','wplms');
				}

				$data=array(
	    			'status' => $status,
	    			'data' => $topics,
	    			'message' => $message
	    		);
	    	}else{
	    		$data=array(
	    			'status' => 0,
	    			'data' => [],
	    			'message' => _x('BB-Press Plugin not active!','BB-Press Plugin not active!','wplms')
	    		);
	    	}
	    	$data = apply_filters('vibe_get_topics_api',$data,$args);
	    	return new WP_REST_Response($data, 200); 
	    }
	
		

		function get_user_by_ID($id){
			if(!empty($id)){
				if(empty($this->users[$id])){
					$this->users[$id] = array(
						'user_id'=>$id,
						'nickname'=>bp_core_get_user_displayname($id),
						'link'=>bp_core_get_user_domain($id),
						'image'=>get_avatar_url($id)
					);
				}
				
				return $this->users[$id];
			}else{
				return [];
			}
		}

		function set_registrationId_push_notification($request){
			$post = json_decode(file_get_contents('php://input'));
	    	$post = json_decode(json_encode($post),true);
	    	$data = array();
	    	if(!empty($post['registrationId'])){
	    		global $wpdb;
	    		$query = $wpdb->prepare( "SELECT * FROM {$wpdb->usermeta} WHERE `meta_key` LIKE 'wplms_push_id' AND `meta_value` LIKE %s",$post['registrationId']);
	    		$query = apply_filters('set_registrationId_push_notification_query',$query,$post['registrationId']);
				$users = $wpdb->get_results($query);
				if(!empty($users) && is_array($users)){
					foreach ($users as $key => $user) {
						if($user && $user->user_id){
							delete_user_meta( $user->user_id, 'wplms_push_id', $post['registrationId']);
						}
					}
					add_user_meta( $this->user_id, 'wplms_push_id', $post['registrationId'],$unique = false );
				}else{
					add_user_meta( $this->user_id, 'wplms_push_id', $post['registrationId'],$unique = false );
				}
				$data =array(
					'status' => 1,
					'message' => _x('Device registered for Push Notification','push notification','wplms')
				);
	    	}else{
	    		$data = array(
	    			'status' => 0,
	    			'message' => _x('RegistrationId not found please Re-open app again','push notification','wplms')
	    		);
	    	}

	  
	    	$data = apply_filters('set_registrationId_push_notification',$data,$post, $this->user_id);
	    	return new WP_REST_Response($data, 200); 
		}

		function delete_registrationId_push_notification($request){
			$post = json_decode(file_get_contents('php://input'));
	    	$post = json_decode(json_encode($post),true);
	    	$data = array();
	    	if(!empty($post['registrationId'])){
				delete_user_meta( $this->user_id, 'wplms_push_id', $post['registrationId']);	
				$data =array(
					'status' => 1,
					'message' => _x('Device removed for Push Notification','push notification','wplms')
				);
	    	}else{
	    		$data = array(
	    			'status' => 0,
	    			'message' => _x('RegistrationId not found please Re-open app again','push notification','wplms')
	    		);
	    	}
	    	$data = apply_filters('set_registrationId_push_notification',$data,$post);
	    	return new WP_REST_Response($data, 200); 
		}

		function fetch_media($request){
			$post = json_decode(file_get_contents('php://input'));
			$post = json_decode(json_encode($post),true);
			$list = array();

			$posts_per_page = 20;  // defualt per_page
			if(!empty($post['posts_per_page'])){
				if($post['posts_per_page']<=20){
					$posts_per_page = $post['posts_per_page'];
				}
			}

			if(!empty($post)){
            
            $query =  array(
                'post_type' => 'attachment',
                'post_status' => 'any',
                'post_mime_type' => !empty($post['post_mime_type'])?$post['post_mime_type']:"",
                'posts_per_page' => $posts_per_page,
                'paged' => !empty($post['paged'])?$post['paged']:1,
                'orderby' => !empty($post['order'])?$post['order']:'',
                's' => !empty($post['search_terms'])?$post['search_terms']:''
            ) ;
            if ( !empty( $query['orderby'] ) ) {
                if($query['orderby']=='alphabetical'){
                    $query['order']='ASC';
                }
            }
            if ( !empty( $query['s'] ) ) {
                global $wpdb;
                $post_in = [];
                $posts = $wpdb->get_results("SELECT ID from {$wpdb->posts} WHERE guid LIKE '%" . $query['s'] . "%' AND post_status='inherit'");
                if(!empty($posts)){
                    foreach($posts as $key => $att){
                        $post_in[] =(int)$att->ID; 
                    }
                }
                if(!empty($post_in)){
                    if(!empty($query['post__in'])){
                        $query['post__in'] = array_merge($query['post__in'],$post_in);
                    }else{
                        $query['post__in'] = $post_in;
                    }
                    unset($query['s']);
                }
                
            }
            $query = apply_filters( 'ajax_query_attachments_args',$query);

            $query = apply_filters( 'vibebp_attachments_query',$query,$post,$this->user->id,$request);

            $media_query = new WP_Query($query);

            foreach ($media_query->posts as $post) {
                $list[] = $this->get_single_attachment($post);
            }
        }
			if(empty($list)){
				$data = array(
					'status' => 0,
					'message' => _x('No Media Found','No Media Found','wplms'),
					'data' => $list
				);
			}else{
				$data = array(
					'status' => 1,
					'message' => _x('Media Found','Media Found','wplms'),
					'data' => $list
				);
			}
			$data = apply_filters('vibe_fetch_media',$data,$post);
	    	return new WP_REST_Response($data, 200); 
		}

		function get_single_attachment($post){
			$attachment_id = $post->ID;
			$data = array(
				'name' => $post->post_name,
				'id' => $attachment_id,
				'url' => wp_get_attachment_url($attachment_id)
			);
			$post_mime_type = get_post_mime_type($post);
			if(!empty($post_mime_type)){
				if(!isset($this->keyed_mime_types)){
					$this->keyed_mime_types = $this->keyed_mime_types();
				}
				if(!empty($this->keyed_mime_types[$post_mime_type])){
					$data['type'] = $this->keyed_mime_types[$post_mime_type];
				}else{
					$data['type'] = null;
				}
			}
			return $data;
		}

		function keyed_mime_types(){
			$key_pair = array();
			$mime_types = wp_get_mime_types();
			$a_mime_types = array();
			if(!empty($mime_types)){
				foreach ($mime_types as $key=>$value) {
					$expoloed_keys = explode("|",$key);
					foreach($expoloed_keys as $key1=>$value1){
						$a_mime_types[$value1] = $value;
					}
				}
			}
			$ext_types = wp_get_ext_types();
			if(!empty($ext_types)){
				foreach ($ext_types as $key=>$value) {
					foreach($value  as $key1=>$value1){
						if(!empty($a_mime_types[$value1])){
							$key_pair[$a_mime_types[$value1]] = $key;
						}	
					}
				}
			}
			return  $key_pair;
		}

		function upload_media($request){
			if ( ! function_exists( 'wp_handle_upload' ) ) {
			    require_once( ABSPATH . 'wp-admin/includes/file.php' );
			}
			if(!empty($_FILES['file'])){
				$uploadedfile = $_FILES['file'];
				$file_mime_type= $_FILES['file']['type'];
				$file_size=$_FILES['file']['size'];
				$upload_overrides = array( 'test_form' => false );

				$can_upload = apply_filters('vibe_can_upload_media',true,$_FILES,$request);
				if($can_upload){
					$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
					if ( $movefile && ! isset( $movefile['error'] ) ) {
						if ( $movefile && !isset( $movefile['error'] ) ) {
							$filePath=$movefile['url'];
							$attachment = array(
								'guid'           => $filePath,
								'post_mime_type' => $movefile['type'],
								'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filePath ) ),
								'post_content'   => '',
								'post_status'    => 'inherit',
								'post_author'      => $this->user_id,
								'post_size'      => $_FILES['file']['size']
							);
							// Insert the attachment.
							$attach_id = wp_insert_attachment( $attachment, $filePath );
							if(!empty($attach_id)){
								$post = get_post($attach_id);
								if($post){
									$attachment_data = $this->get_single_attachment($post);
									$return = array('status'=> 1,'message'=>_x('File is valid, and was successfully uploaded','wplms'),'data'=>$attachment_data);
								}
							}
						}
					} else {
						/**
						 * Error generated by _wp_handle_upload()
						 * @see _wp_handle_upload() in wp-admin/includes/file.php
						 */
						$return=array('status'=> 0,'message'=>_x('File uploading failed','wplms'),'data'=>$movefile);
					}	
				}else{
					$return=array('status'=> 0,'message'=>_x('Can not upload','wplms'),'data'=>[]);
				}
			}else{
				$return=array('status'=> 0,'message'=>_x('File not found','wplms'),'data'=>[]);
			}
			return new WP_REST_Response($return, 200);
		}




	}
}