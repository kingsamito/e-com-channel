<?php

include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
  header("Location: login.php");
}

$id = $_SESSION['management_id'];
$firstname = $_SESSION['Firstname'];
$lastname = $_SESSION['Lastname'];
$position = $_SESSION['Position'];
$position_short = $_SESSION['Position_short'];
$college = $_SESSION['College'];
$dept = $_SESSION['Department'];
$password = $_SESSION['password'];

$member =  $_SESSION["member"];
$memberinbox = $member . "_inbox";
$memberdraft = $member . "_draft";
$membersent = $member . "_sent";

$url_inbox = 'managementdashboard.php?folder=inbox';
$url_sent = 'managementdashboard.php?folder=sent';

$all = 'All ' . $position_short . 's';


include_once 'changepassword.php';


if ($member == "management") {
  $sql1 = "SELECT * FROM academic_letter_inbox";
  $result1 = mysqli_query($conn, $sql1);

  $tin = '';
  $value = '';
  if (mysqli_num_rows($result1) > 0) {
    while ($row = mysqli_fetch_assoc($result1)) {

      for ($i = 0; $i < count(explode(";", $row['through'])) - 1; $i++) {

        $tin = explode(";", $row['through'])[$i] . ' ';
      }
      $value .=  $tin;
    }
  }

  //selct all where the personlogged in is the last person
  if (preg_match("/$position/i", $value)) {
    $sql = "SELECT `id`,`sender`,`subject`,`date`, `type`,`status` FROM academic_letter_inbox WHERE through like '%$position%'
          UNION 
          SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status` FROM commented_academic_letter_inbox WHERE commented_to = '$position'
          UNION
          SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `memo_inbox` WHERE receiver = '$position' or receiver = '$all'
          UNION
          SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `forwarded_memo_inbox` WHERE forwarded_to = '$position' or forwarded_to = '$all' ORDER by `date` DESC";
    $result = mysqli_query($conn, $sql);
    $inboxnum = mysqli_num_rows($result);
  } else {
    $sql = "SELECT `id`,`sender`,`subject`,`date`, `type`,`status` FROM other_letter_inbox WHERE through = '$position'
          UNION
          SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status` FROM commented_academic_letter_inbox WHERE commented_to = '$position'
          UNION
          SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `memo_inbox` WHERE receiver = '$position' or receiver = '$all'
          UNION
          SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `forwarded_memo_inbox` WHERE forwarded_to = '$position' or forwarded_to = '$all' ORDER by `date` DESC";
    $result = mysqli_query($conn, $sql);
    $inboxnum = mysqli_num_rows($result);
  }


  $sentsql = "SELECT `id`,`commented_to` AS `receiver`, `subject`,`type`, `date`,`status` FROM commented_academic_letter_sent WHERE forwarded_by = '$position' 
              UNION
              SELECT `id`, `receiver`, `subject`,`type`, `date`,`status` FROM `memo_sent` WHERE sender = '$position' 
              UNION
              SELECT `id`,`forwarded_to`  AS `receiver`, `subject`,`type`,`date`,`status`  FROM `forwarded_memo_sent` WHERE forwarded_by = '$position' ORDER by `date` DESC";
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


  <title> Crawford University | Management</title>
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
  <input id="user1" type="hidden" value="<?php echo $position; ?>">
  <input id="user2" type="hidden" value="<?php echo $id; ?>">
  <input id="user3" type="hidden" value="<?php echo $value; ?>">
</div>

<div id="retrieval" style="display: none;">

</div>

<div id="reloadContent">
  <?php

  if (!preg_match('/folder/i', $_SERVER['REQUEST_URI'])) {
    include_once 'getmessage.php';
  }
  if (preg_match('/folder/i', $_SERVER['REQUEST_URI'])) {
    $folder = $_GET['folder'];
    if ($folder == 'inbox') {
      include_once 'getmessage.php';
    }
  }
  if (preg_match('/folder/i', $_SERVER['REQUEST_URI'])) {
    $folder = $_GET['folder'];
    if ($folder == 'sent') {
      include_once 'getsentmessage.php';
    }
  }
  ?>
</div>

<?php
include_once 'footer.php';
?>