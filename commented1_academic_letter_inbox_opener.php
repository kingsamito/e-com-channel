<?php
include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
    header("Location: login.php");
}

$member = $_SESSION['member'];
$memberid = $member . '_id';
$userid = $_SESSION[$memberid];

$user = $_SESSION['Position'];
$tin = "";
$comment = "";
$id = $_GET['id'];

$sql = "SELECT * FROM commented_academic_letter_inbox WHERE id='$id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
}
$sender = $row['sender'];
$to = $row['too'];
$through = $row['through'];
$block = $row['block'];
$room = $row['room'];
$hostel = $row['hostel'];
$subject = $row['subject'];
$message = $row['message'];
$comment = $row['comment'];
$status = $row['status'];
$date = $row['message_date'];


$sql = "UPDATE commented_academic_letter_inbox SET `status`='read' WHERE `id` = $id";
$result = mysqli_query($conn, $sql);
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

</head>

<body>

    <div class="memo-main-container">
        <?php include_once 'header_inbox.php'; ?>


        <div class="top-content">
            <div class="top-left">
                <h1></h1>
            </div>
            <div class="top-right">
                <?php
                if ($_SESSION['Position'] == 'Lecturer') {
                ?>
                    <p><?php echo "Office " . $room . ", " . $block . " building,"; ?></p>
                    <p>Crawford University</p>
                    <p>Ogun state</p>
                    <p><?php echo $date . "."; ?></p>
                <?php
                } else {
                ?>
                    <p><?php echo "Room " . $room . ", " . $block . " block,"; ?></p>
                    <p><?php echo $hostel . " hostel,"; ?></p>
                    <p>Crawford University,</p>
                    <p>Ogun state.</p>
                    <p><?php echo $date . "."; ?></p>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="left">
            <p>To: <?php echo $to; ?></p>
            <?php
            for ($i = 0; $i < count(explode(";", $row['through'])) - 1; $i++) {

                echo "<p>Through: " . explode(";", $row['through'])[$i] . "</p>";
            }
            ?>
            <p>Crawford University,</p>
            <p>Faith city, Lusada,</p>
            <p>Ogun State.</p>
        </div>
        <div class="receiver-name">
            <p>Dear Mr,</p>
        </div>
        <div class="content">
            <div class="letter-content">
                <div class="text-center">
                    <h4><?php echo $subject; ?></h4>
                </div>
                <div>
                    <p style="text-align:justify"><?php echo $message; ?></p>
                </div>
            </div>
        </div>
        <div class="footer">
            <p>Yours Sincerely,</p>

            <p><?php echo $sender; ?></p>

        </div>


        <div>
            <br><br><br><br>
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
        </div>

    </div>
    </div>

</body>

</html>