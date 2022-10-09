<?php
include_once 'conn.php';
session_start();

if (isset($_POST['notify']) && isset($_POST['notify1']) && isset($_POST['notify2']) && isset($_POST['notify3'])) {
    if (preg_match('/studentdashboard.php/i', $_POST['notify'])) {


        $fullname = $_POST['notify1'];
        $matric = $_POST['notify2'];
        $colstudent = $_POST['notify3'];
        $inboxsql = "SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status`,`notified` FROM commented_exeat_inbox WHERE commented_to = '$fullname' AND notified = '' 
        UNION 
        SELECT `id`,`sender`,`subject`,`date`,`type`,`status`,`notified` FROM commented_other_letter_inbox WHERE commented_to = '$fullname' AND notified = ''
        UNION 
        SELECT `id`,`sender`,`subject`,`date`,`type`,`status`,`notified` FROM student_academic_letter_inbox WHERE id_no = $matric AND notified = ''
        UNION
        SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status`,`notified` FROM commented_academic_letter_inbox WHERE commented_to = '$fullname' AND notified = ''
        UNION
        SELECT `id`, `sender`,`subject`,`date`,`type`,`status`,`notified`  FROM `memo_inbox` WHERE (receiver = 'All Students' OR receiver = '$colstudent') AND notified NOT LIKE '%$matric%' ORDER by `date` DESC";

        $result = mysqli_query($conn, $inboxsql);

        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo $output = "<div id=" . $row['id'] . "><p>" . $row['sender'] . "</p><p>" . $row['type'] . "</p><p>" . $row['notified'] . "</p><p>" . $row['subject'] . "</p></div>";
            }
        }
    }

    if (preg_match('/academic_staffdashboard.php/i', $_POST['notify'])) {
        $fullname = $_POST['notify1'];
        $id = $_POST['notify2'];
        $colstaff = $_POST['notify3'];

        $inboxsql = "SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status` FROM commented_academic_letter_inbox WHERE commented_to = '$fullname' AND notified = ''
        UNION
        SELECT `id`, `sender`,`subject`,`date`,`type`,`status`  FROM `memo_inbox` WHERE (receiver = 'All Staffs' OR receiver = '$colstaff') AND notified NOT LIKE '%$id%' ORDER by `date` DESC";
        $result = mysqli_query($conn, $inboxsql);

        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo $output = "<div id=" . $row['id'] . "><p>" . $row['sender'] . "</p><p>" . $row['type'] . "</p><p>" . $row['notified'] . "</p><p>" . $row['subject'] . "</p></div>";
            }
        }
    }

    if (preg_match('/non_academic_staffdashboard.php/i', $_POST['notify'])) {
        $position = $_POST['notify1'];
        

        $sql = "SELECT `id`,`sender`,`subject`,`date`, `type`,`status` FROM exeat_inbox WHERE through = '$position' AND notified = ''
          UNION
          SELECT `id`,`sender`,`subject`,`date`, `type`,`status` FROM other_letter_inbox WHERE through = '$position' AND notified = ''
          UNION
          SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`, `type`,`status` FROM commented_other_letter_inbox WHERE commented_to = '$position' AND notified = '' ORDER by `date` DESC";
        $result = mysqli_query($conn, $sql);

        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo $output = "<div id=" . $row['id'] . "><p>" . $row['sender'] . "</p><p>" . $row['type'] . "</p><p>" . $row['notified'] . "</p><p>" . $row['subject'] . "</p></div>";
            }
        }
    }

    if (preg_match('/managementdashboard.php/i', $_POST['notify'])) {
        $position = $_POST['notify1'];
        $id = $_POST['notify2'];
        $value = $_POST['notify3'];
        $all = 'All ' . $_SESSION['Position_short'] . 's';

        if (preg_match("/$position/i", $value)) {
            $sql = "SELECT `id`,`sender`,`subject`,`date`, `type`,`status` FROM academic_letter_inbox WHERE through like '%$position%' AND notified = ''
                  UNION 
                  SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status` FROM commented_academic_letter_inbox WHERE commented_to = '$position' AND notified = ''
                  UNION
                  SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `memo_inbox` WHERE (receiver = '$position' or receiver = '$all') AND notified NOT LIKE '%$id%'
                  UNION
                  SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `forwarded_memo_inbox` WHERE (forwarded_to = '$position' or forwarded_to = '$all') AND notified NOT LIKE '%$id%' ORDER by `date` DESC";
            $result = mysqli_query($conn, $sql);
          } else {
            $sql = "SELECT `id`,`sender`,`subject`,`date`, `type`,`status` FROM other_letter_inbox WHERE through = '$position'
                  UNION
                  SELECT `id`,`forwarded_by` AS `sender`,`subject`,`date`,`type`,`status` FROM commented_academic_letter_inbox WHERE commented_to = '$position' AND notified = ''
                  UNION
                  SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `memo_inbox` WHERE (receiver = '$position' or receiver = '$all') AND notified NOT LIKE '%$id%'
                  UNION
                  SELECT `id`,`sender`, `subject`,`date`, `type`,`status` FROM `forwarded_memo_inbox` WHERE (forwarded_to = '$position' or forwarded_to = '$all') AND notified NOT LIKE '%$id%' ORDER by `date` DESC";
            $result = mysqli_query($conn, $sql);
          }
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo $output = "<div id=" . $row['id'] . "><p>" . $row['sender'] . "</p><p>" . $row['type'] . "</p><p>" . $row['notified'] . "</p><p>" . $row['subject'] . "</p></div>";
            }
        }
    }
}

if (isset($_POST['notifyupdate']) && isset($_POST['notifyupdate1']) && isset($_POST['notifyupdate2']) && isset($_POST['notifyupdate3'])) {
    $id = $_POST['notifyupdate'];
    $type = $_POST['notifyupdate1'];
    $id_no = $_POST['notifyupdate2'];
    $notified = $_POST['notifyupdate3'];

    if ($type == 'commented_exeat') {
        $sql1 = "UPDATE `commented_exeat_inbox` SET `notified`='yes' WHERE id = $id";
        $res1 = mysqli_query($conn, $sql1);
    } elseif ($type == 'commented_other_letter') {
        $sql1 = "UPDATE `commented_other_letter_inbox` SET `notified`='yes' WHERE id = $id";
        $res1 = mysqli_query($conn, $sql1);
    } elseif ($type == 'commented_academic') {
        $sql1 = "UPDATE `commented_academic_letter_inbox` SET `notified`='yes' WHERE id = $id";
        $res1 = mysqli_query($conn, $sql1);
    } elseif ($type == 'academic') {
        $sql1 = "UPDATE `academic_letter_inbox` SET `notified`='yes' WHERE id = $id";
        $res1 = mysqli_query($conn, $sql1);
    }elseif ($type == 'others') {
        $sql1 = "UPDATE `other_letter_inbox` SET `notified`='yes' WHERE id = $id";
        $res1 = mysqli_query($conn, $sql1);
    }elseif ($type == 'exeat' || $type == 'med_exeat') {
        $sql1 = "UPDATE `exeat_inbox` SET `notified`='yes' WHERE id = $id";
        $res1 = mysqli_query($conn, $sql1);
    }elseif ($type == 'forwarded_memo') {
        $useread = $id_no . ";";
        $notified .= $useread;
        $sql1 = "UPDATE `forwarded_memo_inbox` SET `notified`='$notified' WHERE id = $id";
        $res1 = mysqli_query($conn, $sql1);
    } else {
        $useread = $id_no . ";";
        $notified .= $useread;
        $sql1 = "UPDATE `memo_inbox` SET `notified`= '$notified' WHERE id = $id";
        $res1 = mysqli_query($conn, $sql1);
    }
}
