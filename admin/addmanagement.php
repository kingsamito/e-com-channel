<?php
$sql = "SELECT * FROM college";
$result = mysqli_query($conn, $sql);

$idErr = $lnameErr = $fnameErr = $positionErr = $emailErr = $telErr = $genderErr  =  '';

function validate($data)
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

if (isset($_POST["addmanagement"])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $lname = mysqli_real_escape_string($conn, ucwords($_POST['lname']));
    $fname = mysqli_real_escape_string($conn, ucwords($_POST['fname']));
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $position_short = mysqli_real_escape_string($conn, $_POST['position_short']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $tel = mysqli_real_escape_string($conn, $_POST['tel']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $dept = mysqli_real_escape_string($conn, $_POST['dept']);

    if (empty($id)) {
        $idErr = "Id required";
    } else {
        $id = validate($id);

        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            $idErr = "Integer Required";
        }
    }

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

    $password = md5('test');





    if ($idErr == '' && $lnameErr == '' && $fnameErr == '' && $positionErr == '' && $emailErr == '' && $telErr == '' && $genderErr == '') {
        $sql = "INSERT INTO `management`(`management_id`, `Lastname`, `Firstname`, `Position`, `Position_short`, `Email`, `Phone`, `Gender`, `college`,`Department`,`password`) 
        VALUES ('$id','$lname','$fname','$position','$position_short','$email','$tel','$gender','$college','$dept','$password')";
        $result = mysqli_query($conn, $sql);
        if ($result) {

            echo "<script>alert('Success')</script>";
            echo "<script> window.location='users.php?user=management' </script>";
        } else {
            echo "<script>alert('unsuccessful')</script>";
        }
    } else {
        $modal = "true";
        $dir = "#addmanagement";
    }
}

if (isset($_POST["addcsvmanagement"])) {
    $password = md5('test');
	//Import uploaded file to Database
	$handle = fopen($_FILES['filename']['tmp_name'], "r");

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $sql = "INSERT INTO `management`(`management_id`, `Lastname`, `Firstname`, `Position`, `Position_short`, `Email`, `Phone`, `Gender`, `College`, `Department`, `password`) 
        VALUES('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$password');";
		$result = mysqli_query($conn,$sql);
        
		}

	fclose($handle);
    echo "<script type='text/javascript'>alert('Successfully imported a CSV file!');</script>";
	echo "<script> window.location='users.php?user=management' </script>";
}
?>

<div class="modal fade" id="addmanagement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add <?php echo $user; ?> Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars('users.php?user=management'); ?>" method="POST">

                <div class="modal-body">

                    <div class="form-group">
                        <label for="id">Id No:</label>
                        <input type="text" class="form-control" id="id" name="id"><span><?php echo $idErr; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="lname">Lastname:</label>
                        <input type="text" class="form-control" id="lname" name="lname"><span><?php echo $lnameErr; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="fname">Firstname:</label>
                        <input type="text" class="form-control" id="fname" name="fname"><span><?php echo $fnameErr; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="position">Position:</label>
                        <input type="text" class="form-control" id="position" name="position"><span><?php echo $positionErr; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="position">Position_short:</label>
                        <input type="text" class="form-control" id="position_short" name="position_short" placeholder=""><span></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email"><span><?php echo $emailErr; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="tel">Phone Number:</label>
                        <input type="text" class="form-control" id="tel" name="tel"><span><?php echo $telErr; ?></span>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="gender">Gender: </label>
                        <input id="gender" type="radio" name="gender" value="male" checked>Male
                        <input id="gender" type="radio" name="gender" value="female">Female
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">College</label>
                        <select class="form-control" name="college" id="college1">
                            <option value="">-----------------Select College----------------</option>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['college_name_short'];
                                    $name = $row['college_name'];
                                    echo "<option value='$id'>" . $name . "</option>";
                                }
                            } else {
                                echo "No results";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Department</label>
                        <select class="form-control" name="dept" id="department1">
                            <option value="">--------------Select Department--------------</option>
                        </select><span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="addmanagement" class="btn btn-primary">Save</button>
                    </div>
            </form>

        </div>
    </div>
</div>
</div>


<div class="modal fade" id="addcsvmanagement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add <?php echo $user; ?> Import CSV/Excel file</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars('users.php?user=management'); ?>" method="POST" enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="form-group">
                        <label for="filename">CSV/Excel File:</label>
                        <input type="file" multiple name="filename" id="filename" class="input-large">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="addcsvmanagement" class="btn btn-primary">Save</button>
                    </div>
            </form>

        </div>
    </div>
</div>
</div>