<?php

echo "<h3>API Settings</h3>";

?>
<br>
<h5>Key Details</h5>
<br>
<div class="container">
<form>
  <div class="form-group row">
    <label for="description" class="col-sm-2 col-form-label">Description</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="description">
    </div>
  </div>
  <br>
  <div class="form-group row">
    <label for="user" class="col-sm-2 col-form-label">User</label>
    <div class="col-md-6">
      <input type="text" class="form-control" id="user" placeholder="Mr.Video (#1-ryanryaa@me.com)">
    </div>
  </div>
  <br>
  <div class="form-group row">
    <label for="permissions" class="col-sm-2 col-form-label">Permissions</label>

    <div class="col-md-6">
      <select class="form-control" id="sel1">
        <option>Read</option>
        <option>Write</option>
        <option>Read/Write</option>>
      </select>
    </div>
  </div>
  <br>
  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn buton btn-sm" id="key-button">Generate API Key</button>
    </div>
  </div>
</form>
</div>