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


include_once 'MDSDataBase.php';
class MDSTable 
{
	private static $instance; 
        public $mode = "self"; 
        public $tr_click_page ="home";
        public $tr_click_action ="View";
        public $tr_click_mod = "";
        
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	
	public function __construct() {

	}
        
        function loadTable($table){
                if ($table == "") return null;
                include_once 'include/form_config/'.$table.'Form_config.php';
                $tbl_conf = ${$table."Form"};
                //echo "<br><br><br><br><br><br><br><br>".print_r($tbl_conf);
                $tbl = "<div id='prefCont' style='position:relative;'>";
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
                $tbl .= "</div></div>\n";
                $js = "";
                $js .= "<script language='javascript'> \n";
                                        $js .= "oTable = $('#example').dataTable( {\n";
                                        $js .= "'bAutoWidth': false,\n";
                                        $js .= "'bProcessing': true,\n";
                                        $js .= "'bServerSide': true,\n";

                       $js .= "'sPaginationType': 'full_numbers',\n";
                                                $js .= "'sAjaxSource': 'include/server_process.php?FORM=".$table."Form'\n";
                                        $js .= "} );\n";

                                        $js .= "$('#example tbody tr').live('click', function(e){\n";
                                                        $js .= "if (e.which !== 1) return;\n";
                                                        $js .= "var aData = oTable.fnGetData( this );\n";
                                                        if ($this->mode == "self"){
                                                            $js .= "self.document.location='home.php?page=".$this->tr_click_page."&mod=".$this->tr_click_mod."&action=".$this->tr_click_action."&".$tbl_conf[OBJID]."='+aData[0]+'';\n";
                                                        }
                                                        elseif ($this->mode == "new_win"){
                                                            $js .= "window.open('".$tbl_conf[NEXT1]."'+aData[0]+'','Notification','width=600 height=800');\n";
                                                        }
                                                        
                                                $js .= "});\n";
                $js .= "</script>\n";
            return $tbl.$js;
        }

	   
}

?>