<?php

session_start();
include_once 'include/config.php';
$con = mysql_connect(HOST, USERNAME, PASSWORD);
mysql_select_db(DB, $con);

$date=date("Y-m-d");
$uid=$_SESSION['UID'];
//$res="SELECT PID FROM opd_presciption WHERE (CreateDate LIKE '$date%') AND (Status='ready') ORDER BY LastUpDate DESC LIMIT 1";
$res="SELECT opd_presciption.PID AS id,patient.Full_Name_Registered AS Name FROM opd_presciption,patient WHERE (opd_presciption.PID=patient.PID) AND (opd_presciption.CreateDate LIKE '$date%') AND (opd_presciption.Status='Ready') AND (opd_presciption.LastUpDateUID=$uid) ORDER BY opd_presciption.LastUpDate DESC LIMIT 1";
$result = mysql_query($res);

if(mysql_num_rows($result)==1){ 

while($row = mysql_fetch_array($result)) { 	
?> 
<div id="waiting">
<table >


<tr ><td id="wbase2" class="qtext" ><?php echo $row['Name'];?></td><td id="wbase1" class="texts" height="768" ><?php echo $row['id'];?></td></tr>


</table>  
 </div>   
	
	<?php } 
	} else {?>
	
<div id="waiting">
<p class="blocktext" style="font-family:arial;color:red;font-size:180px;" align="center">කරුණාකර  ඔබගේ වාරය එනතෙක්  රැඳී සිටින්න. </p> 

</div>



<?php 
}
?>
<div id="screen_footer" >
 
<img src="images/footer.jpg" width="99.9%">
</div>