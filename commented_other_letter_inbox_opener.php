<?php
include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
    header("Location: login.php");
}

$member = $_SESSION['member'];
$user = $_SESSION['Position'];

$id = $_GET['id'];
$sql = "SELECT * FROM commented_other_letter_inbox WHERE id=$id";
$result = mysqli_query($conn, $sql);

$sql1 = "SELECT * FROM commented_other_letter_inbox WHERE id = '$id'";
$result1 = mysqli_query($conn, $sql1);

$readsql = "UPDATE `commented_other_letter_inbox` SET `status`='read' WHERE `id` = $id";
$readresult = mysqli_query($conn, $readsql);

$row1 = mysqli_fetch_assoc($result1);

$comment = $row1['comment'];

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
    $id_no = mysqli_real_escape_string($conn, $_POST['matric']);
    $to = $_POST['to'];
    $through = $_POST['through'];
    $office = mysqli_real_escape_string($conn, $_POST['block']);
    $room = mysqli_real_escape_string($conn, $_POST['room']);
    $hostel = mysqli_real_escape_string($conn, $_POST['hostel']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $message_date = mysqli_real_escape_string($conn, $_POST['message_date']);
    $date = date("Y-t-d H:i:s");

    $comento = mysqli_real_escape_string($conn, $_POST['commento']);
    $coment = mysqli_real_escape_string($conn, $_POST['comment']);



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
        $sql1 = "INSERT INTO `commented_other_letter_inbox`(`other_letter_id`, `forwarded_by`, `sender`, `id_no`, `too`, `through`, `block`, `room`, `hostel`, `subject`, `message`,  `message_date`,`type`, `commented_to`, `comment`, `status`) 
        VALUES('$id','$user','$sender', '$id_no' , '$to', '$through','$office','$room','$hostel','$subject','$message','$message_date','commented_exeat','$comento','$joincomment','')";

        $sql2 = "INSERT INTO `commented_other_letter_sent`(`other_letter_id`, `forwarded_by`, `sender`, `id_no`, `too`, `through`, `block`, `room`, `hostel`, `subject`, `message`,  `message_date`,`type`, `commented_to`, `comment`) 
        VALUES('$id','$user','$sender', '$id_no' , '$to', '$through','$office','$room','$hostel','$subject','$message','$message_date','commented_exeat','$comento','$joincomment')";

        $result1 = mysqli_query($conn, $sql1);
        $result2 = mysqli_query($conn, $sql2);
        if ($result1 && $result2) {
            echo "<script>alert('Sent Successfully')</script>";
			echo "<script> window.location='non_academic_staffdashboard.php?folder=sent' </script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
    <title>Letter</title>
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
                <form method="POST" action="<?php echo htmlspecialchars('commented_exeat_letter_inbox_opener.php?id=' . $id); ?>">
					<?php
					echo '<div class="noprint">
				
                                    <input type="text area" hidden value="' . $row['sender'] . '" class="form-control text-center"  readonly name="sender">
                                    <input type="text area" hidden value="' . $row['id_no'] . '" class="form-control text-center"  readonly name="matric">
                                    <input type="text area" hidden value="' . $row['too'] . '" class="form-control text-center"  readonly name="to">
                                    <input type="text area" hidden value="' . $row['through'] . '" class="form-control text-center"  readonly name="through">

                                    <input type="text area" hidden value="' . $row['block'] . '" class="form-control text-center"  readonly name="block">
                                    <input type="text area" hidden value="' . $row['room'] . '" class="form-control text-center"  readonly name="room">
                                    <input type="text area" hidden value="' . $row['hostel'] . '" class="form-control text-center"  readonly name="hostel">
                                    <input type="text area" hidden value="' . $row['subject'] . '" class="form-control text-center"  readonly name="subject">
                                    <input type="text area" hidden value="' . $row['message'] . '" class="form-control text-center"  readonly name="message">
                                    <input type="text area" hidden value="' . $row['parentnumber'] . '" class="form-control text-center"  readonly name="parentnumber">
                                    <input type="text area" hidden value="' . $row['message_date'] . '" class="form-control text-center"  readonly name="message_date">
                                    
                            <label>Comment:</label>
                            <input type="text" name="comment" placeholder="comment">
                            <select name="commento">
                            <option value="' . $row['sender'] . '">Send Forward to ' . $row['sender'] . '</option>
                            </select>
                            <button class="btn btn-success" type="submit" name="submit">Send</button>
                        </div>
						
                        </div>';
					?>
				</form>
                <?php
            }
        }

        ?>
</body>

</html>