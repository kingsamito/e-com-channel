<?php

include_once 'conn.php';

session_start();

$recipient_id =   $_POST['recipient_data'];

$college_id = $_SESSION['College'];

if ($recipient_id == "Vice Chancellor") {
  echo '<label for="through">Through: </label>
  <input class="form-control" value="Dean ' . $_SESSION['College'] . '" name="through[]"><br>
  <label for="through">Through: </label>
  <input class="form-control" value="HOD ' . $_SESSION['Department'] . '" name="through[]"><br>
  <label for="through">Through: </label>
  <input class="form-control" value="Program Coordinator ' . $_SESSION['Department'] . '" name="through[]"><br>
';
}

$dean = "Dean " . $_SESSION['College'];
if ($recipient_id == "$dean") {
  echo '<label for="through">Through: </label>
  <input class="form-control" value="HOD ' . $_SESSION['Department'] . '" name="through[]"><br>
  <label for="through">Through: </label>
  <input class="form-control" value="Program Coordinator ' . $_SESSION['Department'] . '" name="through[]"><br>
';
}

$hod = "HOD " . $_SESSION['Department'];
if ($recipient_id == "$hod") {
  echo '<label for="through">Through: </label>
 <input class="form-control" value="Program Coordinator ' . $_SESSION['Department'] . '" name="through[]"><br>
';
}
