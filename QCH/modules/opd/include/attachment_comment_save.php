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
	include_once 'class/MDSAttachmentComment.php';
	
	include_once 'class/MDSUser.php';
	
	if (($_POST["ATTID"] > 0 )&&($_POST["UID"] > 0 )){
		$attachment = new MDSAttachmentComment();
		$staff = new MDSUser();
		$staff->openId($_POST["UID"]);
		$attachment->setValue("Comment",$_POST["comment"]);
		$attachment->setValue("Comment_By",$_POST["UID"]);
		$attachment->setValue("Comment_Date",date('Y-m-d'));
		$attachment->setValue("ATTCHID",$_POST["ATTID"]);
		$attachment->setValue("Active",1);
		$ncomment = "[".date('Y-m-d ')."] ".$staff->getFullName().":".$_POST["comment"];
		$id =$attachment->save('rId');
		echo "<div class='comment' id='".$id."'>".$ncomment."</div>";	
	}
	
	
	
  ?>