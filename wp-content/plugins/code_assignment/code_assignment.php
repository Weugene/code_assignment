<?php
/**
 * Plugin Name: Code assignment IDE
 * Description: Trinket user input code extractor. 
 * This plugin extracts the user input code from Trinket iframe and 
 * save it into the wordpress database table. 
 * It allows you to save the story of user input data.
 * Writes "hello world" to the database for the current user
 * Version: 1.0
 * Author: Evgenii Sharaborin
 */
namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly
require_once __DIR__ . '/code_assignment_api.php';


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


class CodeAssignment extends Widget_Base{
  var $assignment_heading = 'assignment_heading';
  var $assignment_content = 'assignment_content';
  var $code_sample = 'code_sample';
  var $code_solution = 'code_solution';
  var $code_language = 'python';
  protected $widget_id;
  protected $apply_button_value = 'no';

  public function __construct($data = [], $args = null) {
    write_log("Starting to construct a widget");
    parent::__construct($data, $args);
    $this->widget_id = uniqid();
    // More details in https://developers.elementor.com/add-javascript-to-elementor-widgets/
    $this->enqueue_custom_scripts();
    write_log("Ending to construct a widget");
  }

  public function get_name(){
    return 'code_assignment';
  }

  public function get_title(){
    return 'Code assignment';
  }

  public function get_icon(){
    return 'eicon-testimonial-carousel';
  }

  public function get_categories(){
    return ['general'];
  }

  public function get_script_depends() {
    return [ 'script-postscribe', 'script-input-limiter' ];
  }

  public function enqueue_custom_scripts() {
    // Enqueue your JavaScript file
    wp_register_script( 'script-postscribe', 'https://cdnjs.cloudflare.com/ajax/libs/postscribe/2.0.8/postscribe.min.js', [ 'elementor-frontend' ], '2.8.0', true );
    wp_register_script( 'script-input-limiter', plugins_url( 'code_assignment/input_limiter.js'), [ 'elementor-frontend' ], '1.0.0', true );
  }

  // registers the controls used in the widget,
  protected function _register_controls(){
    // $this->enqueue_custom_scripts();
    $this->start_controls_section(
      'section_content',
      [
        'label' => 'Условие задания',
      ]
    );
    // $this->add_control(
    //   'apply_button',
    //   [
    //       'label' => esc_html__('Apply Button', 'apply-button'),
    //       'type' => \Elementor\Controls_Manager::BUTTON,
    //       'text' => esc_html__('Apply', 'apply-button'),
    //       'default' => 'no', // Set your desired default value here
    //   ]
    // );
    // list of controls

    $this->add_control(
      $this->assignment_heading,
      [
        'label' => 'Название задания',
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'Название задания'
      ]
    );


    $this->add_control(
      $this->assignment_content,
      [
        'label' => 'Формулировка задания',
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'default' => 'Условие задания.'
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'code_section',
      [
          'label' => 'Секция программного кода',
          'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'ide_for_iframe',
      [
          'label' => 'Среда разработки',
          'type' => \Elementor\Controls_Manager::SELECT,
          'options' => [
              'trinket' => 'Trinket',
              'godbolt' => 'Godbolt',
              // Add more options for other IDEs
          ],
          'default' => 'trinket',
      ]
    );
    
    $this->add_control(
      'language',
      [
          'label' => 'Язык программирования',
          'type' => \Elementor\Controls_Manager::SELECT,
          'options' => [
              'python' => 'Python',
              'cpp' => 'C++',
              'javascript' => 'JavaScript',
              // Add more options for other languages
          ],
          'default' => 'python',
      ]
    );

    $this->add_control(
      'widget_id',
      [
          'label' => 'Widget ID (optional)',
          'type' => \Elementor\Controls_Manager::TEXT,
          'maxlength' => 20,
          'default' => $this->widget_id, // Set a default id (optional)
      ]
    );

    $this->add_control(
      $this->code_sample,
      [
          'label' => 'Заготовка кода',
          'type' => \Elementor\Controls_Manager::CODE,
          'language' => 'python', // Specify the programming language for syntax highlighting (optional)
          'rows' => 10, // Specify the number of rows for the code input area (optional)
          'default' => '', // Set a default code snippet (optional)
      ]
    );
    
    
    $this->add_control(
      $this->code_solution,
      [
          'label' => 'Решения',
          'type' => \Elementor\Controls_Manager::CODE,
          'language' => 'python', // Specify the programming language for syntax highlighting (optional)
          'rows' => 10, // Specify the number of rows for the code input area (optional)
          'default' => '', // Set a default code snippet (optional)
      ]
    );

    $this->end_controls_section();
  }
  
  // PHP renderer generates the final HTML
  protected function render(){
    // widget settings from the elementor sidebar
    $settings = $this->get_settings_for_display();
    $post_id = get_queried_object_id();

    write_log('Current Post ID: ' . $post_id);

    $this->add_inline_editing_attributes($this->assignment_heading, 'advanced');
    // add attributes Key: {Attribute => Value}
    $this->add_render_attribute(
      $this->assignment_heading,
      [
        'class' => ['code_assignment__label-heading'],
      ]
    );
    $this->add_render_attribute(
      'language',
      [
        'class' => ['language-'.$settings['language'] ],
      ]
    );
    global $wpdb;
    $table_name = $wpdb->prefix . 'students_code_table';
    // Retrieve a single row from the table
    $user_id = get_current_user_id();
    $widget_id = $settings['widget_id'];
    $item = $wpdb->get_row(
      $wpdb->prepare(
        "SELECT * FROM $table_name WHERE user_id = %d AND widget_id = %s",
        $user_id,
        $widget_id
      )
    );
    if ($item === null || $item === false) {
      // The query returned an empty result
      // Handle the case when no item is found
        $settings['code_sample_urlencoded'] = rawurlencode($settings[$this->code_sample]);
    } else {
      // The query returned a valid result
      // Access the retrieved item's properties
      $settings['code_sample_urlencoded'] = rawurlencode($item->list_of_codes);
    }
    
    $this->add_render_attribute(
      'iframe_src',
      [
        'src' => ['https://trinket.io/embed/pygame?listen=true#code='.$settings['code_sample_urlencoded']],
        'id' => [$settings['widget_id']],
        'width' => ['100%'],
        'height' => ['356'],
        'frameborder' => ['0'],
        'marginwidth' => ['0'],
        'marginheight' => ['0'],
        'allowfullscreen' => [true]
      ]
    );
    
    // Access widget parameter settings and pass them to the script snippet
    $w_data = array(
      'ide_for_iframe' => $settings['ide_for_iframe'],
      'code' => $settings['code_sample'],
      'widget_id' => $settings['widget_id'],
      'post_id' => $post_id, // useful only inside Elementor environment, not WPLMS
      'nonce' => wp_create_nonce('wp_rest'),
      'autosave_time' => 5000
      // Add more parameters as needed      
    );

    ?>
    <script type="text/javascript" id="code_assignment_script">
      jQuery(document).ready(function($) {
        var widgetData = <?php echo json_encode( $w_data ); ?>;
        var current_widget_id = null;
        var last_widget_id = null;
        var current_code = null;
        var last_code = null;
        // should I put html escape to protect from XSS attack?
        function htmlEscape(input) {
          // return input.replace(/[&<>"'/]/g, function(match) {
          //     switch (match) {
          //         case '&':
          //             return '&amp;';
          //         case '<':
          //             return '&lt;';
          //         case '>':
          //             return '&gt;';
          //         case '"':
          //             return '&quot;';
          //         case "'":
          //             return '&#39;';
          //         case '/':
          //             return '&#x2F;';
          //         default:
          //             return match;
          //     }
          // });
          return input;
        }
        // send code to the server
        function submitCodeToAPI(){
          current_widget_id = document.activeElement.getAttribute("id");
          
          if (current_widget_id != last_widget_id){
            current_code = null;
            last_code = null;
          }
          // check is empty?
          if (current_code != last_code && current_code) {
            // console.log("INSIDE CONDITION!!!");
            // Get the value assignment id from POST_ID_CURRENT
            let post_id = 0;
            if (typeof POST_ID_CURRENT !== 'undefined' && POST_ID_CURRENT){
              post_id = POST_ID_CURRENT;
              console.log("post id is extracted from POST_ID_CURRENT: " + post_id);
            } else if (elementorFrontendConfig.post.id){
              post_id = elementorFrontendConfig.post.id;
              console.log("post id is extracted from elementorFrontendConfig.post.id: " + post_id);
            } else {
              console.log("post_id is not defined!");
            }
            // Sanitize and escape the code data to prevent XSS attacks
            let sanitizedCode = htmlEscape(current_code);
            
            const data = {
              post_id: post_id,
              widget_id: current_widget_id,
              code: sanitizedCode,
              ide_for_iframe: widgetData['ide_for_iframe']
            };
            console.log("Payload:" + JSON.stringify(data, "I don't understand", 4));
            const url_to_submit_code = '/wordpress/wp-json/trinket/v1/submit-code';
            fetch(url_to_submit_code, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': widgetData["nonce"], // Make sure to localize this value in your WordPress script
              },
              body: JSON.stringify(data),
            }).then(response => {
              return response.json();
            }).then(jsonResponse => {
              console.log({jsonResponse})
            }).catch(error => {
              // Handle any errors
              console.error("Some error occured: " + error);
            });
            // save the last code
            last_code = current_code;
            last_widget_id = current_widget_id;
            ca("vibebp").addNotification({
              text: "Code is saved",
            });
          } else {
            // console.log('Received message with invalid data or the same code'); // TODO: comment me
          }
          last_widget_id = current_widget_id;

        }
        // Add only one listener to save code
        window.addEventListener('message', function(event) { // addEventListener
          // Validate the event source
          if (event.origin !== 'https://trinket.io') {
              console.log('Received message from an untrusted source.');
              return;
          }
          console.log(event);
          current_code = event.data.code;
          
          console.log("current_widget_id: " + current_widget_id);
          console.log("current_code: " + current_code);
        });
        setInterval (submitCodeToAPI, widgetData['autosave_time']);
      });
    </script>

    <div class="code_assignment">
      <div <?php echo $this->get_render_attribute_string($this->assignment_heading); ?>>
        <?php echo $settings[$this->assignment_heading] ?>
      </div>
      <div class="code_assignment__content">
        <div class="code_assignment__content_formulation">
          <?php echo $settings[$this->assignment_content] ?>
        </div>
        <iframe 
            <?php echo $this->get_render_attribute_string('iframe_src'); ?>>
        </iframe>
        <div class="code_assignment__content_sample">
          <pre <?php echo $this->get_render_attribute_string('language'); ?>>
            <code><?php echo $settings[$this->code_solution] ?></code>
          </pre>
        </div>
      </div>
    </div>
    <?php
  }

  // JS renderer specifies the data bindings between the widget settings and the HTML elements
  protected function _content_template(){
    $this->add_render_attribute('data-custom-data', 'nonce', wp_create_nonce('wp_rest'));

    // $apply_button = $this->apply_button_value;
    // write_log('Apply-button'.$apply_button );
    // if ($apply_button === 'yes') {
      ?>
        <#
          view.addInlineEditingAttributes( 'assignment_heading', 'advanced' );
          view.addRenderAttribute(
            'assignment_heading',
            {
                'class': [ 'code_assignment__label-heading' ],
            }
          );
          view.addInlineEditingAttributes( 'language', 'advanced' );
          view.addRenderAttribute(
            'language',
            {
                'class': ['language-' + settings.language ],
            }
          );
          let encodedVariable = encodeURIComponent(settings.code_sample);

          view.addInlineEditingAttributes( 'iframe_src', 'advanced' );
          view.addRenderAttribute(
            'iframe_src',
            {
                'id': settings.widget_id,
                'src': 'https://trinket.io/embed/pygame?listen=true#code=' + encodedVariable,
                'width': '100%',
                'height': '356',
                'frameborder': '0',
                'marginwidth': '0',
                'marginheight': '0',
                'allowfullscreen': true
            }
          );
        #>
        <div class="code_assignment">
          <div {{{ view.getRenderAttributeString( 'assignment_heading' ) }}}>{{{ settings.assignment_heading }}}</div>
          <div class="code_assignment__content">
            <div class="code_assignment__content_formulation"> {{{ settings.assignment_content }}}  </div>
            <iframe 
              {{{ view.getRenderAttributeString( 'iframe_src' ) }}}>
            </iframe>
            <div class="code_assignment__content_sample">
              <pre {{{ view.getRenderAttributeString( 'language' ) }}}><code>{{{ settings.code_solution }}}</code></pre>
            </div>
          </div>
        </div>

        <!-- <script>
          jQuery(document).on('click', '.apply-button', function() {
                  console.log("BUTTON");
                  var widget = $(this).closest('.elementor-widget');
                  var input = widget.find('.input-field');
                  var result = widget.find('.result');

                  var inputValue = input.val();
                  var newContent = 'New content based on ' + inputValue; // Update the content according to your logic

                  result.html(newContent);
          });
        </script> -->

      <?php
    // } else{
    //   echo "Test";
    // }
  }
}