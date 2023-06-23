<?php
/**
 * SETTINGS
 *
 * @class       Vibe_Helpdesk_Settings
 * @author      VibeThemes
 * @category    Admin
 * @package     vibe-helpdesk
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



class Vibe_HelpDesk_Settings{


	public static $instance;
	public static function init(){

        if ( is_null( self::$instance ) )
            self::$instance = new Vibe_HelpDesk_Settings();
        return self::$instance;
    }

	private function __construct(){
		
		add_filter('vibebp_settings_tabs',array($this,'add_tab'));
		add_filter('vibebp_settings_type',array($this,'labels_type'),10,2);
		
	}

	function add_tab($tabs){
		if(function_exists('bbpress')){
			$tabs['helpdesk']=__('Helpdesk','vibe-helpdesk');
		}

		return $tabs;
	}

	function settings(){


		echo '<h3>'.__('Helpdesk General Settings','vibe-helpdesk').'</h3>';

		$template_array = apply_filters('vibebp_bbpress_general_settings_tabs',array(
			'general'=> __('General Settings','vibe-helpdesk'),
			//'agents'=> __('Agents','vibe-helpdesk'),
			//'forums'=> __('Forums','vibe-helpdesk'),
		));
		echo '<ul class="subsubsub">';

		if(empty($_GET['sub']) && empty($current)){
			$current = 'general';
		}else if(!empty($_GET['sub']) && empty($current)){
			$current = esc_attr($_GET['sub']);
		}
		foreach($template_array as $k=>$value){
			
			echo '<li><a href="?page='.VIBE_BP_SETTINGS.'&tab=helpdesk&sub='.$k.'" '.(($k == $current)?'class="current"':'').'>'.$value.'</a>  &#124; </li>';
		}
		echo '</ul><div class="clear"><hr/>';

		$vibebp_settings = VibeBP_Settings::init();

		$settings = $this->get_selected_tab_settings_array($current);
		
		$vibebp_settings->vibebp_settings_generate_form('helpdesk',$settings,$current);
		
		
		//register mail template
		$this->new_bp_core_email_register();
	}

	function new_bp_core_email_register(){
		$user_id = get_current_user_id();
		if(!empty($user_id)){
			//assinged_process_name = 'assigned'/'unassigned'
			$post_title = sprintf(__('Topic %s is %s','vibe-helpdesk'),'{{{topic.name}}}','{{{topic.assinged_process_name}}}');  // HTML email content. 
			if ( ! function_exists( 'post_exists' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/post.php' );
			}
			$post_exists = post_exists( $post_title );
			
			if ( $post_exists )
				return;
		
			// Create post object
			$my_post = array(
				'post_title'    => $post_title,
				'post_content'  => sprintf(__('Topic <a href="%s" target="_blank">%s</a> is %s to you by %s','vibe-helpdesk'),'{{{topic.url}}}','{{{topic.name}}}','{{{topic.assinged_process_name}}}','{{{topic.assigned_by_name}}}'),  // HTML email content.
				'post_excerpt'  => sprintf(__('Topic <a href="%s" target="_blank">%s</a> is %s to you by %s','vibe-helpdesk'),'{{{topic.url}}}','{{{topic.name}}}','{{{topic.assinged_process_name}}}','{{{topic.assigned_by_name}}}'),  // HTML email content.
				'post_status'   => 'publish',
				'post_type' => bp_get_email_post_type(),
				'post_author' => $user_id
			);
		
			$post_id = wp_insert_post( $my_post );
		
			if ( $post_id ) {
				$tt_ids = wp_set_object_terms( $post_id, 'vibe_helpdesk_topic_assign', bp_get_email_tax_type() );
				foreach ( $tt_ids as $tt_id ) {
					$term = get_term_by( 'term_taxonomy_id', (int) $tt_id, bp_get_email_tax_type() );
					wp_update_term( (int) $term->term_id, bp_get_email_tax_type(), array(
						'description' => __( 'Helpdesk Topic assign process', 'vibe-helpdesk' ),
					) );
				}
			}
		}
	}

	function get_selected_tab_settings_array($tab){
		
		$settings = array();
		global $wpdb;
		$forums=[''=>__('Select forum','vibe-helpdesk')];
		$allforums = $wpdb->get_results("SELECT ID,post_title FROM {$wpdb->posts} WHERE post_type='forum'");
		if(!empty($allforums)){
			foreach($allforums as $forum){
				$forums[$forum->ID]=$forum->post_title;
			}
		}
		
		switch($tab){

			case 'agents':
				$settings = apply_filters('vibebp_helpdesk_agent_settings',array(
					array(
						'label'=>__('Agents','vibe-helpdesk'),
						'type'=> 'heading',
						'name'=>'agents'
					),
					array(
						'label' => __('Agent User Role','vibe-helpdesk'),
						'name' => 'bbp_agents',
						'type' => 'member_type',
						'desc' => __('User role who are classified as agents','vibe-helpdesk'),
						'default'=>''
					),
					array(
						'label' => __('Supervisor Ticket User Role','vibe-helpdesk'),
						'name' => 'bbp_supervisor',
						'type' => 'member_type',
						'desc' => __('User role who are can assign tickets to agents','vibe-helpdesk'),
						'default'=>''
					),
				));
			break;
			case 'forums':
				$settings = apply_filters('vibebp_helpdesk_forums_settings',array(
					array(
						'label'=>__('Labels','vibebp' ),
						'type'=> 'heading',
						'name'=>'labels'
					),
					array(
						'label' => __('Select Topic Labels','vibe-helpdesk'),
						'name' => 'bbp_labels',
						'type' => 'labels',
						'cpt'  => 'forum',
						'desc' => '',
						'default'=>150
					),
				));
			break;
			case 'general':

				$settings = apply_filters('vibebp_helpdesk_general_settings',array(
					array(
						'label'=>__('General Settings','vibebp' ),
						'type'=> 'heading',
						'name'=>'general'
					),
					array(
						'label' => __('Who can create a new Forum','vibe-helpdesk'),
						'name' => 'create_forum_member_type',
						'type' => 'member_type',
						'desc' => __('Who can create new Forum.','vibe-helpdesk'),
					),
					array(
						'label' => __('Private BBPress','vibe-helpdesk'),
						'name' => 'bbp_private',
						'type' => 'checkbox',
						'value' => 1,
						'desc' => __('Forums are not publically accessible.','vibe-helpdesk'),
					),
					array(
						'label' => __('Global Parent BBPress Forum','vibe-helpdesk'),
						'name' => 'bbp_parent_forum',
						'type' => 'select',
						'options' => $forums,
						'desc' => __('Global parent forum for all sub forums created programmatically','vibe-helpdesk'),
					)
				));
			break;
		}
		return $settings;
	}

				
	function labels_type($return,$setting){

		if($setting['type'] != 'labels')
			return $return;

		echo '<th scope="row" class="titledesc"><label>'.$setting['label'].'</label></th>';
		echo '<td class="forminp"><a class="button-primary repeatable_label" data-type="label" 
			data-cpt="'.$setting['cpt'].'" 
			data-field="'.$setting['name'].'">+</a>
			<ul id="'.$setting['name'].'"></ul>
			<input type="hidden" class="vibebp_settings_labels" name="'.$setting['name'].'" 
			value=""/><span>'.$setting['desc'].'</span></td><script>
			var '.$setting['name'].'='.json_encode($setting['value']).';
			</script>';
			
		wp_enqueue_script('vibe_helpdesk_settings',plugins_url('../assets/js/main.js',__FILE__),array('jquery'),VIBEHELPDESK_VERSION,true);
		return 1;
	}

}
Vibe_HelpDesk_Settings::init();

function helpdesk(){
	$settings = Vibe_HelpDesk_Settings::init();
	$settings->settings();
}