<?php

if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly.
}

class Wplms_Vibe_Carousel extends \Elementor\Widget_Base  // We'll use this just to avoid function name conflicts 
{


    public function get_name() {
		return 'vibe-carousel';
	}

	public function get_title() {
		return __( 'Vibe Carousel', 'wplms' );
	}

	public function get_icon() {
		return 'vicon vicon-layout-slider';
	}

	public function get_categories() {
		return [ 'wplms' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Controls', 'wplms' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Carousel Title', 'wplms' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Enter Carousel Title', 'wplms' ),
			]
		);

		$this->add_control(
			'more_link',
			[
				'label' => __( 'Show More link', 'wplms' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'0' => [
						'title' => __( 'No', 'wplms' ),
						'icon' => 'vicon vicon-close',
					],
					'1' => [
						'title' => __( 'Yes', 'wplms' ),
						'icon' => 'fa fa-check',
					],
				],
			]
		);


		$this->add_control(
			'show_controls',
			[
				'label' =>__('Show Direction arrows', 'wplms'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'0' => [
						'title' => __( 'No', 'wplms' ),
						'icon' => 'vicon vicon-close',
					],
					'1' => [
						'title' => __( 'Yes', 'wplms' ),
						'icon' => 'fa fa-check',
					],
				],
			]
		);

		$this->add_control(
			'show_controlnav',
			[
				'label' =>__('Show Control dots', 'wplms'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'0' => [
						'title' => __( 'No', 'wplms' ),
						'icon' => 'vicon vicon-close',
					],
					'1' => [
						'title' => __( 'Yes', 'wplms' ),
						'icon' => 'fa fa-check',
					],
				],
			]
		);


		$v_post_types = array();
	    $post_types=get_post_types('','objects'); 

	    foreach ( $post_types as $post_type ){
	        if( !in_array($post_type->name, array('attachment','revision','nav_menu_item','sliders','modals','shop','shop_order','shop_coupon','forum','topic','reply')))
	           $v_post_types[$post_type->name]=$post_type->label;
	    }
	    
	    if(!array_key_exists('news',$v_post_types)){
	        $v_post_types['news'] = __('Course News','wplms');
	    }

		$this->add_control(
			'post_type',
			[
				'label' => sprintf(__('Enter Post Type %s (Select Post Type from Posts/Courses/Clients/Products ...)%s', 'wplms'),'<br /><span style="font-size:11px;">','</span>'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'course',
				'options' => $v_post_types,
			]
		);
		$this->add_control(
			'taxonomy',
			[
				'label' => __('Enter relevant Taxonomy name used for Filter buttons (example : course-cat,event-type..)', 'wplms' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'example : course-cat,event-type..', 'wplms' ),
			]
		);
		
		$this->add_control(
			'term',
			[
				'label' => __('Enter Taxonomy Term Slug <br />(optional, only if above is selected, comma separated for multiple terms): ', 'wplms'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Enter Taxonomy Terms', 'wplms' ),
			]
		);

		$this->add_control(
			'post_ids',
			[
				'label' => __('Enter Post Ids', 'wplms'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'url',
				'placeholder' => __( 'Enter comma saparated', 'wplms' ),
			]
		);

		$this->add_control(
			'course_style',
			[
				'label' => __('Course Types [Only for Post type = Course]', 'wplms'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'recent',
				'options' => array(
	                'recent' => 'Recently published',
	                'alphabetical' => 'Alphabetical',
	                'popular' => 'Most Students',
	                'featured' => 'Featured',
	                'rated'  => 'Highest Rated',
	                'reviews' => 'Most Reviews',
	                'start_date' => 'Upcoming Courses (Start Date)',
	                'expired_start_date'=>'Expired Courses (Past Start Date)',
	                'free'=> 'Free Courses',
	                'random' => 'Random'
                ),
			]
		);

		$this->add_control(
			'featured_style',
			[
				'label' => __( 'Featured Style', 'wplms' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => plugins_url('../images/thumb_2.png',__FILE__),
				'options' => apply_filters('vibe_builder_thumb_styles',array(
	                'course' => 'course',
                    'course2' => 'course2',
                    'course3' => 'course3',
                    'course4' => 'course4',
                    'course5' => 'course5',
                    'course6' => 'course6',
                    'course7' => 'course7', 
                    'course8' => 'course8',
                    'course9' => 'course9',
                    'course10' => 'course10',
                    'postblock' => 'postblock',
                    'side'=> 'side',
                    'blogpost' => 'blogpost' ,
                    'images_only'=> 'Images only',
                    'testimonial'=> 'testimonial',
                    'testimonial2'=> 'testimonial2',
                    'event_card'=> 'event_card',
                    'general'=> 'general',
                    'generic'=> 'generic',
                    'simple'=> 'simple',
                    'blog_card'=> 'Blog card',
                    'generic_card'=> 'Generic card',
                )),
			]
		);

		$this->add_control(
			'auto_slide',
			[
				'label' =>__('Auto slide/rotate', 'wplms'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'0' => [
						'title' => __( 'No', 'wplms' ),
						'icon' => 'vicon vicon-close',
					],
					'1' => [
						'title' => __( 'Yes', 'wplms' ),
						'icon' => 'fa fa-check',
					],
				],
			]
		);

		$this->add_control(
			'carousel_max',
			[
				'label' =>__('Number of blocks in Desktop screen', 'wplms'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 12,
				'step' => 1,
				'default' => 4,
			]
		);

		$this->add_control(
			'carousel_min',
			[
				'label' =>__('Number of blocks in Mobile Screen', 'wplms'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 12,
				'step' => 1,
				'default' => 2,
			]
		);

		$this->add_control(
			'carousel_move',
			[
				'label' =>__('Move blocks in one slide', 'wplms'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 12,
				'step' => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'wrap_around',
			[
				'label' =>__('Return to First element after Last', 'wplms'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 12,
				'step' => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'carousel_number',
			[
				'label' =>__('Total Number of Blocks', 'wplms'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 99,
				'step' => 1,
				'default' => 6,
			]
		);

		$this->add_control(
			'carousel_rows',
			[
				'label' =>__('Carousel Rows', 'wplms'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 99,
				'step' => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'carousel_excerpt_length',
			[
				'label' =>__('Excerpt Length in Block (in characters)', 'wplms'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 10,
				'max' => 200,
				'step' => 5,
				'default' => 100,
			]
		);


		$this->add_control(
			'carousel_link',
			[
				'label' => __('Show Link button on image hover', 'wplms'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'0' => [
						'title' => __( 'No', 'wplms' ),
						'icon' => 'vicon vicon-close',
					],
					'1' => [
						'title' => __( 'Yes', 'wplms' ),
						'icon' => 'fa fa-check',
					],
				],
			]
		);


		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		
		
		$shortcode = '[v_carousel 
	    title="'.($settings['title']).'" 
	    show_title="'.(empty($settings['title'])?0:1).'" 
	    show_more="'.(empty($settings['more_link'])?0:1).'" 
	    more_link="'.($settings['more_link']).'" 
	    show_controls="'.($settings['show_controls']).'" 
	    show_controlnav="'.($settings['show_controlnav']).'" 
	    post_type="'.($settings['post_type']).'" 	
	    taxonomy="'.(empty($settings['taxonomy'])?0:$settings['taxonomy']).'" 
	    term="'.(empty($settings['term'])?0:$settings['term']).'" 
	    post_ids="'.($settings['post_ids']).'" 
	    course_style="'.($settings['course_style']).'" 
	    featured_style="'.($settings['featured_style']).'" 
	    auto_slide="'.(isset($settings['auto_slide'])?$settings['auto_slide']:'').'" 
	    column_width="'.(isset($settings['column_width'])?$settings['column_width']:200).'" 
	    carousel_max="'.($settings['carousel_max']).'" 
	    carousel_min="'.($settings['carousel_min']).'" 
	    carousel_move="'.($settings['carousel_move']).'" 
	    carousel_number="'.($settings['carousel_number']).'" 
	    carousel_rows="'.($settings['carousel_rows']).'" 
	    carousel_excerpt_length="'.($settings['carousel_excerpt_length']).'" 
	    carousel_link="'.($settings['carousel_link']).'"] [/v_carousel]';
		
		//echo $shortcode;

		echo do_shortcode($shortcode);
	}

}


