<?php

include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
  header("Location: login.php");
}

$id = $_SESSION['management_id'];
$firstname = $_SESSION['Firstname'];
$lastname = $_SESSION['Lastname'];
$position = $_SESSION['Position'];
$position_short = $_SESSION['Position_short'];
$college = $_SESSION['college'];
$dept = $_SESSION['dept'];
$password = $_SESSION['password'];

$member =  $_SESSION["member"];
$memberinbox = $member . "_inbox";
$memberdraft = $member . "_draft";
$membersent = $member . "_sent";



$all = 'All ' . $position_short . 's';

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


if ($member == "management") {
  $sql1 = "SELECT * FROM academic_letter_inbox";
  $result1 = mysqli_query($conn, $sql1);

  $tin = '';
  $value = '';
  if (mysqli_num_rows($result1) > 0) {
    while ($row = mysqli_fetch_assoc($result1)) {

      for ($i = 0; $i < count(explode(";", $row['through'])) - 1; $i++) {

        $tin = explode(";", $row['through'])[$i] . ' ';
      }
      $value .=  $tin;
    }
  }

  //selct all where the personlogged in is the last person
  if (preg_match("/$position/i", $value)) {
    $sql = "SELECT `id`,`sender`,`subject`,`date`, `type`,`status` FROM academic_letter_inbox WHERE through like '%$position%' or too = '$position'
          UNION 
          SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status` FROM commented_academic_letter_inbox WHERE commented_to = '$position'
          UNION
          SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `memo_inbox` WHERE receiver = '$position' or receiver = '$all'
          UNION
          SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `forwarded_memo_inbox` WHERE forwarded_to = '$position' or forwarded_to = '$all' ORDER by `date` DESC";
    $result = mysqli_query($conn, $sql);
    $inboxnum = mysqli_num_rows($result);
  } else {
    $sql = "SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status` FROM commented_academic_letter_inbox WHERE commented_to = '$position'
          UNION
          SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `memo_inbox` WHERE receiver = '$position' or receiver = '$all'
          UNION
          SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `forwarded_memo_inbox` WHERE forwarded_to = '$position' or forwarded_to = '$all' ORDER by `date` DESC";
    $result = mysqli_query($conn, $sql);
    $inboxnum = mysqli_num_rows($result);
  }


  $sentsql = "SELECT `id`,`commented_to` AS `receiver`, `subject`,`type`, `date`,`status` FROM commented_academic_letter_sent WHERE forwarded_by = '$position' 
              UNION
              SELECT `id`, `receiver`, `subject`,`type`, `date`,`status` FROM `memo_sent` WHERE sender = '$position' 
              UNION
              SELECT `id`,`forwarded_to`  AS `receiver`, `subject`,`type`,`date`,`status`  FROM `forwarded_memo_sent` WHERE forwarded_by = '$position' ORDER by `date` DESC";
  $sentresult = mysqli_query($conn, $sentsql);
  $sentnum = mysqli_num_rows($sentresult);
}
?>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <title> Crawford University | Management</title>
  <link rel="stylesheet" href="admin/fontawesome-free-6.1.1-web/css/all.min.css">
  <link rel="stylesheet" href="admin/style.css">
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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="managementdashboard.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Crawford</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="managementdashboard.php?folder=inbox">
          <i class="fas fa-inbox fa-fw"></i>
          <!-- Counter - Messages -->
          <span class="badge badge-danger badge-counter"><?php echo $inboxnum; ?></span>
          <span>Inbox</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <li class="nav-item active">
        <a class="nav-link" href="managementdashboard.php?folder=sent">
          <i class="fas fa-envelope fa-fw"></i>
          <!-- Counter - Messages -->
          <span class="badge badge-danger badge-counter"><?php echo $sentnum; ?></span>
          <span>Sent</span></a>
      </li>




      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>


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
                <span class="mr-2 d-none d-lg-inline text-gray-600 small text-uppercase">

                  <?php echo $position; ?>

                </span>
                <i class="fas fa-fw fa-user"></i>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changepassword">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Change Password
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

        <div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form action="" method="POST">
                <div class="modal-body">

                  <div class="form-group">
                    <label for="old">Old Password:</label>
                    <input type="password" class="form-control" id="old" name="old"><span><?php echo $oldErr ?></span>
                  </div>
                  <div class="form-group">
                    <label for="new">New Password:</label>
                    <input type="password" class="form-control" id="new" name="new"><span><?php echo $newErr ?></span>
                  </div>
                  <div class="form-group">
                    <label for="conew">Confirm New Password:</label>
                    <input type="password" class="form-control" id="conew" name="conew"><span><?php echo $conewErr ?></span>
                  </div>
                </div>
                <div class="modal-footer">

                  <button type="submit" name="changepass" class="btn btn-primary">Save</button>

              </form>


            </div>
          </div>
        </div>
      </div>

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

      <!-- Begin Page Content -->
      <div class="container-fluid">

        <!-- Page Heading -->

      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
  </div>
  </div>
  <script>
    $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
      $("body").toggleClass("sidebar-toggled");
      $(".sidebar").toggleClass("toggled");
      if ($(".sidebar").hasClass("toggled")) {
        $('.sidebar .collapse').collapse('hide');
      };
    });
  </script>
  <script>
    function loadlog() {
      var nrlm;
      var url = window.location.href;
      if (!url.search(/folder\b/i)) {
        urlm = 'getmessage.php';
      }

      if (url.search(/folder\b/i)) {
        if (url.search(/folder=inbox\b/i) != -1) {
          urlm = 'getmessage.php';
        }
      }

      if (url.search(/folder\b/i)) {
        if (url.search(/folder=sent\b/i) != -1) {
          urlm = 'getsentmessage.php';
        }
      }

      $.ajax({
        url: urlm,
        type: "POST",
        cache: false,
        success: function(data) {

          $(".container-fluid").html(data);


        }
      });
    }

    setInterval(loadlog, 10)
  </script>
</body>

</html>



<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Inbox</h1>
    <div class="dropdown">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">New Message</button>
        <div class="dropdown-menu">
            <?php

            echo '<a class="dropdown-item" href="memo.php">Memo</a>';

            ?>

        </div>
    </div>
</div>


<?php
include_once 'conn.php';

session_start();

$position = $_SESSION['Position'];
$position_short = $_SESSION['Position_short'];
$all = 'All ' . $position_short . 's';

$sql1 = "SELECT * FROM academic_letter_inbox";
$result1 = mysqli_query($conn, $sql1);

$tin = '';
$value = '';
if (mysqli_num_rows($result1) > 0) {
  while ($row = mysqli_fetch_assoc($result1)) {

    for ($i = 0; $i < count(explode(";", $row['through'])) - 1; $i++) {

      $tin = explode(";", $row['through'])[$i] . ' ';
    }
    $value .=  $tin;
  }
}

//selct all where the personlogged in is the last person
if (preg_match("/$position/i", $value)) {
  $sql = "SELECT `id`,`sender`,`subject`,`date`, `type`,`status` FROM academic_letter_inbox WHERE through like '%$position%' or too = '$position'
        UNION 
        SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status` FROM commented_academic_letter_inbox WHERE commented_to = '$position'
        UNION
        SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `memo_inbox` WHERE receiver = '$position' or receiver = '$all'
        UNION
        SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `forwarded_memo_inbox` WHERE forwarded_to = '$position' or forwarded_to = '$all' ORDER by `date` DESC";
  $result = mysqli_query($conn, $sql);
  $inboxnum = mysqli_num_rows($result);
} else {
  $sql = "SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status` FROM commented_academic_letter_inbox WHERE commented_to = '$position'
        UNION
        SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `memo_inbox` WHERE receiver = '$position' or receiver = '$all'
        UNION
        SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `forwarded_memo_inbox` WHERE forwarded_to = '$position' or forwarded_to = '$all' ORDER by `date` DESC";
  $result = mysqli_query($conn, $sql);
  $inboxnum = mysqli_num_rows($result);
}

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
            if ($row["status"] == "") {
                $output =
                '<div class="mb-4 px-3">
                    <div class="card border-left-primary shadow">
                        <a href="memoinboxopener.php?id='.$row["id"].'" class="list-group-item-action stretched-link">
                            <div class="card-body p-3">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">'.$row["sender"].'</div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">'.$row["subject"].'</div>
                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">'.$row["date"].'</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>';
            } else {
            $output =
                '<div class="mb-4 px-3">
                    <div class="card border-left-primary shadow">
                        <a href="memoinboxopener.php?id='.$row["id"].'" class="list-group-item-action stretched-link">
                            <div class="card-body p-3">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">'.$row["sender"].'</div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">'.$row["subject"].'</div>
                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">'.$row["date"].'</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>';

            }
        }
    }


    echo $output;


    <div class="mb-4 px-3">
    <div class="card">
            <a href="memoinboxopener.php?id=' . $row["id"] . '" class="list-group-item-action ">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">' . $row["sender"] . '</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">' . $row["subject"] . '</div>
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">' . $row["date"] . '</div>
                    </div>
                </div>
            </a>
        </div>
    
            <div class="card">
            <a href="memoinboxopener.php?id=' . $row["id"] . '" class="list-group-item-action ">
                <div class="card-body p-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">' . $row["sender"] . '</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">' . $row["subject"] . '</div>
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">' . $row["date"] . '</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    