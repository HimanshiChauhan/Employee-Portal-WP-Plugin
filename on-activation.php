<?php

global $wpdb;
require_once(ABSPATH.'wp-admin/includes/upgrade.php');

if(count($wpdb->get_var('SHOW TABLES LIKE "wp_client_credentials" ')) == 0) {

    $sql_query_to_create_table = "CREATE TABLE `wp_client_credentials` (
                                  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `client_id` varchar(150) DEFAULT NULL,
                                  `client_secret` varchar(150) DEFAULT NULL,
                                  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                  PRIMARY KEY (`id`)
                                  ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    dbDelta($sql_query_to_create_table);

}

if(count($wpdb->get_var('SHOW TABLES LIKE "wp_career" ')) == 0) {

    $sql_query_to_create_table = "CREATE TABLE `wp_career` (
                                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `created_at` timestamp NULL DEFAULT NULL,
                                  `updated_at` timestamp NULL DEFAULT NULL,
                                  PRIMARY KEY (`id`)
                                  ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"; // sql query to create table

    dbDelta($sql_query_to_create_table);

}

$career = array();
$career['post_title'] = "Career";
$career['post_content'] = "<!-- wp:shortcode -->
[jobs-list]
<!-- /wp:shortcode -->";
$career['post_status'] = "publish";
$career['post_slug'] = "Career";
$career['post_type'] = "page";

$post_id1 = wp_insert_post($career);
update_option("career_page_id",$post_id1);

$job = array();
$job['post_title'] = "Job";
$job['post_content'] = "<!-- wp:shortcode -->
[job-detail]
<!-- /wp:shortcode -->";
$job['post_status'] = "publish";
$job['post_slug'] = "Job";
$job['post_type'] = "page";

$post_id2 = wp_insert_post($job);
update_option("job_page_id",$post_id2);
