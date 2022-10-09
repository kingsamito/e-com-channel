<?php

$lnameErr = $fnameErr = $usernameErr = '';



if (isset($_POST["updateadmin"])) {
  $id = $_POST['id'];
  $lname = mysqli_real_escape_string($conn, $_POST['lname']);
  $fname = mysqli_real_escape_string($conn, $_POST['fname']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);

  if (empty($lname)) {
    $lnameErr = "** Lastname is required";
  } else {

    if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
      $lnameErr = "** Only letters and white spaces allowed";
    }
  }
  if (empty($fname)) {
    $fnameErr = "** Firstname is required";
  } else {

    if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
      $fnameErr = "** Only letters and white spaces allowed";
    }
  }
  if (empty($username)) {
    $usernameErr = "** Username is required";
  } else {

    if (!preg_match("/^[a-zA-Z-' ]*$/", $username)) {
      $usernameErr = "** Only letters and white spaces allowed";
    }
  }

  $former = '';

  if ($lnameErr == '' && $fnameErr == '' && $usernameErr == '') {
    $sql = "UPDATE `admin` SET `firstname`='$fname',`lastname`='$lname',`username`='$username' WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      echo "<script>alert('Success')</script>";
      echo "<script> window.location='admin-profile.php' </script>";
    } else {
      echo "<script>alert('unsuccessful')</script>";
    }
  } else {
    $modal = "true";
    $dir = "#editadmin";
    $former = '<div class="modal-body" id="editresult"><input type="hidden" name="id" value="'.$id.'"><div class="form-group"><label> Firstname </label><input type="text" name="fname" class="form-control" value="' . $fname . '" placeholder="Enter firstname"><p style="color: #ff3333;">' . $fnameErr . '</p></div><div class="form-group"><label> Lastname </label><input type="text" name="lname" class="form-control" value="' . $lname . '" placeholder="Enter lastname"><p style="color: #ff3333;">' . $lnameErr . '</p></div><div class="form-group"><label> Username </label><input type="text" name="username" class="form-control" value="' . $username . '" placeholder="Enter Username"><p style="color: #ff3333;">' . $usernameErr . '</p></div></div>';
}
}
?>

<div class="modal fade" id="editadmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Admin Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

        <div class="modal-body" id="editresult">
        <?php echo $former; ?>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="updateadmin" id="updateadmin" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>