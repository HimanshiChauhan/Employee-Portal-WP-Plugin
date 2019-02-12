<?php

global $wpdb;

$url = 'http://localhost:8000/api/jobs';
$response = wp_remote_get( $url );
$body = json_decode( wp_remote_retrieve_body( $response ), true );
    
foreach ($body as $key) {
    $title = $key["title"];
    $excerpt = $key["excerpt"];
    $location = $key["location"];
    $category = $key["category"];
    $description = $key["description"];
    $wpdb->query(
      $wpdb->prepare(
        "INSERT into wp_career (title,excerpt,location,category,description) values('%s','%s','%s','%s','%s')",$title,$excerpt,$location,$category,$description
      )
    );
}
