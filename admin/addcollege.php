<?php

$collegeErr = $colshortErr =  '';

function validate($data)
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

if (isset($_POST["addcollege"])) {
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $colshort = mysqli_real_escape_string($conn, $_POST['colshort']);
    

    if (empty($college)) {
        $collegeErr = "College is required";
    } else {
        $college = validate($college);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $college)) {
            $collegeErr = "only letters and white spaces allowed";
        }
    }
    if (empty($colshort)) {
        $colshortErr = "College Short is required";
    } else {
        $colshort = validate($colshort);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $colshort)) {
            $colshortErr = "only letters and white spaces allowed";
        }
    }
    
    if ($collegeErr == '' && $colshortErr == '') {
        $sql = "INSERT INTO `college`(`college_name`, `college_name_short`) 
        VALUES ('$college','$colshort')";
        $result = mysqli_query($conn, $sql);
        if ($result) {

            echo "<script>alert('Success')</script>";
            echo "<script> window.location='college-dept.php?coldep=college' </script>";
        } else {
            echo "<script>alert('unsuccessful')</script>";
        }
    } else {
        $modal = "true";
        $dir = "#addcollege";
    }
}

?>

<div class="modal fade" id="addcollege" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add <?php echo $coldep; ?> Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars('college-dept.php?coldep=college'); ?>" method="POST">

                <div class="modal-body">

                   
                    <div class="form-group">
                        <label for="college">College:</label>
                        <input type="text" class="form-control" id="college" name="college"><span><?php echo $collegeErr; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="colshort">College Short:</label>
                        <input type="text" class="form-control" id="colshort" name="colshort"><span><?php echo $colshortErr; ?></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="addcollege" class="btn btn-primary">Save</button>
                    </div>
            </form>

        </div>
    </div>
</div>
</div>

