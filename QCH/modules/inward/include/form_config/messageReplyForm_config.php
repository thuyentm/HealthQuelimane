<?php
  			
//new message

include_once 'MDSDatabase.php';

$result1 = NULL;
$mdsDB1 = MDSDataBase::GetInstance();
$mdsDB1->connect();
$msgid=$_GET['MESSAGEID'];
$sql1 = "SELECT from_user,subject FROM messages WHERE message_id = '".$msgid."'";
$result1=$mdsDB1->mysqlQuery($sql1);
		
$messageReplyForm = array();
$messageReplyForm["OBJID"] = "message_id";
$messageReplyForm["TABLE"] = "messages";
$messageReplyForm["LIST"] = array( 'message_id','To', 'Subject','Message');
$messageReplyForm["DISPLAY_LIST"] = array( 'ID','Name', 'Status','Remarks','Active');
$messageReplyForm["AUDIT_INFO"] = true;
$messageReplyForm["NEXT"]  = "home.php?page=newmessage";	

$date=date("Y-m-d h:i:s");

$row = mysql_fetch_row($result1);

	
$messageReplyForm["FLD"][0]=array(
                                    "Id"=>"to_user",    "Name"=>"From",  "Type"=>"hidden",
                                    "Value"=>$row[0],   "Help"=>"",  "Ops"=>"",
                                    "valid"=>""
                                    ); 
								
$messageReplyForm["FLD"][1]=array(
                                    "Id"=>"subject", "Name"=>"Subject",
                                    "Type"=>"hidden",  "Value"=>$row[1],
                                    "Help"=>"", "Ops"=>"",
                                    "valid"=>""
                                    );
								
							
								
$messageReplyForm["FLD"][2]=array(
                                    "Id"=>"message", "Name"=>"Reply",    "Type"=>"remarks",
                                    "Value"=>"",     "Help"=>"Your Reply",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$messageReplyForm["FLD"][3]=array(
								"Id"=>"fileToUpload","Name"=>"File to attach","Type"=>"file",
                               "Value"=>"","Help"=>"Select the file to be attached","Ops"=>"",
							   "valid"=>"");
	
$messageReplyForm["FLD"][4]=array(
									"Id"=>"Attach_Type", "Name"=>"Attachment type","Type"=>"select",
									"Value"=>array("PDF","Scan Image","ECG","X-Ray","Document","Other"), "Help"=>"Attachment type","Ops"=>" ",
									"valid"=>"");								
          
$messageReplyForm["FLD"][5]=array(
                                    "Id"=>"from_user",     "Name"=>"uid",    "Type"=>"hidden",     "Value"=>$_SESSION["UID"],
                                    "Help"=>"", "Ops"=>""
                                    );  
$messageReplyForm["FLD"][6]=array(
                                    "Id"=>"deleted",     "Name"=>"del",    "Type"=>"hidden",     "Value"=>"No",
                                    "Help"=>"", "Ops"=>""
                                    );
$messageReplyForm["FLD"][7]=array(
                                    "Id"=>"sent_deleted",     "Name"=>"sent_del",    "Type"=>"hidden",     "Value"=>"No",
                                    "Help"=>"", "Ops"=>""
                                    );	
$messageReplyForm["FLD"][8]=array(
                                    "Id"=>"Seen",     "Name"=>"read",    "Type"=>"hidden",     "Value"=>"No",
                                    "Help"=>"", "Ops"=>""
                                    );								
$messageReplyForm["FLD"][9]=array(
                                    "Id"=>"message_date",     "Name"=>"date",    "Type"=>"hidden",     "Value"=>$date,
                                    "Help"=>"", "Ops"=>""
                                    );							
								
  
$messageReplyForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Send",   "Type"=>"button", "Value"=>"Send",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"SendMessage()"
                                    
                                    );                                            
/*     $patient_alergyForm["BTN"][1]=array(
                                   "Id"=>"ClearBtn",    "Name"=>"Clear", "Type"=>"button",  "Value"=>"Clear", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"clearForm()",
                                   "Next"=>""
                                    );  
*/									
     $messageReplyForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"Back", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////ICD FORM END		
?>