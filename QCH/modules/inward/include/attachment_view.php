<?php

session_start();
if (!session_is_registered(username)) {
	if ($_SERVER['HTTPS'] == 'on') {
		$port = "https://";
	}
	else{
		$port = "http://";
	}
	$loc =  urlencode ( $port.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']) ;
	header('Location:../login.php?continue='.$loc);
}
	
	
	//include 'class/MDSAttachment.php';
	$hash = $_GET["hash"];
	//echo $hash;
	
	include_once 'config.php';

	$con = mysql_connect(HOST, USERNAME, PASSWORD);

		mysql_select_db(DB, $con);
		                
		$sql=" SELECT * FROM attachment WHERE (Attach_Hash = '".$hash."') ";
		$result1 = mysql_query($sql);
				
		while ($row= mysql_fetch_assoc($result1)){
			
			$att_id=$row['ATTCHID'];
			$pid=$row['PID'];
			$link=$row['Attach_Link'];
			$att_name=$row['Attach_Name'];
			$create_date=$row['CreateDate'];
			$att_type=$row['Attach_Type'];
			$att_description=$row['Attach_Description'];
			
			
			}
		
		
		//include_once 'class/MDSUser.php';
		$sql2="SELECT * FROM attachment_comment where ( ATTCHID ='".$att_id."')"; 
		$result2 = mysql_query($sql2); 
		$count = mysql_num_rows($result2);
		//if ($count2 == 0) return NULL;
		
		if ($count >0){
		//$out = "";
		while($row2 = mysql_fetch_assoc($result2))  {
		// $staff = new MDSUser();
		//$staff->openId($row["Comment_By"]);
			$out .= "<div class='comment' id='".$row2["ATTCH_COM_ID"]."'>[".substr($row2["Comment_Date"],0,10)."] " .$row2["CreateUser"].":".$row2["Comment"]."</div>"; 
		}
		//return $out;
	}
		else{
		$out='';
		
		}
	
	//$att_file = new MDSAttachment();
  	//if (openFile($hash) != -1){
		//echo $att_file->getValue("Attach_Link");
	    include_once 'class/MDSPatient.php';
		$patient = new MDSPatient();
		$patient->openId($pid);
		
//}
	//else {
		//echo "File Not found";
	//	exit; 
	//}  
  ?>
  

   <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	  <script type="text/javascript" src="../js/jquery-1.4.2.js"></script>
     <title>Attachment</title>
	</head>	
  <body style='background:#aaaaaa;'>
  <table border=1 bordercolor='#000000' width=100% height=90% style='background:#555555;font-family:Arial;color:#F1F2F2;'>
  <tr><td colspan=2 id='file' style='font-size:14;'><b>HHIMS Attachment<b></td></tr>
  <tr><td width=70% height=100% id='info'><iframe width=100% height=100% src="../attach/<?php echo $link; ?>">
  <img />
  </iframe>
  </td>
  <td valign='top'>
	  <table width=100% border=0 cellspacing=1 cellpadding=2 style='background:#555555;font-family:Arial;color:#F1F2F2;font-size:12px;'>
	  <tr><td width=25% valign=top>Patient : </td><td><?php echo $patient->getFullName(); ?> </td></tr>
	  <tr><td width=25% valign=top>Patient ID : </td><td><?php echo $patient->getId(); ?> </td></tr>
	  <tr><td valign=top>Sex : </td><td><?php echo $patient->getGender(); ?> </td></tr>
	  <tr><td valign=top>Age : </td><td><?php echo $patient->getAge('y'); ?> </td></tr>
	  <tr><td valign=top>Address : </td><td><?php echo $patient->getAddress(); ?> </td></tr>
	  <tr><td valign=top colspan=2><hr></td></tr>
	  <tr><td width=25% valign=top>FileName : </td><td><?php echo $att_name; ?> </td></tr>
	  <tr><td valign=top>Date : </td><td><?php echo $create_date; ?> </td></tr>
	  <tr><td valign=top>Type : </td><td><?php echo $att_type; ?> </td></tr>
	  <tr><td valign=top>Remarks : </td><td><?php echo $att_description; ?> </td></tr>
	  <tr><td valign=top colspan=2><hr></td></tr>
	  <tr><td valign=top colspan=2 style='background:#f1f1f1;color:#000000;'>Comments:
	  <div id='other_comments'>
	  <?php echo $out; ?>
	  </div>
	  <tr><td valign=top colspan=2>Your Comments:<br>
	  <textarea style='width:350;height:100;' id='comment'> </textarea>
	  <input type='button' value='Add' onclick=addComment('<?php echo $_SESSION["UID"]; ?>','<?php echo $att_id; ?>')>
	  </td></tr>
	  </table>
	</td></tr>
  </table>
  <script language="javascript">
function addComment(uid,attid){
		var reg = /[\<\>\.\'\"\:\;\|\{\}\[\]\,\=\+\-\_\!\~\`\(\)\$\#\@\^\&\,\d\\/\\?]/;
		var comment = $("#comment").val().replace(reg,'');
		var result = $.ajax({
			url : "attachment_comment_save.php",
			data:{"UID":uid,"comment":comment,"ATTID":attid},
			global : false,
			type : "POST",
			async : false
		}).responseText;
		if (result!=""){
			$("#other_comments").append(result);
			$("#comment").val("");
		}
}
	
  </script>
  </body>
  </html>
  