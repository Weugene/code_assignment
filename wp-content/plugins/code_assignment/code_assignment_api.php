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

// create table if not exists
function create_students_code_table_if_not_exists(string $table_name){
    global $wpdb;
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") !== $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            user_id int(9) NOT NULL,
            post_id int(9) NOT NULL,
            widget_id VARCHAR(20) NOT NULL,
            list_of_codes text NOT NULL,
            created_at datetime NOT NULL,
            PRIMARY KEY  (user_id, post_id, widget_id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
}

function set_trinket_code($code, $iframe){
    $url = "https://trinket.io/embed/python#code=".$code;
    $iframe->setAttribute("src", urlencode($url));
}

function get_trinket_code($iframe){
    $url = $iframe->getAttribute("src");
    $iframe->setAttribute("src", $url."?listen=true");

    return $code;
}


function trinket_extractor_plugin(int $post_id, WP_Post $post, $update) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'trinket_code_table';
    
    // Make sure the current user is logged in before proceeding
    if (!is_user_logged_in()) {
        return;
    }

    // Create the table if it doesn't exist
    create_students_code_table_if_not_exists($table_name);
    
    $current_user = wp_get_current_user();
    $user_id = intval($current_user->ID);

    // Extract all code tags in a post
    $post_content = '<html>' . apply_filters('the_content', $post->post_content) . '</html>';
    $post_html = new DOMDocument();
    $post_html->loadHTML($post_content);
    
    // process code tags
    $code_tags = $post_html->getElementsByTagName("code");

    // process iframes
    $iframe_tags = $post_html->getElementsByTagName("iframe");

    foreach ($code_tags as $index => $code_tag) {
        $widget_id = $index + 1;
        $id_attr = $code_tag->getAttribute('id');
        if (!empty($id_attr)) {
            $widget_id = intval($id_attr);
        }
        $trinket_code = sanitize_textarea_field($post_html->saveHTML($code_tag));
        // Prepare the data to be inserted or updated in the database
        $data = array(
            'trinket_code' => $trinket_code,
            'created_at' => current_time('mysql')
        );

        $where = array(
            'user_id' => $user_id,
            'post_id' => $post_id,
            'widget_id' => $widget_id
        );

        // Check if the record already exists
        $record_exists = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND post_id = %d AND widget_id = %d",
                $user_id,
                $post_id,
                $widget_id
            )
        );
        write_log("record_exists=" . $record_exists."\n");

        if ($record_exists) {
            // Extract saved code:
            $trinket_code_old = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT trinket_code FROM $table_name WHERE user_id = %d AND post_id = %d AND widget_id = %d",
                    $user_id,
                    $post_id,
                    $widget_id
                )
            );
            error_log($trinket_code_old);
            // echo '<script>console.log("PHP message: ' . $trinket_code_old . '")</script>';
            // Update the existing record
            $updated = $wpdb->update($table_name, $data, $where);

            if ($updated === false) {
                error_log('Error updating data in database: ' . $wpdb->last_error);
                return;
            }
            write_log("Updated\n");
        } else {
            // Insert the new record
            $data['user_id'] = $user_id;
            $data['post_id'] = $post_id;
            $data['widget_id'] = $widget_id;
            // Insert the data into the database and handle any errors
            $inserted = $wpdb->insert($table_name, $data);
            write_log("Inserted=".$inserted." insert_id=".$wpdb->insert_id." data=".$data."\n");
            if ($inserted === false) {
                error_log('Error inserting data into database: ' . $wpdb->last_error);
                return;
            }
            // Check that the data was actually inserted into the database
            // if ($wpdb->insert_id === 0) {
            //     error_log('Data was not inserted into the database');
            //     return;
            // }
            write_log("Inserted finally\n");
        }
    }
    // Success!
    return;
}
// add_action('init', 'trinket_extractor_plugin');
// add_action( 'post_updated', 'trinket_extractor_plugin', 10, 3 );


// 
add_action( 'rest_api_init', function () {
    register_rest_route( 'trinket/v1', '/submit-code/', array(
        'methods'  => 'POST',
        'callback' => 'my_custom_endpoint_callback',
        'permission_callback' => 'my_custom_endpoint_permission_callback',
    ) );
} );

function my_custom_endpoint_permission_callback( $request ) {
    // Check if the user is authenticated
    if ( ! is_user_logged_in() ) {
        return new WP_Error( 'rest_forbidden', 'You are not authorized to access this endpoint.', array( 'status' => 401 ) );
    }

    // Additional permission checks can be added here if required
    $request_data = $request->get_json_params();

    // Check if the JSON payload exists and contains the desired data
    if ( empty( $request_data ) || ! isset( $request_data['code'] ) ) {
        $error = new WP_Error( 'empty_payload', 'Empty JSON payload or missing code parameter', array( 'status' => 400 ) );
        return rest_ensure_response( $error );
    }
    return true;
}

function my_custom_endpoint_callback( $request ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'students_code_table';
    // Handle the API request and return a response
    $user_id = get_current_user_id();
    $response = array(
        'success' => true,
        'user_id' => $user_id,
        'ide_for_iframe' => null,
    );

    $request_data = $request->get_json_params();
    
    $post_id = sanitize_textarea_field($request_data['post_id']);
    $widget_id = sanitize_textarea_field($request_data['widget_id']);
    $ide_for_iframe = sanitize_textarea_field($request_data['ide_for_iframe']);
    $list_of_codes = sanitize_textarea_field($request_data['code']);

    // Create the table if it doesn't exist
    create_students_code_table_if_not_exists($table_name);

    
    // Prepare the data to be inserted or updated in the database
    $data = array(
        'list_of_codes' => $list_of_codes,
        'created_at' => current_time('mysql')
    );

    $where = array(
        'user_id' => $user_id,
        'post_id' => $post_id,
        'widget_id' => $widget_id
    );

    // Check if the record already exists
    $record_exists = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND post_id = %d AND widget_id = %s",
            $user_id,
            $post_id,
            $widget_id
        )
    );
    write_log("record_exists: " . $record_exists."\n");

    if ($record_exists) {
        // Extract saved code:
        $list_of_codes_old = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT list_of_codes FROM $table_name WHERE user_id = %d AND post_id = %d AND widget_id = %s",
                $user_id,
                $post_id,
                $widget_id
            )
        );
        write_log("Extract saved code: " . $list_of_codes_old);
        // Update the existing record
        $updated = $wpdb->update($table_name, $data, $where);

        if ($updated === false) {
            error_log('Error updating data in database: ' . $wpdb->last_error);
            return;
        }
        write_log("Updated\n");
    } else {
        // Insert the new record
        $data['user_id'] = $user_id;
        $data['post_id'] = $post_id;
        $data['widget_id'] = $widget_id;
        // Insert the data into the database and handle any errors
        $inserted = $wpdb->insert($table_name, $data);
        write_log("Inserted=".$inserted." insert_id=".$wpdb->insert_id." data=".$data."\n");
        if ($inserted === false) {
            error_log('Error inserting data into database: ' . $wpdb->last_error);
            return;
        }
        // Check that the data was actually inserted into the database
        // if ($wpdb->insert_id === 0) {
        //     error_log('Data was not inserted into the database');
        //     return;
        // }
        write_log("Inserted finally\n");
    }

    $response['list_of_codes'] = $list_of_codes;
    $response['ide_for_iframe'] = $ide_for_iframe;
    $response['post_id'] = $post_id;

    return rest_ensure_response( $response );
}
