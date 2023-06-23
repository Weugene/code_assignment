<?php
/**
 * Plugin Name: My custom widgets
 * Description: Class of widgets. 
 * Version: 1.0
 * Author: Evgenii Sharaborin
 */
namespace WPC;

// use Elementor\Plugin; ?????

class Widget_Loader{
  // Singleton class
  private static $_instance = null;

  public static function instance()
  {
    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }


  private function include_widgets_files(){
    // list of my custom widgets files
    require_once(plugin_dir_path( __FILE__ ) . '/code_assignment/code_assignment.php');
  }
 
  public function register_widgets(){

    $this->include_widgets_files();
    // list of their initialization
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\CodeAssignment());

  }

  public function __construct(){
    add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets'], 99);
  }
}

// Instantiate Plugin Class
Widget_Loader::instance();
