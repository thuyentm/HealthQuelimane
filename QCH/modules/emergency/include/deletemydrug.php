<?php

include_once 'config.php';

$con = mysql_connect(HOST, USERNAME, PASSWORD);

mysql_select_db(DB, $con);

$drugid=$_POST['seid'];

$qry= "DELETE FROM Doctor_Drug WHERE DDID=$drugid";

$result=mysql_query($qry);

echo json_encode($result);

?>
