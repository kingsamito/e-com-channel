<?php
include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
    header("Location: login.php");
}

$user = $_SESSION['Position'];
$name = $_SESSION['Firstname'] . " " . $_SESSION['Lastname'];

$member = $_SESSION['member'];
$memberid = $member . '_id';
$userid = $_SESSION[$memberid];

$id = $_GET['id'];
$sql = "SELECT * FROM memo_inbox WHERE id=$id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
}
$sender = $row['sender'];
$ref = $row['ref'];
$message_date = $row['message_date'];
$receiver = $row['receiver'];
$subject = $row['subject'];
$message = $row['message'];
$status = $row['status'];
$date = date("Y-t-d H:i:s");

if (preg_match('/All/i', $receiver)) {
    $useread = $userid . ";";
    $status .= $useread;
    $sql = "UPDATE `memo_inbox` SET `status`='$status' WHERE `id` = $id";
    $result = mysqli_query($conn, $sql);
} else {
    $sql = "UPDATE `memo_inbox` SET `status`='read' WHERE `id` = $id";
    $result = mysqli_query($conn, $sql);
}

$recipientErr = '';
if (isset($_POST["forward"])) {
    $recipient = mysqli_real_escape_string($conn, $_POST['recipient']);
    $message_date = date('F d,Y');
    $time = date("h:i:sa");

    if ($recipient == '') {
        $recipientErr = "Recipient is required";
    }



    if ($recipientErr == '') {

        $sql = "INSERT INTO `forwarded_memo_inbox`(`id`, `sender`, `forwarded_by`, `ref`, `receiver`, `message_date`, `time`, `subject`, `message`, `date`, `forwarded_to`, `name`, `type`) 
        VALUES ('$id','$sender','$user','$ref','$receiver','$message_date','$time','$subject','$message','$date','$recipient','$name','forwarded_memo')";
        $result = mysqli_query($conn, $sql);

        $sql1 = "INSERT INTO `forwarded_memo_sent`(`id`, `sender`, `forwarded_by`, `ref`, `receiver`, `message_date`, `time`, `subject`, `message`, `date`, `forwarded_to`, `name`, `type`) 
        VALUES ('$id','$sender','$user','$ref','$receiver','$message_date','$time','$subject','$message','$date','$recipient','$name','forwarded_memo')";
        $result1 = mysqli_query($conn, $sql1);
        if ($result && $result1) {
            echo "<script>alert('Sent Successfully')</script>";
            header("Location: managementdashboard.php");
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
                <?php
                if ($member == "management") { ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forward">
                        Forward <i class="fa fa-forward"></i>
                    </button>
                <?php
                }
                ?>
                <button type="button" class="btn btn-success" onclick="window.print()">Print <i class="fa fa-print"></i></button>

            </div>


        </div>

        <div class="modal fade" id="forward" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Forward Memo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST">
                        
                        <input type="text" class="form-control" id="recipient" readonly name="recipient" hidden value="<?php echo $recipient; ?>">
                        


                        <div class="modal-body">

                            <div class="form-group">
                                <label for="to">Forward To:</label>
                                <select name="recipient" class="form-control" id="recipient">
                                    <option value="">Select Recipient</option>
                                    <?php
                                    $who = "Vice Chancellor";
                                    $too = "Registrar;Bursar;Dean;Director";


                                    if (preg_match("/Vice Chancellor/i", $user)) {
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
                                    } elseif (preg_match("/Dean/i", $user) && preg_match("/Dean/i", $too)) {
                                        $sql = "SELECT * FROM management WHERE Position like '%HOD%' AND college = '$college'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            echo '<option value="' . $who . '">' . $who . '</option>';
                                            echo '<option value="All HODs">All HODs</option>';
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $row['Position'] . '">' . $row['Position'] . '</option>';
                                            }
                                        }
                                    } elseif (preg_match("/HOD/i", $user)) {
                                        $sql = "SELECT * FROM management WHERE Position like '%Program coordinator%' AND dept = '$dept'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $row['Position'] . '">' . $row['Position'] . '</option>';
                                            }
                                        }
                                    } elseif (preg_match("/Program coordinator/i", $user)) {
                                        echo '<option value="All Staffs">All Staffs ' . $dept . '</option>';
                                        echo '<option value="All Students">All Students ' . $dept . '</option>';
                                    } else {
                                        if (preg_match("/$user/i", $too)) {
                                            echo '<option value="' . $who . '">' . $who . '</option>';
                                        }
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" name="forward" class="btn btn-primary">Forward</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="header row my-4">
            <div class="col-md-6">
                <div class="form-group">
                    <p>From: <?php echo $sender; ?></p>
                </div>
                <div class="form-group">
                    <p>Ref: <?php echo $ref; ?></p>
                </div>
                <div class="form-group">
                    <p>Date:<?php echo $message_date; ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <p>To: <?php echo $receiver ?></p>
                </div>
            </div>
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



    </div>


</body>

</html>