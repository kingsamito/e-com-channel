<?php

include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
    header("Location: login.php");
}

$sender = $_SESSION['Firstname'] . " " . $_SESSION['Lastname'];
$matric = $_SESSION['Matric'];

$toErr = $throughErr = $blockErr = $roomErr = $hostelErr = $subjectErr = $messageErr =  '';

function validate($data)
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

if (isset($_POST["sendmessage"])) {
    $to = $_POST['to'];
    $through = $_POST['through'];

    $thr = "";
    foreach ($through as $item) {
        $thr .= $item . ";";
    }





    if ($toErr == '' && $throughErr == '') {
        $sql = "INSERT INTO `academic_letter_inbox`(`too`, `through`) VALUES('$to', '$thr')";
        $sql1 = "INSERT INTO `academic_letter_sent`(`too`, `through`) VALUES('$to', '$thr')";
        $result = mysqli_query($conn, $sql);
        $result1 = mysqli_query($conn, $sql1);
        if ($result &&  $result1) {
            echo "<script>alert('Sent Successfully')</script>";
            header("Location: studentdashboard.php");
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
    <link rel="stylesheet" href="style.css">

    <script src="jquery.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <style>

    </style>

</head>

<body>
    <div class="row mt-4">
        <div class="col-md-7 m-auto">
            <div class="form-container">


                <div class="container">
                    <div class="d-flex justify-content-between mb-1">
                        <h2>Message</h2>

                    </div>

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="messageform">


                        <div class="form-group" style="width:50%">
                            <label for="to">To:</label>
                            <select name="to" id="recipient">
                                <?php
                                echo "College " . $_SESSION['collegename'];
                                $college_id = $_SESSION['College'];
                                $toosql = "SELECT * FROM `too` WHERE college_id = '$college_id' OR college_id = ''";
                                $resultcollege = mysqli_query($conn, $toosql);
                                if (mysqli_num_rows($resultcollege) > 0) {
                                    while ($row = mysqli_fetch_assoc($resultcollege)) {

                                        $recipient_short = $row['short_name'];
                                        $recipient_name = $row['Position'];

                                        echo "<option value='$recipient_name'>" . $recipient_name . "</option>";
                                    }
                                } else {
                                    echo "No results";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group" id="through" style="width:50%">

                        </div>

                
                        <div>
                            <!-- <button type="submit" name="savemessage" class="btn btn-primary" form="messageform">Save</button> -->
                            <button type="submit" name="sendmessage" class="btn btn-primary" form="messageform">Send</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
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