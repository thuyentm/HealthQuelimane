<?php

include_once 'include/config.php';

$con = mysql_connect(HOST, USERNAME, PASSWORD);

mysql_select_db(DB, $con);
	
// requires php5
 define('UPLOAD_DIR', 'admission/');
$img = $_POST['seid'];
//$date=date("Y-m-d h:i:s");
$pid=$_POST['seid1'];
//$date=$_POST['seid2'];

//$res = $pid . "_" . $date;
//$res=$patexamid;

$res1="SELECT ADMID FROM admission WHERE PID=$pid ORDER BY LastUpDate DESC LIMIT 1";
$result1 = mysql_query($res1);
//print $success ? $file : 'Unable to save the file.';

while ($row= mysql_fetch_assoc($result1)){ 
$admid=$row['ADMID'];
}
 $img = str_replace('data:image/png;base64,', '', $img);
 $img = str_replace(' ', '+', $img);
 $data = base64_decode($img);
 if(isset($admid)){
 $file = UPLOAD_DIR . $admid . '.png';
 $success = file_put_contents($file, $data); 
 }
 
 $sql="UPDATE admission SET exam_sketch='admission/$admid.png' WHERE ADMID=$admid";
 //$sql="UPDATE patient_exam SET exam_sketch='patient_exam/$res.png' WHERE PID=$pid AND LastUpDate='$date'";
 $result = mysql_query($sql);
//print $success ? $file : 'Unable to save the file.';

echo json_encode($result);

	

?>