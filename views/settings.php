<?php

echo "<h3>API Settings</h3>";

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>

<br>
<h5>Key Details</h5>
<br>
<div class="container">
  <form action="#" id="formPost" method="POST">
    <div class="form-group row">
      <label for="id" class="col-sm-2 col-form-label">Client ID</label>
      <div class="col-md-6">
        <input type="text" class="form-control" required id="id">
      </div>
    </div>
    <br>
    <div class="form-group row">
      <label for="secret" class="col-sm-2 col-form-label">Client Secret</label>
      <div class="col-md-6">
        <input type="text" class="form-control" required id="secret">
      </div>
    </div>
    <br>
    <div class="form-group row">
      <div class="col-sm-10">
        <button type="submit" class="btn buton btn-md" id="key-button">Save</button>
      </div>
    </div>
  </form>
</div>
