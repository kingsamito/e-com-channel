<?php
if (isset($_POST["deleteadmin"])) {
  $id = $_POST['id'];
  $sql = "DELETE FROM `admin` WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('Success')</script>";
    echo "<script> window.location='admin-profile.php' </script>";
  } else {
    echo "<script>alert('unsuccessful')</script>";
  }
}
if (isset($_POST["deletemanagement"])) {
  $id = $_POST['id'];
  $sql = "DELETE FROM `management` WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('Success')</script>";
    echo "<script> window.location='users.php?user=management' </script>";
  } else {
    echo "<script>alert('unsuccessful')</script>";
  }
}
if (isset($_POST["deletemanagement"])) {
  $id = $_POST['id'];
  $sql = "DELETE FROM `management` WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('Success')</script>";
    echo "<script> window.location='users.php?user=management' </script>";
  } else {
    echo "<script>alert('unsuccessful')</script>";
  }
}
if (isset($_POST["deleteacademic_staff"])) {
  $id = $_POST['id'];
  $sql = "DELETE FROM `academic_staff` WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('Success')</script>";
    echo "<script> window.location='users.php?user=academic_staff' </script>";
  } else {
    echo "<script>alert('unsuccessful')</script>";
  }
}
if (isset($_POST["deletenon_academic_staff"])) {
  $id = $_POST['id'];
  $sql = "DELETE FROM `non_academic_staff` WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('Success')</script>";
    echo "<script> window.location='users.php?user=non_academic_staff' </script>";
  } else {
    echo "<script>alert('unsuccessful')</script>";
  }
}
if (isset($_POST["deletestudent"])) {
  $id = $_POST['id'];
  $sql = "DELETE FROM `student` WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('Success')</script>";
    echo "<script> window.location='users.php?user=student' </script>";
  } else {
    echo "<script>alert('unsuccessful')</script>";
  }
}
?>
<div class="modal fade" id="deletequery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Are you sure you want to delete this user ?</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="formid">
          

        </form>


      </div>
    </div>
  </div>
</div>