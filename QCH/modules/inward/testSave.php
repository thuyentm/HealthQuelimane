<?php

include_once 'include/config.php';

$con = mysql_connect(HOST, USERNAME, PASSWORD);

mysql_select_db(DB, $con);
	
// requires php5
 define('UPLOAD_DIR', 'patient_exam/');
$img = $_POST['seid'];
//$date=date("Y-m-d h:i:s");
$pid=$_POST['seid1'];
//$date=$_POST['seid2'];

//$res = $pid . "_" . $date;
//$res=$patexamid;

$res1="SELECT PATEXAMID FROM patient_exam WHERE PID=$pid ORDER BY LastUpDate DESC LIMIT 1";
$result1 = mysql_query($res1);
//print $success ? $file : 'Unable to save the file.';

while ($row= mysql_fetch_assoc($result1)){ 
$patexamid=$row['PATEXAMID'];
}
 $img = str_replace('data:image/png;base64,', '', $img);
 $img = str_replace(' ', '+', $img);
 $data = base64_decode($img);
 if(isset($patexamid)){
 $file = UPLOAD_DIR . $patexamid . '.png';
 $success = file_put_contents($file, $data); 
 }
 
 $sql="UPDATE patient_exam SET exam_sketch='patient_exam/$patexamid.png' WHERE PATEXAMID=$patexamid";
 //$sql="UPDATE patient_exam SET exam_sketch='patient_exam/$res.png' WHERE PID=$pid AND LastUpDate='$date'";
 $result = mysql_query($sql);
//print $success ? $file : 'Unable to save the file.';

echo json_encode($result);

	

?>