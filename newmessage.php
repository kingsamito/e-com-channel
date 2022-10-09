<?php
include_once 'conn.php';
session_start();

if(!isset($_SESSION["Position"])){
    header("Location: login.php");
  }

$sender = $_SESSION['Firstname']." ".$_SESSION['Lastname'];
$matric = $_SESSION['Matric'];

$toErr = $throughErr = $blockErr = $roomErr = $hostelErr = $subjectErr = $messageErr = $parentErr =  '';

function validate($data){
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

if(isset($_POST["sendmessage"])){
    $to = mysqli_real_escape_string($conn, $_POST['to']);
    $through = mysqli_real_escape_string($conn, $_POST['through']);
    $block = mysqli_real_escape_string($conn, $_POST['block']);
    $room = mysqli_real_escape_string($conn, $_POST['room']);
    $hostel = mysqli_real_escape_string($conn, $_POST['hostel']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $parent = mysqli_real_escape_string($conn, $_POST['parent']);

    

    if(empty($to)) {
    $toErr = "to is required";
    }
    else{
        $to = validate($to);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$to)) {
            $toErr = "only letters and white spaces allowed";
        }
    }
    if(empty($through)) {
    $throughErr = "through is required";
    }
    else{
        $through = validate($through);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$through)) {
            $throughErr = "only letters and white spaces allowed";
        }
    }
    if(empty($block)) {
        $blockErr = "Block number is required";
    }
    
    else{
        $block = validate($block);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$block)) {
            $blockErr = "Only letters and white spaces allowed";
        }

    }
    if(empty($room)) {
        $roomErr = "Room number is required";
    }
    
    else{
        $room = validate($room);

        if(!filter_var($room,FILTER_VALIDATE_INT)) {
            $roomErr = "only integer allowed";
        }

    }

    if(empty($hostel)) {
        $hostelErr = "Hostel name is required";
    }
    
    else{
        $hostel = validate($hostel);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$hostel)) {
            $hostelErr = "Only letters and white spaces allowed";
        }

    }

    if(empty($subject)) {
        $subjectErr = "Subject is required";
    }
    
    else{
        $subject = validate($subject);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$subject)) {
            $subjectErr = "Only letters and white spaces allowed";
        }

    }
    if(empty($message)) {
        $messageErr = "Message is required";
    }
    
    else{
        $message = validate($message);

        if(!preg_match("/^[a-zA-Z0-9 .,?:!\/ ]*$/",$message)) {
            $messageErr = "Only letters and white spaces allowed";
        }

    }
    if(empty($parent)) {
        $parentErr = "Parent number is required";
    }
    
    else{
        $parent = validate($parent);

        if(!filter_var($parent,FILTER_VALIDATE_INT)) {
            $parentErr = "only integer allowed";
        }
    }



    if($toErr == '' && $throughErr == '' && $blockErr =='' && $roomErr == '' && $hostelErr == '' && $subjectErr == '' && $messageErr == '' && $parentErr == '') {
        $sql = "INSERT INTO `admininbox`(`sender`, `matric`, `to`, `through`, `block`, `room`, `hostel`, `subject`, `message`, `parentnumber`) VALUES('$sender', '$matric' , '$to', '$through','$block','$room','$hostel','$subject','$message','$parent')";
        $sql1 = "INSERT INTO `studentsent`(`sender`, `matric`, `to`, `through`, `block`, `room`, `hostel`, `subject`, `message`, `parentnumber`) VALUES('$sender', '$matric' , '$to', '$through','$block','$room','$hostel','$subject','$message','$parent')";
        $result = mysqli_query($conn,$sql);
        $result1 = mysqli_query($conn,$sql1);
        if($result &&  $result1) {
            echo "<script>alert('Sent Successfully')</script>";
            header("Location: studentinbox.php");
        }
        else {
            echo "<script>alert('Message unsuccessfully')</script>";
        }
    }
    


}

if(isset($_POST["savemessage"])){
    $to = mysqli_real_escape_string($conn, $_POST['to']);
    $through = mysqli_real_escape_string($conn, $_POST['through']);
    $block = mysqli_real_escape_string($conn, $_POST['block']);
    $room = mysqli_real_escape_string($conn, $_POST['room']);
    $hostel = mysqli_real_escape_string($conn, $_POST['hostel']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $parent = mysqli_real_escape_string($conn, $_POST['parent']);

    

    if(empty($to)) {
    $toErr = "to is required";
    }
    else{
        $to = validate($to);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$to)) {
            $toErr = "only letters and white spaces allowed";
        }
    }
    if(empty($through)) {
    $throughErr = "through is required";
    }
    else{
        $through = validate($through);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$through)) {
            $throughErr = "only letters and white spaces allowed";
        }
    }
    if(empty($block)) {
        $blockErr = "Block number is required";
    }
    
    else{
        $block = validate($block);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$block)) {
            $blockErr = "Only letters and white spaces allowed";
        }

    }
    if(empty($room)) {
        $roomErr = "Room number is required";
    }
    
    else{
        $room = validate($room);

        if(!filter_var($room,FILTER_VALIDATE_INT)) {
            $roomErr = "only integer allowed";
        }

    }

    if(empty($hostel)) {
        $hostelErr = "Hostel name is required";
    }
    
    else{
        $hostel = validate($hostel);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$hostel)) {
            $hostelErr = "Only letters and white spaces allowed";
        }

    }

    if(empty($subject)) {
        $subjectErr = "Subject is required";
    }
    
    else{
        $subject = validate($subject);

        if(!preg_match("/^[a-zA-Z-' ]*$/",$subject)) {
            $subjectErr = "Only letters and white spaces allowed";
        }

    }
    if(empty($message)) {
        $messageErr = "Message is required";
    }
    
    else{
        $message = validate($message);

        if(!preg_match("/^[a-zA-Z0-9 .,?:!\/ ]*$/",$message)) {
            $messageErr = "Only letters and white spaces allowed";
        }

    }
    if(empty($parent)) {
        $parentErr = "Parent number is required";
    }
    
    else{
        $parent = validate($parent);

        if(!filter_var($parent,FILTER_VALIDATE_INT)) {
            $parentErr = "only integer allowed";
        }
    }



    if($toErr == '' && $throughErr == '' && $blockErr =='' && $roomErr == '' && $hostelErr == '' && $subjectErr == '' && $messageErr == '' && $parentErr == '') {
        $sql = "INSERT INTO `studentdraft`(`sender`, `matric`, `to`, `through`, `block`, `room`, `hostel`, `subject`, `message`, `parentnumber`) VALUES('$sender', '$matric' , '$to', '$through','$block','$room','$hostel','$subject','$message','$parent')";
        $result = mysqli_query($conn,$sql);
        if($result) {
            echo "<script>alert('Sent Successfully')</script>";
            header("Location: studentinbox.php");
        }
        else {
            echo "<script>alert('Message unsuccessfully')</script>";
        }
    }
    


}
?>
<html>
<head>
	<link rel="stylesheet" href="bootstrap.min.css">
    
    <script src="jquery.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
	<style>
		.form-group{
			margin-bottom: 0;
		}
		label{
			margin-bottom: 0;
		}
	</style>
</head>
<body>
	<div class="row mt-4">
		<div class="col-md-7 m-auto">
			<div class="container">
        <div class="d-flex justify-content-between mb-1">
          <h2>Message</h2>
          <div>
            <button type="submit" name="savemessage" class="btn btn-primary" form="messageform">Save</button>
            <button type="submit" name="sendmessage" class="btn btn-primary" form="messageform">Send</button>
          </div>
          
    	</div>

		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="messageform">
		<div class="form-group" style="width:50%">
			<label for="to">To:</label>
			<input type="text" class="form-control" id="to" name="to"><span><?php echo $toErr; ?></span>
		</div>
		<div class="form-group" style="width:50%">
			<label for="through">Through:</label>
			<input type="text" class="form-control" id="through" name="through"><span><?php echo $throughErr; ?></span>
		</div>
		<div class="clearfix">
			<div class="form-group float-right"  style="width:50%">
				<label for="block">Block name:</label>
				<input type="text" class="form-control" id="block" name="block"><span><?php echo $blockErr; ?></span>
			</div>
		</div>
		<div class="clearfix">
			<div class="form-group float-right" style="width:50%">
				<label for="room">Room No:</label>
				<input type="number" class="form-control" id="room" name="room"><span><?php echo $roomErr; ?></span>
			</div>
		</div>
		<div class="clearfix">
			<div class="form-group float-right" style="width:50%">
				<label for="hostel">Male/Female Hostel:</label>
				<input type="text" class="form-control" id="hostel" name="hostel"><span><?php echo $hostelErr; ?></span>
			</div>
		</div>


		<div class="form-group">
			<label for="subject">Subject:</label>
			<input type="text" class="form-control text-center" id="subject" name="subject"><span><?php echo $subjectErr; ?></span>
		</div>
		<div class="form-group">
			<label for="message">Message:</label>
			<textarea class="form-control" rows="15" id="message" name="message"></textarea><span><?php echo $messageErr; ?></span>
		</div>
        <div class="form-group">
			<label for="parent">Parent No:</label>
			<input type="number" class="form-control" id="parent" name="parent"><span><?php echo $parentErr; ?></span>
		</div>

		</form>
			</div>
		</div>
	</div>
</body>
</html>