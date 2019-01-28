<?php
/*
*@package EmployeePortalPlugin
*/
/*
Plugin Name: Employee Portal

Plugin URI: http://employeeportal.com/plugin

Description: Employee Portal is a central hub of data. However, this data can have multiple sources. Like job 
applications can come through the website, project assignments will be done in Github, payment details can be 
retrieved from Bank’s application etc.
This WordPress plugin allows easy integration with Employee Portal. This will help set up 
important pieces like job listing and job forms.

Version: 1.0.0

Author: Himanshi Chauhan

Author URI: http://employeeportal.com

Licence: later

Text Domain: employeeportal-plugin
*/

define("PLUGIN_DIR_PATH",plugin_dir_path(__FILE__));
define("PLUGIN_URL",plugins_url());
define("PLUGIN_VERSION","1.0");

function add_my_employee_portal_menu(){
    add_menu_page(
        "employeeportal", //page title
        "Employee Portal", //menu title
        "manage_options", //admin level
        "employee-portal", //page slug - parent slug
        "add_new_function", //callback function
        "dashicons-admin-users", //icon url
        26 //positions
    );

    add_submenu_page(
        "employee-portal", //parent slug
        "Add New", //page title
        "Add New", //menu title
        "manage_options", //capability = user_level access
        "employee-portal", //menu slug
        "add_new_function" //callable function
    );

    add_submenu_page(
        "employee-portal", //parent slug
        "Settings", //page title
        "Settings", //menu title
        "manage_options", //capability = user_level access
        "settings", //menu slug
        "settings_function" //callable function
    );

}

add_action("admin_menu","add_my_employee_portal_menu");  //action hook

function add_new_function(){
   include_once PLUGIN_DIR_PATH."/views/add-new.php";
}

function settings_function(){
    // settings_function
    include_once PLUGIN_DIR_PATH."/views/settings.php";
}

function employee_portal_assets(){
    // css and js files
    wp_register_style("ep_style","https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css");
    wp_enqueue_style("ep_style");

    wp_enqueue_style(
        "epp_style", //unique name for css file
        PLUGIN_URL."/Employee_Portal/assets/css/style.css", // css file path
        '', // dependency on other files
        PLUGIN_VERSION // plugin version number
    );
    
    wp_register_script("ep_script","https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js");
    wp_enqueue_script("ep_script");

    wp_enqueue_script(
        "epp_script",
        PLUGIN_URL."//Employee_Portal/assets/js/script.js",
        '',
        PLUGIN_VERSION, // plugin version number
        false
    );

    wp_localize_script("epp_script","ajaxurl",admin_url("admin-ajax.php"));
}

add_action("init","employee_portal_assets");

if(isset($_REQUEST['action'])) {    //it checks the action param is set or not
    switch($_REQUEST['action']) {   //if set pass to switch methods to match case
        case "employee_portal_library" : add_action("admin_init","add_employee_portal_library");    //match case
        function add_employee_portal_library() {    //function attached with action hook
            global $wpdb;
            include_once PLUGIN_DIR_PATH."/library/employee_portal_lib.php";    //ajax handler file with /library folder
        }
    }
}

// custom ajax_req from js file
add_action("wp_ajax_employee_portal_ajax_req","employee_portal_ajax_req_fn");
function employee_portal_ajax_req_fn() {
    print_r($_REQUEST);

    global $wpdb;
    $wpdb->query(
      $wpdb->prepare(
        "INSERT into wp_employee_portal (username,password,signature) values('%s','%s','%s')",$_REQUEST["username"],$_REQUEST["pass"],$_REQUEST["sign"]
      )
    );
    
    wp_die();
}

function employee_portal_tables() {
    
    global $wpdb;
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');

    if(count($wpdb->get_var('SHOW TABLES LIKE "wp_employee_portal" ')) == 0) {

        $sql_query_to_create_table = "CREATE TABLE `wp_employee_portal` (
                                     `id` int(11) NOT NULL AUTO_INCREMENT,
                                     `username` varchar(150) DEFAULT NULL,
                                     `password` varchar(150) DEFAULT NULL,
                                     `signature` varchar(150) DEFAULT NULL,
                                     `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                      PRIMARY KEY (`id`)
                                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1"; // sql query to create table

        dbDelta($sql_query_to_create_table);

        $page = array();
        $page['post_title'] = "Jobs";
        $page['post_content'] = "Customise the page";
        $page['post_status'] = "publish";
        $page['post_slug'] = "Jobs";
        $page['post_type'] = "page";

        $post_id = wp_insert_post($page);
        add_option("employee_portal_page_id",$post_id);

    }
}

register_activation_hook(__FILE__,'employee_portal_tables');

function deactivate_table() {

    global $wpdb;
    $wpdb->query("DROP table IF EXISTS wp_employee_portal");

    $the_post_id = get_option("employee_portal_page_id");

    if(!empty($the_post_id)) {
        wp_delete_post($the_post_id,true);
    }

}

register_deactivation_hook(__FILE__,'deactivate_table');
register_uninstall_hook(__FILE__,'deactivate_table');

