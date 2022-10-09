<?php

$lnameErr = $fnameErr = $usernameErr = $emailErr = '';

function validate($data)
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

if (isset($_POST["addadmin"])) {
    $lname = mysqli_real_escape_string($conn, ucwords($_POST['lname']));
    $fname = mysqli_real_escape_string($conn, ucwords($_POST['fname']));
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    if (empty($lname)) {
        $lnameErr = "** Lastname is required";
    } else {
        $lname = validate($lname);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
            $lnameErr = "** Only letters and white spaces allowed";
        }
    }
    if (empty($fname)) {
        $fnameErr = "** Firstname is required";
    } else {
        $fname = validate($fname);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
            $fnameErr = "** Only letters and white spaces allowed";
        }
    }
    if (empty($email)) {
        $emailErr = "Email is required";
    } else {
        $email = validate($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    if (empty($username)) {
        $usernameErr = "** Username is required";
    } else {
        $username = validate($username);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $username)) {
            $usernameErr = "** Only letters and white spaces allowed";
        }
    }
    
    $password = md5('test');

    if ($lnameErr == '' && $fnameErr == '' && $usernameErr == '' && $emailErr == '') {
        $sql = "INSERT INTO `admin`(`firstname`, `lastname`,`email`, `username`, `password`) 
        VALUES ('$lname','$fname','$email','$username','$password')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script>alert('Success')</script>";
            echo "<script> window.location='admin-profile.php' </script>";
        } else {
            echo "<script>alert('unsuccessful')</script>";
        }
    }else{
        $modal = "true";
    }
}
?>
