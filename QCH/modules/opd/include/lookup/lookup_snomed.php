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

session_start();
if (!session_is_registered(username)) {
    header("location: http://".$_SERVER['SERVER_NAME']);
} 
if ($_GET["TYPE"]) {
	$frm = $_GET["TYPE"];
 }
 else {
	$frm = "findingForm";
 }
include '../form_config/'.$frm.'_config.php';
$tbl_conf = ${$frm};

 $tbl = '';
   $tbl .= '<div class="tablecont">';
    $tbl .= '<table align="center" cellpadding="0" cellspacing="0" border="0" class="display" id="example1" width="70%">';
	$tbl .= '<thead>';
		$tbl .= '<tr>';
			for ( $i = 0; $i < count($tbl_conf["DISPLAY_LIST"]); ++$i ) {
				$tbl .= '<th width="'.$tbl_conf["DISPLAY_WIDTH"][$i].'">'.$tbl_conf["DISPLAY_LIST"][$i].'</th>';
			}
		$tbl .= '</tr>';
	$tbl .= '</thead>';
	$tbl .= '<tbody>';
	$tbl .= '</tbody>';
$tbl .= '</table>';
$tbl .= '</div>';

$tbl .= '<script language="javascript">';

				$tbl .= 'oTable1 = $("#example1").dataTable( {';
                                        $tbl .= '"aaSorting": [[2, "asc"]],';
					$tbl .= '"bAutoWidth": false,';
					$tbl .= '"bProcessing": true,';
					$tbl .= '"bServerSide": true,';
					//$tbl .= '"oSearch": {"sSearch": ""},';
				   $tbl .= '"sPaginationType": "full_numbers",';
					$tbl .= '"sAjaxSource": "include/server_process.php?FORM='.$frm.'"';
				$tbl .= '} );';
				
					$tbl .= '$("#example1 tbody tr").live("click", function(e){';
						$tbl .= 'if (e.which !== 1) return;';
						$tbl .= 'var aData = oTable1.fnGetData( this );';
                                                if ($frm == "disorderForm") {
                                                    $tbl .= 'updateSNOMED(aData[1],aData[2],"'.$_GET["ELID"].'",aData[3],aData[4]);';
                                                }
                                                else{
                                                    $tbl .= 'updateSNOMEDOnly(aData[1],aData[2],"'.$_GET["ELID"].'","","");';
                                                }
					$tbl .= '});';
                         $tbl .= "function fnShowHide( iCol )\n";
			$tbl .= "{\n";
				$tbl .= "var bVis = oTable1.fnSettings().aoColumns[iCol].bVisible;\n";
				$tbl .= "oTable1.fnSetColumnVis( iCol, bVis ? false : true );\n";
			$tbl .= "}\n";					
                            if ($tbl_conf["OPS"]) $tbl .= $tbl_conf["OPS"]."\n";	

$tbl .= '</script>';
echo $tbl;
?>