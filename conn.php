<?php

$dbsevername = "sql306.epizy.com";
$dbusername = "epiz_32759108";
$dbpassword = "ekdx7lLM85VWs";
$dbname = "epiz_32759108_e_com_system";

$conn = mysqli_connect($dbsevername, $dbusername, $dbpassword, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
