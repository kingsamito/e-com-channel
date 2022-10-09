<?php
include_once 'conn.php';
session_start();


$lnameErr = $fnameErr = $positionErr = $emailErr = $telErr = $genderErr  = $passErr =  '';

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
    $email = mysqli_real_escape_string($conn, $_POST['email']);    
    $tel = mysqli_real_escape_string($conn, $_POST['tel']);
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
    if(empty($email)) {
        $emailErr = "Email is required";
    }
    
    else{
        $email = validate($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }

    }
    if(empty($tel)) {
        $telErr = "Phone number is required";
    }
    
    else{
        $tel = validate($tel);

         if(!preg_match("/^[0-9 \ ]*$/",$tel)) {
            $telErr = "Only numbers allowed";
        }

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
    




    if($lnameErr == '' && $fnameErr == '' && $positionErr =='' && $emailErr =='' && $telErr =='' && $genderErr =='' && $passErr == '') {
        $sql = "INSERT INTO `management`(`Lastname`, `Firstname`, `Position`, `Email`, `Phone`, `Gender`, `password`) 
        VALUES ('$lname','$fname','$position','$email','$tel','$gender','$password')";
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
            <label class="form-control-label" for="pwd">Password</label>
            <input id="pwd" type="password" class="form-control" placeholder="Password" name="addpass"><span> <?php echo $passErr ?></span>
        </div>
        <button type="submit" class="btn btn-success" name="create">Create</button>
	</form>

</body>
</html>