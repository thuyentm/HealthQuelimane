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
include_once 'class/MDSPager.php';

function loadMessageMenu() {

	include_once 'MDSDatabase.php';
	include_once 'class/MDSUser.php';
	$user = new MDSUser();
	$user->openId($_SESSION["UID"]);

	$result1 = NULL;
	$mdsDB1 = MDSDataBase::GetInstance();
	$mdsDB1->connect();
	$sql1 = "SELECT * FROM messages WHERE to_user = '".$user->getId()."' AND Seen='No'";
	$result1=$mdsDB1->mysqlQuery($sql1);
    $inbox=mysql_num_rows($result1);
	
	$sql2 = "SELECT * FROM messages WHERE from_user = '".$user->getId()."'";
	$result2=$mdsDB1->mysqlQuery($sql2);
    $outbox=mysql_num_rows($result2);
	
    $menu = "";
    $menu .="<div id='left-sidebar'>\n";
    $menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
    $menu .="<a>Messages</a>\n";
    $menu .="<div> \n";
    $menu .="<input type='button' class='submenuBtn' value='Compose Message'  onclick=self.document.location='home.php?page=newmessage'>\n";
    $menu .="<input type='button' class='submenuBtn' value='Inbox ($inbox)'  onclick=self.document.location='home.php?page=message'>\n";
    $menu .="<input type='button' class='submenuBtn' value='Outbox ($outbox)' onclick=self.document.location='home.php?page=outbox' >\n";
    $menu .="</div> \n";

    $menu .=" </div> \n";
    $menu .="</div> \n";
    $menu .="<script language='javascript'>\n";
    $menu .="$('#list1a').accordion();\n";
    $menu .="</script>\n";

    echo $menu;
}

function loadInboxTable() {
    $tbl = "";
	
	include_once 'class/MDSUser.php';
	$user = new MDSUser();
	$user->openId($_SESSION["UID"]);

  /*  $qry = " SELECT  
           lab_order.LAB_ORDER_ID, 
           patient.PID, 
           concat(patient.Personal_Title, ' ',patient.Full_Name_Registered), 
           lab_order.OrderDate, 
           lab_order.OBJID 
           FROM lab_order, patient 
           WHERE ( lab_order.PID = patient.PID ) AND (lab_order.Dept = 'OPD') "; */
	   
	$qry = " SELECT  
           messages.message_id, 
           user.FirstName, 
           messages.subject, 
           messages.message,
		   messages.message_date,
		   messages.Seen
           FROM messages, user 
           WHERE ( messages.to_user = '".$user->getId()."' ) AND (user.UID = messages.from_user) ";   

    $pager2 = new MDSPager($qry);
    $pager2->setDivId('prefCont'); //important
    $pager2->setDivClass('');
//        $pager2->setDivStyle('position:absolute');
    $pager2->setRowid('message_id');
    $pager2->setHeight(400);
    $pager2->setCaption("My Message Inbox");
    //$pager->setSortname("OrderDate");
    //$pager2->setColOption("OBJID", array("search" => true, "hidden" => true));
$pager2->setColOption("message_id",array("search"=>false,"hidden" => true,"width"=>50));
$pager2->setColOption("FirstName",array("search"=>true,"hidden" => false,"width"=>100));
$pager2->setColNames(array("MessageID", "From","Subject","Messsage", "Date","Read"));
    //$pager2->setColOption("OrderDate", array("stype" => "text", "searchoptions" => array("dataInit_JS" => "datePicker_REFID","defaultValue"=>date("Y-m-d"))));
$pager2->setColOption("message_date", $pager2->getDateSelector());
    //$pager2->setColOption("Collection_Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Done:Done", "Default" => "Done")));
    //$pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Done:Done", "Default" => "Pending")));
	//$pager2->setColOption("Priority", array("stype" => "select", "searchoptions" => array("value" => ":All;Urgent:Urgent;Normal:Normal", "Default" => "All")));
    // $pager2->setColOption("Dept", array("stype" => "select", "searchoptions" => array("value" => ":All;OPD:OPD;ADM:InPatient","Default"=>"OPD")));


    $pager2->gridComplete_JS = "function(){
            var c =null;
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                c = $(this).css('background');
                $(this).css({'background':'yellow','cursor':'pointer'});
            }).mouseout(function(e){
                $(this).css('background',c);
            }).click(function(e){
                var rowId = $(this).attr('id');
                window.location='home.php?page=MessageView&action=Reply&MESSAGEID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=message')+'';;
            });
            }";
    return $pager2->render();
}

function loadOutboxTable() {
    $tbl = "";
	
	include_once 'class/MDSUser.php';
	$user = new MDSUser();
	$user->openId($_SESSION["UID"]);

  /*  $qry = " SELECT  
           lab_order.LAB_ORDER_ID, 
           patient.PID, 
           concat(patient.Personal_Title, ' ',patient.Full_Name_Registered), 
           lab_order.OrderDate, 
           lab_order.OBJID 
           FROM lab_order, patient 
           WHERE ( lab_order.PID = patient.PID ) AND (lab_order.Dept = 'OPD') "; */
	   
	$qry = " SELECT  
           messages.message_id, 
           user.FirstName, 
           messages.subject, 
           messages.message,
		   messages.message_date
           FROM messages, user 
           WHERE ( messages.from_user = '".$user->getId()."' ) AND (user.UID = messages.to_user) ";   

    $pager2 = new MDSPager($qry);
    $pager2->setDivId('prefCont'); //important
    $pager2->setDivClass('');
//        $pager2->setDivStyle('position:absolute');
    $pager2->setRowid('message_id');
    $pager2->setHeight(400);
    $pager2->setCaption("My Message Outbox");
    //$pager->setSortname("OrderDate");
    //$pager2->setColOption("OBJID", array("search" => true, "hidden" => true));
$pager2->setColOption("message_id",array("search"=>false,"hidden" => false,"width"=>50));
$pager2->setColOption("FirstName",array("search"=>true,"hidden" => false,"width"=>100));
$pager2->setColNames(array("MessageID", "To","Subject","Messsage", "Date"));
    //$pager2->setColOption("OrderDate", array("stype" => "text", "searchoptions" => array("dataInit_JS" => "datePicker_REFID","defaultValue"=>date("Y-m-d"))));
$pager2->setColOption("message_date", $pager2->getDateSelector());
    //$pager2->setColOption("Collection_Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Done:Done", "Default" => "Done")));
    //$pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Done:Done", "Default" => "Pending")));
	//$pager2->setColOption("Priority", array("stype" => "select", "searchoptions" => array("value" => ":All;Urgent:Urgent;Normal:Normal", "Default" => "All")));
    // $pager2->setColOption("Dept", array("stype" => "select", "searchoptions" => array("value" => ":All;OPD:OPD;ADM:InPatient","Default"=>"OPD")));


    $pager2->gridComplete_JS = "function() {
            var c =null;
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                c = $(this).css('background');
                $(this).css({'background':'yellow','cursor':'pointer'});
            }).mouseout(function(e){
                $(this).css('background',c);
            }).click(function(e){
                var rowId = $(this).attr('id');
                window.location='home.php?page=MessageView&action=View&MESSAGEID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=message')+'';;
            });
            }";
    return $pager2->render();
}

function loadNew() {
    $out = $Btns = $jq = "";
    $pharCont = "";
   // $head.=loadHeader("Messages");
    $lbar = "" . loadMessageMenu() . "";
    //$pharCont = loadInboxTable();

    $out =$lbar;
    echo $out;
}

function loadInbox() {
    $out = $Btns = $jq = "";
    $pharCont = "";
    $head.=loadHeader("Messages");
    $lbar = "" . loadMessageMenu() . "";
    $pharCont = loadInboxTable();

    $out = $head . $lbar . $pharCont;
    echo $out;
}

function loadOutbox() {
	
$out = $Btns = $jq = "";
    $pharCont = "";
    $head.=loadHeader("Messages");
    $lbar = "" . loadMessageMenu() . "";
    $pharCont = loadOutboxTable();

    $out = $head . $lbar . $pharCont;
    echo $out;
	
}


function renderFormEdit($msgid){
	
		include_once 'MDSDatabase.php';
		$result1 = NULL;
		$mdsDB1 = MDSDataBase::GetInstance();
		$mdsDB1->connect();		
		$sql1 = "SELECT user.FirstName,user.OtherName,messages.from_user,messages.to_user,messages.subject,messages.message,messages.fileName,messages.Attach_Url FROM messages LEFT JOIN user ON user.UID=messages.from_user WHERE message_id = '".$msgid."'";
		$result1=$mdsDB1->mysqlQuery($sql1);
		
		$out = "";
		$out .= "<div id='formCont' class='formCont' style='left:5px;' >\n";
		$out .= "<div class='prescriptionHead' style='font-size:23px;'>".getPrompt("Message")."</div>";
		$out .= "<div class='prescriptionInfo'>\n";
		$out .= "<table border=0 width=100% class='PrescriptionInfo'>\n";
		$out .= "<tr>";
		while($row1 = $mdsDB1->mysqlFetchArray($result1))  {
		$out .= "<td>".getPrompt("From").": </td><td>".$row1["FirstName"]." ".$row1["OtherName"]."</td>"; 
		
		$out .= "</tr>";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Subject").": </td><td >".$row1["subject"]."</td>"; 
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Message").": </td><td>".$row1["message"]."</td>";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Attachment").": </td><td><a href=".$row1["Attach_Url"]." target='_blank' >".$row1["fileName"]."</td>"; 
		
		}
		$out .= "</tr>";
		
		$out .= "</table>\n";
		$out .= "</div>\n ";	
		return $out;
	}

?>