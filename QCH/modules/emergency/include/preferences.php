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


function loadUserTable(){
$tbl = <<<'EOT'
   <div class="tablecont">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="70%">
	<thead> 
		<tr> 
			<th width="10%">ID</th> 
			<th style="width:300px">First Name</th> 
			<th style="width:300px">Other Name</th> 
			<th style="width:300px">Date of Birth</th> 
			<th style="width:300px">Gender</th> 
			<th style="width:300px">Post</th> 
			<th style="width:300px">UserName</th> 
            <th style="width:300px">UserGroup</th> 
            <th style="width:300px">Village</th> 
		</tr> 
	</thead> 
	<tbody> 
	</tbody> 
</table> 
</div>

<script language="javascript">
				oTable = $('#example').dataTable( {
		
				"aaSorting": [[0, 'asc']],
				//"bJQueryUI": true,
				"bAutoWidth": false,
				"bProcessing": true,
				"bServerSide": true,
               "sPaginationType": "full_numbers",
					"sAjaxSource": "include/server_process.php?FORM=userForm"
				} );
				

					$("#example tbody tr").live("click", function(e){
						if (e.which !== 1) return;
						var aData = oTable.fnGetData( this );
						self.document.location='home.php?page=preferences&mod=UserNew&UID='+aData[0]+'';
					});

</script>
EOT;
    return $tbl;
}

function loadLabTestTable(){
    $tbl = <<<'EOT'
   <div class="tablecont">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="70%">
	<thead> 
		<tr> 
			<th width="10%">ID</th> 
			<th style="width:160px">Department</th> 
			<th style="width:160px">Group Name</th> 
			<th style="width:180px">Test</th> 
			<th style="width:400px">Ref. Value</th> 
		</tr> 
	</thead> 
	<tbody> 
	</tbody> 
</table> 
</div>

<script language="javascript">
				oTable = $('#example').dataTable( {
		
				"aaSorting": [[1, 'asc']],
				//"bJQueryUI": true,
				"bAutoWidth": false,
				"bProcessing": true,
				"bServerSide": true,
               "sPaginationType": "full_numbers",
					"sAjaxSource": "include/server_process.php?FORM=labTestForm"
				} );
				

					$("#example tbody tr").live("click", function(e){
						if (e.which !== 1) return;
						var aData = oTable.fnGetData( this );
						self.document.location='home.php?page=preferences&mod=LabTestNew&LABID='+aData[0]+'';
					});

</script>
EOT;
    return $tbl;
}
function loadUserGroupTable(){
    $tbl = <<<'EOT'
   <div class="tablecont">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="70%">
	<thead> 
		<tr> 
			<th width="10%">ID</th> 
			<th style="width:300px">Group name</th> 
			<th style="width:5px">Active</th> 
		</tr> 
	</thead> 
	<tbody> 
	</tbody> 
</table> 
</div>

<script language="javascript">
				oTable = $('#example').dataTable( {
		
				"aaSorting": [[0, 'asc']],
				//"bJQueryUI": true,
				"bAutoWidth": false,
				"bProcessing": true,
				"bServerSide": true,
					"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
						if ( aData[2] == "1" )
						{
							$('td:eq(2)', nRow).html( 'Yes' );
						}
						else {
							$('td:eq(2)', nRow).html( 'No' );
						}
						return nRow;
					},						
               "sPaginationType": "full_numbers",
					"sAjaxSource": "include/server_process.php?FORM=userGroupForm"
				} );
				
					$("#example tbody tr").live("click", function(e){
						if (e.which !== 1) return;
						var aData = oTable.fnGetData( this );
						self.document.location='home.php?page=preferences&mod=UserGroupNew&UGID='+aData[0]+'';
					});

</script>
EOT;
    return $tbl;
}

function loadUserMenuTable(){
    $tbl = <<<'EOT'
   <div class="tablecont">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="70%">
	<thead> 
		<tr> 
			<th width="10%">ID</th> 
			<th style="width:300px">Name</th> 
            <th style="width:300px">Group</th> 
			<th style="width:300px">Link</th> 
			<th style="width:5px">Order</th> 
			<th style="width:5px">Active</th> 
		</tr> 
	</thead> 
	<tbody> 
	</tbody> 
</table> 
</div>

<script language="javascript">
				oTable = $('#example').dataTable( {
		
				"aaSorting": [[0, 'asc']],
				//"bJQueryUI": true,
				"bAutoWidth": false,
				"bProcessing": true,
				"bServerSide": true,
					"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
						if ( aData[5] == "1" )
						{
							$('td:eq(5)', nRow).html( 'Yes' );
						}
						else {
							$('td:eq(5)', nRow).html( 'No' );
						}
						return nRow;
					},						
               "sPaginationType": "full_numbers",
					"sAjaxSource": "include/server_process.php?FORM=userMenuForm"
				} );
				
					$("#example tbody tr").live("click", function(e){
						if (e.which !== 1) return;
						var aData = oTable.fnGetData( this );
						self.document.location='home.php?page=preferences&mod=MenuNew&UMID='+aData[0]+'';
					});

</script>
EOT;
    return $tbl;
}
function loadComplaintTable(){
    $tbl = <<<'EOT'
   <div class="tablecont">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="70%">
	<thead> 
		<tr> 
			<th width="5%">ID</th> 
			<th style="width:30%">Complaint</th> 
            <th style="width:10%">Type</th> 
			<th style="width:5%">Notifiable</th> 
			<th style="width:40%">ICD Link</th> 
			<th style="width:5%">Remarks</th> 
		</tr> 
	</thead> 
	<tbody> 
	</tbody> 
</table> 
</div>

<script language="javascript">
				oTable = $('#example').dataTable( {
		
				"aaSorting": [[1, 'asc']],
				//"bJQueryUI": true,
				"bAutoWidth": false,
				"bProcessing": true,
				"bServerSide": true,
					"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
						if ( aData[3] == "1" )
						{
							$('td:eq(3)', nRow).html( 'Yes' );
							$(nRow).css({"color":"#FF0000"});
						}
						else {
							$('td:eq(3)', nRow).html( 'No' );
						}
						return nRow;
					},						
               "sPaginationType": "full_numbers",
					"sAjaxSource": "include/server_process.php?FORM=complaintForm"
				} );
				
					$("#example tbody tr").live("click", function(e){
						if (e.which !== 1) return;
						var aData = oTable.fnGetData( this );
						self.document.location='home.php?page=preferences&mod=ComplaintsNew&COMPID='+aData[0]+'';
					});

</script>
EOT;
    return $tbl;
}
function loadICDTable(){
    $tbl = <<<'EOT'
   <div class="tablecont">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="70%">
	<thead> 
		<tr> 
			<th width="10%">ID</th> 
			<th style="width:100px">Code</th> 
            <th style="width:400px">Name</th> 
			<th style="width:10px">Notifiable</th> 
			<th style="width:100px">Remarks</th> 
		</tr> 
	</thead> 
	<tbody> 
	</tbody> 
</table> 
</div>

<script language="javascript">
				oTable = $('#example').dataTable( {
		
				"aaSorting": [[0, 'asc']],
				//"bJQueryUI": true,
				"bAutoWidth": false,
				"bProcessing": true,
				"bServerSide": true,
					"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
						if ( aData[3] == "1" )
						{
							$('td:eq(2)', nRow).html( 'Yes' );
							$(nRow).css({"color":"#FF0000"});
						}
						else {
							$('td:eq(2)', nRow).html( 'No' );
						}
						return nRow;
					},						
               "sPaginationType": "full_numbers",
					"sAjaxSource": "include/server_process.php?FORM=ICDForm"
				} );
				
					$("#example tbody tr").live("click", function(e){
						if (e.which !== 1) return;
						var aData = oTable.fnGetData( this );
						self.document.location='home.php?page=preferences&mod=IcdNew&ICDID='+aData[0]+'';
					});
                         function fnShowHide( iCol )
                  	 {
				var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
				oTable.fnSetColumnVis( iCol, bVis ? false : true );
			}
                       fnShowHide(0);

</script>
EOT;
    return $tbl;
}

function loadIMMRTable(){
    $tbl = <<<'EOT'
   <div class="tablecont">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="70%">
	<thead> 
		<tr> 
			<th width="5%">ID</th> 
			<th style="width:5%">Code</th> 
            <th style="width:40%">Name</th> 
			<th style="width:40%">Category</th> 
			<th style="width:10px">ICD Links</th> 
		</tr> 
	</thead> 
	<tbody> 
	</tbody> 
</table> 
</div>

<script language="javascript">
				oTable = $('#example').dataTable( {
				"aaSorting": [[0, 'asc']],
				//"bJQueryUI": true,
				"bAutoWidth": false,
				"bProcessing": true,
				"bServerSide": true,
				
               "sPaginationType": "full_numbers",
					"sAjaxSource": "include/server_process.php?FORM=IMMRForm"
				} );
				
					$("#example tbody tr").live("click", function(e){
						if (e.which !== 1) return;
						var aData = oTable.fnGetData( this );
						self.document.location='home.php?page=preferences&mod=ImmrNew&IMMRID='+aData[0]+'';
					});
                         function fnShowHide( iCol )
                  	 {
				var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
				oTable.fnSetColumnVis( iCol, bVis ? false : true );
			}
                       fnShowHide(0);                                        

</script>
EOT;
    return $tbl;
}


function loadTable($table){
	if ($table == "") return null;
	include 'form_config/'.$table.'Form_config.php';
	$tbl_conf = ${$table."Form"};
	$tbl = "";
	$tbl .= "<div class='tablecont'>\n";
        $tbl .= "<table align='center' cellpadding='0' cellspacing='0' border='0' class='display' id='example' width='70%'>\n";
	$tbl .= "<thead> \n";
		$tbl .= "<tr> \n";
			for ( $i = 0; $i < count($tbl_conf["DISPLAY_LIST"]); ++$i ) {
				$tbl .= "<th width='".$tbl_conf["DISPLAY_WIDTH"][$i]."'>".getPrompt($tbl_conf["DISPLAY_LIST"][$i])."</th> \n";
			}			
		$tbl .= "</tr> \n";
	$tbl .= "</thead> \n";
	$tbl .= "<tbody> \n";
	$tbl .= "</tbody> \n";
	$tbl .= "</table> \n";
	$tbl .= "</div>\n";
	$js = "";
	$js .= "<script language='javascript'> \n";
				$js .= "oTable = $('#example').dataTable( {\n";
                                //if ($tbl_conf["OPS"]) $js .= $tbl_conf["OPS"]."\n";
                                if ($tbl_conf["SORT"]) $js .= $tbl_conf["SORT"]."\n";
				$js .= "'bAutoWidth': false,\n";
				$js .= "'bProcessing': true,\n";
				$js .= "'bServerSide': true,\n";
                                
					
               $js .= "'sPaginationType': 'full_numbers',\n";
					$js .= "'sAjaxSource': 'include/server_process.php?FORM=".$table."Form'\n";
				$js .= "} );\n";
				
				$js .= "$('#example tbody tr').live('click', function(e){\n";
						$js .= "if (e.which !== 1) return;\n";
						$js .= "var aData = oTable.fnGetData( this );\n";
						$js .= "self.document.location='home.php?page=preferences&mod=".$table."New&".$tbl_conf[OBJID]."='+aData[0]+'';\n";
					$js .= "});\n";
                                        
                                        
                         $js .= "function fnShowHide( iCol )\n";
			$js .= "{\n";
				$js .= "var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;\n";
				$js .= "oTable.fnSetColumnVis( iCol, bVis ? false : true );\n";
			$js .= "}\n";
                        if ($tbl_conf["OPS"]) $js .= $tbl_conf["OPS"]."\n";
	$js .= "</script>\n";
    return $tbl.$js;
}


function loadForm($fName){
	include_once 'class/MDSForm.php';
	include_once 'form_config/'.$fName.'_config.php';
	$form = new MDSForm();
        $form->left=100;
	$frm = ${$fName};
    $out .=$form->addErrorDiv();
  	$form->FrmName = $fName;
    $out .= $form->render($frm);
    echo $out;

}
function loadPreferences() {
	include_once 'class/MDSPreference.php';
	include_once 'class/MDSLeftMenu.php';
    $mod = $_GET["mod"];
      //if ($mod == "Complaints") {$mod = " / ".$mod;}
	$out = $lbar = $head = "";
	$pref = new MDSPreference($mod); 
	$l_menu = new MDSLeftMenu();
	$prefCont = $pref->loadPreference();
	$lbar 	= 	$l_menu->renderLeftMenu("Preference",$pref);
    $out = $head.$lbar.$prefCont;
    echo $out;
}

?>