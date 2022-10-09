<?php
$url = $_SERVER['REQUEST_URI'];
$oldErr = $newErr = $conewErr = '';

if (isset($_POST["changepass"])) {
    $old = mysqli_real_escape_string($conn, $_POST['old']);
    $new = mysqli_real_escape_string($conn, $_POST['new']);
    $conew = mysqli_real_escape_string($conn, $_POST['conew']);
  
  
    if (empty($old)) {
      $oldErr = "** Old Password is required";
    } else {
      $old = md5($old);
    }
    if (empty($new)) {
      $newErr = "** New Password is required";
    } else {
      $new = md5($new);
    }
    if (empty($conew)) {
      $conewErr = "** Confirm Password is required";
    } else {
      $conew = md5($conew);
    }
  
    if ($oldErr == '' && $newErr == '' && $conewErr == '' && $old != $password) {
      $oldErr = "** Incorrect Old Password";
    } else {
      if ($new != $conew) {
        $newErr = "** Password Doesn't Match";
        $conewErr = "** Password Doesn't Match";
      }
    }
  
  
    if ($oldErr == '' && $newErr == '' && $conewErr == '') {
      $sql = "UPDATE `management` SET `password` = '$conew' WHERE `management_id` = $id";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        $_SESSION['password'] = $conew;
        echo "<script>alert('Success')</script>";
        header("Location: $url");
      } else {
        echo "<script>alert('Unsuccessful')</script>";
      }
    }
}