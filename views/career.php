<?php

echo "<h1><center><strong>Open Positions</strong></center></h1><br>";

global $wpdb;
$table_name = $wpdb->prefix . "career";
$jobs = $wpdb->get_results("SELECT * FROM $table_name"); 
$url = get_template_directory_uri()."/job"; ?>

<div class="list-group list-group-flush">

     <?php foreach($jobs as $job) {  ?>
          <a href="<?php echo $url."?job=".$job->id; ?>" class="list-group-item list-group-item-action">       
               <h3 class="mb-1"><strong><?php echo $job->title; ?></strong></h3>
               <p class="text-justify mb-1"><?php echo $job->excerpt; ?></p>
               <small><strong>Job Category</strong> : <?php echo $job->category; ?><br>
               <strong>Job Location</strong> : <?php echo $job->location; ?></small>
               <br>
          </a>
     <?php } ?>

</div>
