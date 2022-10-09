<?php

include_once 'conn.php';

$sql = "SELECT * from `time`";
$res = mysqli_query($conn, $sql);

/* function relative_date($time){

    $today = strtotime(date('Y-m-d H:i:s'));
    $time = strtotime($time);
    
    $reldays = ($time - $today) / 86400;

    if ($reldays >= 0 && $reldays < 1) {

        return 'Today';
    } else if ($reldays >= 1 && $reldays < 2) {

        return 'Tomorrow';
    } else if ($reldays >= -1 && $reldays < 0) {

        return 'Yesterday';
    }

    if (abs($reldays) < 7) {

        if ($reldays > 0) {

            $reldays = floor($reldays);

            return 'In ' . $reldays . ' day' . ($reldays != 1 ? 's' : '');
        } else {

            $reldays = abs(floor($reldays));

            return $reldays . ' day' . ($reldays != 1 ? 's' : '') . ' ago';
        }
    }

    if (abs($reldays) < 182) {

        return date('l, j F', $time ? $time : time());
    } else {

        return date('l, j F, Y', $time ? $time : time());
    }
} */

while ($ro = mysqli_fetch_assoc($res)) {
    $time = $ro['date'];
    $time = strtotime($time);

    if ($time >= strtotime("today")) {
        echo date("H:i", $time);
    } elseif ($time >= strtotime("yesterday")) {
        echo "yesterday";
    } elseif ($time >= strtotime("-2 Days")) {
        echo date("l", $time);
    }elseif ($time >= strtotime("-3 Days")) {
        echo date("l", $time);
    }elseif ($time >= strtotime("-4 Days")) {
        echo date("l", $time);
    }elseif ($time >= strtotime("-5 Days")) {
        echo date("l", $time);
    }else{
        echo date("m/d/y", $time);
    }
}

/* function dates($date){


    
    
} */

$d = strtotime("2022-08-31 00:08:39");
echo date("m/d/y", $d);

/* $d=strtotime("-2 Days");
echo date("Y-m-d h:i:sa", $d);

$d=strtotime("yesterday");
echo date("Y-m-d h:i:sa", $d);

$d=strtotime("today");
echo date("Y-m-d h:i:sa", $d);

$d=strtotime("tomorrow");
echo date("Y-m-d h:i:sa", $d);

$d=strtotime("next Saturday");
echo date("Y-m-d h:i:sa", $d);

$d=strtotime("+3 Months");
echo date("Y-m-d h:i:sa", $d); */