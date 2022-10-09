<?php
include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
    header("Location: login.php");
}

$member = $_SESSION['member'];

$comment = "";
$id = $_GET['id'];
$sql = "SELECT * FROM commented_exeat_inbox WHERE id=$id";
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
$parent = $row['parentnumber'];
$comment = $row['comment'];
$status = $row['status'];
$date = $row['message_date'];

$readsql = "UPDATE commented_exeat_inbox SET `status`='read' WHERE `id` = $id";
$readresult = mysqli_query($conn, $readsql);

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
    <link rel="stylesheet" href="admin/fontawesome-free-6.1.1-web/css/all.min.css">

    <script src="jquery.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>

</head>

<body>

    <div class="memo-main-container">
        <?php include_once 'header_inbox.php'; ?>

        <div class="d-flex justify-content-between mb-1">
            <h2></h2>
            <div class="noprint">
                <button type="button" class="btn btn-success" onclick="window.print()">Print <i class="fa fa-print"></i></button>
            </div>


        </div>
        <div class="main-container">
            <div class="top-content">
                <div class="top-left">
                    <h1></h1>
                </div>
                <div class="top-right">
                    <p><?php echo "Room " . $room . ", " . $block . " block,"; ?></p>
                    <p><?php echo $hostel . " hostel,"; ?></p>
                    <p>Crawford University</p>
                    <p>Ogun state</p>
                    <p><?php echo $date . "."; ?></p>
                </div>
            </div>
            <div class="left">
                <p>To: <?php echo $to; ?></p>
                <p>Through: <?php echo $through; ?></p>
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
                    <div>Parent phone number: <?php echo $parent; ?></div>
                </div>
            </div>
            <div class="footer">
                <p>Yours Sincerely,
                </p>
                <p>Signature</p>
                <p><?php echo $sender ?></p>

            </div>

            <div>
                <br><br><br><br>
                <p>Comment</p>
                <ol>
                    <?php
                    for ($i = 0; $i < count(explode(";", $row['comment'])) - 1; $i++) {
                        echo '<li>' . explode(";", $row['comment'])[$i] . '</li>';
                    }
                    ?>
                </ol>
            </div>

        </div>
    </div>

</body>

</html>