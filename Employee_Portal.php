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
    wp_register_style("epp_style","https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css");
    wp_enqueue_style("epp_style");
    wp_enqueue_style(
        "ep_style", //unique name for css file
        PLUGIN_URL."/Employee_Portal/assets/css/style.css", // css file path
        '', // dependency on other files
        PLUGIN_VERSION // plugin version number
    );

    wp_register_script("epp_script","https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js");
    wp_enqueue_script("epp_script");

    $object_array = array(
        "Name"=>"Employee Portal",
        "Author"=>"Himanshi Chauhan"
    );

    wp_localize_script("epp_script","employee_portal","object_array");
}

add_action("init","employee_portal_assets");

function employee_portal_tables() {
    
    global $wpdb;
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');

    if(count($wpdb->get_var('SHOW TABLES LIKE "wp_employee_portal" ')) == 0) {

        $sql_query_to_create_table = "CREATE TABLE `wp_employee_portal` (
                                     `id` int(11) NOT NULL AUTO_INCREMENT,
                                     `name` varchar(150) DEFAULT NULL,
                                     `email` varchar(150) DEFAULT NULL,
                                     `phone` varchar(150) DEFAULT NULL,
                                     `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                      PRIMARY KEY (`id`)
                                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1"; // sql query to create table

        dbDelta($sql_query_to_create_table);

    }
}

register_activation_hook(__FILE__,'employee_portal_tables');

function deactivate_table() {

    global $wpdb;
    $wpdb->query("DROP table IF Exists wp_employee_portal");

    $the_post_id = get_option("employee_portal_page_id");
    if(!empty($the_post_id)) {
        wp_delete_post($the_post_id,true);
    }

}

register_deactivation_hook(__FILE__,"deactivate_table");
register_uninstall_hook(__FILE__,"deactivate_table");

function create_page() {
    $page = array();
    $page['post_title'] = "Jobs";
    $page['post_content'] = PLUGIN_DIR_PATH."/views/jobs.php";
    $page['post_status'] = "publish";
    $page['post_slug'] = "Jobs";
    $page['post_type'] = "page";

    $post_id = wp_insert_post($page);

    add_option("employee_portal_page_id",$post_id);
}

register_activation_hook(__FILE__,'create_page');