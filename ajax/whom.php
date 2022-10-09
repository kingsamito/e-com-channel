<?php
include_once '../conn.php';

session_start();

$sender = $_SESSION['Position'];

$recipient =   $_POST['recipient_data'];

$new_recipient = 'All '.$recipient;
$new_recipient1 = 'All Academic Staff';
$new_recipient2 = 'All Non Academic Staff';
$output = '<option value="">Select whom</option>';
if(preg_match('/Program Coordinator/i',$sender) || preg_match('/hod/i', $sender)){
    $output .= "<option value='$recipient'>$new_recipient</option>";
    echo $output;
}elseif(preg_match('/dean/i',$sender)){
    if($recipient == 'Student'){
        $output .= "<option value='$new_recipient'>$new_recipient</option>";
    }else {
        $output .= "<option value='$new_recipient1'>$new_recipient1</option>";
    }
    echo $output;
}elseif(preg_match('/vice chancellor/i',$sender)){
    if($recipient == 'Student'){
        $output .= "<option value='$new_recipient'>$new_recipient</option>";
    }elseif($recipient == 'Academic Staff'){
        $output .= "<option value='$new_recipient1'>$new_recipient1</option>";
    }else{
        $output .= "<option value='$new_recipient2'>$new_recipient2</option>";
    }
    echo $output;
}else{
    echo $output;
}

/* $whom = "SELECT * FROM whom WHERE recipient_id = $recipient_id";

$whom_qry = mysqli_query($conn, $whom);
// $output="";
$output = '<option value="">Select whom</option>';
while ($whom_row = mysqli_fetch_assoc($whom_qry)) {
    $output .= '<option value="' . $whom_row['whom_name'] . '">' . $whom_row['whom_name'] . '</option>';
}

echo $output; */

