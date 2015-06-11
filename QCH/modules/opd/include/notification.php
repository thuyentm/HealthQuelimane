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


include_once 'class/MDSNotification.php';
include_once 'class/MDSLeftMenu.php';
include_once 'class/MDSTable.php';
include_once 'class/MDSPager.php';
function loadNotificationList(){
        $out ="";
        $header = loadHeader("Notification List");
        $l_menu = new MDSLeftMenu();
        $out .=$l_menu->renderLeftMenu("notification",null); 
        
        //$table = new MDSTable();
        //$table->tr_click_page ="notification";
        //$table->tr_click_action ="View";
        //$out .= $table->loadTable('notification_entry');
        //return $header.$out;
    
        $pager2 = new MDSPager("select NOTIFICATION_ID,Episode_Type,Disease,LabConfirm,Confirmed,CreateDate,Status from notification where Active = 1");
        $pager2->setDivId('prefCont'); //important
        $pager2->setDivClass('');
//        $pager2->setDivStyle('position:absolute');
        $pager2->setRowid('NOTIFICATION_ID'); 
//        $pager2->setHeight(400); 
        $pager2->setCaption("Notification List"); 
        //$pager->setSortname("CreateDate");
        $pager2->setColNames(array("ID","Department","Disease","Lab confirmed","Confirmed","Date","Status"));
        $pager2->setColOption("NOTIFICATION_ID", array("search"=>false));
        $pager2->setColOption("Episode_Type", array("stype" => "select", "searchoptions" => array("value" => ":All;Admission:Admission;OPD:OPD")));
        $pager2->setColOption("LabConfirm",  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
        $pager2->setColOption("Confirmed", array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
        $pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Sent:Sent","defaultValue"=>"Pending")));
        $pager2->setColOption("CreateDate", $pager2->getDateSelector());
//        $pager2->setColOption("CreateDate", array("stype" => "text", "searchoptions" => array("dataInit_JS" => "datePicker_REFID","defaultValue"=>"")));
        
        $pager2->gridComplete_JS = "function() {
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                $(this).css({'cursor':'pointer'});
            }).mouseout(function(e){
            }).click(function(e){
                var rowId = $(this).attr('id');
                window.location='home.php?page=notification&mod=&action=View&NOTIFICATION_ID='+rowId;
            });
            }";
        $pager2->setOrientation_EL("L");
        return $pager2->render();
//        return htmlentities($pager2->render(false));
}



function viewNotification($nid){
        $out ="";
        $header = loadHeader("Notification");
        if ($nid == "")
             return "Notification not found!!";   
        $notification = new MDSNotification();
        $notification->openId($nid);
        $notification_info = $notification->display();
        return $header . $notification_info."<div align=center >".$_GET["error"]."</div>";
}

function sendNotification($nid){
        $out ="";
        $status = 0;
        if ($nid == "")
             return "Notification not found!!";   
        $notification = new MDSNotification();
        $notification->openId($nid);
        $status = $notification->sendMail();
        if ( $status == 1 ){
            $notification->setValue('Status','Sent');
            $notification->save();
            echo "<div align=center class='info'> Notification Sent. <a href='home.php?page=notification'>Continue<a></div>";
            
            //header("location:home.php?page=notification");
        }
        else{
            echo "<div align=center  class='info'> Notification NOT Sent.<br>".$status."<br> <a href='home.php?page=notification&NOTIFICATION_ID=".$nid."&action=View'>Continue<a></div>";
            //header("location:home.php?page=notification&NOTIFICATION_ID=".$nid."&action=View&error=".$status."");
        }
        
}
function loadNotificationScreen($nid=""){
	include 'form_config/notification_entryForm_config.php';
	include_once 'class/MDSForm.php';
	$pid = $admid = $out = $frm = "";
        if (nid == ""){
            $episodeid = $_GET["EPISODEID"];
            if ($episodeid == "") { echo "Admission not found!"; return NULL; };
            if ($_GET["TYPE"] == "admission") {
                    include_once 'class/MDSAdmission.php';
                    $admission = new MDSAdmission();
                    $admission->openId($episodeid);
                    $patient = $admission->getAdmitPatient();
            }
            else {
                    return null;
            }
            $out .= $patient->patientBannerTiny();
        }
	$form = new MDSForm();
    
    $out .= addErrorDiv();
    $out .= loadHeader("Notification");
	
    $form->FrmName = "notification_entryForm";
    $frm = $form->render($notification_entryForm);	
	echo $out.$frm;

}
function addErrorDiv(){
		return "<div id='MDSError' class='mdserror'></div>";
}
?>
