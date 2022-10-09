<?php
include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
    header("Location: login.php");
}

$sender = $_SESSION['Position'];
$name = $_SESSION['Firstname'] . " " . $_SESSION['Lastname'];
$college = $_SESSION['College'];
$dept = $_SESSION['Department'];

$member = $_SESSION['member'];

/* $sql = "SELECT * FROM recipient";
$result = mysqli_query($conn, $sql);

if ($sender != 'Vice Chancellor' || $sender != 'Registrar') {


    $che = "SELECT * FROM `too` WHERE `Position` = '$sender'";
    $cheresult = mysqli_query($conn, $che);

    if (mysqli_num_rows($cheresult) > 0) {
        $cherow = mysqli_fetch_assoc($cheresult);
    }
    $college_id = $cherow['college_id'];

    $collegenamesql = "SELECT college_name_short FROM college WHERE college_id = $college_id";
    $collegenamesqlresult = mysqli_query($conn, $collegenamesql);
    if (mysqli_num_rows($collegenamesqlresult)) {
        while ($row = mysqli_fetch_assoc($collegenamesqlresult)) {
            $collegename = $row['college_name_short'];
            $_SESSION['collegename'] = $collegename;
        }
    }
} */



$refErr = $recipientErr = $subjectErr = $messageErr =  '';

function validate($data)
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

if (isset($_POST["sendmessage"])) {
    $ref = mysqli_real_escape_string($conn, $_POST['ref']);
    $recipient = mysqli_real_escape_string($conn, $_POST['recipient']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $date = date('F d,Y');
    $time = date("h:i:sa");


    if (empty($ref)) {
        $refErr = "Ref is required";
    } else {
        $ref = validate($ref);

        if (!preg_match("/^[a-zA-Z0-9 .,?:!\/ ]*$/", $ref)) {
            $refErr = "Only letters and white spaces allowed";
        }
    }

    if ($recipient == '') {
        $recipientErr = "Recipient is required";
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

    if ($refErr == '' && $recipientErr == '' && $subjectErr == '' && $messageErr == '') {

        $sql = "INSERT INTO `memo_inbox`(`sender`, `ref`, `receiver`, `message_date`, `time`, `subject`, `message`, `name`, `type`, `status`) 
        VALUES ('$sender','$ref','$recipient','$date','$time','$subject','$message','$name','memo','')";
        $result = mysqli_query($conn, $sql);

        $sql1 = "INSERT INTO `memo_sent`(`sender`, `ref`, `receiver`, `message_date`, `time`, `subject`, `message`, `name`,  `type`, `status`) 
        VALUES ('$sender','$ref','$recipient','$date','$time','$subject','$message','$name','memo','read')";
        $result1 = mysqli_query($conn, $sql1);
        if ($result && $result1) {
            echo "<script>alert('Sent Successfully')</script>";
            header("Location: managementdashboard.php?folder=sent");
        } else {
            echo "<script>alert('Message unsuccessful')</script>";
           
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
            <a href="managementdashboard.php"><button class="">&larr;</button></a>
        </div>
    
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="header row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="from">From:</label>
                        <input type="text" class="form-control" id="from" name="from" value="<?php echo $sender; ?>" disabled><span></span>
                    </div>
                    <div class="form-group">
                        <label for="ref">Ref:</label>
                        <input type="text" class="form-control" id="ref" name="ref"><span><?php echo $refErr; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="text" class="form-control" id="date" name="datee" value="<?php echo date('F d, Y'); ?>" disabled><span></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="to">To:</label>
                        <select name="recipient" class="form-control" id="recipient">
                            <option value="">Select Recipient</option>
                            <?php
                            $who = "Vice Chancellor";
                            $too = "Registrar;Bursar;Dean;Director";


                            if (preg_match("/Vice Chancellor/i", $sender)) {
                                $de = explode(";", $too);
                                    for ($i = 0; $i < count(explode(";", $too)); $i++) {
                                        $dey = explode(";", $too)[$i];
                                        $se = "SELECT * FROM management WHERE position like '%$dey%'";
                                        $seresult = mysqli_query($conn, $se);
                                        if (mysqli_num_rows($seresult) > 0) {
                                            while ($serow = mysqli_fetch_assoc($seresult)) {
                                                echo '<option value="' . $serow['Position'] . '">' . $serow['Position'] . '</option>';
                                            }
                                        }
                                        if (mysqli_num_rows($seresult) > 1) {
                                            echo '<option value=""> All ' . $dey . 's</option>';
                                            while ($serow = mysqli_fetch_assoc($seresult)) {
                                                echo '<option value="' . $serow['Position'] . '">' . $serow['Position'] . '</option>';
                                            }
                                        }
                                    }
                            }
                            elseif (preg_match("/Dean/i", $sender) && preg_match("/Dean/i", $too)) {
                                $sql = "SELECT * FROM management WHERE Position like '%HOD%' AND college = '$college'";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    echo '<option value="' . $who . '">' . $who . '</option>';
                                    echo '<option value="All HODs">All HODs</option>';
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row['Position'] . '">' . $row['Position'] . '</option>';
                                    }
                                }
                            }
                            elseif (preg_match("/HOD/i", $sender)) {
                                $sql = "SELECT * FROM management WHERE Position like '%Program coordinator%' AND dept = '$dept'";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row['Position'] . '">' . $row['Position'] . '</option>';
                                    }
                                }
                            }
                            elseif (preg_match("/Program coordinator/i", $sender)) {
                                echo '<option value="All Staffs '.$dept.'">All Staffs '.$dept.'</option>';
                                echo '<option value="All Students '.$dept.'">All Students '.$dept.'</option>';
                            }
                            else{
                                if (preg_match("/$sender/i",$too)) {
                                    echo '<option value="' . $who . '">' . $who . '</option>';
                                }
                            }
                            /* $sen = "SELECT * FROM `memo_who_to_who` WHERE who like '%$sender%'";
                            $senresult = mysqli_query($conn, $sen);

                            if (mysqli_num_rows($senresult) > 0) {
                                while ($senrow = mysqli_fetch_assoc($senresult)) {
                                    $de = explode(";", $senrow['too']);
                                    for ($i = 0; $i < count(explode(";", $senrow['too'])); $i++) {
                                        $dey = explode(";", $senrow['too'])[$i];
                                        $se = "SELECT * FROM management WHERE position like '%$dey%'";
                                        $seresult = mysqli_query($conn, $se);
                                        if (mysqli_num_rows($seresult) > 0) {
                                            while ($serow = mysqli_fetch_assoc($seresult)) {
                                                echo '<option value="">' . $serow['Position'] . '</option>';
                                            }
                                        }
                                        if (mysqli_num_rows($seresult) > 1) {
                                            echo '<option value=""> All ' . $dey . 's</option>';
                                            while ($serow = mysqli_fetch_assoc($seresult)) {
                                                echo '<option value="">' . $serow['Position'] . '</option>';
                                            }
                                        }
                                    }
                                }
                            } */
                            ?>
                        </select><span> <?php echo $recipientErr ?></span>
                    </div>

                </div>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" class="form-control text-center" id="subject" name="subject"><span><?php echo $subjectErr; ?></span>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" rows="10" id="message" name="message"></textarea><span><?php echo $messageErr; ?></span>
            </div>

            <div class="form-group text-center">
                <button type="submit" name="sendmessage" class="btn btn-primary">Send</button>
            </div>


        </form>
    </div>

    <script>
        // to

        $('#recipient').on('change', function() {
            if ($(this).val() != '') {
                var recipient = this.value;
                // console.log(to_id);
                $.ajax({
                    url: 'ajax/whom.php',
                    type: "POST",
                    data: {
                        recipient_data: recipient
                    },
                    success: function(data) {

                        $('#whom').html(data);
                        // console.log(data);


                    }
                })
            } else {
                $('#whom').html('<option value="">Select Whom</option>');
            }
        });
    </script>
</body>

</html>