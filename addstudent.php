<?php
include_once 'conn.php';
session_start();

$sql = "SELECT * FROM college";
$result = mysqli_query($conn,$sql); 

$lnameErr = $fnameErr = $positionErr = $matricErr = $departmentErr = $collegeErr = $genderErr  = $passErr =  '';

function validate($data){
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

if(isset($_POST["create"])){
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $matric = mysqli_real_escape_string($conn, $_POST['matric']);
    $college = mysqli_real_escape_string($conn, $_POST['college']);    
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $password = mysqli_real_escape_string($conn, md5($_POST['addpass'] ));
    
    

    if(empty($lname)) {
    $lnameErr = "Lastname is required";
    }
    else{
        $lname = validate($lname);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
            $lnameErr = "only letters and white spaces allowed";
        }
    }
    if(empty($fname)) {
    $fnameErr = "Firstname is required";
    }
    else{
        $fname = validate($fname);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$fname)) {
            $fnameErr = "only letters and white spaces allowed";
        }
    }
    if(empty($position)) {
        $positionErr = "position is required";
    }
    
    else{
        $position = validate($position);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$position)) {
            $positionErr = "Only letters and white spaces allowed";
        }

    }
    if(empty($matric)) {
        $matricErr = "matric is required";
    }
    
    else{
        $matric = validate($matric);

        if(!preg_match("/^[0-9 \ ]*$/",$matric)) {
            $matricErr = "Only numbers allowed";
        }

    }
    if(empty($college)) {
        $collegeErr = "college is required";
    }
    
    else{
        $college = validate($college);

    }
    if(empty($department)) {
        $departmentErr = "department is required";
    }
    
    else{
        $department = validate($department);


    }
    
    if(empty($gender)) {
        $genderErr = "gender is required";
    }
    
    else{
        $gender = validate($gender);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$gender)) {
            $genderErr = "Only letters and white spaces allowed";
        }

    }
    if(empty($password)) {
        $passErr = "Password is required";
    }
    




    if($lnameErr == '' && $fnameErr == '' && $positionErr =='' && $matricErr =='' && $departmentErr =='' && $collegeErr =='' && $genderErr =='' && $passErr == '') {
        $sql = "INSERT INTO `student`(`Lastname`, `Firstname`, `Position`, `Matric`, `Department`, `College`, `Gender`, `password`) 
        VALUES ('$lname','$fname','$position','$matric','$department','$college','$gender','$password')";
        $result = mysqli_query($conn,$sql);
        if($result) {
            
            echo "<script>alert('Success')</script>";
            header("Location: creator.php");
        }
        else {
            echo "<script>alert('unsuccessful')</script>";
        }
    }
    


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo</title>
    
    <script src="jquery.min.js"></script>
</head>
<body>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="messageform">
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
            <label for="matric">Matric:</label>
            <input type="text" class="form-control" id="matric" name="matric"><span><?php echo $matricErr; ?></span>
        </div>
        <div class="form-group">
            <label class="form-control-label">College</label>
            <select name="college" id="college">
                <option value="">-----------------Select College----------------</option>
                <?php
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_assoc($result)){
                                        $id = $row['college_id'];
                                        $name = $row['college_name'];
                                        echo "<option value='$id'>".$name."</option>";
                                }
                                }else{
                                    echo "No results";
                                }
                        ?>
            </select><span> <?php echo $collegeErr ?></span>
        </div>
        <div class="form-group">
            <label class="form-control-label">Department</label>
            <select name="department" id="department">
                <option value="">--------------Select Department--------------</option>
            </select><span> <?php echo $departmentErr ?></span>
        </div>
        <div class="form-group">
            <label class="form-control-label" for="gender">Gender: </label>
            <input id="gender" type="radio" name="gender" value="male" checked>Male
            <input id="gender" type="radio" name="gender" value="female">Female
        </div>
        <div class="form-group">
            <label class="form-control-label" for="pwd">Password</label>
            <input id="pwd" type="password" class="form-control" placeholder="Password" name="addpass"><span> <?php echo $passErr ?></span>
        </div>
        <button type="submit" class="btn btn-success" name="create">Create</button>
	</form>

    <script>
    // College

    $('#college').on('change', function() {
        if($(this).val() != ''){
        var college_id = this.value;
        // console.log(college_id);
        $.ajax({
            url: 'ajax/dept.php',
            type: "POST",
            data: {
                college_data: college_id
            },
            success: function(data) {
                
                    $('#department').html(data);
                // console.log(data);
                
                
            }
        })
    }else{
                    $('#department').html('<option value="">--------------Select Department--------------</option>');
                }
    });
    
</script>
</body>
</html>