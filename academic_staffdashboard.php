<?php

include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
  header("Location: login.php");
}


$firstname = $_SESSION['Firstname'];
$lastname = $_SESSION['Lastname'];
$fullname = $firstname . " " . $lastname;
$position = $_SESSION['Position'];
$collegename = $_SESSION['College'];
$deptname = $_SESSION['Department'];

$member =  $_SESSION["member"];
$memberinbox = $member . "_inbox";
$memberdraft = $member . "_draft";
$membersent = $member . "_sent";
$id = $member . "_id";
$Acad_id = $_SESSION[$id];


$url_inbox = 'academic_staffdashboard.php?folder=inbox';
$url_sent = 'academic_staffdashboard.php?folder=sent';

if ($member == "academic_staff") {

  $id_no = $_SESSION['academic_staff_id'];

  $colstaff = 'All Staffs ' . $deptname;
  $display = "";
  /* $inboxsql = "SELECT `id`,`sender`,`too`,`date`,`type` FROM staff_academic_letter_inbox WHERE id_no = $id_no"; */
  $inboxsql = "SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status` FROM commented_academic_letter_inbox WHERE commented_to = '$fullname' 
  UNION
  SELECT `id`, `sender`,`subject`,`date`,`type`,`status`  FROM `memo_inbox` WHERE receiver = 'All Staffs' OR receiver = '$colstaff' ORDER by `date` DESC";;
  $result = mysqli_query($conn, $inboxsql);
  $inboxnum = mysqli_num_rows($result);



  $display1 = "";
  $sentsql = "SELECT `id`,`sender`,`too`,`subject`,`date`,`type` FROM academic_letter_sent WHERE id_no = $id_no ORDER by `date` DESC";
  $sentresult = mysqli_query($conn, $sentsql);
  $sentnum = mysqli_num_rows($sentresult);
}



?>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <title> Crawford University | Academic Staff</title>
  <link rel="stylesheet" href="admin/fontawesome-free-6.1.1-web/css/all.min.css">
  <link rel="stylesheet" href="admin/style.css">
  <link rel="stylesheet" href="bootstrap.min.css">

  <script src="jquery.min.js"></script>
  <script src="popper.min.js"></script>
  <script src="bootstrap.min.js"></script>
</head>

<?php
include_once 'body.php';
?>

<div id="userContainer">
  <input id="user1" type="hidden" value="<?php echo $fullname; ?>">
  <input id="user2" type="hidden" value="<?php echo $id_no; ?>">
  <input id="user3" type="hidden" value="<?php echo $colstaff; ?>">
</div>

<div id="retrieval" style="display: none;">

</div>

<div id="reloadContent">

  <?php
  if (!preg_match('/folder/i', $_SERVER['REQUEST_URI'])) {
    include_once 'get_acad_staff_message.php';
  }
  if (preg_match('/folder/i', $_SERVER['REQUEST_URI'])) {
    $folder = $_GET['folder'];
    if ($folder == 'inbox') {
      include_once 'get_acad_staff_message.php';
    }
  }
  if (preg_match('/folder/i', $_SERVER['REQUEST_URI'])) {
    $folder = $_GET['folder'];
    if ($folder == 'sent') {
      include_once 'get_acad_staff_sentmessage.php';
    }
  }
  ?>
</div>

<?php

include_once 'footer.php';
?>