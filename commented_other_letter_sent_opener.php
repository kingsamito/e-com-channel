<?php
include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
    header("Location: login.php");
}

$member = $_SESSION['member'];


$id = $_GET['id'];
$sql = "SELECT * FROM commented_other_letter_sent WHERE id=$id";
$result = mysqli_query($conn, $sql);

$sql1 = "SELECT * FROM commented_other_letter_sent WHERE id = '$id'";
$result1 = mysqli_query($conn, $sql1);

$row1 = mysqli_fetch_assoc($result1);

$comment = $row1['comment'];


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
        <?php include_once 'header_sent.php'; ?>


        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                echo '<div class="main-container">
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
							<p>To: ' . $row['too'] . '</p>
							<p>Through: ' . $row['through'] . '</p>
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
									<h4>' . $row['subject'] . '</h4>
								</div>
							<div>
							<p style="text-align:justify">' . $row['message'] . '<br></p>
						</div>
						<p>Parent Number: ' . $row['parentnumber'] . '</p>
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
                        echo '<li>' . explode(";", $row['comment'])[$i] . '</li>';
                    }
                    ?>
                </ol>
        <?php

            }
        }

        ?>
</body>

</html>