<?php
include_once 'conn.php';

session_start();

$user = $_SESSION['Position'];

$member = $_SESSION['member'];

$tin = "";
$comment = "";
$id = $_GET['id'];
$sql = "SELECT * FROM commented_academic_letter_inbox WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

$sql1 = "SELECT * FROM commented_academic_letter_inbox WHERE id = '$id'";
$result1 = mysqli_query($conn, $sql1);

$row1 = mysqli_fetch_assoc($result1);

$comment = $row1['comment'];
$letter_id = $row1['letter_id'];

$readsql = "UPDATE `commented_academic_letter_inbox` SET `status`='read' WHERE `id` = $id";
$readresult = mysqli_query($conn, $readsql);

function validate($data)
{
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    $data = trim($data);
    return $data;
}

$comentErr = '';
if (isset($_POST["submit"])) {
    $sender = mysqli_real_escape_string($conn, $_POST['sender']);
    $id_no = mysqli_real_escape_string($conn, $_POST['id_no']);
    $to = $_POST['to'];
    $through = $_POST['through'];
    $office = mysqli_real_escape_string($conn, $_POST['block']);
    $room = mysqli_real_escape_string($conn, $_POST['room']);
    $hostel = mysqli_real_escape_string($conn, $_POST['hostel']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $message_date = mysqli_real_escape_string($conn, $_POST['message_date']);
    $sender_position = mysqli_real_escape_string($conn, $_POST['sender_position']);

    $comento = mysqli_real_escape_string($conn, $_POST['commento']);
    $coment = mysqli_real_escape_string($conn, $_POST['comment']);

    $thr = "";
    foreach ($through as $item) {
        $thr .= $item . ";";
    }


    if (empty($coment)) {
        $comentErr = "comment is required";
    } else {
        $coment = validate($coment);

        if (!preg_match("/^[a-zA-Z0-9 .',;?_:!\/ ]*$/", $coment)) {
            $comentErr = "Only letters and white spaces allowed";
        }
    }

    $coment = str_replace("'", "''", $coment);


    if ($comentErr == '') {
        $add = $user . ": " . $coment . ";";
        $joincomment = $comment . $add;
        $sql1 = "INSERT INTO `commented_academic_letter_inbox`(`letter_id`, `forwarded_by`, `sender`, `id_no`, `too`, `through`, `block`, `room`, `hostel`, `subject`, `message`, `message_date`, `type`, `sender_position`,`commented_to`, `comment`,`status`) 
        VALUES('$letter_id','$user','$sender', '$id_no' , '$to', '$through','$office','$room','$hostel','$subject','$message','$message_date','commented_academic','$sender_position','$comento','$joincomment','')";

        $sql2 = "INSERT INTO `commented_academic_letter_sent`(`letter_id`, `forwarded_by`, `sender`, `id_no`, `too`, `through`, `block`, `room`, `hostel`, `subject`, `message`, `message_date`, `type`, `sender_position`,`commented_to`, `comment`,`status`) 
        VALUES('$letter_id','$user','$sender', '$id_no' , '$to', '$through','$office','$room','$hostel','$subject','$message','$message_date','commented_academic','$sender_position','$comento','$joincomment','read')";

        $result1 = mysqli_query($conn, $sql1);
        $result2 = mysqli_query($conn, $sql2);
        if ($result1 && $result2) {
            echo "<script>alert('Sent Successfully')</script>";
            header("Location: managementdashboard.php");
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
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="lettertest.css">

    <script src="jquery.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <style>
        body {
            background-image: url('img/marvin-meyer-SYTO3xs06fU-unsplash.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

        span {
            color: red;
        }



        .nav {
            justify-content: center;

        }

        .nav a {
            color: white;
        }
    </style>
</head>

<body>
    <div class="memo-main-container">
        <?php include_once 'header_inbox.php'; ?>
        <form method="POST" action="" id="messageform">
            <?php
            /* echo mysqli_num_rows($result); */
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $to = $row['too'];
                    $tin = explode(";", $row['through']);
                    $comment = $row["comment"];
                }
                $newLen = count($tin) - 1;

                /*  echo "lenght".$newLen; */

                if ($newLen == 3) {
                    $search = preg_quote(":");
                    $nefind = $tin[2] . ":";
                    $find = "/$nefind/";

                    $nefind1 = $tin[1] . ":";
                    $find1 = "/$nefind1/";

                    $nefind2 = $tin[0] . ":";
                    $find2 = "/$nefind2/";
                    if ($user == $tin[2]) {
                        $sql = "SELECT * FROM commented_academic_letter_inbox WHERE commented_to = '$user' AND id = '$id'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['sender_position'] == 'Lecturer') {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Office ' . $row['room'] . ', ' . $row['block'] . ' building,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                } else {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Room ' . $row['room'] . ', ' . $row['block'] . ' block,</p>
                                        <p>' . $row['hostel'] . ' hostel,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                }
                                $thro  = '';
                                for ($i = 0; $i < count(explode(";", $row['through'])) - 1; $i++) {
                                    $thro .= explode(";", $row['through'])[$i] . ";";
                                    echo "<p>Through: " . explode(";", $row['through'])[$i] . "</p>";
                                }
                                echo '<p>Crawford University,</p>
                                        <p>Faith city, Lusada,</p>
                                        <p>Ogun State.</p>
                                        </div>
                                        <div class="receiver-name">
                                        <p>Dear Mr,</p>
                                        </div>
                                        <div class="content">
                                        <div class="letter-content">
                                        <div class="text-center">
                                        <h4>' . $row['subject'] . '</h4>
                                        </div>
                                        <div>
                                        <p style="text-align:justify">' . $row['message'] . '<br></p>
                                        </div>
                                        </div>
                                        </div>
                                        <div class="footer">
                                            <p>Yours Sincerely,</p>

                                            <p>' . $row['sender'] . '</p>

                                        </div>';

            ?><br><br><br><br>
                                <p>Comment</p>
                                <ol>

                                    <?php
                                    for ($i = 0; $i < count(explode(";", $row['comment'])) - 1; $i++) {
                                        if (preg_match('/Vice Chancellor/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:red">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } elseif (preg_match('/dean/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:blue">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } else {
                                            echo '<li style="color:black">' . explode(";", $row['comment'])[$i] . '</li>';
                                        }
                                    }
                                    ?>
                                </ol>
                            <?php
                                echo '<div>
                                    <input type="text area" hidden value="' . $row['sender'] . '" class="form-control text-center"  readonly name="sender">
                                    <input type="text area" hidden value="' . $row['id_no'] . '" class="form-control text-center"  readonly name="id_no">
                                    <input type="text area" hidden value="' . $row['too'] . '" class="form-control text-center"  readonly name="to">
                                    <input type="text area" hidden value="' . $thro . '" class="form-control text-center"  readonly name="through">

                                    <input type="text area" hidden value="' . $row['block'] . '" class="form-control text-center"  readonly name="block">
                                    <input type="text area" hidden value="' . $row['room'] . '" class="form-control text-center"  readonly name="room">
                                    <input type="text area" hidden value="' . $row['hostel'] . '" class="form-control text-center"  readonly name="hostel">
                                    <input type="text area" hidden value="' . $row['subject'] . '" class="form-control text-center"  readonly name="subject">
                                    <input type="text area" hidden value="' . $row['message'] . '" class="form-control text-center"  readonly name="message">
                                    <input type="text area" hidden value="' . $row['message_date'] . '" class="form-control text-center"  readonly name="message_date">
                                    <input type="text area" hidden value="' . $row['sender_position'] . '" class="form-control text-center"  readonly name="sender_position">
                                    
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <select name="commento">
                            <option value="' . $tin[1] . '">Send Forward to ' . $tin[1] . '</option>
                            <option value="' . $row['sender'] . '">Send Backward to ' . $row['sender'] . '</option>
                            </select>
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>';
                            }
                        }
                    } elseif ($user == $tin[1]) {
                        $sql = "SELECT * FROM commented_academic_letter_inbox WHERE commented_to = '$user' AND id = '$id'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['sender_position'] == 'Lecturer') {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Office ' . $row['room'] . ', ' . $row['block'] . ' building,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                } else {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Room ' . $row['room'] . ', ' . $row['block'] . ' block,</p>
                                        <p>' . $row['hostel'] . ' hostel,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                }
                                $thro  = '';
                                for ($i = 0; $i < count(explode(";", $row['through'])) - 1; $i++) {
                                    $thro .= explode(";", $row['through'])[$i] . ";";
                                    echo "<p>Through: " . explode(";", $row['through'])[$i] . "</p>";
                                }
                                echo '<p>Crawford University,</p>
                                        <p>Faith city, Lusada,</p>
                                        <p>Ogun State.</p>
                                        </div>
                                        <div class="receiver-name">
                                        <p>Dear Mr,</p>
                                        </div>
                                        <div class="content">
                                        <div class="letter-content">
                                        <div class="text-center">
                                        <h4>' . $row['subject'] . '</h4>
                                        </div>
                                        <div>
                                        <p style="text-align:justify">' . $row['message'] . '<br></p>
                                        </div>
                                        </div>
                                        </div>
                                        <div class="footer">
                                            <p>Yours Sincerely,</p>

                                            <p>' . $row['sender'] . '</p>

                                        </div>';

                            ?><br><br><br><br>
                                <p>Comment</p>
                                <ol>

                                    <?php
                                    for ($i = 0; $i < count(explode(";", $row['comment'])) - 1; $i++) {
                                        if (preg_match('/Vice Chancellor/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:red">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } elseif (preg_match('/dean/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:blue">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } else {
                                            echo '<li style="color:black">' . explode(";", $row['comment'])[$i] . '</li>';
                                        }
                                    }
                                    ?>
                                </ol>
                            <?php
                                echo '<div>
                                    <input type="text area" hidden value="' . $row['sender'] . '" class="form-control text-center"  readonly name="sender">
                                    <input type="text area" hidden value="' . $row['id_no'] . '" class="form-control text-center"  readonly name="id_no">
                                    <input type="text area" hidden value="' . $row['too'] . '" class="form-control text-center"  readonly name="to">
                                    <input type="text area" hidden value="' . $thro . '" class="form-control text-center"  readonly name="through">

                                    <input type="text area" hidden value="' . $row['block'] . '" class="form-control text-center"  readonly name="block">
                                    <input type="text area" hidden value="' . $row['room'] . '" class="form-control text-center"  readonly name="room">
                                    <input type="text area" hidden value="' . $row['hostel'] . '" class="form-control text-center"  readonly name="hostel">
                                    <input type="text area" hidden value="' . $row['subject'] . '" class="form-control text-center"  readonly name="subject">
                                    <input type="text area" hidden value="' . $row['message'] . '" class="form-control text-center"  readonly name="message">
                                    <input type="text area" hidden value="' . $row['message_date'] . '" class="form-control text-center"  readonly name="message_date">
                                    <input type="text area" hidden value="' . $row['sender_position'] . '" class="form-control text-center"  readonly name="sender_position">
                                    
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <select name="commento">
                            <option value="' . $tin[0] . '">Send Forward to ' . $tin[0] . '</option>
                            <option value="' . $tin[2] . '">Send Backward to ' . $tin[2] . '</option>
                            </select>
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>';
                            }
                        }
                    } elseif ($user == $tin[0]) {
                        $sql = "SELECT * FROM  commented_academic_letter_inbox WHERE commented_to = '$user' AND id = '$id'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['sender_position'] == 'Lecturer') {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Office ' . $row['room'] . ', ' . $row['block'] . ' building,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                } else {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Room ' . $row['room'] . ', ' . $row['block'] . ' block,</p>
                                        <p>' . $row['hostel'] . ' hostel,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                }
                                $thro  = '';
                                for ($i = 0; $i < count(explode(";", $row['through'])) - 1; $i++) {
                                    $thro .= explode(";", $row['through'])[$i] . ";";
                                    echo "<p>Through: " . explode(";", $row['through'])[$i] . "</p>";
                                }
                                echo '<p>Crawford University,</p>
                                        <p>Faith city, Lusada,</p>
                                        <p>Ogun State.</p>
                                        </div>
                                        <div class="receiver-name">
                                        <p>Dear Mr,</p>
                                        </div>
                                        <div class="content">
                                        <div class="letter-content">
                                        <div class="text-center">
                                        <h4>' . $row['subject'] . '</h4>
                                        </div>
                                        <div>
                                        <p style="text-align:justify">' . $row['message'] . '<br></p>
                                        </div>
                                        </div>
                                        </div>
                                        <div class="footer">
                                            <p>Yours Sincerely,</p>

                                            <p>' . $row['sender'] . '</p>

                                        </div>';

                            ?><br><br><br><br>
                                <p>Comment</p>
                                <ol>

                                    <?php
                                    for ($i = 0; $i < count(explode(";", $row['comment'])) - 1; $i++) {
                                        if (preg_match('/Vice Chancellor/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:red">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } elseif (preg_match('/dean/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:blue">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } else {
                                            echo '<li style="color:black">' . explode(";", $row['comment'])[$i] . '</li>';
                                        }
                                    }
                                    ?>
                                </ol>
                            <?php
                                echo '<div>
                                    <input type="text area" hidden value="' . $row['sender'] . '" class="form-control text-center"  readonly name="sender">
                                    <input type="text area" hidden value="' . $row['id_no'] . '" class="form-control text-center"  readonly name="id_no">
                                    <input type="text area" hidden value="' . $row['too'] . '" class="form-control text-center"  readonly name="to">
                                    <input type="text area" hidden value="' . $thro . '" class="form-control text-center"  readonly name="through">

                                    <input type="text area" hidden value="' . $row['block'] . '" class="form-control text-center"  readonly name="block">
                                    <input type="text area" hidden value="' . $row['room'] . '" class="form-control text-center"  readonly name="room">
                                    <input type="text area" hidden value="' . $row['hostel'] . '" class="form-control text-center"  readonly name="hostel">
                                    <input type="text area" hidden value="' . $row['subject'] . '" class="form-control text-center"  readonly name="subject">
                                    <input type="text area" hidden value="' . $row['message'] . '" class="form-control text-center"  readonly name="message">
                                    <input type="text area" hidden value="' . $row['message_date'] . '" class="form-control text-center"  readonly name="message_date">
                                    <input type="text area" hidden value="' . $row['sender_position'] . '" class="form-control text-center"  readonly name="sender_position">
                                    
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <select name="commento">
                            <option value="' . $to . '">Send Forward to ' . $to . '</option>
                            <option value="' . $tin[1] . '">Send Backward to ' . $tin[1] . '</option>
                            </select>
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>';
                            }
                        }
                    } elseif ($user == $to) {
                        $sql = "SELECT * FROM  commented_academic_letter_inbox WHERE commented_to = '$user'  AND id = '$id'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['sender_position'] == 'Lecturer') {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Office ' . $row['room'] . ', ' . $row['block'] . ' building,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                } else {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Room ' . $row['room'] . ', ' . $row['block'] . ' block,</p>
                                        <p>' . $row['hostel'] . ' hostel,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                }
                                $thro  = '';
                                for ($i = 0; $i < count(explode(";", $row['through'])) - 1; $i++) {
                                    $thro .= explode(";", $row['through'])[$i] . ";";
                                    echo "<p>Through: " . explode(";", $row['through'])[$i] . "</p>";
                                }
                                echo '<p>Crawford University,</p>
                                        <p>Faith city, Lusada,</p>
                                        <p>Ogun State.</p>
                                        </div>
                                        <div class="receiver-name">
                                        <p>Dear Mr,</p>
                                        </div>
                                        <div class="content">
                                        <div class="letter-content">
                                        <div class="text-center">
                                        <h4>' . $row['subject'] . '</h4>
                                        </div>
                                        <div>
                                        <p style="text-align:justify">' . $row['message'] . '<br></p>
                                        </div>
                                        </div>
                                        </div>
                                        <div class="footer">
                                            <p>Yours Sincerely,</p>

                                            <p>' . $row['sender'] . '</p>

                                        </div>';

                            ?><br><br><br><br>
                                <p>Comment</p>
                                <ol>

                                    <?php
                                    for ($i = 0; $i < count(explode(";", $row['comment'])) - 1; $i++) {
                                        if (preg_match('/Vice Chancellor/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:red">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } elseif (preg_match('/dean/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:blue">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } else {
                                            echo '<li style="color:black">' . explode(";", $row['comment'])[$i] . '</li>';
                                        }
                                    }
                                    ?>
                                </ol>
                            <?php
                                echo '<div>
                                    <input type="text area" hidden value="' . $row['sender'] . '" class="form-control text-center"  readonly name="sender">
                                    <input type="text area" hidden value="' . $row['id_no'] . '" class="form-control text-center"  readonly name="id_no">
                                    <input type="text area" hidden value="' . $row['too'] . '" class="form-control text-center"  readonly name="to">
                                    <input type="text area" hidden value="' . $thro . '" class="form-control text-center"  readonly name="through">

                                    <input type="text area" hidden value="' . $row['block'] . '" class="form-control text-center"  readonly name="block">
                                    <input type="text area" hidden value="' . $row['room'] . '" class="form-control text-center"  readonly name="room">
                                    <input type="text area" hidden value="' . $row['hostel'] . '" class="form-control text-center"  readonly name="hostel">
                                    <input type="text area" hidden value="' . $row['subject'] . '" class="form-control text-center"  readonly name="subject">
                                    <input type="text area" hidden value="' . $row['message'] . '" class="form-control text-center"  readonly name="message">
                                    <input type="text area" hidden value="' . $row['message_date'] . '" class="form-control text-center"  readonly name="message_date">
                                    <input type="text area" hidden value="' . $row['sender_position'] . '" class="form-control text-center"  readonly name="sender_position">
                                    
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <select name="commento">
                            <option value="' . $tin[0] . '">Send Forward to ' . $tin[0] . '</option>
                            </select>
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>';
                            }
                        }
                    } else {
                        echo "No Message";
                    }
                } elseif ($newLen == 2) {
                    $search = preg_quote(":");


                    $nefind1 = $tin[1] . ":";
                    $find1 = "/$nefind1/";



                    $nefind2 = $tin[0] . ":";
                    $find2 = "/$nefind2/";

                    if ($user == $tin[1]) {

                        $sql = "SELECT * FROM commented_academic_letter_inbox WHERE commented_to = '$user' AND id = '$id'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['sender_position'] == 'Lecturer') {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Office ' . $row['room'] . ', ' . $row['block'] . ' building,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                } else {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Room ' . $row['room'] . ', ' . $row['block'] . ' block,</p>
                                        <p>' . $row['hostel'] . ' hostel,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                }
                                $thro  = '';
                                for ($i = 0; $i < count(explode(";", $row['through'])) - 1; $i++) {
                                    $thro .= explode(";", $row['through'])[$i] . ";";
                                    echo "<p>Through: " . explode(";", $row['through'])[$i] . "</p>";
                                }
                                echo '<p>Crawford University,</p>
                                        <p>Faith city, Lusada,</p>
                                        <p>Ogun State.</p>
                                        </div>
                                        <div class="receiver-name">
                                        <p>Dear Mr,</p>
                                        </div>
                                        <div class="content">
                                        <div class="letter-content">
                                        <div class="text-center">
                                        <h4>' . $row['subject'] . '</h4>
                                        </div>
                                        <div>
                                        <p style="text-align:justify">' . $row['message'] . '<br></p>
                                        </div>
                                        </div>
                                        </div>
                                        <div class="footer">
                                            <p>Yours Sincerely,</p>

                                            <p>' . $row['sender'] . '</p>

                                        </div>';

                            ?><br><br><br><br>
                                <p>Comment</p>
                                <ol>

                                    <?php
                                    for ($i = 0; $i < count(explode(";", $row['comment'])) - 1; $i++) {
                                        if (preg_match('/Vice Chancellor/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:red">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } elseif (preg_match('/dean/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:blue">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } else {
                                            echo '<li style="color:black">' . explode(";", $row['comment'])[$i] . '</li>';
                                        }
                                    }
                                    ?>
                                </ol>
                            <?php
                                echo '<div>
                                    <input type="text area" hidden value="' . $row['sender'] . '" class="form-control text-center"  readonly name="sender">
                                    <input type="text area" hidden value="' . $row['id_no'] . '" class="form-control text-center"  readonly name="id_no">
                                    <input type="text area" hidden value="' . $row['too'] . '" class="form-control text-center"  readonly name="to">
                                    <input type="text area" hidden value="' . $thro . '" class="form-control text-center"  readonly name="through">

                                    <input type="text area" hidden value="' . $row['block'] . '" class="form-control text-center"  readonly name="block">
                                    <input type="text area" hidden value="' . $row['room'] . '" class="form-control text-center"  readonly name="room">
                                    <input type="text area" hidden value="' . $row['hostel'] . '" class="form-control text-center"  readonly name="hostel">
                                    <input type="text area" hidden value="' . $row['subject'] . '" class="form-control text-center"  readonly name="subject">
                                    <input type="text area" hidden value="' . $row['message'] . '" class="form-control text-center"  readonly name="message">
                                    <input type="text area" hidden value="' . $row['message_date'] . '" class="form-control text-center"  readonly name="message_date">
                                    <input type="text area" hidden value="' . $row['sender_position'] . '" class="form-control text-center"  readonly name="sender_position">
                                    
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <select name="commento">
                            <option value="' . $tin[0] . '">Send Forward to ' . $tin[0] . '</option>
                            <option value="' . $row['sender'] . '">Send Backward to ' . $row['sender'] . '</option>
                            </select>
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>';
                            }
                        }
                    } elseif ($user == $tin[0]) {
                        $sql = "SELECT * FROM  commented_academic_letter_inbox WHERE commented_to = '$user' AND id = '$id'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['sender_position'] == 'Lecturer') {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Office ' . $row['room'] . ', ' . $row['block'] . ' building,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                } else {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Room ' . $row['room'] . ', ' . $row['block'] . ' block,</p>
                                        <p>' . $row['hostel'] . ' hostel,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                }
                                $thro  = '';
                                for ($i = 0; $i < count(explode(";", $row['through'])) - 1; $i++) {
                                    $thro .= explode(";", $row['through'])[$i] . ";";
                                    echo "<p>Through: " . explode(";", $row['through'])[$i] . "</p>";
                                }
                                echo '<p>Crawford University,</p>
                                        <p>Faith city, Lusada,</p>
                                        <p>Ogun State.</p>
                                        </div>
                                        <div class="receiver-name">
                                        <p>Dear Mr,</p>
                                        </div>
                                        <div class="content">
                                        <div class="letter-content">
                                        <div class="text-center">
                                        <h4>' . $row['subject'] . '</h4>
                                        </div>
                                        <div>
                                        <p style="text-align:justify">' . $row['message'] . '<br></p>
                                        </div>
                                        </div>
                                        </div>
                                        <div class="footer">
                                            <p>Yours Sincerely,</p>

                                            <p>' . $row['sender'] . '</p>

                                        </div>';

                            ?><br><br><br><br>
                                <p>Comment</p>
                                <ol>

                                    <?php
                                    for ($i = 0; $i < count(explode(";", $row['comment'])) - 1; $i++) {
                                        if (preg_match('/Vice Chancellor/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:red">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } elseif (preg_match('/dean/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:blue">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } else {
                                            echo '<li style="color:black">' . explode(";", $row['comment'])[$i] . '</li>';
                                        }
                                    }
                                    ?>
                                </ol>
                            <?php
                                echo '<div>
                                    <input type="text area" hidden value="' . $row['sender'] . '" class="form-control text-center"  readonly name="sender">
                                    <input type="text area" hidden value="' . $row['id_no'] . '" class="form-control text-center"  readonly name="id_no">
                                    <input type="text area" hidden value="' . $row['too'] . '" class="form-control text-center"  readonly name="to">
                                    <input type="text area" hidden value="' . $thro . '" class="form-control text-center"  readonly name="through">

                                    <input type="text area" hidden value="' . $row['block'] . '" class="form-control text-center"  readonly name="block">
                                    <input type="text area" hidden value="' . $row['room'] . '" class="form-control text-center"  readonly name="room">
                                    <input type="text area" hidden value="' . $row['hostel'] . '" class="form-control text-center"  readonly name="hostel">
                                    <input type="text area" hidden value="' . $row['subject'] . '" class="form-control text-center"  readonly name="subject">
                                    <input type="text area" hidden value="' . $row['message'] . '" class="form-control text-center"  readonly name="message">
                                    <input type="text area" hidden value="' . $row['message_date'] . '" class="form-control text-center"  readonly name="message_date">
                                    <input type="text area" hidden value="' . $row['sender_position'] . '" class="form-control text-center"  readonly name="sender_position">
                                    
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <select name="commento">
                            <option value="' . $to . '">Send Forward to ' . $to . '</option>
                            <option value="' . $tin[1] . '">Send Backward to ' . $tin[1] . '</option>
                            </select>
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>';
                            }
                        }
                    } elseif ($user == $to) {
                        $sql = "SELECT * FROM  commented_academic_letter_inbox WHERE commented_to = '$user'  AND id = '$id'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['sender_position'] == 'Lecturer') {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Office ' . $row['room'] . ', ' . $row['block'] . ' building,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                } else {
                                    echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Room ' . $row['room'] . ', ' . $row['block'] . ' block,</p>
                                        <p>' . $row['hostel'] . ' hostel,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                                }
                                $thro  = '';
                                for ($i = 0; $i < count(explode(";", $row['through'])) - 1; $i++) {
                                    $thro .= explode(";", $row['through'])[$i] . ";";
                                    echo "<p>Through: " . explode(";", $row['through'])[$i] . "</p>";
                                }
                                echo '<p>Crawford University,</p>
                                        <p>Faith city, Lusada,</p>
                                        <p>Ogun State.</p>
                                        </div>
                                        <div class="receiver-name">
                                        <p>Dear Mr,</p>
                                        </div>
                                        <div class="content">
                                        <div class="letter-content">
                                        <div class="text-center">
                                        <h4>' . $row['subject'] . '</h4>
                                        </div>
                                        <div>
                                        <p style="text-align:justify">' . $row['message'] . '<br></p>
                                        </div>
                                        </div>
                                        </div>
                                        <div class="footer">
                                            <p>Yours Sincerely,</p>

                                            <p>' . $row['sender'] . '</p>

                                        </div>';

                            ?><br><br><br><br>
                                <p>Comment</p>
                                <ol>

                                    <?php
                                    for ($i = 0; $i < count(explode(";", $row['comment'])) - 1; $i++) {
                                        if (preg_match('/Vice Chancellor/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:red">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } elseif (preg_match('/dean/i', (explode(";", $row['comment'])[$i]))) {
                                            echo '<li style="color:blue">' . explode(";", $row['comment'])[$i] . '</li>';
                                        } else {
                                            echo '<li style="color:black">' . explode(";", $row['comment'])[$i] . '</li>';
                                        }
                                    }
                                    ?>
                                </ol>
                            <?php
                                echo '<div>
                                    <input type="text area" hidden value="' . $row['sender'] . '" class="form-control text-center"  readonly name="sender">
                                    <input type="text area" hidden value="' . $row['id_no'] . '" class="form-control text-center"  readonly name="id_no">
                                    <input type="text area" hidden value="' . $row['too'] . '" class="form-control text-center"  readonly name="to">
                                    <input type="text area" hidden value="' . $thro . '" class="form-control text-center"  readonly name="through">

                                    <input type="text area" hidden value="' . $row['block'] . '" class="form-control text-center"  readonly name="block">
                                    <input type="text area" hidden value="' . $row['room'] . '" class="form-control text-center"  readonly name="room">
                                    <input type="text area" hidden value="' . $row['hostel'] . '" class="form-control text-center"  readonly name="hostel">
                                    <input type="text area" hidden value="' . $row['subject'] . '" class="form-control text-center"  readonly name="subject">
                                    <input type="text area" hidden value="' . $row['message'] . '" class="form-control text-center"  readonly name="message">
                                    <input type="text area" hidden value="' . $row['message_date'] . '" class="form-control text-center"  readonly name="message_date">
                                    <input type="text area" hidden value="' . $row['sender_position'] . '" class="form-control text-center"  readonly name="sender_position">
                                    
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <select name="commento">
                            <option value="' . $tin[0] . '">Send Forward to ' . $tin[0] . '</option>
                            </select>
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>';
                            }
                        }
                    } else {
                        echo "No Message";
                    }
                } else {
                    $sql = "SELECT * FROM  commented_academic_letter_inbox WHERE commented_to = '$user'  AND id = '$id'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['sender_position'] == 'Lecturer') {
                                echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Office ' . $row['room'] . ', ' . $row['block'] . ' building,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                            } else {
                                echo '
                                        <div class="top-content">
                                        <div class="top-left"><h1></h1></div>
                                        <div class="top-right">
                                        <p>Room ' . $row['room'] . ', ' . $row['block'] . ' block,</p>
                                        <p>' . $row['hostel'] . ' hostel,</p>
                                        <p>Crawford University,</p>
			                            <p>Ogun state.</p>
			                            <p>' . $row['message_date'] . '</p>
                                        </div>
	                                    </div>
                                        <div class="left">
	                                    <p>To: ' . $row['too'] . '</p>';
                            }
                            $thro  = '';
                            for ($i = 0; $i < count(explode(";", $row['through'])) - 1; $i++) {
                                $thro .= explode(";", $row['through'])[$i] . ";";
                                echo "<p>Through: " . explode(";", $row['through'])[$i] . "</p>";
                            }
                            echo '<p>Crawford University,</p>
                                        <p>Faith city, Lusada,</p>
                                        <p>Ogun State.</p>
                                        </div>
                                        <div class="receiver-name">
                                        <p>Dear Mr,</p>
                                        </div>
                                        <div class="content">
                                        <div class="letter-content">
                                        <div class="text-center">
                                        <h4>' . $row['subject'] . '</h4>
                                        </div>
                                        <div>
                                        <p style="text-align:justify">' . $row['message'] . '<br></p>
                                        </div>
                                        </div>
                                        </div>
                                        <div class="footer">
                                            <p>Yours Sincerely,</p>

                                            <p>' . $row['sender'] . '</p>

                                        </div>';

                            ?><br><br><br><br>
                            <p>Comment</p>
                            <ol>

                                <?php
                                for ($i = 0; $i < count(explode(";", $row['comment'])) - 1; $i++) {
                                    if (preg_match('/Vice Chancellor/i', (explode(";", $row['comment'])[$i]))) {
                                        echo '<li style="color:red">' . explode(";", $row['comment'])[$i] . '</li>';
                                    } elseif (preg_match('/dean/i', (explode(";", $row['comment'])[$i]))) {
                                        echo '<li style="color:blue">' . explode(";", $row['comment'])[$i] . '</li>';
                                    } else {
                                        echo '<li style="color:black">' . explode(";", $row['comment'])[$i] . '</li>';
                                    }
                                }
                                ?>
                            </ol>
            <?php
                            echo '<div>
                                    <input type="text area" hidden value="' . $row['sender'] . '" class="form-control text-center"  readonly name="sender">
                                    <input type="text area" hidden value="' . $row['id_no'] . '" class="form-control text-center"  readonly name="id_no">
                                    <input type="text area" hidden value="' . $row['too'] . '" class="form-control text-center"  readonly name="to">
                                    <input type="text area" hidden value="' . $thro . '" class="form-control text-center"  readonly name="through">

                                    <input type="text area" hidden value="' . $row['block'] . '" class="form-control text-center"  readonly name="block">
                                    <input type="text area" hidden value="' . $row['room'] . '" class="form-control text-center"  readonly name="room">
                                    <input type="text area" hidden value="' . $row['hostel'] . '" class="form-control text-center"  readonly name="hostel">
                                    <input type="text area" hidden value="' . $row['subject'] . '" class="form-control text-center"  readonly name="subject">
                                    <input type="text area" hidden value="' . $row['message'] . '" class="form-control text-center"  readonly name="message">
                                    <input type="text area" hidden value="' . $row['message_date'] . '" class="form-control text-center"  readonly name="message_date">
                                    <input type="text area" hidden value="' . $row['sender_position'] . '" class="form-control text-center"  readonly name="sender_position">
                                    
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <select name="commento">
                            <option value="' . $to . '">Send Forward to ' . $to . '</option>
                            </select>
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>';
                        }
                    } else {
                        echo "No Message";
                    }
                }
            } else {
                echo "No Message";
            }

            ?>
        </form>


    </div>



</body>

</html>