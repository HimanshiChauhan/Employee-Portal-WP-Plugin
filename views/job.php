<?php
$job_script = plugins_url()."/Employee_Portal/public/script.js";
$id = $_GET["job"];

global $wpdb;
$table_name = $wpdb->prefix . "career";
$details = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d",$id)
        );
?>

<div class="container">
    <h1 class="text-dark"><center><strong><?php echo $details->title; ?></strong></center></h1>
    <p class="text-center"><?php echo $details->excerpt; ?></p>
    <p class="text-center"><strong>Job Category</strong> : <?php echo $details->category; ?><br>
    <strong>Job Location</strong> : <?php echo $details->location; ?></p>
    <h4><center><strong>Description</strong></center></h4>
    <p class="text-justify"><?php echo $details->description; ?></p>
    <br>
    <center><button id="myBtn" type="button" class="btn btn-info">Apply Now</button></center>
</div>

<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
        <h2>Apply for this position</h2>
        <span class="close">&times;</span>
    </div>
    <div class="modal-body">
      <form action="#">
        <div class="row">
          <div class="col">
            <input type="text" class="form-control" placeholder="First name">
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="Last name">
          </div>
        </div>
        <br>
        <input type="text" class="form-control input-sm" placeholder="Email"><br>
        <input type="text" class="form-control input-sm" placeholder="Phone number"><br>
        <input type="text" class="form-control input-sm" placeholder="College"><br>
        <input type="text" class="form-control input-sm" placeholder="Graduation year"><br>
        <input type="text" class="form-control input-sm" placeholder="Course"><br>
        <input type="text" class="form-control input-sm" placeholder="Linkedin URL"><br>
        <textarea cols="30" rows="5" class="form-control input-sm" placeholder="Why do you think you are fit for this job?"></textarea><br>
        <div class="form-group">
          <label for="exampleFormControlFile1">Resume</label>
          <input type="file" class="form-control-file" id="exampleFormControlFile1">
          <small class="text-muted">Please upload PDF document only</small>
        </div>
        <br>
        <button type="submit" class="btn btn-outline-secondary">Submit</button>
      </form>
    </div>
  </div>
</div>

<script src="<?php echo $job_script; ?>"></script>
