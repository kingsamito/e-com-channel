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


if ($member == "non_academic_staff") {
  if ($_SESSION["Position"] == "Hall Master") {
    $inboxsql = "SELECT * FROM exeat_inbox WHERE through = '$position'";
    $inboxresult = mysqli_query($conn, $inboxsql);
    $inboxnum = mysqli_num_rows($inboxresult);
  }
  if ($_SESSION["Position"] == "Dean Student Affairs") {
    $inboxsql = "SELECT * FROM exeat_inbox WHERE too = '$position' AND hm_comment != ''";
    $inboxresult = mysqli_query($conn, $inboxsql);
    $inboxnum = mysqli_num_rows($inboxresult);
  }



  $draftsql = "SELECT * FROM $memberdraft WHERE SENDER= $Acad_id";
  $draftresult = mysqli_query($conn, $draftsql);
  $draftnum = mysqli_num_rows($draftresult);

  $sentsql = "SELECT * FROM $membersent WHERE SENDER= '$position'";
  $sentresult = mysqli_query($conn, $sentsql);
  $sentnum = mysqli_num_rows($sentresult);
}


if ($member == "academic_staff") {

  $collegesql = "SELECT academic_staff.College, college.college_name_short
  FROM academic_staff
  INNER JOIN college ON academic_staff.College=college.college_id";
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
      $_SESSION['collegename'] = $collegename;
    }
  }

  $dept_id = $_SESSION['Department'];
  $deptnamesql = "SELECT dept_name FROM department WHERE dept_id = $dept_id";
  $deptnamesqlresult = mysqli_query($conn, $deptnamesql);
  if (mysqli_num_rows($deptnamesqlresult)) {
    while ($row = mysqli_fetch_assoc($deptnamesqlresult)) {
      $deptname = $row['dept_name'];
      $_SESSION['deptname'] = $deptname;
    }
  }

  $inboxsql = "SELECT * FROM $memberinbox WHERE RECEIVER = 'All Staff' OR RECEIVER LIKE '%$collegename%'";
  $inboxresult = mysqli_query($conn, $inboxsql);
  $inboxnum = mysqli_num_rows($inboxresult);


  $draftsql = "SELECT * FROM $memberdraft WHERE SENDER= $Acad_id";
  $draftresult = mysqli_query($conn, $draftsql);
  $draftnum = mysqli_num_rows($draftresult);

  $sentsql = "SELECT * FROM $membersent WHERE SENDER = $Acad_id";
  $sentresult = mysqli_query($conn, $sentsql);
  $sentnum = mysqli_num_rows($sentresult);
}


if ($member == "student") {

  $matric = $_SESSION["Matric"];

  $collegesql = "SELECT student.College, college.college_name_short
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
      $_SESSION['collegename'] = $collegename;
    }
  }

  $dept_id = $_SESSION['Department'];
  $deptnamesql = "SELECT dept_name FROM department WHERE dept_id = $dept_id";
  $deptnamesqlresult = mysqli_query($conn, $deptnamesql);
  if (mysqli_num_rows($deptnamesqlresult)) {
    while ($row = mysqli_fetch_assoc($deptnamesqlresult)) {
      $deptname = $row['dept_name'];
      $_SESSION['deptname'] = $deptname;
    }
  }

  /*  $inboxsql = "SELECT * FROM $memberinbox WHERE RECEIVER = 'All Student' OR RECEIVER LIKE '%$collegename%'";
  $inboxresult = mysqli_query($conn, $inboxsql);
  $inboxnum = mysqli_num_rows($inboxresult); */

  $inboxsql = "SELECT * FROM student_exeat_inbox WHERE matric=$matric";
  $inboxresult = mysqli_query($conn, $inboxsql);
  $inboxnum = mysqli_num_rows($inboxresult);



  $draftsql = "SELECT * FROM $memberdraft WHERE SENDER= $Acad_id";
  $draftresult = mysqli_query($conn, $draftsql);
  $draftnum = mysqli_num_rows($draftresult);

  $sentsql = "SELECT * FROM academic_letter_sent WHERE matric = $matric UNION SELECT * FROM other_letter_sent WHERE matric = $matric;";
  $sentresult = mysqli_query($conn, $sentsql);
  $sentnum = mysqli_num_rows($sentresult);


  /* $sentsql = "SELECT * FROM $membersent WHERE SENDER = $Acad_id";
  $sentresult = mysqli_query($conn, $sentsql);
  $sentnum = mysqli_num_rows($sentresult);  */
}

if ($member == "management") {
  /* $inboxsql = "SELECT * FROM academic_letter_inbox WHERE through LIKE 'All%' OR RECEIVER = '$position'";
  $inboxresult = mysqli_query($conn, $inboxsql);
  $inboxnum = mysqli_num_rows($inboxresult); */


  $tin = "";
  $comment = "";
  $sql = "SELECT * FROM academic_letter_inbox WHERE through like '%$position%' or too = '$position'";
  $result = mysqli_query($conn, $sql);
  echo $position . "<br>";
  echo mysqli_num_rows($result) . "<br>";

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $to = $row['too'];
      $tin = explode(";", $row['through']);
      $comment = $row["comment"];

      echo $to .  "<br>";

      $newLen = count($tin) - 1;
      echo $newLen . "<br>";
      echo $position . "<br>";

      $display = '';

      if ($newLen == 3) {
        $search = preg_quote(":");
        $nefind = $tin[2] . ":";
        $find = "/$nefind/";

        $nefind1 = $tin[1] . ":";
        $find1 = "/$nefind1/";

        $nefind2 = $tin[0] . ":";
        $find2 = "/$nefind2/";
        if ($position == $tin[2]) {

          $sql = "SELECT * FROM  academic_letter_inbox";
          $result = mysqli_query($conn, $sql);
          $inboxnum = mysqli_num_rows($result);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $display.= "<a href='academic_letter_inbox_opener.php?id=" . $row['id'] . "' " . "class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>" . $row["sender"] . "<span class='badge badge-pill badge-info'>" . $row['date'] . "</span></a>";
            }
          }
        } elseif ($position == $tin[1]) {
          $sql = "SELECT * FROM  academic_letter_inbox WHERE comment like '%$nefind%'";
          $result = mysqli_query($conn, $sql);
          $inboxnum = mysqli_num_rows($result);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $display.= "<a href='academic_letter_inbox_opener.php?id=" . $row['id'] . "' " . "class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>" . $row["sender"] . "<span class='badge badge-pill badge-info'>" . $row['date'] . "</span></a>";
            }
          }
        } elseif ($position == $tin[0]) {
          $sql = "SELECT * FROM  academic_letter_inbox WHERE comment like '%$nefind1%'";
          $result = mysqli_query($conn, $sql);
          $inboxnum = mysqli_num_rows($result);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $display.= "<a href='academic_letter_inbox_opener.php?id=" . $row['id'] . "' " . "class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>" . $row["sender"] . "<span class='badge badge-pill badge-info'>" . $row['date'] . "</span></a>";
            }
          }
        } elseif ($position == $to) {
          $sql = "SELECT * FROM  academic_letter_inbox WHERE comment like '%$nefind2%'";
          $result = mysqli_query($conn, $sql);
          $inboxnum = mysqli_num_rows($result);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $display.= "<a href='academic_letter_inbox_opener.php?id=" . $row['id'] . "' " . "class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>" . $row["sender"] . "<span class='badge badge-pill badge-info'>" . $row['date'] . "</span></a>";
            }
          } else {
            echo "No Message";
          }
        } else {
          echo "No Message";
        }
      }
      if ($newLen == 2) {
        $search = preg_quote(":");
        
        $nefind1 = $tin[1] . ":";
        $find1 = "/$nefind1/";

        $nefind2 = $tin[0] . ":";
        $find2 = "/$nefind2/";
        if ($position == $tin[1]) {

          $sql = "SELECT * FROM  academic_letter_inbox";
          $result = mysqli_query($conn, $sql);
          $inboxnum = mysqli_num_rows($result);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $display.= "<a href='academic_letter_inbox_opener.php?id=" . $row['id'] . "' " . "class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>" . $row["sender"] . "<span class='badge badge-pill badge-info'>" . $row['date'] . "</span></a>";
            }
          }
        }elseif ($position == $tin[0]) {
          $sql = "SELECT * FROM  academic_letter_inbox WHERE comment like '%$nefind1%'";
          $result = mysqli_query($conn, $sql);
          $inboxnum = mysqli_num_rows($result);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $display.= "<a href='academic_letter_inbox_opener.php?id=" . $row['id'] . "' " . "class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>" . $row["sender"] . "<span class='badge badge-pill badge-info'>" . $row['date'] . "</span></a>";
            }
          }
        } elseif ($position == $to) {
          $sql = "SELECT * FROM  academic_letter_inbox WHERE comment like '%$nefind2%'";
          $result = mysqli_query($conn, $sql);
          $inboxnum = mysqli_num_rows($result);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $display.= "<a href='academic_letter_inbox_opener.php?id=" . $row['id'] . "' " . "class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>" . $row["sender"] . "<span class='badge badge-pill badge-info'>" . $row['date'] . "</span></a>";
            }
          } else {
            echo "No Message";
          }
        } else {
          echo "No Message";
        }
      }
      if ($newLen == 1) {
        $search = preg_quote(":");
        
        $nefind2 = $tin[0] . ":";
        $find2 = "/$nefind2/";
        if ($position == $tin[0]) {

          $sql = "SELECT * FROM  academic_letter_inbox";
          $result = mysqli_query($conn, $sql);
          $inboxnum = mysqli_num_rows($result);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $display.= "<a href='academic_letter_inbox_opener.php?id=" . $row['id'] . "' " . "class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>" . $row["sender"] . "<span class='badge badge-pill badge-info'>" . $row['date'] . "</span></a>";
            }
          }
        }elseif ($position == $to) {
          $sql = "SELECT * FROM  academic_letter_inbox WHERE comment like '%$nefind2%'";
          $result = mysqli_query($conn, $sql);
          $inboxnum = mysqli_num_rows($result);
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $display.= "<a href='academic_letter_inbox_opener.php?id=" . $row['id'] . "' " . "class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>" . $row["sender"] . "<span class='badge badge-pill badge-info'>" . $row['date'] . "</span></a>";
            }
          } else {
            echo "No Message";
          }
        } else {
          echo "No Message";
        }
      }
    }
  } else {
    echo "No Message";
  }







  /* $draftsql = "SELECT * FROM $memberdraft WHERE SENDER= $Acad_id";
  $draftresult = mysqli_query($conn, $draftsql);
  $draftnum = mysqli_num_rows($draftresult);

  $sentsql = "SELECT * FROM $membersent WHERE SENDER= '$position'";
  $sentresult = mysqli_query($conn, $sentsql);
  $sentnum = mysqli_num_rows($sentresult); */
}
/* 
 */

/* $inboxsql = "SELECT * FROM $memberinbox WHERE RECEIVER = 'all' OR RECEIVER = '$collegename'";
$inboxresult = mysqli_query($conn, $inboxsql);
$inboxnum = mysqli_num_rows($inboxresult);
  

$draftsql = "SELECT * FROM academicdraft WHERE SENDER= $Acad_id";
$draftresult = mysqli_query($conn, $draftsql);
$draftnum = mysqli_num_rows($draftresult);

$sentsql = "SELECT * FROM academicsent WHERE SENDER = $Acad_id";
$sentresult = mysqli_query($conn, $sentsql);
$sentnum = mysqli_num_rows($sentresult); 
  */

/* $sendersql = "SELECT academicinbox.SENDER, non_academic_staff.Position
FROM academicinbox
INNER JOIN non_academic_staff ON academicinbox.SENDER=non_academic_staff.Acad_id ORDER BY academicinbox.id";
$sendersqlresult = mysqli_query($conn, $sendersql);

$receiversql = "SELECT academicsent.RECEIVER, non_academic_staff.Position
FROM academicsent
INNER JOIN non_academic_staff ON academicsent.RECEIVER=non_academic_staff.Acad_id ORDER BY academicsent.id";
$receiversqlresult = mysqli_query($conn, $receiversql);
  */

?>
<html>

<head>
  <link rel="stylesheet" href="bootstrap.min.css">

  <script src="jquery.min.js"></script>
  <script src="popper.min.js"></script>
  <script src="bootstrap.min.js"></script>
</head>

<body>

  <div class="row mt-4">
    <div class="col-md-10 m-auto">
      <div class="container">
        <a href="logout.php"><button class="btn btn-success">Logout out</button></a>

        <?php
        echo "<h1>" . $firstname . " " . $lastname . " " . $position . " " . $Acad_id ./* " college ".$college." college name ".$collegename. */ "</h1>";
        ?>

        <div class="d-flex justify-content-between mb-1">
          <h2>Mail</h2>
          <div class="dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">New Message</button>
            <div class="dropdown-menu">
              <?php
              if ($member == 'non_academic_staff') {
                echo '<a class="dropdown-item" href="memo.php">Memo</a>
                          <a class="dropdown-item" href="newmessage.php">Letter</a>';
              } elseif ($member == 'academic_staff') {
                echo '<a class="dropdown-item" href="sletter.php">Letter</a>';
              } elseif ($member == 'student') {
                echo '<a class="dropdown-item" href="tester.php">Academic Letter</a>
                          <a class="dropdown-item" href="exeatletter.php">Exeat Letter</a>
                          <a class="dropdown-item" href="medicalexeat.php">Medical Exeat</a>
                          <a class="dropdown-item" href="otherletter.php">Others</a>';
              } else {
                echo '<a class="dropdown-item" href="memo.php">Memo</a>';
              }
              ?>

            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-lg-4">
            <ul class="nav nav-tab flex-column">
              <div class="list-group">
                <a href="#inbox" data-toggle="tab" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center active">Inbox<span class="badge badge-pill badge-info"><?php echo $inboxnum; ?></span></a>
                <!-- <a href="#draft" data-toggle="tab" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Draft<span class="badge badge-pill badge-warning"><?php echo $draftnum; ?></span></a>
                    <a href="#sent" data-toggle="tab" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Sent<span class="badge badge-pill badge-success"><?php echo $sentnum; ?></span></a>
                   -->
              </div>
            </ul>
          </div>

          <div class="col-lg-8">
            <div class="tab-content">
              <div class="tab-pane fade active show" id="inbox">
                <?php
                if ($inboxnum > 0) {
                  echo $display;
                } else {
                  echo "No results";
                }
                ?>
              </div>

              <div class="tab-pane fade" id="draft">
                <?php
                if ($draftnum > 0) {
                  while ($row = mysqli_fetch_assoc($draftresult)) {
                    $id = $row['id'];
                    echo "<a href='academicdraftopen.php?id=" . $id . "' " . "class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>" . $row["SENDER"] . "<span class='badge badge-pill badge-info'>" . $row['DATE'] . "</span></a>";
                  }
                } else {
                  echo "No results";
                }
                ?>
              </div>

              <div class="tab-pane fade" id="sent">
                <?php
                if ($sentnum > 0) {
                  while ($row = mysqli_fetch_assoc($sentresult)) {
                    $id = $row['id'];

                    echo "<a href='letteropen.php?id=" . $id . "' " . "class='list-group-item list-group-item-action d-flex justify-content-between align-items-center'>" . $row["too"] . "<span class='badge badge-pill badge-info'>" . $row['date'] . "</span></a>";
                  }
                } else {
                  echo "No results";
                }
                ?>
              </div>

            </div>
          </div>

        </div>

      </div>
    </div>
  </div>



</body>

</html>