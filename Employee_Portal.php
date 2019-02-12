<?php
/*
*@package EmployeePortal
*/
/*
Plugin Name: Employee Portal

Plugin URI: plugin url

Description: This plugin helps in integrating with the Employee Portal

Version: 1.0.0

Author: Himanshi Chauhan
*/

define("PLUGIN_DIR_PATH",plugin_dir_path(__FILE__));
define("PLUGIN_URL",plugins_url());
define("PLUGIN_VERSION","1.0");

function add_my_employee_portal_menu()
{
    add_menu_page(
        "employeeportal",
        "Employee Portal",
        "manage_options",
        "employee-portal",
        "about_us_function",
        "dashicons-admin-users",
        26
    );

    add_submenu_page(
        "employee-portal",
        "About Us",
        "About Us",
        "manage_options",
        "employee-portal",
        "about_us_function"
    );

    add_submenu_page(
        "employee-portal",
        "Settings",
        "Settings",
        "manage_options",
        "settings",
        "settings_function"
    );

}

add_action("admin_menu","add_my_employee_portal_menu");

function about_us_function()
{
   include_once PLUGIN_DIR_PATH."/views/about-us.php";
}

function settings_function()
{
    include_once PLUGIN_DIR_PATH."/views/settings.php";
}

function employee_portal_admin_assets()
{
    wp_register_style("ep_style","https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css");
    wp_enqueue_style("ep_style");

    wp_register_script("ep_script","https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js");
    wp_enqueue_script("ep_script");

    wp_enqueue_script(
        "epp_script",
        PLUGIN_URL."/Employee_Portal/assets/js/script.js",
        '',
        PLUGIN_VERSION,
        false
    );

    wp_enqueue_style(
        "job_style",
        PLUGIN_URL."/Employee_Portal/public/style.css",
        '',
        PLUGIN_VERSION,
        false
    );

    wp_localize_script("epp_script","ajaxurl",admin_url("admin-ajax.php"));
}

add_action("init","employee_portal_admin_assets");
// add_action( 'wp_enqueue_scripts', 'employee_portal_admin_assets' );
// add_action( 'admin_enqueue_scripts', 'employee_portal_admin_assets' );

function employee_portal_ajax_req_fn()
{
    global $wpdb;
    $client_id = $_POST["client_id"];
    $client_secret = $_POST["client_secret"];
    $wpdb->query(
      $wpdb->prepare(
        "INSERT into wp_client_credentials (client_id,client_secret) values('%s','%s')",$client_id,$client_secret
      )
    );
    
    // wp_die();

    if($wpdb > 0) {
        $return = array(
            'message' => 'You have successfully saved your credentials',
        );
        wp_send_json_success( $return );
    }
}

add_action("wp_ajax_employee_portal_ajax_req","employee_portal_ajax_req_fn");

function activate_employee_portal()
{
    include PLUGIN_DIR_PATH."/on-activation.php";
}

register_activation_hook(__FILE__,'activate_employee_portal');

function send_api_request()
{
    include PLUGIN_DIR_PATH."/api-interaction.php";
}

register_activation_hook(__FILE__,'send_api_request',13);

function jobs_list_shortcode_fn()
{
    include PLUGIN_DIR_PATH."/views/career.php";
}

add_shortcode("jobs-list","jobs_list_shortcode_fn");

function job_detail_shortcode_fn()
{
    include PLUGIN_DIR_PATH."/views/job.php";
}

add_shortcode("job-detail","job_detail_shortcode_fn");

function remove_post()
{
    $the_post_id1 = get_option("career_page_id");

    if(!empty($the_post_id1)) {
        wp_delete_post($the_post_id1,true);
    }

    $the_post_id2 = get_option("job_page_id");

    if(!empty($the_post_id2)) {
        wp_delete_post($the_post_id2,true);
    }
}

function remove_table()
{
    global $wpdb;
    $wpdb->query("DROP table IF EXISTS wp_client_credentials");
    $wpdb->query("DROP table IF EXISTS wp_career");
}

register_deactivation_hook(__FILE__,'remove_post');
register_deactivation_hook(__FILE__,'remove_table');
register_uninstall_hook(__FILE__,'remove_table');
