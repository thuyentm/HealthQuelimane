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

 $tbl = "";
   $tbl .= "<div class='tablecont'> \n";
    $tbl .= "<table align='center' cellpadding='0' cellspacing='0' border='0' class='display' id='example' width='70%'> \n";
	$tbl .= "<thead>  \n";
		$tbl .= "<tr>  \n";
			$tbl .= "<th width='10%'>ID</th>  \n";
			$tbl .= "<th style='width:10%'>Code</th>  \n";
                        $tbl .= "<th style='width:70%'>Name</th>  \n";
			$tbl .= "<th style='width:10%'>Notify</th>  \n";
                        $tbl .= "<th style='width:10%'>Notify</th>  \n";
		$tbl .= "</tr>  \n";
	$tbl .= "</thead>  \n";
	$tbl .= "<tbody>  \n";
	$tbl .= "</tbody>  \n";
$tbl .= "</table>  \n";
$tbl .= "</div> \n";

$tbl .= "<script language='javascript'> \n";

				$tbl .= "oTable = $('#example').dataTable( { \n";
		
					$tbl .= "'aaSorting': [[0, 'asc']], \n";
					$tbl .= "'bAutoWidth': false, \n";
					$tbl .= "'bProcessing': true, \n";
					$tbl .= '"oSearch": {"sSearch": "'.$_GET['SRCH'].'"},';
					$tbl .= "'bServerSide': true, \n";
					$tbl .= "'fnRowCallback': function( nRow, aData, iDisplayIndex ) { \n";
						$tbl .= "if ( aData[3] == '1' ) \n";
						$tbl .= "{ \n";
							$tbl .= "$('td:eq(3)', nRow).html( 'Yes' ); \n";
							$tbl .= "$(nRow).css({'color':'#FF0000'}); \n";
						$tbl .= "} \n";
						$tbl .= "else { \n";
							$tbl .= "$('td:eq(3)', nRow).html( 'No' ); \n";
						$tbl .= "} \n";
						$tbl .= "return nRow; \n";
					$tbl .= "}, \n";
				   $tbl .= "'sPaginationType': 'full_numbers', \n";
					$tbl .= "'sAjaxSource': 'include/server_process.php?FORM=ICDForm' \n";
				$tbl .= "} ); \n";
				
					$tbl .= "$('#example tbody tr').live('click', function(e){ \n";
						$tbl .= "if (e.which !== 1) return; \n";
						$tbl .= " var aData = oTable.fnGetData( this ); \n";
						$tbl .= " updateICD(aData[1],aData[1]+': '+aData[2],'".$_GET["ELID"]."','".$_GET["TEXT"]."');";
					$tbl .= "}); \n";
					
                         $tbl .= "function fnShowHide( iCol )\n";
			$tbl .= "{\n";
				$tbl .= "var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;\n";
				$tbl .= "oTable.fnSetColumnVis( iCol, bVis ? false : true );\n";
			$tbl .= "}\n";					
                            $tbl .= "fnShowHide( 0 )\n";

$tbl .= "</script> \n";

echo $tbl;
?>