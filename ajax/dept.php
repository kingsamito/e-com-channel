<?php

use LDAP\Result;

include_once '../conn.php';

$college_id =   $_POST['college_data'];

$sql = "SELECT * FROM college WHERE college_name_short = '$college_id'";
$result = mysqli_query($conn, $sql);

if($result){
    $row = mysqli_fetch_assoc($result);
}

$newcollege_id = $row['college_id'];

$department = "SELECT * FROM dept WHERE college_id = $newcollege_id";

$department_qry = mysqli_query($conn, $department);
// $output="";
$output = '<option value="">--------------Select Department--------------</option>';
while ($department_row = mysqli_fetch_assoc($department_qry)) {
    $output .= '<option value="' . $department_row['dept_name'] . '">' . $department_row['dept_name'] . '</option>';
}

echo $output;