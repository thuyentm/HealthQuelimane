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

include 'config.php';


function getDefaultQuantity($Dosage,$Frquency,$HowLong){
	include "config_drug.php";
	$dosage =  getDosage($Dosage);
	$frequency = getFrequency($Frquency);
        if ($_SESSION["DISPENSE_DRUG_COUNT"] ==0) return "";
        if (
                ($dosage)
                &&($frequency)
                &&($howlong["VALUE"][$HowLong]))
        {
            return ceil($dosage*$frequency*$howlong["VALUE"][$HowLong]);
        }
        else {
            return "";
        }
}
function getDosage($dosage){
    mysql_connect(HOST, USERNAME, PASSWORD) or die("cannot connect"); 
    mysql_select_db(DB) or die("cannot select DB");
	$sql="SELECT Factor from drugs_dosage where (Active =1) AND (Dosage = '".$dosage."')";
	$result = mysql_query($sql);
	$count=mysql_num_rows($result);
    if (!$result) return null;
	$i=0;	
	while($row = mysql_fetch_array($result))  {
		return $row[0];
	}
}
function getFrequency($frquency){                                                                             
    mysql_connect(HOST, USERNAME, PASSWORD) or die("cannot connect"); 
    mysql_select_db(DB) or die("cannot select DB");
	$sql="SELECT Factor from drugs_frequency where (Active =1) AND (Frequency = '".$frquency."')";
	$result = mysql_query($sql);
	$count=mysql_num_rows($result);
    if (!$result) return null;
	$i=0;	
	while($row = mysql_fetch_array($result))  {
		return $row[0];
	}
}
function getPrescriptionItemsForDispense($prsid,$stock=''){

    mysql_connect(HOST, USERNAME, PASSWORD) or die("cannot connect"); 
    mysql_select_db(DB) or die("cannot select DB");
	$sql="
	SELECT prescribe_items.PRS_ITEM_ID,
        drugs.Name,
        prescribe_items.Dosage,
        prescribe_items.Status,
        prescribe_items.LastUpDateUser,
        prescribe_items.LastUpDateUser,
        prescribe_items.HowLong,
        prescribe_items.Quantity,
        prescribe_items.Frequency, ";
        if ($stock == "ClinicStock"){
            $sql .= " drugs.ClinicStock  as Stock ";
        }
        else {
            $sql .= " drugs.Stock as Stock ";
        }
        $sql .= "FROM prescribe_items,drugs 
        where prescribe_items.Active = 1 AND (prescribe_items.DRGID = drugs.DRGID OR prescribe_items.PDRGID = drugs.DRGID) AND prescribe_items.PRES_ID = '".$prsid."' ";
	$result = mysql_query($sql);
	$count=mysql_num_rows($result);
    if (!$result) return null;
	$out = "";
	if ($count == 0) {
		return "<script language='javascript'>$(document).ready(function(){ $('#okBtn').hide();}) </script>";
	}
	$i=0;	
	while($row = mysql_fetch_array($result))  {
		$out .= "<tr><td>".++$i."</td>\n";
		$out .= "<td>".$row["Name"]."</td>\n";
		$out .= "<td>".$row["Dosage"]."</td>\n";
                $out .= "<td>".$row["Frequency"]."</td>\n";
		$out .= "<td>".$row["HowLong"]."</td>\n";
		$out .= "<td><input type='hidden' id='d".$row["PRS_ITEM_ID"]."' value='".$row["PRS_ITEM_ID"]."'><input id='v".$row["PRS_ITEM_ID"]."' class='input'  type='number' onkeyup=checkNumber(this); min=1 max=250 step=1 ";
		if ( $row["Quantity"] > 0) {
			$out .= " value='".$row["Quantity"]."' readonly=true ";
		}
		else {
		
			$out .= " value='".getDefaultQuantity($row["Dosage"],$row["Frequency"],$row["HowLong"])."' ";
		}
                
		$out .= " style='text-align:right;width:100px;font-weight:bold;' >";
                $out .= " in Stock(<b>".$row["Stock"]."</b>)";
		$out .= "<i>&nbsp;".$row["Status"];
                if ($row["Status"]=="Dispensed")
                    $out .= " By: ".$row["LastUpDateUser"];
                $out .= "<i></td><tr>";
        //<input type='button' value='Remove'  onclick=removeItem(".$PRS_ITEM_ID."); />
	}
	return $out;
}




function renderPrescriptionForm($frm,$fName,$type,$opd,$mode){

        include_once 'class/MDSPatient.php';
        include_once 'class/MDSPrescription.php';
        $out = "";
        $prsid = null;
        if ( !$opd ) 
                return null ;
        $pat = $opd->getOpdPatient();	
        if (!$pat) 
                return null ;		
        $prescription = new MDSPrescription($type,$opd->getId(),$pat->getId());
        if ( !$prescription ) 
                return null ;

        $out .= $prescription->renderForm($opd,$pat,$mode);
    
        $out .="<script language='javascript'>\n";
        $out .=" function drugContinue(drid) {\n";
            $out .=" alert(String(drid)); \n";
        $out .=" }\n";
        $out .=" function drugSelect(pdrid,drid,dosage,frequency,howlong) {\n";
		    
		    $out .=" $('#PDRGID option[value='+pdrid+']').attr('selected', true); \n";
            $out .=" $('#DRGID option[value='+drid+']').attr('selected', true); \n";
            $out .=" $('#Dosage option[value='+dosage+']').attr('selected', true); \n";
            $out .=" $('#Frequency option[value='+frequency+']').attr('selected', true); \n";
            $out .=" $('#HowLong option[value='+howlong+']').attr('selected', true); \n";
            
        $out .=" }\n";        
        $out .="function saveData() {\n";
            $data =  "data:({";
            for ($i = 0; $i < count($frm["FLD"]); ++$i) 
            { 
                if ($frm["FLD"][$i]["Id"]!="_") {
                     $data.= $frm["FLD"][$i]["Id"].":$('#".$frm["FLD"][$i]["Id"]."').val(),";   
                }

            }
			$data .= 'FORM:'.'"'.$fName.'"';

			if ($frm["AUDIT_INFO"] == true ) {	
				$data .= 'CreateUser:'."$('#CreateUser').val(),";   
				$data .= 'CreateDate:'."$('#CreateDate').val(),";   
				$data .= 'LastUpDateUser:'."$('#LastUpDateUser').val(),";   
				$data .= 'LastUpDate:'."$('#LastUpDate').val()";   
			}
            $data .=  "}),";

            $out .="  var resM = $.ajax({ \n";
                                       $out .="url: 'include/data_save.php?',\n";
                                       $out .="global: false,\n";
                                       $out .="type: 'POST',\n";
                                       $out .=$data."\n";
                                       $out .="async:false\n";
					$out .="}).responseText;\n";
    					$out .=" eval(resM); \n";
                                    $out .=" if ( !Error ) { \n";
									$out .=" self.document.location='".$frm["NEXT"]."".$opd->getId()."&action=Edit' ; \n ";
									$out .="} else { $('#MDSError').html(res); }\n";
        $out .="}\n"; //function saveData
        $out .="parent.window.onbeforeunload = confirmExit; \n";
        $out .="</script>\n"; 
	    return $out;
}
function renderADMPrescriptionForm($frm,$fName,$type,$opd,$mode){

        include_once 'class/MDSPatient.php';
        include_once 'class/MDSPrescription.php';
        $out = "";
        $prsid = null;
        if ( !$opd ) 
                return null ;
        $pat = $opd->getAdmitPatient();	
        if (!$pat) 
                return null ;		
        $prescription = new MDSPrescription($type,$opd->getId(),$pat->getId());
        if ( !$prescription ) 
                return null ;

        $out .= $prescription->renderADMForm($opd,$pat,$mode);
    
        $out .="<script language='javascript'>\n";
        $out .="function saveData() {\n";
            $data =  "data:({";
            for ($i = 0; $i < count($frm["FLD"]); ++$i) 
            { 
                if ($frm["FLD"][$i]["Id"]!="_") {
                     $data.= $frm["FLD"][$i]["Id"].":$('#".$frm["FLD"][$i]["Id"]."').val(),";   
                }

            }
			$data .= 'FORM:'.'"'.$fName.'"';

			if ($frm["AUDIT_INFO"] == true ) {	
				$data .= 'CreateUser:'."$('#CreateUser').val(),";   
				$data .= 'CreateDate:'."$('#CreateDate').val(),";   
				$data .= 'LastUpDateUser:'."$('#LastUpDateUser').val(),";   
				$data .= 'LastUpDate:'."$('#LastUpDate').val()";   
			}
            $data .=  "}),";

            $out .="  var resM = $.ajax({ \n";
                                       $out .="url: 'include/data_save.php?',\n";
                                       $out .="global: false,\n";
                                       $out .="type: 'POST',\n";
                                       $out .=$data."\n";
                                       $out .="async:false\n";
					$out .="}).responseText;\n";
    					$out .=" eval(resM); \n";
                                    $out .=" if ( !Error ) { \n";
									$out .=" window.location.reload() \n ";
									$out .="} else { $('#MDSError').html(res); }\n";
        $out .="}\n"; //function saveData
        $out .="parent.window.onbeforeunload = confirmExit; \n";
        $out .="</script>\n"; 
	    return $out;
}
function renderDispenseForm($prsid){
	include_once 'class/MDSPatient.php';
	include_once 'class/MDSPrescription.php';
	include_once 'class/MDSOpd.php';
	
	$out = "";
	if ( $prsid == "" ) 
		return null ;
	$prescription = new MDSPrescription();	
	$opd = new MDSOpd();	
	$prescription->openId($prsid);
	$opd->openId($prescription->getValue("OPDID"));	
	if ( $opd == null) 
		return null ;
    $pat = $opd->getOpdPatient();	;	
	if ($pat == null) 
		return null;
		
		

	$out .= "<div id='formCont' class='formCont' style='left:20;' >\n";
	$out .= "<div class='prescriptionHead' style='font-size:23px;'>".getPrompt("OPD Prescription")."</div>";
	$out .= "<div class='prescriptionInfo'>\n";
	$out .= "<table border=0 width=100% class='PrescriptionInfo'>\n";
	$out .= "<tr>";
	$out .= "<td>".getPrompt("Hospital")." : </td><td>".$_SESSION["Hospital"]."</td>"; 
	$out .= "<td nowrap>".getPrompt("Prescription ID")." : </td><td nowrap>".$prescription->getId()."</td>"; 
	$out .= "</tr>";
	$out .= "<tr>";
	$out .= "<td>".getPrompt("Prescribed By").": </td><td >".$prescription->getValue("PrescribeBy")."</td>"; 
	$out .= "<td>".getPrompt("Prescribed On")." : </td><td nowrap>".$prescription->getValue("PrescribeDate")."</td>"; 
	$out .= "</tr>";
		//$out .= "<tr><td colspan=4><hr style='border:0;color: #000000;background-color: #000000;height:1px;'></td></tr>";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Patient").": </td><td>".$pat->getFullName()." (".$pat->getId().") </td>"; 
		list ($yrs,$mths)= $pat->dateDifference($pat->getValue("DateOfBirth"),date('Y/m/d'));
		$out .= "<td nowrap>".getPrompt("Gender")."/".getPrompt("Age")." : </td><td nowrap>".$pat->getValue("Gender")."&nbsp;/&nbsp;".$yrs."yrs&nbsp;".$mths."mths</td>"; 
		$out .= "</tr>";		
	//  $out .= "<tr><td colspan=4><hr style='border:0;color: #000000;background-color: #000000;height:1px;'></td></tr>";
	$out .= "<tr>";
	$out .= "<td>".getPrompt("Complaints / Injuries").": </td><td>".$opd->getValue("Complaint")."</td>"; 
	$out .= "<td nowrap>".getPrompt("Doctor")." : </td><td nowrap>".$opd->getValue("Doctor")."</td>"; 
	$out .= "</tr>";
	$out .= "<tr>";
	$out .= "<td>".getPrompt("Stock").": </td><td><b>";
        if ($prescription->getValue("GetFrom") == "Stock")
            $out .="OPD Stock";
        else
            $out .="Clinic Stock";
        $out .="</B></td>"; 
	$out .= "<td nowrap>".getPrompt("Visit type").": </td><td nowrap>".$opd->getValue("VisitType")."</td>"; 
	$out .= "</tr>";
        $out .= "<tr><td colspan=4><hr style='border:0;color: #000000;background-color: #000000;height:1px;'></td></tr>";
	$out .= "</table>\n";
	$out .= "<table border=0 width=100% class='PrescriptionInfo'>\n";
	$out .= "<tr>";
	$out .= "<td class='pTd'>#</td><td class='pTd'>".getPrompt("Drug")."</td><td nowrap class='pTd'>".getPrompt("Dosage")."</td><td nowrap class='pTd'>".getPrompt("Frequency")."</td><td nowrap class='pTd'>".getPrompt("Period")."</td><td nowrap class='pTd'>".getPrompt("Quantity")."</td>"; 
	$out .= "</tr>";
	$out .= getPrescriptionItemsForDispense($prescription->getId(),$prescription->getValue("GetFrom")); 

	$out .= "</table>\n";
	$out .= "<div align=center>";
	if ( $prescription->getValue("Status") == "Pending"){
		$prsid=$prescription->getId();
		$out .= "<input id='okBtn' type='button'  class='formButton' value='Ready' onclick=DrugsReady($prsid);>\n ";
		$out .= "<input id='okBtn' type='button'  class='formButton' value='Dispense' onclick=saveData();>\n ";
		
	}
	if ( $prescription->getValue("Status") == "Ready"){
		
		$out .= "<input id='okBtn' type='button'  class='formButton' value='Dispense' onclick=saveData();>\n ";
		
	}
	$out .= "<input type='button' value='Back'  class='formButton' onclick=window.history.back();>";
	$out .= loadPlugins();
	$out .= "<div>\n ";
	
	$out .= "</div>\n";
	$out .= "</div>\n ";
    
			$out .="<script language='javascript'>\n";
			$out .="function saveData() {\n";
			$out .=" var val=''; var txt=''; \n";
           
			$out .=" $('input[type=\"number\"]').each(function(){ \n";
				$out .=" val += $(this).val()+'|'; \n";
			$out .=" }); \n";
			
			$out .=" $('input:hidden').each(function(){ \n";
				$out .=" txt += $(this).val()+'|'; \n";
			$out .=" }); \n";
          
			
			$data =  "data:({";
			$data .= 'txt:'."txt,";    
			$data .= 'val:'."val,";    
			$data .= "PRSID:'".$prescription->getId()."',";    
			$data .= "LastUpDateUser:'".$_SESSION["FirstName"]." ".$_SESSION["OtherName"]."',";   
			$data .= "LastUpDate:'".date("Y-m-d H:i:s")."',";   
                        $data .= "Stock:'".$prescription->getValue("GetFrom")."'";   
            $data .=  "}),";


            $out .=" $('#okBtn').attr('disabled','true'); \n";
            $out .="var resM=$.ajax({ \n";
                                       $out .="url: 'include/prescribe_save.php?',\n";
                                       $out .="global: false,\n";
                                       $out .="type: 'POST',\n";
                                       $out .=$data."\n";
                                       $out .="async:false\n";
                                    $out .="}).responseText;\n";
                                    $out .=" eval(resM); \n";
                                    $out .=" if ( !Error ) { \n";
                                                if ($_GET["RETURN"]){
                                                    $out .=" self.document.location='".$_GET["RETURN"]."' ; \n ";
                                                }
                                                else{
                                                    $out .=" self.document.location='home.php?page=pharmacy' ; \n ";
                                                }
                                    $out .="} else { $('#MDSError').html(res); }\n";
            $out .=" $('#okBtn').attr('disabled','false'); \n";
       $out .="}\n"; //function saveData
       $out .="parent.window.onbeforeunload = confirmExit; \n";
       $out .="</script>\n"; 
	return $out;

}
function loadPlugins(){
		if (file_exists("plugins/plugins_conf.php")){
			try{
				include_once "plugins/plugins_conf.php";
				for ($i = 0; $i < count($plugins); ++$i){
					for ($j = 0; $j < count($p_hhims[$plugins[$i]]); ++$j){
						if ( ($p_hhims[$plugins[$i]][$j]["page"] == $_GET["page"])  && ($p_hhims[$plugins[$i]][$j]["action"] == $_GET["action"]) )
							{
								try {
									return  "<span class='formButton' style='height:30;font-size:12;padding:4px;background:#f9e3cf;border:1px solif #830101;color:#FFFFFF;'><a name='".$plugins[$i].$i."'  id='".$plugins[$i].$i."'  type='".$p_hhims[$plugins[$i]][$j]["type"]."' value='".$p_hhims[$plugins[$i]][$j]["value"]."'  target='' onclick='".$p_hhims[$plugins[$i]][$j]["click"]."' href='javascript:void(0);'>".$p_hhims[$plugins[$i]][$j]["value"]."</a><img src='".$p_hhims[$plugins[$i]][$j]["img"]."' width=40 valign=middle></span>";
								}
								catch (Exception $e) {}
							}
						}
					
				}
			}
			catch (Exception $e) {
			}
		}	
}

function renderADMDispenseForm($prsid){
	include_once 'class/MDSPatient.php';
	include_once 'class/MDSPrescription.php';
	include_once 'class/MDSAdmission.php';
	
	$out = "";
	if ( $prsid == "" ) 
		return null ;
	$prescription = new MDSPrescription();	
	$opd = new MDSAdmission();	
	$prescription->openId($prsid);
	$opd->openId($prescription->getValue("OPDID"));	
	if ( $opd == null) 
		return null ;
    $pat = $opd->getAdmitPatient();	;	
	if ($pat == null) 
		return null;
			

	$out .= "<div id='formCont' class='formCont' style='left:20;' >\n";
	$out .= "<div class='prescriptionHead' style='font-size:23px;'>".getPrompt("Admission Prescription")."</div>";
	$out .= "<div class='prescriptionInfo'>\n";
	$out .= "<table border=0 width=100% class='PrescriptionInfo'>\n";
	$out .= "<tr><td colspan=4>".$pat->patientBannerTiny('10px')."</td></tr>";
	$out .= "</table>\n";
	$out .= "<table border=0 width=100% class='PrescriptionInfo'>\n";
	$out .= "<tr>";
	$out .= "<td class='pTd'>#</td><td class='pTd'>".getPrompt("Drug")."</td><td nowrap class='pTd'>".getPrompt("Dosage")."</td><td nowrap class='pTd'>".getPrompt("Frequency")."</td><td nowrap class='pTd'>".getPrompt("Period")."</td><td nowrap class='pTd'>".getPrompt("Quantity")."</td>"; 
	$out .= "</tr>";
	$out .= getPrescriptionItemsForDispense($prescription->getId(),''); 

	$out .= "</table>\n";
	$out .= "<div align=center>";
	//if ( $prescription->getValue("Status") == "Pending")
		$out .= "<input id='okBtn' type='button'  class='formButton' value='Dispense' onclick=saveData();>\n ";
	$out .= "<input type='button' value='Back'  class='formButton' onclick=window.history.back();><div>\n ";
	$out .= "</div>\n";
	$out .= "</div>\n ";
    
			$out .="<script language='javascript'>\n";
			$out .="function saveData() {\n";
			$out .=" var val=''; var txt=''; \n";
           
			$out .=" $('input[type=\"number\"]').each(function(){ \n";
				$out .=" val += $(this).val()+'|'; \n";
			$out .=" }); \n";
			
			$out .=" $('input:hidden').each(function(){ \n";
				$out .=" txt += $(this).val()+'|'; \n";
			$out .=" }); \n";

			$data =  "data:({";
			$data .= 'txt:'."txt,";    
			$data .= 'val:'."val,";    
			$data .= "PRSID:'".$prescription->getId()."',";    
			$data .= "LastUpDateUser:'".$_SESSION["FirstName"]." ".$_SESSION["OtherName"]."',";   
			$data .= "LastUpDate:'".date("Y-m-d H:i:s")."',";   
                        $data .= "Stock:'".$prescription->getValue("GetFrom")."'";   
            $data .=  "}),";


            $out .=" $('#okBtn').attr('disabled','true'); \n";
            $out .="var resM=$.ajax({ \n";
                                       $out .="url: 'include/prescribe_save.php?',\n";
                                       $out .="global: false,\n";
                                       $out .="type: 'POST',\n";
                                       $out .=$data."\n";
                                       $out .="async:false\n";
                                    $out .="}).responseText;\n";
                                    $out .=" eval(resM); \n";
                                    $out .=" if ( !Error ) { \n";
                                                if ($_GET["RETURN"]){
                                                    $out .=" self.document.location='".$_GET["RETURN"]."' ; \n ";
                                                }
                                                else{
                                                    $out .=" self.document.location='home.php?page=pharmacy' ; \n ";
                                                }
                                    $out .="} else { $('#MDSError').html(res); }\n";
            $out .=" $('#okBtn').attr('disabled','false'); \n";
       $out .="}\n"; //function saveData
       $out .="parent.window.onbeforeunload = confirmExit; \n";
       $out .="</script>\n"; 
	return $out;

}
?>