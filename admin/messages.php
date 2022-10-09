<?php
include_once '../conn.php';

session_start();

if (!isset($_SESSION['username'])) {
  header('Location: login.php');
}

$message = $_GET['message'];


$username = $_SESSION['username'];

$sql = "SELECT * FROM `$message`";
$result = mysqli_query($conn, $sql);

include_once 'changepassword.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title> Crawford University | Admin Panel</title>
  <link rel="stylesheet" href="fontawesome-free-6.1.1-web/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="popper.min.js"></script>
  <script src="bootstrap.min.js"></script>



</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Crawford</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <li class="nav-item">
        <a class="nav-link" href="admin-profile.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Admin Profile</span></a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#users" aria-expanded="true" aria-controls="users">
          <i class="fas fa-fw fa-users"></i>
          <span>Users</span>
        </a>
        <div id="users" class="collapse" aria-labelledby="headingusers" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="users.php?user=management">Management</a>
            <a class="collapse-item" href="users.php?user=academic_staff">Academic Staff</a>
            <a class="collapse-item" href="users.php?user=non_academic_staff">Non Academic Staff</a>
            <a class="collapse-item" href="users.php?user=student">Student</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collegedept" aria-expanded="true" aria-controls="collegedept">
          <i class="fas fa-fw fa-school"></i>
          <span>College/Dept</span>
        </a>
        <div id="collegedept" class="collapse" aria-labelledby="headingcollege" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="college-dept.php?coldep=college">Colleges</a>
            <a class="collapse-item" href="college-dept.php?coldep=dept">Department</a>
          </div>
        </div>
      </li>


      



      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          


          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">

                  ADMIN

                </span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

                <form action="logout.php" method="POST">

                  <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>

                </form>


              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Admin Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                <div class="modal-body">

                  <div class="form-group">
                    <label> Firstname </label>
                    <input type="text" name="fname" class="form-control" placeholder="Enter firstname">
                    <p style="color: #ff3333;"><?php echo $fnameErr; ?></p>
                  </div>
                  <div class="form-group">
                    <label> Lastname </label>
                    <input type="text" name="lname" class="form-control" placeholder="Enter lastname">
                    <p style="color: #ff3333;"><?php echo $lnameErr; ?></p>
                  </div>
                  <div class="form-group">
                    <label> Username </label>
                    <input type="text" name="username" class="form-control" placeholder="Enter Username">
                    <p style="color: #ff3333;"><?php echo $usernameErr; ?></p>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" name="registerbtn" class="btn btn-primary">Save</button>
                </div>
              </form>

            </div>
          </div>
        </div>


        <div class="container-fluid">

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Admin Profile
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                  Add Admin Profile
                </button>
              </h6>
            </div>

            <div class="card-body">

              <div class="table-responsive">

              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th> ID </th>
                      <th> Sender </th>
                      <th> Date </th>
                      <th colspan="2" style="text-align: center;">Action </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                          <td> <?php echo $row['id']; ?> </td>
                          <td> <?php echo $row['sender']; ?> </td>
                          <td> <?php echo $row['date']; ?> </td>
                          <td>
                            <form action="" method="post">
                              <input type="hidden" name="edit_id" value="">
                              <a id="<?php echo $row['id'] ?>" href="#editadmin<?php echo $row['id'] ?>" data-toggle="modal"><button type="button" name="edit_btn" class="btn btn-success"> EDIT</button></a>
                            </form>
                          </td>
                          <td>
                            <form action="" method="post">
                              <input type="hidden" name="delete_id" value="">
                              <a id="<?php echo $row['id'] ?>" href="#deleteadmin<?php echo $row['id'] ?>" data-toggle="modal"><button type="button" name="delete_btn" class="btn btn-danger"> DELETE</button>
                            </form>
                            <?php include_once 'editadmin.php'; ?>
                            <?php include_once 'deleteadmin.php'; ?>
                          </td>
                        </tr>
                    <?php
                      }
                    }
                    ?>


                  </tbody>
                </table>

              </div>
            </div>
          </div>

        </div>

        
      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
  </div>
  <!-- End of Content Wrapper -->

  <script>
    $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
      $("body").toggleClass("sidebar-toggled");
      $(".sidebar").toggleClass("toggled");
      if ($(".sidebar").hasClass("toggled")) {
        $('.sidebar .collapse').collapse('hide');
      };
    });
  </script>
</body>

</html>