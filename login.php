<?php
include_once 'conn.php';

session_start();

function validate($data)
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}
$userErr = $passErr = $memberErr = '';


if (isset($_POST["signin"])) {
    $user = mysqli_real_escape_string($conn, $_POST['login_info']);
    $password = mysqli_real_escape_string($conn, $_POST['login_password']);
    $member = $_POST['member_type'];

    if (empty($user)) {
        $userErr = "** User required";
    } else {
        $user = validate($user);

        if (!filter_var($user, FILTER_VALIDATE_INT)) {
            $userErr = "** Integer Required";
        }
    }

    if (empty($password)) {
        $passErr = "** Password is required";
    } else {
        $password = md5($password);
    }



    if ($userErr == '' && $passErr == '') {
        if ($member == '') {
            $memberErr = "Designation Required";
        } else {
            $id = $member . "_id";
            $sql = "SELECT * FROM $member WHERE $id = '$user' AND password = '$password';";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                foreach ($row as $x => $x_value) {
                    $_SESSION[$x] = $x_value;
                }
                $_SESSION['member'] = $member;
                $location = $_SESSION['member'] . "dashboard.php";
                header("Location: $location");
            } else {
                echo "<script>alert('Incorrect user/Password')</script>";
            }
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
  <link rel="stylesheet" href="admin/style.css">
  <link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="popper.min.js"></script>
  <script src="bootstrap.min.js"></script>
  <style>
        span {
            color: red;
        }

    </style>
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

              <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
                <div class="form-group ">
                    <input id="info" type="text" class="form-control" placeholder="Username/user/CRU No." name="login_info"><span> <?php echo $userErr ?></span>
                </div>
                <div class="form-group">
                    <input id="pwd" type="password" class="form-control" placeholder="Password" name="login_password"><span> <?php echo $passErr ?></span>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Member Type</label>
                    <select name="member_type">
                        <option value="">Select Category</option>
                        <option value="non_academic_staff">Non Academic Staff</option>
                        <option value="academic_staff">Academic Staff</option>
                        <option value="student">Student</option>
                        <option value="management">Management</option>
                    </select><span> <?php echo $memberErr ?></span>
                </div>
                <div class="button">
                <button type="submit" name="signin" class="btn btn-primary btn-user btn-block"> Login </button>
                </div>
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


</body>

</html>