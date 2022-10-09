<?php

include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
    header("Location: login.php");
}

$sender = $_SESSION['Firstname'] . " " . $_SESSION['Lastname'];
$matric = $_SESSION['student_id'];
$gender = $_SESSION['Gender'];

$position = $_SESSION["Position"];



$toErr = $throughErr = $blockErr = $roomErr = $hostelErr = $subjectErr = $messageErr =  '';

function validate($data)
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

$thr = "";
if (isset($_POST["sendmessage"])) {
    $to = $_POST['to'];
    if (isset($_POST['through'])) {
        $through = $_POST['through'];
        foreach ($through as $item) {
            $thr .= $item . ";";
        }
    } else {
        $thr = "";
    }

    $block = mysqli_real_escape_string($conn, $_POST['block']);
    $room = mysqli_real_escape_string($conn, $_POST['room']);
    $hostel = ucwords($gender);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $message_date = date('d F Y');

    





    if (empty($block)) {
        $blockErr = "Block number is required";
    } else {
        $block = validate($block);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $block)) {
            $blockErr = "Only letters and white spaces allowed";
        }
    }
    if (empty($room)) {
        $roomErr = "Room number is required";
    } else {
        $room = validate($room);

        if (!filter_var($room, FILTER_VALIDATE_INT)) {
            $roomErr = "only integer allowed";
        }
    }

    if (empty($hostel)) {
        $hostelErr = "Hostel name is required";
    } else {
        $hostel = validate($hostel);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $hostel)) {
            $hostelErr = "Only letters and white spaces allowed";
        }
    }

    if (empty($subject)) {
        $subjectErr = "Subject is required";
    } else {
        $subject = validate($subject);

        if (!preg_match("/^[a-zA-Z0-9 .',;?_:!\/ ]*$/", $subject)) {
            $subjectErr = "Only letters and white spaces allowed";
        }
    }
    $subject = str_replace("'", "''", $subject);

    if (empty($message)) {
        $messageErr = "Message is required";
    } else {
        $message = validate($message);

        if (!preg_match("/^[a-zA-Z0-9 .',;?_:!\/ ]*$/", $message)) {
            $messageErr = "Only letters and white spaces allowed";
        }
    }
    $message = str_replace("'", "''", $message);

    if ($toErr == '' && $throughErr == '' && $blockErr == '' && $roomErr == '' && $hostelErr == '' && $subjectErr == '' && $messageErr == '') {
        $sql = "INSERT INTO `academic_letter_inbox`(`sender`, `id_no`, `too`, `through`, `block`, `room`, `hostel`, `subject`, `message`,`message_date`,`type`,`sender_position`,`status`) 
                VALUES('$sender', '$matric' , '$to', '$thr','$block','$room','$hostel','$subject','$message','$message_date','academic','$position','')";
        $sql1 = "INSERT INTO `academic_letter_sent`(`sender`, `id_no`, `too`, `through`, `block`, `room`, `hostel`, `subject`, `message`,`message_date`,`type`,`sender_position`)   
                VALUES('$sender', '$matric' , '$to', '$thr','$block','$room','$hostel','$subject','$message','$message_date','academic','$position')";
        $result = mysqli_query($conn, $sql);
        $result1 = mysqli_query($conn, $sql1);
        if ($result &&  $result1) {
            echo "<script>alert('Sent Successfully')</script>";
            echo "<script> window.location='studentdashboard.php?folder=sent' </script>";
        } else {
            echo "<script>alert('Message unsuccessfully')</script>";
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
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="lettertest.css">

    <script src="jquery.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <style>

    </style>

</head>

<body>
    <div class="container">
        <div class="my-3">
            <a href="studentdashboard.php"><button class="">&larr;</button></a>
        </div>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="messageform">


            <div class="clearfix">
                <div class="form-group float-right" style="width:50%">
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
                    <input type="text" class="form-control" id="hostel" name="hostel" value="<?php echo ucwords($gender); ?>" disabled><span><?php echo $hostelErr; ?></span>
                </div>
            </div>



            <div class="form-group" style="width:50%">
                <label for="to">To:</label>
                <select class="form-control" name="to" id="recipient">
                    <option value='Vice Chancellor'>Vice Chancellor</option>";
                    <option value='Dean <?php echo $_SESSION['College']; ?>'>Dean <?php echo $_SESSION['College']; ?></option>";
                    <option value='HOD <?php echo $_SESSION['Department']; ?>'>HOD <?php echo $_SESSION['Department']; ?></option>";
                    <option value='Program Coordinator <?php echo $_SESSION['Department']; ?>'>Program Coordinator <?php echo $_SESSION['Department']; ?></option>";
                </select>
            </div>
            <div class="form-group" id="through" style="width:50%">

                <label for="through">Through: </label>
                <input class="form-control" value="Dean <?php echo $_SESSION['College']; ?>" name="through[]"><br>
                <label for="through">Through: </label>
                <input class="form-control" value="HOD <?php echo $_SESSION['Department']; ?>" name="through[]"><br>
                <label for="through">Through: </label>
                <input class="form-control" value="Program Coordinator <?php echo $_SESSION['Department']; ?>" name="through[]"><br>

            </div>

            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" class="form-control text-center" id="subject" name="subject"><span><?php echo $subjectErr; ?></span>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" rows="15" id="message" name="message"></textarea><span><?php echo $messageErr; ?></span>
            </div>

            <div class="mb-3">
                <button type="submit" name="sendmessage" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>
</body>

<script>
    // to

    $('#recipient').on('change', function() {
        if ($(this).val() != '') {
            var recipient_id = this.value;
            // console.log(to_id);
            $.ajax({
                url: 'tester1.php',
                type: "POST",
                data: {
                    recipient_data: recipient_id
                },
                success: function(data) {

                    $('#through').html(data);
                    // console.log(data);


                }
            })
        } else {
            $('#whom').html('<option value="">Select Whom</option>');
        }
    });
</script>