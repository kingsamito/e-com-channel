<?php

$lnameErr = $fnameErr = $positionErr = $emailErr = $telErr = $genderErr  =  '';



if (isset($_POST["updatemanagement"])) {
    $id = $_POST['id'];
    $lname = mysqli_real_escape_string($conn, ucwords($_POST['lname']));
    $fname = mysqli_real_escape_string($conn, ucwords($_POST['fname']));
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $position_short = mysqli_real_escape_string($conn, $_POST['position_short']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $tel = mysqli_real_escape_string($conn, $_POST['tel']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $dept = mysqli_real_escape_string($conn, $_POST['dept']);

    if (empty($lname)) {
        $lnameErr = "Lastname is required";
    } else {
        $lname = validate($lname);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
            $lnameErr = "only letters and white spaces allowed";
        }
    }
    if (empty($fname)) {
        $fnameErr = "Firstname is required";
    } else {
        $fname = validate($fname);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
            $fnameErr = "only letters and white spaces allowed";
        }
    }
    if (empty($position)) {
        $positionErr = "position is required";
    } else {
        $position = validate($position);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $position)) {
            $positionErr = "Only letters and white spaces allowed";
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
    if (empty($tel)) {
        $telErr = "Phone number is required";
    } else {
        $tel = validate($tel);

        if (!preg_match("/^[0-9 \ ]*$/", $tel)) {
            $telErr = "Only numbers allowed";
        }
    }


    if (empty($gender)) {
        $genderErr = "gender is required";
    } else {
        $gender = validate($gender);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $gender)) {
            $genderErr = "Only letters and white spaces allowed";
        }
    }

    $former = '';

    if ($lnameErr == '' && $fnameErr == '' && $positionErr == '' && $emailErr == '' && $telErr == '' && $genderErr == '') {
        $sql = "UPDATE `management` SET `Lastname`='$lname', `Firstname`='$fname', `Position`='$position', `Position_short`='$position_short', `Email`='$email', `Phone`='$tel', `Gender`='$gender' WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script>alert('Success')</script>";
            echo "<script> window.location='users.php?user=management' </script>";
        } else {
            echo "<script>alert('unsuccessful')</script>";
        }
    } else {
        $modal = "true";
        $dir = "#editmanagement";
        $former = '<div class="modal-body" id="editresult"><input type="hidden" name="id" value="' . $id . '"><div class="form-group">
        <label for="lname">Lastname:</label>
        <input type="text" class="form-control" id="lname" name="lname" value="' . $lastname . '"><span><?php echo $lnameErr; ?></span>
    </div>
    <div class="form-group">
        <label for="fname">Firstname:</label>
        <input type="text" class="form-control" id="fname" name="fname" value="' . $firstname . '"><span><?php echo $fnameErr; ?></span>
    </div>
    <div class="form-group">
        <label for="position">Position:</label>
        <input type="text" class="form-control" id="position" name="position" value="' . $position . '"><span><?php echo $positionErr; ?></span>
    </div>
    <div class="form-group">
        <label for="position">Position_short:</label>
        <input type="text" class="form-control" id="position_short" name="position_short" value="' . $position_short . '"><span></span>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="' . $email . '"><span><?php echo $emailErr; ?></span>
    </div>
    <div class="form-group">
        <label for="tel">Phone Number:</label>
        <input type="text" class="form-control" id="tel" name="tel" value="' . $tel . '"><span><?php echo $telErr; ?></span>
    </div></div>';
    }
}
?>

<div class="modal fade" id="editmanagement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit management Data</h5>
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
                    <button type="submit" name="updatemanagement" id="updatemanagement" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>