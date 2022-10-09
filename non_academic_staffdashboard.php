<?php

include_once 'conn.php';

session_start();

if (!isset($_SESSION["Position"])) {
  header("Location: login.php");
}


$firstname = $_SESSION['Firstname'];
$lastname = $_SESSION['Lastname'];
$position = $_SESSION['Position'];

$member =  $_SESSION["member"];
$memberinbox = $member . "_inbox";
$memberdraft = $member . "_draft";
$membersent = $member . "_sent";
$id = $member . "_id";
$Acad_id = $_SESSION[$id];

$url_inbox = 'non_academic_staffdashboard.php?folder=inbox';
$url_sent = 'non_academic_staffdashboard.php?folder=sent';

include_once 'changepassword.php';

if ($member == "non_academic_staff") {

  $sql = "SELECT `id`,`sender`,`subject`,`date`, `type`,`status` FROM exeat_inbox WHERE through = '$position'
          UNION
          SELECT `id`,`sender`,`subject`,`date`, `type`,`status` FROM other_letter_inbox WHERE through = '$position'
          UNION
          SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`, `type`,`status` FROM commented_other_letter_inbox WHERE commented_to = '$position' ORDER by `date` DESC";
  $result = mysqli_query($conn, $sql);
  $inboxnum = mysqli_num_rows($result);

  /*  $tin = '';
  $value = '';
  if (mysqli_num_rows($sqlresult) > 0) {
    while ($row = mysqli_fetch_assoc($sqlresult)) {

      $tin = $row['through'];
      $value .=  $tin;
    }
  }

  if (preg_match("/$position/i", $value)) {
    $sql = "SELECT `id`,`sender`,`subject`,`date`, `type`,`status` FROM exeat_inbox WHERE through = '$position'
            UNION
            SELECT `id`,`sender`,`subject`,`date`, `type`,`status` FROM other_letter_inbox WHERE through = '$position'";
    $result = mysqli_query($conn, $sql);
    $inboxnum = mysqli_num_rows($result);
  } else {
    $sql = "SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`, `type`,`status` FROM commented_other_letter_inbox WHERE commented_to = '$position' ORDER by `date` DESC";
    $result = mysqli_query($conn, $sql);
    $inboxnum = mysqli_num_rows($result);
  } */

  $sentsql = "SELECT `id`,`commented_to` AS `too`, `subject`,`type`, `date` FROM commented_other_letter_sent WHERE forwarded_by = '$position' 
              UNION
              SELECT `id`,`commented_to` AS `too`, `subject`,`type`, `date` FROM commented_other_letter_sent WHERE forwarded_by = '$position' ORDER by `date` DESC";
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


  <title> Crawford University | Non Academic Staff</title>
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
  <input id="user2" type="hidden" value="">
  <input id="user3" type="hidden" value="">
</div>

<div id="retrieval" style="display: none;">

</div>

<div id="reloadContent">
<?php

if (!preg_match('/folder/i', $_SERVER['REQUEST_URI'])) {
  include_once 'get_non_acad_staff_message.php';
}
if (preg_match('/folder/i', $_SERVER['REQUEST_URI'])) {
  $folder = $_GET['folder'];
  if ($folder == 'inbox') {
    include_once 'get_non_acad_staff_message.php';
  }
}
if (preg_match('/folder/i', $_SERVER['REQUEST_URI'])) {
  $folder = $_GET['folder'];
  if ($folder == 'sent') {
    include_once 'get_non_acad_staff_sentmessage.php';
  }
}
?>
</div>

<?php
include_once 'footer.php';
?>