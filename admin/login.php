<?php
include_once '../conn.php';

session_start();

function validate($data)
{
  $data = htmlspecialchars($data);
  $data = stripslashes($data);
  $data = trim($data);
  return $data;
}
$userErr = $passErr = '';


if (isset($_POST["signin"])) {
  $user = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (empty($user)) {
    $userErr = "** Username required";
  } else {
    $user = validate($user);

    if (!preg_match("/^[a-zA-Z0-9 .,?:!\/ ]*$/", $user)) {
      $userErr = "** Only letters and white spaces allowed";
    }
  }

  if (empty($password)) {
    $passErr = "** password is required";
  } else {
    $password = md5($password);
  }



  if ($userErr == '' && $passErr == '') {
    $sql = "SELECT * FROM `admin` WHERE `username` = '$user' AND `password` = '$password';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      foreach ($row as $x => $x_value) {
        $_SESSION[$x] = $x_value;
      }
      header("Location: index.php");
    } else {
      echo "<script>alert('Incorrect user/Password')</script>";
    }
  }
}


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

<body>

  <div class="container">

    
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-6 col-md-6">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Login Here!</h1>
                  </div>

                  <form class="user" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                    <div class="form-group">
                      <input type="text" name="username" class="form-control form-control-user" placeholder="Enter Username">
                      <p style="color: #ff3333;"><?php echo $userErr; ?></p>
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" placeholder="Enter Password">
                      <p style="color: #ff3333;"><?php echo $passErr; ?></p>
                    </div>

                    <button type="submit" name="signin" class="btn btn-primary btn-user btn-block"> Login </button>
                    <hr>
                  </form>


                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

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
</body>

</html>