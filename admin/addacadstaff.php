<?php

$sql = "SELECT * FROM college";
$result = mysqli_query($conn, $sql);

$idErr = $lnameErr = $fnameErr = $emailErr = $departmentErr = $collegeErr = $genderErr  = $passErr =  '';


if (isset($_POST["addnacademicstaff"])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

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
    if (empty($email)) {
        $emailErr = "Email is required";
    } else {
        $email = validate($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    
    if (empty($college)) {
        $collegeErr = "college is required";
    } else {
        $college = validate($college);
    }
    if (empty($department)) {
        $departmentErr = "department is required";
    } else {
        $department = validate($department);
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






    if ($lnameErr == '' && $fnameErr == '' && $emailErr == '' && $departmentErr == '' && $collegeErr == '' && $genderErr == '' && $passErr == '') {
        $sql = "INSERT INTO `academic_staff`(`academic_staff_id`, `Lastname`, `Firstname`, `email`, `Position`, `Department`, `College`, `Gender`, `password`) 
        VALUES ('$id','$lname','$fname','$email','Lecturer','$department','$college','$gender','$password')";
        $result = mysqli_query($conn, $sql);
        if ($result) {

            echo "<script>alert('Success')</script>";
            echo "<script> window.location='users.php?user=academic_staff' </script>";
        } else {
            echo "<script>alert('unsuccessful')</script>";
        }
    } else {
        $modal = "true";
        $dir = "#addacademicstaff";
    }
}
if (isset($_POST["addcsvacademicstaff"])) {
    $password = md5('test');
	//Import uploaded file to Database
	$handle = fopen($_FILES['filename']['tmp_name'], "r");

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $sql = "INSERT INTO `academic_staff`(`academic_staff_id`, `Lastname`, `Firstname`, `email`, `Position`, `Department`, `College`, `Gender`, `password`) 
        values('$data[0]','$data[1]','$data[2]','$data[3]',,'$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$password'))";
		
		}

	fclose($handle);

	echo "<script type='text/javascript'>alert('Successfully imported a CSV file!');</script>";
	echo "<script> window.location='users.php?user=academic_staff' </script>";
}
?>

<div class="modal fade" id="addacademicstaff" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add <?php echo $user; ?> Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars('users.php?user=academic_staff'); ?>" method="POST">

                <div class="modal-body">

                    <div class="form-group">
                        <label for="id">Id:</label>
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
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email"><span><?php echo $emailErr; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">College</label>
                        <select class="form-control" name="college" id="college">
                            <option value="">-----------------Select College----------------</option>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['college_id'];
                                    $name = $row['college_name'];
                                    echo "<option value='$id'>" . $name . "</option>";
                                }
                            } else {
                                echo "No results";
                            }
                            ?>
                        </select><span> <?php echo $collegeErr ?></span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Department</label>
                        <select class="form-control" name="department" id="department">
                            <option value="">--------------Select Department--------------</option>
                        </select><span> <?php echo $departmentErr ?></span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="gender">Gender: </label>
                        <input id="gender" type="radio" name="gender" value="male" checked>Male
                        <input id="gender" type="radio" name="gender" value="female">Female
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="addnacademicstaff" class="btn btn-primary">Save</button>
                    </div>
            </form>

        </div>
    </div>
</div>
</div>


<div class="modal fade" id="addcsvacademicstaff" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add <?php echo $user; ?> Import CSV/Excel file</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars('users.php?user=student'); ?>" method="POST">

                <div class="modal-body">

                    <div class="form-group">
                        <label for="filename">CSV/Excel File:</label>
                        <input type="file" multiple name="filename" id="filename" class="input-large">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="addcsvacademicstaff" class="btn btn-primary">Save</button>
                    </div>
            </form>

        </div>
    </div>
</div>
</div>