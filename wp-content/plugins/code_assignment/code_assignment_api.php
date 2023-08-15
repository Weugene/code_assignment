<?php
/**
 * Plugin Name: Code assignment IDE API
 * Description: REST API to submit code and check code.
 * In the submit stage the obtained code is saved into the database.
 * In the check stage the obtained code is not only  saved, but 
 * send to the ECMC.org API to the Piston autograder.
 * Version: 1.0
 * Author: Evgenii Sharaborin
 */

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


// 
add_action( 'rest_api_init', function () {
    register_rest_route( 'code-assignment/v1', '/save-teacher-code/', array(
        'methods'  => 'POST',
        'callback' => 'save_teacher_code_callback',
        'permission_callback' => 'teacher_permission_callback',
    ) );
    register_rest_route( 'code-assignment/v1', '/submit-code/', array(
        'methods'  => 'POST',
        'callback' => 'submit_code_callback',
        'permission_callback' => 'logged_users_permission_callback',
    ) );
    register_rest_route( 'code-assignment/v1', '/check-code/', array(
        'methods'  => 'POST',
        'callback' => 'check_code_callback',
        'permission_callback' => 'logged_users_permission_callback',
    ) );
} );


// Allow only for authorized users with proper payload
function logged_users_permission_callback( $request ) {
    // Check if the user is authenticated
    if ( ! is_user_logged_in() ) {
        $error = new WP_Error( 'rest_forbidden', 'You are not authorized to access this endpoint.', array( 'status' => 401 ) );
        return rest_ensure_response( $error );
    }

    // Additional permission checks can be added here if required
    $request_data = $request->get_json_params();

    // Check if the JSON payload exists and contains the desired data
    if ( empty( $request_data ) || ! isset( $request_data['code'] ) ) {
        $error = new WP_Error( 'empty_payload', 'Empty JSON payload or missing `code` parameter', array( 'status' => 400 ) );
        return rest_ensure_response( $error );
    }
    return true;
}

// Allow only for teachers
function teacher_permission_callback( $request ){
    $logged = logged_users_permission_callback( $request);
    $user = wp_get_current_user();
    write_log($user);
    write_log($user->roles);
    if (in_array( 'student', (array) $user->roles )){
        return false;
    }
    
    return true;
}

class Callback_processor_SUOT{
    protected $wpdb;
    protected $teacher_table_name;
    protected $student_table_name;
    protected $user_id;
    protected $main_stdout;
    protected $main_function_call;
    
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->student_table_name = $wpdb->prefix . 'student_code_table';
        $this->teacher_table_name = $wpdb->prefix . 'teacher_code_table';
        $this->user_id = get_current_user_id();
        $this->main_stdout = <<<EOT
        import contextlib
        import json
        import copy
        from unittest.mock import patch
        from io import StringIO
        with open("args.json") as user_file:
            file_contents = user_file.read()
        params = json.loads(file_contents)
        args = params["args"]
        student_code = params["student_code"]
        teacher_code = params["teacher_code"]
        output = dict()
        if not student_code and not teacher_code:
            total_result = []
            score = dict()
            for i, arg in enumerate(args):
                result = {
                    "teacher/main.py": None,
                    "student/main.py": None,
                    "arg": arg,
                    "passed": 0,
                    "failed": 0
                }
                try:
                    for code_name in ["teacher/main.py", "student/main.py"]:
                        def mock_input():
                            return copy.deepcopy(arg).pop(0)
        
                        with patch("builtins.input", side_effect=mock_input):
                            output_buffer = StringIO()
                            with contextlib.redirect_stdout(output_buffer):
                                exec(open(code_name).read())
                            result[code_name] = output_buffer.getvalue()
                    if result["teacher/main.py"] == result["student/main.py"]:
                        result["passed"] = 1
                    else:
                        result["failed"] = 1
                except:
                    result["failed"] = 1
                total_result.append(result)
            score["passed"] = sum([result["passed"] for result in total_result])
            score["failed"] = sum([result["failed"] for result in total_result])
        
            output["total_result"] = total_result
            output["score"] = score
        
        else:
            output["error"] = f"Error: inconsistent names in main_stdout: student_code: {student_code}, teacher_code: {teacher_code}"
        print(json.dumps(output))
        EOT;
        $this->main_function_call = 
        <<<EOT
        import copy
        import json
        from unittest.mock import patch
        with open('args.json') as user_file:
            file_contents = user_file.read()
        params = json.loads(file_contents)
        args = params["args"]
        func_names = {"student_code": None, "teacher_code": None}
        output = dict()
        if params["student_code"] and params["teacher_code"]:
            from student import main as sc
            from teacher import main as tc
            if hasattr(sc, params["student_code"]) and hasattr(tc, params["teacher_code"]):
                func_names["student_code"] = getattr(sc, params["student_code"])
                func_names["teacher_code"] = getattr(tc, params["teacher_code"])
                total_result = []
                score = dict()
                for i, arg in enumerate(args):
                    result = {
                        "student_code": None,
                        "teacher_code": None,
                        "arg": arg,
                        "passed": 0,
                        "failed": 0
                    }
                    try:
                        for code_name in func_names:
                            def mock_input():
                                return copy.deepcopy(arg.values()).pop(0)
                            with patch('builtins.input', side_effect=mock_input):
                                result[code_name] = func_names[code_name](**arg)
                        if result["student_code"] == result["teacher_code"]:
                            result["passed"] = 1
                        else:
                            result["failed"] = 1
                    except:
                        result["failed"] = 1
                    total_result.append(result)
                score["passed"] = sum([result["passed"] for result in total_result])
                score["failed"] = sum([result["failed"] for result in total_result])
                output["total_result"] = total_result
                output["score"] = score
            else:
                output["error"] = f"Inconsistent names in main_function_call: student_code: {params['student_code']}, teacher_code: {params['teacher_code']}"
        else:
            output["error"] = "Student_code and student_code are not defined"
        print(json.dumps(output))
        EOT;
    } 
    // create teacher's code table if not exists
    function create_teacher_code_table_if_not_exists(){
        if ($this->wpdb->get_var("SHOW TABLES LIKE '$this->teacher_table_name'") !== $this->teacher_table_name) {
            $charset_collate = $this->wpdb->get_charset_collate();

            $sql = "CREATE TABLE $this->teacher_table_name (
                post_id int(9) NOT NULL,
                widget_id VARCHAR(20) NOT NULL,
                creator int(9) NOT NULL,
                teacher_codes text NOT NULL,
                autograder_input text NOT NULL,
                created_at datetime NOT NULL,
                modified_at datetime NOT NULL,
                PRIMARY KEY  (post_id, widget_id)
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }
    // create student's code table if not exists
    function create_student_code_table_if_not_exists(){
        if ($this->wpdb->get_var("SHOW TABLES LIKE '$this->student_table_name'") !== $this->student_table_name) {
            $charset_collate = $this->wpdb->get_charset_collate();

            $sql = "CREATE TABLE $this->student_table_name (
                user_id int(9) NOT NULL,
                post_id int(9) NOT NULL,
                widget_id VARCHAR(20) NOT NULL,
                student_codes text NOT NULL,
                created_at datetime NOT NULL,
                modified_at datetime NOT NULL,
                PRIMARY KEY  (user_id, post_id, widget_id)
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }
    // save student's codes in db
    function save_student_code_in_db($request){
        $request_data = $request->get_json_params();
        $post_id = sanitize_textarea_field($request_data['post_id']);
        $widget_id = sanitize_textarea_field($request_data['widget_id']);
        $ide_for_iframe = sanitize_textarea_field($request_data['ide_for_iframe']);
        $student_codes = sanitize_textarea_field($request_data['code']);

        $response = array(
            'success' => true,
            'user_id' => $this->user_id,
            'ide_for_iframe' => null,
            'student_codes' => null,
            'post_id' => $post_id 
        );
        
        // Prepare the data to be inserted or updated in the database
        $data = array(
            'student_codes' => $student_codes,
            'modified_at' => current_time('mysql')
        );
    
        $where = array(
            'user_id' => $this->user_id,
            'post_id' => $post_id,
            'widget_id' => $widget_id
        );
    
        // Check if the record already exists
        $record_exists = $this->wpdb->get_var(
            $this->wpdb->prepare(
                "SELECT COUNT(*) FROM $this->student_table_name WHERE user_id = %d AND post_id = %d AND widget_id = %s",
                $this->user_id,
                $post_id,
                $widget_id
            )
        );
        write_log("record_exists: " . $record_exists . " with user_id: " . $this->user_id . ", post_id: " . $post_id . " widget_id: " . $widget_id);
    
        if ($record_exists) {
            // Extract saved code:
            // $student_codes_old = $this->wpdb->get_var(
            //     $this->wpdb->prepare(
            //         "SELECT student_codes FROM $this->student_table_name WHERE user_id = %d AND post_id = %d AND widget_id = %s",
            //         $this->user_id,
            //         $post_id,
            //         $widget_id
            //     )
            // );
            // write_log("Extract last saved code: " . $student_codes_old);
            // Update the existing record
            $updated = $this->wpdb->update($this->student_table_name, $data, $where);
    
            if ($updated === false) {
                $err_msg = 'Error updating data in database: ' . $this->wpdb->last_error;
                error_log($err_msg);
                $response['success'] = false;
                $response['error'] = $err_msg;
            }
            write_log("Updated\n");
        } else {
            // Insert the new record
            $data['user_id'] = $this->user_id;
            $data['post_id'] = $post_id;
            $data['widget_id'] = $widget_id;
            $data['created_at'] = current_time('mysql');
            // Insert the data into the database and handle any errors
            $inserted = $this->wpdb->insert($this->student_table_name, $data);
            write_log("Inserted=".$inserted." insert_id=".$this->wpdb->insert_id." data:");
            write_log($data);
            if ($inserted === false) {
                $err_msg = 'Error inserting data into database: ' . $this->wpdb->last_error;
                $response['success'] = false;
                $response['error'] = $err_msg;
            }
            write_log("Inserted finally\n");
        }
    
        $response['student_codes'] = $student_codes;
        $response['ide_for_iframe'] = $ide_for_iframe;
        $response['post_id'] = $post_id;
        return $response;
    }
    // Extract teacher's code by post_id, widget_id
    // It returns an item, if not exists, then returns null
    function get_teacher_code( $request ){
        $request_data = $request->get_json_params();
        
        $post_id = sanitize_textarea_field($request_data['post_id']);
        $widget_id = sanitize_textarea_field($request_data['widget_id']);
        return $this->wpdb->get_row(
            $this->wpdb->prepare(
                "SELECT * FROM $this->teacher_table_name WHERE post_id = %d AND widget_id = %s",
                $post_id,
                $widget_id
            )
        );
    }

    function save_teacher_code( $request ){
        $request_data = $request->get_json_params();
        
        $post_id = sanitize_textarea_field($request_data['post_id']);
        $widget_id = sanitize_textarea_field($request_data['widget_id']);
        $teacher_codes = sanitize_textarea_field($request_data['teacher_codes']);
        $autograder_input = sanitize_textarea_field($request_data['autograder_input']);

        $response = array(
            'success' => true,
            'creator' => $this->user_id,
            'teacher_codes' => $teacher_codes,
            'post_id' => $post_id 
        );
        
        // Prepare the data to be inserted or updated in the database
        $data = array(
            'autograder_input' => $autograder_input,
            'teacher_codes' => $teacher_codes,
            'modified_at' => current_time('mysql')
        );
    
        $where = array(
            'post_id' => $post_id,
            'widget_id' => $widget_id
        );
    
        // Check if the record already exists
        $record_exists = $this->wpdb->get_var(
            $this->wpdb->prepare(
                "SELECT COUNT(*) FROM $this->teacher_table_name WHERE post_id = %d AND widget_id = %s",
                $post_id,
                $widget_id
            )
        );
        write_log(" teacher's code exists : " . $record_exists . ", post_id: " . $post_id . " widget_id: " . $widget_id);

        if ($record_exists) {
            // Update the existing record
            $updated = $this->wpdb->update($this->teacher_table_name, $data, $where);
    
            if ($updated === false) {
                $err_msg = 'Error updating data in database: ' . $this->wpdb->last_error;
                error_log($err_msg);
                $response['success'] = false;
                $response['error'] = $err_msg;
            }
        } else {
            // Insert the new record
            $data['creator'] = $this->user_id;
            $data['post_id'] = $post_id;
            $data['widget_id'] = $widget_id;
            $data['created_at'] = current_time('mysql');
            // Insert the data into the database and handle any errors
            $inserted = $this->wpdb->insert($this->teacher_table_name, $data);
            if ($inserted === false) {
                $err_msg = 'Error inserting data into database: ' . $this->wpdb->last_error;
                error_log($err_msg);
                $response['success'] = false;
                $response['error'] = $err_msg;
            }
        }
        return $response;
    }

    function parse_codes($string_codes, $prefix = "."){
        $codes = json_decode($string_codes, true);
        $array = array(); // Empty array
        foreach ($codes as &$code) {
            $code["name"] = $prefix . "/" . $code["name"];
        }
        return $codes;
    }

    function execute_piston_api($data){
        // API endpoint URL
        $url = 'https://emkc.org/api/v2/piston/execute';
        // Convert data array to JSON string
        $json_data = json_encode($data);
        // Set up cURL options
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        // Execute cURL request
        $response = curl_exec($ch);
        $response = json_decode($response, TRUE);
        $response['success'] = true;
        // Check for cURL errors
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            error_log($err_msg);
            $response['success'] = false;
            $response['error'] = $error_msg;
        }
        // Close cURL session
        curl_close($ch);    
        
        return $response;
    }

    function get_type_of_run($query){
        $json_config = json_decode($query['autograder_input']);
        // input
        if ($json_config->student_code == $json_config->teacher_code 
            && $json_config->teacher_code == null
            && is_array($json_config->args[0])){
            return $this->main_stdout;
        }
        // function
        if ($json_config->student_code != null
            && $json_config->teacher_code != null
            && is_object($json_config->args[0])){
            return $this->main_function_call;
        }
        return null;
    }

    function execute_piston_autograder($query) {
        $main_code = $this->get_type_of_run($query);
        if (is_null($main_code)){
            $response['success'] = false;
            $response['error'] = 'json configuration is not proper or not exist';
            $response['autograder_input'] = json_decode($query['autograder_input']);
            return $response;
        }
        // parse teacher's and student's code and put them into folders
        $files = array(
            0 => array(
                "name" => "main.py",
                "content" => $main_code
            ),
            1 => array(
                "name" => "args.json",
                "content" => $query['autograder_input']
            ),
            2 => array(
                "name" => "teacher/main.py",
                "content" => $query['teacher_codes']
            )
        );
        $student_codes = $this->parse_codes($query['student_codes'], 'student');
        
        $files = array_merge($files, $student_codes);
        
        // JSON body data
        $data = array(
            "language" => "python",
            "version" => "3.10.0",
            "files" => $files,
            "stdin" => "",
            "args" => [],
            "myargs" => 1,
            "compile_timeout" => 10000,
            "run_timeout" => 3000,
            "compile_memory_limit" => -1,
            "run_memory_limit" => -1
        );
        write_log("EMKC data:");
        write_log($data);
        $response = $this->execute_piston_api($data);
        $response["run"]["output"] = json_decode($response["run"]["stdout"] );
    
        // Return the API response (from JSON format to array)
        return $response;
    }
}

function handle_response($response){
    $wp_response = rest_ensure_response( $response );
    if (!$response['success']){
        $wp_response->set_status(400);
    }
    return $wp_response;
}
function save_teacher_code_callback( $request ){
    $suot = new Callback_processor_SUOT();
    // Create the table if it doesn't exist
    $suot->create_teacher_code_table_if_not_exists();
    // save in table
    $response = $suot->save_teacher_code( $request );
    return handle_response($response);
}

function submit_code_callback( $request ) {
    $suot = new Callback_processor_SUOT();
    // Create the table if it doesn't exist
    $suot->create_student_code_table_if_not_exists();
    // Save student's code in db
    $response = $suot->save_student_code_in_db($request);
    return handle_response($response);
}

// Save student's code and send to the autograder
function check_code_callback( $request ) {
    $suot = new Callback_processor_SUOT();
    // Create the table if it doesn't exist
    $suot->create_student_code_table_if_not_exists();
    $suot->create_teacher_code_table_if_not_exists();
    // Save student's code in db
    $student_item = $suot->save_student_code_in_db($request);
    //extract teacher's code
    $teacher_item = $suot->get_teacher_code( $request );

    $query = array(
        "autograder_input" => $teacher_item->autograder_input,
        "teacher_codes" => $teacher_item->teacher_codes,
        "student_codes" => $student_item['student_codes'],

    );
    //send to autograder
    $response = $suot->execute_piston_autograder($query);
    write_log($response );
    return handle_response($response);
}
