<?php
$sql = "SELECT * FROM college";
$result = mysqli_query($conn, $sql);

$collegeErr = $deptErr =  '';

function validate($data)
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

if (isset($_POST["adddept"])) {
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $dept = mysqli_real_escape_string($conn, $_POST['dept']);


    if (empty($college)) {
        $collegeErr = "College is required";
    } else {
        $college = validate($college);

        if (!preg_match("/^[0-9' ]*$/", $college)) {
            $collegeErr = "only letters and white spaces allowed";
        }
    }
    if (empty($dept)) {
        $deptErr = "Dept is required";
    } else {
        $dept = validate($dept);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $dept)) {
            $deptErr = "only letters and white spaces allowed";
        }
    }

    if ($collegeErr == '' && $deptErr == '') {
        $sql = "INSERT INTO `dept`(`college_id`, `dept_name`) 
        VALUES ('$college','$dept')";
        $result = mysqli_query($conn, $sql);
        if ($result) {

            echo "<script>alert('Success')</script>";
            echo "<script> window.location='college-dept.php?coldep=dept' </script>";
        } else {
            echo "<script>alert('unsuccessful')</script>";
        }
    } else {
        $modal = "true";
        $dir = "#adddept";
    }
}

?>

<div class="modal fade" id="adddept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add <?php echo $coldep; ?> Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars('college-dept.php?coldep=dept'); ?>" method="POST">

                <div class="modal-body">


                    <div class="form-group">
                        <label class="form-control-label">College</label>
                        <select class="form-control" name="college" id="college1">
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
                        <label for="dept">Dept:</label>
                        <input type="text" class="form-control" id="dept" name="dept"><span><?php echo $deptErr; ?></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="adddept" class="btn btn-primary">Save</button>
                    </div>
            </form>

        </div>
    </div>
</div>
</div>