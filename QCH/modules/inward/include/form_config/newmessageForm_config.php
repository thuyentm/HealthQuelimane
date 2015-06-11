<?php
  			
//new message
$newmessageForm = array();
$newmessageForm["OBJID"] = "message_id";
$newmessageForm["TABLE"] = "messages";
$messageForm["LIST"] = array( 'message_id','To', 'Subject','Message');
$messageForm["DISPLAY_LIST"] = array( 'ID','Name', 'Status','Remarks','Active');
$newmessageForm["AUDIT_INFO"] = true;
$messageForm["NEXT"]  = "home.php?page=newmessage";	

$continue = array("Id"=>"Continue","Name"=>"","Type"=>"hidden","Value"=>"home.php?page=message","Help"=>"","Ops"=>"");

$date=date("Y-m-d H:i:s");


$newmessageForm["FLD"][0]=array(
                                    "Id"=>"to_user",    "Name"=>"To",  "Type"=>"to_user",
                                    "Value"=>"",   "Help"=>"Receipient of the Message",  "Ops"=>"",
                                    "valid"=>"*"
                                    ); 
								
$newmessageForm["FLD"][1]=array(
                                    "Id"=>"subject", "Name"=>"Subject",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Subject of the Message", "Ops"=>"",
                                    "valid"=>"*"
                                    );
								
$newmessageForm["FLD"][2]=array(
                                    "Id"=>"message", "Name"=>"Message",    "Type"=>"remarks",
                                    "Value"=>"",     "Help"=>"Message",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
								
$newmessageForm["FLD"][3]=array(
								"Id"=>"fileToUpload","Name"=>"File to attach","Type"=>"file",
                               "Value"=>"","Help"=>"Select the file to be attached","Ops"=>"",
							   "valid"=>"");
	
$newmessageForm["FLD"][4]=array(
									"Id"=>"Attach_Type", "Name"=>"Attachment type","Type"=>"select",
									"Value"=>array("PDF","Scan Image","ECG","X-Ray","Document","Other"), "Help"=>"Attachment type","Ops"=>" ",
									"valid"=>"");							
          
$newmessageForm["FLD"][5]=array(
                                    "Id"=>"from_user",     "Name"=>"uid",    "Type"=>"hidden",     "Value"=>$_SESSION["UID"],
                                    "Help"=>"", "Ops"=>""
                                    );  
$newmessageForm["FLD"][6]=array(
                                    "Id"=>"deleted",     "Name"=>"del",    "Type"=>"hidden",     "Value"=>"No",
                                    "Help"=>"", "Ops"=>""
                                    );
$newmessageForm["FLD"][7]=array(
                                    "Id"=>"sent_deleted",     "Name"=>"sent_del",    "Type"=>"hidden",     "Value"=>"No",
                                    "Help"=>"", "Ops"=>""
                                    );
$newmessageForm["FLD"][8]=array(
                                    "Id"=>"Seen",     "Name"=>"read",    "Type"=>"hidden",     "Value"=>"No",
                                    "Help"=>"", "Ops"=>""
                                    );							
$newmessageForm["FLD"][9]=array(
                                    "Id"=>"message_date",     "Name"=>"date",    "Type"=>"hidden",     "Value"=>$date,
                                    "Help"=>"", "Ops"=>""
                                    );

								
  
$newmessageForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Send",   "Type"=>"button", "Value"=>"Send",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"SendMessage()"
                                    
                                    );                                            
/*     $patient_alergyForm["BTN"][1]=array(
                                   "Id"=>"ClearBtn",    "Name"=>"Clear", "Type"=>"button",  "Value"=>"Clear", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"clearForm()",
                                   "Next"=>""
                                    );  
*/									
     $newmessageForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////ICD FORM END		
?>