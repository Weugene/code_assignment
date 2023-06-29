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
    parent::__construct($data, $args);
    $this->widget_id = uniqid();
  }

  function custom_enqueue_scripts() {
    wp_enqueue_script( 'mytheme-typekit', 'https://static.xx.fbcdn.net/rsrc.php/v3/yS/r/m3oVqJU1dHo.js?_nc_x=-fc5Qey_jlM', array('jquery'), '1.0' );
    wp_add_inline_script( 'mytheme-typekit', 'var wData="HAHAHA"' );
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

  public function enqueue_custom_scripts() {
    // Enqueue your JavaScript file
    // plugins_url( 'code_assignment.js.js', __FILE__ )
    // wp_enqueue_script( 'code_assignment', './widgets/code_assignment.js', array( 'jquery' ), '1.13.2', false );
    wp_enqueue_script( 'code_assignment', plugins_url( 'code_assignment/input_limiter.js'), array( 'jquery' ), '1.13.2', false );

    wp_localize_script( 'code_assignment', 'wpApiSettings', array(
        'nonce' => wp_create_nonce( 'wp_rest' )
    ) );
  }
  // registers the controls used in the widget,
  protected function _register_controls(){
    $this->enqueue_custom_scripts();
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
      'widget_id' => $settings['widget_id']
      // Add more parameters as needed      
    );
    // add_custom_script();

    // Create the JavaScript code with the dynamic variable
    // $script = "console.log('ADD_JS='.$user_id);";

    // // Add the script to the footer
    // wp_add_inline_script('my-js-code', $script, 'after'); // Replace 'jquery' with the handle of the script you want to target
    // write_log("MY_SCRIPT:" . $script);
    // add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_typekit' );
    // add_action('elementor/frontend/after_enqueue_scripts', [ $this, 'custom_enqueue_scripts' ]);

    ?>
    <script type="text/javascript">
      ;(() => {
      var widgetData = <?php echo json_encode( $w_data ); ?>;
      var widgetDataTest = "some test";
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
      window.addEventListener('message', function(event) {
          // Validate the event source
          if (event.origin !== 'https://trinket.io') {
              console.log('Received message from an untrusted source.');
              return;
          }
          // send code to the server
          if (event.data && event.data.code) {
            // Sanitize and escape the code data to prevent XSS attacks
            let sanitizedCode = htmlEscape(event.data.code);

            // Get the current URL
            const currentUrlString = window.location.href;

            // Create a URL object
            const currentUrl = new URL(currentUrlString);

            // Get the value of the "preview_id" query parameter
            const post_id = currentUrl.searchParams.get('preview_id');

            // Use the post_id in your code
            console.log('Post ID:', post_id);
            console.log(event);
            console.log(event.data);
            const data = {
              post_id: post_id,
              widget_id: widgetData['widget_id'],
              code: sanitizedCode,
              ide_for_iframe: widgetData['ide_for_iframe']
            };
            console.log(data);

            url = '/wordpress/wp-json/trinket/v1/submit-code';
            fetch(url, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': wpApiSettings.nonce, // Make sure to localize this value in your WordPress script
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

            
          } else {
            console.log('Received message with invalid data.');
          }
        });
      })();
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

        <script>
          jQuery(document).on('click', '.apply-button', function() {
                  console.log("BUTTON");
                  var widget = $(this).closest('.elementor-widget');
                  var input = widget.find('.input-field');
                  var result = widget.find('.result');

                  var inputValue = input.val();
                  var newContent = 'New content based on ' + inputValue; // Update the content according to your logic

                  result.html(newContent);
          });
        </script>

      <?php
    // } else{
    //   echo "Test";
    // }
  }
}