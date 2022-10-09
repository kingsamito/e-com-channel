<?php
include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
    header("Location: login.php");
}

$member = $_SESSION['member'];
$memberid = $member . '_id';
$userid = $_SESSION[$memberid];


$id = $_GET['id'];
$sql = "SELECT * FROM academic_letter_sent WHERE id=$id";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
}
$sender = $row['sender'];
$matric = $row['id_no'];
$to = $row['too'];
$through = explode(";", $row['through']);
$block = $row['block'];
$room = $row['room'];
$hostel = $row['hostel'];
$subject = $row['subject'];
$message = $row['message'];
$date = $row['message_date'];


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

</head>

<body>


    <div class="memo-main-container">
        <?php include_once 'header_sent.php'; ?>



        <div class="top-content">
            <div class="top-left">
                <h1></h1>
            </div>
            <div class="top-right">
                <?php
                if ($_SESSION['Position'] == 'Lecturer') {
                ?>
                    <p><?php echo "Office " . $room . ", " . $block . " building,"; ?></p>
                    <!-- <p><?php echo $hostel . " hostel,"; ?></p> -->
                    <p>Crawford University,</p>
                    <p>Ogun state.</p>
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
            <p>
                <?php
                for ($i = 0; $i < count($through) - 1; $i++) {
                    echo "<p>Through:" . $through[$i] . "</p>";
                }
                ?>
            </p>
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
                    <?php
                    if ($_SESSION['Position'] == 'Student') {
                    ?>
                        <p style="text-align:justify"><?php echo "<b>My name is " . $sender . " with matric number " . $matric . " </b> " . $message; ?></p>
                    <?php
                    } else {
                    ?>
                        <p style="text-align:justify"><?php echo  $message; ?></p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="footer">
            <p>Yours Sincerely,</p>

            <p><?php echo $sender; ?></p>

        </div>

    </div>
</body>

</html>