<?php
session_start();
include_once 'include/config.php';

$con = mysql_connect(HOST, USERNAME, PASSWORD);

mysql_select_db(DB, $con);

$prsid=$_POST['id'];
$uid=$_SESSION['UID'];
$date=date("Y-m-d H:i:s");

$qry= "UPDATE opd_presciption SET Status='Ready', LastUpDate='$date', LastUpDateUID='$uid' WHERE PRSID=$prsid";

$result=mysql_query($qry);

if($result){
echo json_encode($result);
}

?>