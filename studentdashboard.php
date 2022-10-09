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

$url_inbox = 'studentdashboard.php?folder=inbox';
$url_sent = 'studentdashboard.php?folder=sent';

include_once 'changepassword.php';

if ($member == "student") {

  $matric = $_SESSION["student_id"];

  /* $collegesql = "SELECT student.College, college.college_name_short
  FROM student
  INNER JOIN college ON student.College=college.college_id";
  $collegesqlresult = mysqli_query($conn, $collegesql);

  $collegesql = "SELECT College FROM $member WHERE $id = $Acad_id";
  $collegesqlresult = mysqli_query($conn, $collegesql);
  if (mysqli_num_rows($collegesqlresult)) {
    while ($row = mysqli_fetch_assoc($collegesqlresult)) {
      $college = $row['College'];
    }
  }

  $collegenamesql = "SELECT college_name_short FROM college WHERE college_id = $college";
  $collegenamesqlresult = mysqli_query($conn, $collegenamesql);
  if (mysqli_num_rows($collegenamesqlresult)) {
    while ($row = mysqli_fetch_assoc($collegenamesqlresult)) {
      $collegename = $row['college_name_short'];
      
    }
  }

  $dept_id = $_SESSION['Department'];
  $deptnamesql = "SELECT dept_name FROM dept WHERE dept_id = $dept_id";
  $deptnamesqlresult = mysqli_query($conn, $deptnamesql);
  if (mysqli_num_rows($deptnamesqlresult)) {
    while ($row = mysqli_fetch_assoc($deptnamesqlresult)) {
      $deptname = $row['dept_name'];
      
    }
  }
 */
  /*  $inboxsql = "SELECT * FROM $memberinbox WHERE RECEIVER = 'All Student' OR RECEIVER LIKE '%$collegename%'";
  $inboxresult = mysqli_query($conn, $inboxsql);
  $inboxnum = mysqli_num_rows($inboxresult); */
  $colstudent = 'All Students ' . $deptname;
  $display = "";
  $inboxsql = "SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status` FROM commented_exeat_inbox WHERE commented_to = '$fullname' 
  UNION 
  SELECT `id`,`sender`,`subject`,`date`,`type`,`status` FROM commented_other_letter_inbox WHERE commented_to = '$fullname'
  UNION
  SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status` FROM commented_academic_letter_inbox WHERE commented_to = '$fullname' 
  UNION
  SELECT `id`, `sender`,`subject`,`date`,`type`,`status`  FROM `memo_inbox` WHERE receiver = 'All Students' OR receiver = '$colstudent' ORDER by `date` DESC";

  $result = mysqli_query($conn, $inboxsql);
  $inboxnum = mysqli_num_rows($result);


  /* $draftsql = "SELECT * FROM $memberdraft WHERE SENDER= $Acad_id";
  $draftresult = mysqli_query($conn, $draftsql);
  $draftnum = mysqli_num_rows($draftresult); */
  $display1 = "";
  $sentsql = "SELECT `id`,`subject`,`too`,`date`,`type` FROM exeat_sent WHERE matric = $matric
  UNION 
  SELECT `id`,`subject`,`too`,`date`,`type` FROM student_other_letter_sent WHERE matric = $matric
  UNION 
  SELECT `id`,`subject`,`too`,`date`,`type` FROM academic_letter_sent WHERE id_no = $matric
  UNION 
  SELECT `id`,`subject`,`too`,`date`,`type` FROM other_letter_sent WHERE matric = $matric ORDER by `date` DESC";
  $sentresult = mysqli_query($conn, $sentsql);
  $sentnum = mysqli_num_rows($sentresult);


  /* $sentsql = "SELECT * FROM academic_letter_sent WHERE matric = $matric UNION SELECT * FROM other_letter_sent WHERE matric = $matric;";
  $sentresult = mysqli_query($conn, $sentsql);
  $sentnum = mysqli_num_rows($sentresult); */


  /* $sentsql = "SELECT * FROM $membersent WHERE SENDER = $Acad_id";
  $sentresult = mysqli_query($conn, $sentsql);
  $sentnum = mysqli_num_rows($sentresult);  */
}



?>
<html>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">


<title> Crawford University | Student</title>
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
  <input id="user2" type="hidden" value="<?php echo $matric; ?>">
  <input id="user3" type="hidden" value="<?php echo $colstudent; ?>">
</div>

<div id="retrieval" style="display: none;">

</div>

<div id="reloadContent">
  <?php

  if (!preg_match('/folder/i', $_SERVER['REQUEST_URI'])) {
    include_once 'get_student_message.php';
  }
  if (preg_match('/folder/i', $_SERVER['REQUEST_URI'])) {
    $folder = $_GET['folder'];
    if ($folder == 'inbox') {
      include_once 'get_student_message.php';
    }
  }
  if (preg_match('/folder/i', $_SERVER['REQUEST_URI'])) {
    $folder = $_GET['folder'];
    if ($folder == 'sent') {
      include_once 'get_student_sentmessage.php';
    }
  }
  ?>
</div>



<?php
include_once 'footer.php';
?>




<!-- <script>
  var old = document.getElementsByClassName("message")

  function showNotification() {
    var title = "New message from Samito";
    var body = "Hey whatsap. i'm just testing the system";
    const notification = new Notification(
      title, {
        body: body
      },
    );
    console.log(Notification)
  }

  if (Notification.permission === "granted") {
    showNotification();
  } else if (Notification.permission !== "denied") {
    Notification.requestPermission().then(permission => {
      if (permission === "granted") {
        showNotification();
      }
    })
  }
</script> -->