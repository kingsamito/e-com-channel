<?php

$dbsevername = "fdb28.awardspace.net";
$dbusername = "4190923_ecom";
$dbpassword = "M383EYJP@7ZDK@y";
$dbname = "4190923_ecom";

$conn = mysqli_connect($dbsevername, $dbusername, $dbpassword, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
