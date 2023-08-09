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


abstract class Iframe_SUOT {
  public $name = null;
  public $src = null;
  public $id = null;
  public $width = '100';
  public $height = '356';
  public function __construct($data) {
    write_log("Construct a Iframe_SUOT base ");
    $this->name = $data['name'];
    $this->src = $data['src'];
    $this->id = $data['id'];
    $this->width = isset($data['width']) ? $data['width'] : $this->width;
    $this->height = isset($data['height']) ? $data['height'] : $this->height;
    write_log("Finished a Iframe_SUOT base ");
  }
  final public function iframe_name(){
    return $this->name;
  }
  abstract public function generate_iframe_attributes($settings);
}

class Trinket_SUOT extends Iframe_SUOT{
  public $frameborder = '0';
  public $marginwidth = '0';
  public $marginheight = '0';
  public $allowfullscreen = true;

  public function __construct($data) {
    $data['name'] = 'trinket-iframe';
    write_log("Trinket constructor");
    parent::__construct($data);
    $this->frameborder = isset($data['frameborder']) ? $data['frameborder'] : $this->frameborder;
    $this->marginwidth = isset($data['marginwidth']) ? $data['marginwidth'] : $this->marginwidth;
    $this->marginheight = isset($data['marginheight']) ? $data['marginheight'] : $this->marginheight;
    $this->allowfullscreen = isset($data['allowfullscreen']) ? $data['allowfullscreen'] : $this->allowfullscreen;
    write_log("Finished Trinket constructor");
  }

  // useful to generate attributed for iframe
  public function generate_iframe_attributes($settings){
    return [
      'src' => ['https://trinket.io/embed/pygame?listen=true#code='.$settings['code_sample_urlencoded']],
      'id' => [$settings['widget_id']],
      'class' => ['iframe-suot'],
      'ide' => [$this->name],
      'width' => [$this->width . "%"],
      'height' => [$this->height],
      'frameborder' => [$this->frameborder],
      'marginwidth' => [$this->marginwidth],
      'marginheight' => [$this->marginheight],
      'allowfullscreen' => [$this->allowfullscreen],
    ];
  }

  // useful to generate attributed for iframe
  public function generate_iframe_attributes_for_elementor_js(){
    echo "{
      'id': settings.widget_id,
      'class': ['iframe-suot'],
      'ide': settings.ide_for_iframe,
      'src': 'https://trinket.io/embed/pygame?listen=true#code=' + encodedVariable,
      'width': settings.width + '%',
      'height': settings.height,
      'frameborder': '0',
      'marginwidth': '0',
      'marginheight': '0',
      'allowfullscreen': true,
    }";
  }

}


class CodeAssignment extends Widget_Base{
  protected $assignment_heading = 'assignment_heading';
  protected $assignment_content = 'assignment_content';
  protected $code_sample = 'code_sample';
  protected $code_solution = 'code_solution';
  protected $autograder_input = 'autograder_input';
  protected $code_language = 'python';
  protected $widget_id;
  protected $apply_button_value = 'no';
  protected $iframeObj = null;
  private static $counter = 0;

  public function __construct($data = [], $args = null) {
    write_log("Starting to construct a CodeAssignment widget");
    parent::__construct($data, $args);
    $this->widget_id = uniqid(); // TODO: FIX BUG!!!
    $settings = [
      'ide_for_iframe' => 'trinket-iframe',
      'code_sample_urlencoded' => 'print%28%22Hello%20world%22%29',
      'widget_id' => $this->widget_id,
      'width' => '100%',
      'height' => '400'
    ];
    $this->create_iframe_object($settings);
    // write_log("IN CONSTRUCTOR:");
    // write_log(get_object_vars($this));
    // Generate the widget ID
    self::$counter++;
    
    write_log("counter: ".self::$counter);
    // More details in https://developers.elementor.com/add-javascript-to-elementor-widgets/
    $this->enqueue_custom_scripts();
    write_log("Ending to construct a CodeAssignment widget");
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
    return [ 'script-postscribe', 'script-input-limiter', 'tsparticles-confetti', 'tsparticles-preset-fireworks' ];
  }

  public function get_style_depends() {
		return [ 'code-assignment-css' ];
	}

  public function enqueue_custom_scripts() {
    wp_enqueue_script('script-postscribe', 'https://cdnjs.cloudflare.com/ajax/libs/postscribe/2.0.8/postscribe.min.js', array(), '2.0.8', true  );
    wp_register_script( 'script-input-limiter', plugins_url( 'code_assignment/input_limiter.js'), [ 'elementor-frontend' ], '1.0.0', true );
    // Register tsparticles-confetti script
    wp_register_script('tsparticles-confetti', 'https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js', array(), '2.12.0', true);
    // Register tsparticles-preset-fireworks script
    wp_register_script('tsparticles-preset-fireworks', 'https://cdn.jsdelivr.net/npm/tsparticles-preset-fireworks@2.7.0/tsparticles.preset.fireworks.bundle.js', array('tsparticles-confetti'), '2.7.0', true);
    
    // Enqueue CSS files
    wp_register_style( 'code-assignment-css', plugins_url( 'code_assignment/code_assignment.css') );

    // Enqueue scripts and styles
    wp_enqueue_script('script-postscribe');
    wp_enqueue_script('tsparticles-confetti');
    wp_enqueue_script('tsparticles-preset-fireworks');
    wp_enqueue_style('code-assignment-css');
  }

  public function create_iframe_object($settings){
    $data = [
      'id' => $settings['widget_id'],
      'width' => $settings['width'],
      'height' => $settings['height']
    ];
    if ($settings['ide_for_iframe'] === "trinket-iframe"){
      $newData = [
        'src' => ['https://trinket.io/embed/pygame?listen=true#code='.$settings['code_sample_urlencoded']],
        'frameborder' => '0',
        'marginwidth' => '0',
        'marginheight' => '0',
        'allowfullscreen' => true
      ];
      $data = array_merge($data, $newData);
      $this->iframeObj = new Trinket_SUOT($data);
    }
    if ($settings['ide_for_iframe'] == 'godbolt-iframe'){
      // TODO
      $newData = [
        'src' => ['https://trinket.io/embed/pygame?listen=true#code='.$settings['code_sample_urlencoded']],
        'frameborder' => '0',
        'marginwidth' => '0',
        'marginheight' => '0',
        'allowfullscreen' => true
      ];
      $data = array_merge($data, $newData);
      $this->iframeObj = new Trinket_SUOT($data);
    }
    // Chech iframeObj initialization
    if ($this->iframeObj === null) {
      write_log("IFRAME OBJECT is null");
    }
  }

  // registers the controls used in the editor panel
  protected function _register_controls(){
    write_log("START REGISTER CONTROL!!!");
    $this->start_controls_section(
      'section_content',
      [
        'label' => esc_html__('Условие задания', 'codeassignment'),
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
        'label' => esc_html__('Название задания', 'codeassignment'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('Название задания', 'codeassignment')
      ]
    );

    $this->add_control(
      $this->assignment_content,
      [
        'label' => esc_html__('Формулировка задания', 'codeassignment'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'default' => esc_html__('Условие задания.', 'codeassignment')
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'code_section',
      [
          'label' => esc_html__('Секция программного кода', 'codeassignment'),
          'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'ide_for_iframe',
      [
          'label' => esc_html__('Среда разработки', 'codeassignment'),
          'type' => \Elementor\Controls_Manager::SELECT,
          'options' => [
              'trinket-iframe' => 'Trinket',
              'godbolt-iframe' => 'Godbolt',
              // Add more options for other IDEs
          ],
          'default' => 'trinket-iframe',
      ]
    );

    $this->add_control(
      'height',
      [
        'label' => esc_html__('Высота, px', 'codeassignment'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => '600'
      ]
    );

    $this->add_control(
      'width',
      [
        'label' => esc_html__('Ширина, %', 'codeassignment'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => '100'
      ]
    );
    
    $this->add_control(
      'language',
      [
          'label' => esc_html__('Язык программирования', 'codeassignment'),
          'type' => \Elementor\Controls_Manager::SELECT,
          'options' => [
              'python' => 'Python',
              'cpp' => 'C++',
              'javascript' => 'JavaScript',
              // Add more options for other languages
          ],
          'default' => 'Python',
      ]
    );

    $this->add_control(
      'widget_id',
      [
          'label' => esc_html__('Widget ID (optional)', 'codeassignment'),
          'type' => \Elementor\Controls_Manager::TEXT,
          'maxlength' => 20,
          'default' => $this->widget_id, // Set a default id (optional)
      ]
    );

    $this->add_control(
      $this->code_sample,
      [
          'label' => esc_html__('Заготовка кода', 'codeassignment'),
          'type' => \Elementor\Controls_Manager::CODE,
          'language' => 'python', // Specify the programming language for syntax highlighting (optional)
          'rows' => 10, // Specify the number of rows for the code input area (optional)
          'default' => 'print("Hello world")', // Set a default code snippet (optional)
          'placeholder' => esc_html__( 'Enter your code', 'elementor' ),
          'dynamic' => [
            'active' => false,
          ],
      ]
    );
    
    $this->add_control(
      $this->code_solution,
      [
          'label' => esc_html__('Решение', 'codeassignment'),
          'type' => \Elementor\Controls_Manager::CODE,
          'language' => 'python', // Specify the programming language for syntax highlighting (optional)
          'rows' => 10, // Specify the number of rows for the code input area (optional)
          'default' => 'print("Hello world")', // Set a default code snippet (optional)
      ]
    );

    $this->add_control(
      $this->autograder_input,
      [
          'label' => esc_html__('JSON для автогрейдера', 'codeassignment'),
          'type' => \Elementor\Controls_Manager::CODE,
          'language' => 'json', // Specify the programming language for syntax highlighting (optional)
          'rows' => 10, // Specify the number of rows for the code input area (optional)
          'default' => '{
            "args": [
              {
                "sum1": 1,
                "sum2": 50
              },
              {
                "sum1": 11,
                "sum2": 10
              }
            ],
            "timeout": 3,
            "total_points" : 25,
            "student_code": "solution",
            "teacher_code": "answer"
          }', // Set a default code snippet (optional)
      ]
    );

    $this->end_controls_section();
    write_log("Finished REGISTER CONTROL!!!");
  }
  
  // PHP renderer generates the final HTML
  protected function render(){
    write_log("START RENDER!!!");
    // widget settings from the elementor sidebar
    $settings = $this->get_settings_for_display();
    $post_id = get_queried_object_id();

    // add attributes Key: {Attribute => Value}
    $this->add_inline_editing_attributes($this->assignment_heading, 'advanced');
    $this->add_render_attribute(
      $this->assignment_heading,
      [
        'class' => ['code_assignment_heading'],
      ]
    );
    $this->add_inline_editing_attributes($this->assignment_content, 'advanced');
    $this->add_render_attribute(
      $this->assignment_content,
      [
        'class' => ['code_assignment_problem_formulation'],
      ]
    );
    // $this->add_inline_editing_attributes('code_assignment_sample', 'advanced');
    // $this->add_render_attribute(
    //   'code_assignment_sample',
    //   [
    //     'class' => ['code_assignment_sample'],
    //   ]
    // );
    $this->add_inline_editing_attributes($this->code_solution, 'advanced');
    $this->add_render_attribute(
      $this->code_solution,
      [
        'class' => ['code_assignment_solution'],
      ]
    );
    $this->add_inline_editing_attributes('language', 'advanced');
    $this->add_render_attribute(
      'language',
      [
        'class' => ['language-' . $settings['language'], 'line-numbers'],
      ]
    );

    global $wpdb;
    $table_name = $wpdb->prefix . 'student_code_table';
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
    write_log("item render:");
    write_log($item);
    if ($item === null || $item === false) {
      // The query returned an empty result
      // Handle the case when no item is found
        $settings['code_sample_urlencoded'] = rawurlencode($settings[$this->code_sample]);
    } else {
      // The query returned a valid result
      // Access the retrieved item's properties
      $settings['code_sample_urlencoded'] = rawurlencode($item->student_codes);
    }

    // write_log("input generate_iframe_attributes:");
    // write_log($settings);
    $this->create_iframe_object($settings);
    
    $this->add_render_attribute(
      'iframe_src',
      $this->iframeObj->generate_iframe_attributes($settings)
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
      console.log('render() Widget');
    </script>

    <div class="code_assignment">
      <div <?php echo $this->get_render_attribute_string($this->assignment_heading); ?>>
        <h3><?php echo $settings[$this->assignment_heading] ?></h3>
      </div>
      <div <?php echo $this->get_render_attribute_string($this->assignment_content); ?>>
          <?php echo $settings[$this->assignment_content] ?>
      </div>
      <iframe 
          <?php echo $this->get_render_attribute_string('iframe_src'); ?>>
      </iframe>
      <div <?php echo $this->get_render_attribute_string($this->code_solution); ?>>
        <pre <?php echo $this->get_render_attribute_string('language'); ?>><code id='prism-code' class='language-python'><?php echo $settings[$this->code_solution] ?></code></pre>
      </div>
      
      <button class="autograder-button" onclick="sendToAutoGrader(this)">
        Отправить на проверку
      </button>
      <div class="loader">
        <div class="check">
          <span class="check-one"></span>
          <span class="check-two"></span>
        </div>
      </div>
    </div>
    <div class="congratulations-container" id="congratulationsMessage">
      <div class="congratulations-content">
          Congratulations! You did a great job!
      </div>
    </div>
    <?php
    write_log("FINISH RENDER!!!");
  }

  // JS renderer specifies the data bindings between the widget settings and the HTML elements
  // This is a preview area. It affects only for new widgets
  protected function _content_template(){
    $this->add_render_attribute('data-custom-data', 'nonce', wp_create_nonce('wp_rest'));
    write_log("this->iframeObj");
    write_log(get_object_vars($this));

      ?>
        <#
          view.addInlineEditingAttributes( 'assignment_heading', 'advanced' );
          view.addRenderAttribute(
            'assignment_heading',
            {
                'class': [ 'code_assignment_heading' ],
            }
          );
          view.addInlineEditingAttributes( 'assignment_content', 'advanced' );
          view.addRenderAttribute(
            'assignment_content',
            {
                'class': [ 'code_assignment_problem_formulation' ],
            }
          );
          view.addInlineEditingAttributes( 'code_assignment_sample', 'advanced' );
          view.addRenderAttribute(
            'code_assignment_sample',
            {
                'class': ['language-' + settings.language, 'code_assignment_sample' ],
            }
          );
          view.addInlineEditingAttributes( 'code_solution', 'advanced' );
          view.addRenderAttribute(
            'code_solution',
            {
                'class': ['code_assignment_solution', 'line-numbers' ],
            }
          );
          let encodedVariable = encodeURIComponent(settings.code_sample);

          view.addInlineEditingAttributes( 'iframe_src', 'advanced' );
          view.addRenderAttribute(
            'iframe_src',
            <?php $this->iframeObj->generate_iframe_attributes_for_elementor_js(); ?>
          );
        #>
       
        <div class="code_assignment">
          <div {{{ view.getRenderAttributeString( 'assignment_heading' ) }}}>
            <h3>{{{ settings.assignment_heading }}}</h3>
          </div>
          <div {{{ view.getRenderAttributeString( 'assignment_content' ) }}}> 
              {{{ settings.assignment_content }}} 
          </div>
          <!-- TURN OFF TO GET RID OF FOCUS CATCHING -->
          <!-- <iframe 
            {{{ view.getRenderAttributeString( 'iframe_src' ) }}}>
          </iframe> -->
          <div {{{ view.getRenderAttributeString( 'code_solution' ) }}}>
            <pre {{{ view.getRenderAttributeString( 'language' ) }}}>
              <code>
                {{{ settings.code_sample }}}
              </code>
            </pre>
          </div>
          <div {{{ view.getRenderAttributeString( 'code_solution' ) }}}>
            <pre {{{ view.getRenderAttributeString( 'language' ) }}}><code>{{{ settings.code_solution }}}</code></pre>
          </div>
          <button class="autograder-button" onclick="sendToAutoGrader(this)">
            Отправить на проверку
          </button>
          <div class="loader">
            <div class="check">
              <span class="check-one"></span>
              <span class="check-two"></span>
            </div>
          </div>
        </div>
        <script>
          console.log("Test content_template");
          function submit_teacher_code() {
            const data = {
              post_id: get_assignment_post_id(),
              widget_id: `{{{ settings.widget_id }}}`,
              teacher_codes: htmlEscape(`{{{ settings.code_solution }}}`),
              autograder_input: `{{{ settings.autograder_input }}}`
            };
            console.log("Payload:" + JSON.stringify(data, "I don't understand", 4));
            const url_to_submit_code = '/wordpress/wp-json/code-assignment/v1/save-teacher-code';
            fetch(url_to_submit_code, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': window.vibebp.xnonce, // Make sure to localize this value in your WordPress script
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
            wp.data.dispatch("vibebp").addNotification({
                text: "Teacher's code is saved",
            });
        }
        submit_teacher_code();
        </script>

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
