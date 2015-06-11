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
function renderLabOrderForm($frm,$fName,$type,$episode){
    //include 'config.php';

	include_once 'class/MDSLabOrder.php';
	$out = "";
	$orderid = null;
    $frm = $labOrderForm;
	if ($type == "OPD") {
		$pat = $episode->getOpdPatient();	
		if (!$pat) 
			return null ;	
		$labOrder = new MDSLabOrder();
		$labOrder->prepair($episode,$pat,$type);
		$out = $labOrder->renderForm($episode,$pat,$type);	
		$o_type= "OPDID";
		$page = "opd";
	}
	else if ($type =="ADM") {
		$pat = $episode->getAdmitPatient();
		if (!$pat) 
			return null ;	
		$labOrder = new MDSLabOrder();
		$labOrder->prepair($episode,$pat,$type);
		$out = $labOrder->renderForm($episode,$pat,$type);	
		$o_type= "ADMID";		
		$page = "admission";
	}
	else {
		return null ;
	}	
	


    
	$out .= " <script language='javascript'>\n";
        $out .="$('#OrderDate').datepicker({changeMonth: true,changeYear: true,yearRange: 'c-1:c+1',dateFormat: 'yy-mm-dd ',maxDate: '+14D', minDate: '-0D'});\n";
	$out .= " $('#dd').datepicker({changeMonth: true,changeYear: true,yearRange: '1930:2011',dateFormat: 'yy-mm-dd',maxDate: '+0D', onSelect: function(dateText, inst) { updateDateTime('CollectionDateTime');}});\n";
	$out .= " $('#dcont, #createBtn').hide();\n";
	$out .= " function saveData() {\n";
	$out .= " var labItems = ''; \n";
	$out .= " $('input:checked').each(function (i) { \n";
	$out .= " labItems += $(this).val()+'|'; \n";
	$out .= " }); \n ";
	$out .= " var dateTime =  $('#CollectionDateTime').val(); \n";
	$data  = ' data:({';
	$data .= ' Dept:"'.$type.'", OPDID:"'.$episode->getId().'", PID:"'.$pat->getId().'", OrderDate:$("#OrderDate").val(), OrderBy:"'.getLoggedUser().'", Status:"Pending", CreateDate:"'.date("Y-m-d H:i:s").'", Active:"1", CreateUser:"'.getLoggedUser().'", Priority:$("#Priority").val(),TestGroupName:$("#labTest").val(),';   
	$data .= ' LabItems:labItems, ';
	$data .= ' CollectionDateTime:dateTime, ';	
	$data .= ' FORM:'.'"'.$fName.'"';
	$data .= ' }),';
         $out .=" $('#okBtn').attr('disabled','true'); \n";
	$out .=" var resM=$.ajax({ \n";
							   $out .= "url: 'include/lab_order_save.php',\n";
							   $out .= "global: false,\n";
							   $out .= "type: 'POST',\n";
							   $out .= $data."\n";
							   $out .= "async:false\n";
							$out .= "}).responseText;\n";
							$out .= " eval(resM); \n";
							$out .= " if ( !Error) { \n";
							$out .= " self.document.location='home.php?page=".$page."&action=View&".$o_type."=".$episode->getId()."' ; \n ";
							$out .= "} else { $('#MDSError').html(res); }\n";
	$out .=" }\n"; //function saveData
	$out .=" parent.window.onbeforeunload = confirmExit; \n";
	$out .="</script>\n"; 
	return $out;
}
function renderLabOrderFormEdit($frm,$fName,$type,$opd,$orderid){
    //include 'config.php';
	//TS: $opd is not used
	include_once 'class/MDSLabOrder.php';
	$out = "";
    $frm = $labOrderForm;
	if ( !$orderid ) 
		return null ;
	$labOrder = new MDSLabOrder();
	$labOrder->openId($orderid);
	$episode = $labOrder->getEpisode();
	if ($type == "OPD") {
		$pat = $episode->getOpdPatient();
	}
	else if ($type == "ADM") {
		$pat = $episode->getAdmitPatient();
	}else {
		return null;
	}
	if (!$pat) 
		return null ;	
	$out = $labOrder->renderFormEdit($episode,$pat,$type);

	$out .= " <script language='javascript'>\n";
	$out .= " $('#dd').datepicker({changeMonth: true,changeYear: true,yearRange: '1930:2011',dateFormat: 'yy-mm-dd',maxDate: '+0D', onSelect: function(dateText, inst) { updateDateTime('CollectionDateTime');}});\n";
	if ($labOrder->getValue("Active") == 0) {
		$out .= " $('.input').attr('disabled','true');\n";	
		$out .= " $('#saveBtn').attr('disabled','true');\n";	
		$out .= " $('#formCont').css({'background':'#fcd1d1','border':'2px solid #FF0000'});\n";	
		$out .= " $('#formCont').append('<center class=\'mdserror\'>!Object Deleted by ".$labOrder->getValue("LastUpDateUser")." on ".$labOrder->getValue("LastUpDate")."</center>');\n";	
	}
	
	$out .= " function saveData() {\n";
	$out .= " var results = ''; \n";
	$out .= " var tests   = ''; \n";
	
	$out .= " if (!$('#confirm').attr('checked')){ alert('Please confirm the result!'); return null; } \n";
	$out .= " $('input[typ=\"result\"]').each(function (i) { \n";
	$out .= " results += $(this).val()+'|'; \n";
	$out .= " tests += $(this).attr('id')+'|'; \n";
	$out .= " }); \n ";
	$out .= " var dateTime =  $('#CollectionDateTime').val(); \n";
	$data  = ' data:({';
	$data .= ' ORDID:"'.$labOrder->getId().'",Status:"Done", LastUpDate:"'.date("Y-m-d H:i:s").'", LastUpDateUser:"'.getLoggedUser().'", ';   
	$data .= ' LabResults:results, ';
	$data .= ' LabTests:tests, ';
	$data .= ' CollectionDateTime:dateTime, ';	
	$data .= ' FORM:'.'"'.$fName.'", Action:"Update"';
	$data .= ' }),';
         $out .=" $('#saveBtn').attr('disabled','true'); \n";
	$out .=" var resM=$.ajax({ \n";
							   $out .= "url: 'include/lab_order_save.php',\n";
							   $out .= "global: false,\n";
							   $out .= "type: 'POST',\n";
							   $out .= $data."\n";
							   $out .= "async:false\n";
							$out .= "}).responseText;\n";
							$out .= " eval(resM); \n";
							//$out .= " if ( !Error) { \n";
							$out .= " self.document.location='".$_GET["RETURN"]."' ; \n ";
							//$out .= "} else { $('#MDSError').html(res); }\n";
	$out .=" }\n"; //function saveData
	$out .=" parent.window.onbeforeunload = confirmExit; \n";
	$out .="</script>\n"; 
	return $out;
}
?>