header("Content-Type: application/json");

<?php
/*
--------------------------------------------------------------------------------
HHIMS - Hospital Health Information Management System
Copyright (c) 2011 Information and Communication Technology Agency of Sri Lanka
<http: www.hhims.org/>
----------------------------------------------------------------------------------
This program is free software: you can redistribute it and/or modify it under the
terms of the GNU Affero General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR 
A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along 
with this program. If not, see <http://www.gnu.org/licenses/> or write to:
Free Software  HHIMS
C/- Lunar Technologies (PVT) Ltd,
15B Fullerton Estate II,
Gamagoda, Kalutara, Sri Lanka
---------------------------------------------------------------------------------- 
Author: Mr. Thurairajasingam Senthilruban   TSRuban[AT]mdsfoss.org
Consultant: Dr. Denham Pole                 DrPole[AT]gmail.com
URL: http: www.hhims.org
----------------------------------------------------------------------------------
*/
	include_once 'class/MDSAttachment.php';
	include_once 'class/MDSUpload.php';
	include_once 'class/MDSPatient.php';
	include_once 'class/MDSDataBase.php';
	
	$upfile = new MDSUpload();
	$upfile->upload_type = $_POST["Attach_Type"];
	$error  = "";
	$msg  = "";
	$file_name = "";
	$fileElementName = 'fileToUpload';

	if(!empty($_FILES[$fileElementName]['error'])){
		switch($_FILES[$fileElementName]['error']){
			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;
			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
	}elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none'){
		$error = 'No file was uploaded..';
	}
	elseif (!$upfile->isFileTypeAllowed($_FILES['fileToUpload']['name'])){
		$error = 'File type not allowed';
	}
	
	else {
			$upfile->upload_to = "message";
			$from=$_POST["From_User"];
			$to=$_POST["To_User"];
			
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		
		$sql="SELECT message_id FROM messages WHERE from_user=$from AND to_user=$to ORDER BY message_date DESC LIMIT 1";
		
		$result=$mdsDB->mysqlQuery($sql); 
		
		while($row = $mdsDB->mysqlFetchArray($result))  {
		
			$msgid=$row['message_id'];
		
		}
			
			if ($upfile->createMsgFolder($from,$to)==-1){
				$error .= " Error Directory";
			}
			else{
			
				$file_url = "../attach/base_hospital_avissawella/message/".$from."_".$to."/".$msgid."_".$_FILES['fileToUpload']['name'];
				if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file_url)){
					$file_name = $_FILES['fileToUpload']['name'];
					$link=substr($file_url,3);
					
					$sql2="UPDATE messages SET Attach_Url='$link',fileName='$file_name' WHERE message_id='$msgid'";
					
					$result2=$mdsDB->mysqlQuery($sql2);
					
					
				}
				else{
					if(!file_exists($file_name)) {
						$error .= " : Folder doesn't exist.";
					} elseif(!is_writable($file_name)) {
						$error .= " : Folder not writable.";
					} 
					else {
						$error .= " : ERROR";
					}
				}
			}
	}		
	$data=array('error' => $error, 'msg' => $msg);
	echo $data; 
	exit;

	
  ?>