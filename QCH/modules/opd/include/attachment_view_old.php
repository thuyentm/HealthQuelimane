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
	include_once 'class/MDSAttachment.php';
	include_once 'class/MDSPatient.php';
	$hash = $_GET["hash"];
	echo $hash;
	$att_file = new MDSAttachment();
/* 	if ($att_file->openFile($hash) != -1){
		//echo $att_file->getValue("Attach_Link");
		$patient = new MDSPatient();
		$patient->openId($att_file->getValue("PID"));
		
}
	else {
		echo "File Not found";
		exit; 
	} */
  ?>
  

   <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	  <script type="text/javascript" src="../js/jquery-1.4.2.js"></script>
     <title>Attachment</title>
	</head>	
  <body style='background:#aaaaaa;'>
  <table border=1 bordercolor='#000000' width=100% height=90% style='background:#555555;font-family:Arial;color:#F1F2F2;'>
  <tr><td colspan=2 id='file' style='font-size:14;'><b>HHIMS Attachment<b></td></tr>
  <tr><td width=70% height=100% id='info'><iframe width=100% height=100% src="../attach/<?php echo $att_file->getValue("Attach_Link"); ?>">
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
	  <tr><td width=25% valign=top>FileName : </td><td><?php echo $att_file->getValue("Attach_Name"); ?> </td></tr>
	  <tr><td valign=top>Date : </td><td><?php echo $att_file->getValue("CreateDate"); ?> </td></tr>
	  <tr><td valign=top>Type : </td><td><?php echo $att_file->getValue("Attach_Type"); ?> </td></tr>
	  <tr><td valign=top>Remarks : </td><td><?php echo $att_file->getValue("Attach_Description"); ?> </td></tr>
	  <tr><td valign=top colspan=2><hr></td></tr>
	  <tr><td valign=top colspan=2 style='background:#f1f1f1;color:#000000;'>Comments:
	  <div id='other_comments'>
	  <?php echo $att_file->getComments(); ?>
	  </div>
	  <tr><td valign=top colspan=2>Your Comments:<br>
	  <textarea style='width:350;height:100;' id='comment'> </textarea>
	  <input type='button' value='Add' onclick=addComment('<?php echo $_SESSION["UID"]; ?>','<?php echo $att_file->getValue("ATTCHID"); ?>')>
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
  