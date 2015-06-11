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

include_once 'MDSPersistent.php';
include_once 'MDSDataBase.php';
class MDSQuestionnaire extends MDSPersistent
{
	private static $instance; 
	private $table = "quest_struct";
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	
	public function __construct() {
		parent::__construct($this->table);
	}
	
        public function load(){
            if ($_GET["mod"]=="preview"){
                return $this->preview();
            }
            else if ($_GET["mod"]=="datanew"){
                return $this->loadForm();
            }
        }
        private function preview($pview = true){
                $out = "";
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT * FROM quest_flds_struct where (QUES_ST_ID ='".$this->getId()."') "); 
		if (!$result) { echo "ERROR getting Exam Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$i = 0;
		
		$out .= "<div id='formCont' class='formCont' ";
                $out .= " style='left:10;'\n";   
                $out .= ">\n";  
		
		$out .= "<form id='frm' method='post'><table cellspacing=0 cellpadding=0 width=80%>\n";                
                $out .= "<tr><td colspan=5 style='font-size:20;' align=center>Questionaire: ".$this->getValue("Name");
                if ($this->getValue("Remarks") != "")        
                        $out .= "<br><span style='font-size:16;color:#333333'><i>".$this->getValue("Remarks")."</i></span>";
                $out .= "<hr>";
                if (!$pview) {
                    $out .= "<input type='hidden' id='Date' value='".date('Y-m-d')."'>";
                    $out .= "<input type='hidden' id='Type' value='".$this->getValue("Type")."'>";
                    $out .= "<input type='hidden' id='OBID' value='".$_GET["OBID"]."'>";
                }
                $out .= "</td></tr>\n";
                $i=1;
		while($row = $mdsDB->mysqlFetchArray($result))  {
                    $out .= "<tr><td  class='caption' width=10 style='width:20;'>";
                    if ($pview) $out .= $i;
                    $out .="</td><td class='caption' nowrap>".$row["Field"]."</td><td>".$this->renderInput($row["Type"],$row["PValue"],$row["DValue"],$i)."&nbsp;";
                    if ($pview) $out .="<a target='_self' href='home.php?page=preferences&mod=quest_flds_structNew&QUES_FLD_ST_ID=".$row[0]."'>Edit</a>";
                    $out .="</td><td></td></tr></tr>";    
                    $i++;
                }            
                $out .= "<tr><td colspan=4  align=center><br>";
                if ($pview) $out .= "<a target='_self' href='home.php?page=preferences&mod=quest_flds_structNew&QUES_ST_ID=".$this->getId()."'>Add an another field</a>";
                $out .= "</td></tr>\n";                
                if (!$pview)
                    $out .= "<tr><td></td><td></td><td colspan=3><input type='button' value='Save Questionnaire' onclick='saveData();' /><input type='button' value='Cancel' onclick=window.history.back(1); /></td></tr>\n";                
                $out .= "</table></form></div>\n";  
                
                
                   
	$out .= " <script language='javascript'>\n";
                $out .= " function saveData() {\n";
                $out .= " var fields = ''; \n";
                for ($f=1;$f < $i ;$f++ ){
                    $out .= " fields +=  $('#fld".$f."').val()+'||'; \n";
                }
                


                $data  = ' data:({';
                $data .= ' Type:"'.$this->getValue("Type").'", OBID:"'.$_GET["OBID"].'", Date:"'.date('Y-m-d').'", CreateDate:"'.date("Y-m-d H:i:s").'", Active:"1", CreateUser:"'.getLoggedUser().'", QUES_ST_ID:"'.$this->getid().'",';   
                $data .= ' FORM:"questionnaireForm"';
                $data .= ' }),';

                $out .=" var resM=$.ajax({ \n";
                           $out .= "url: 'include/data_save.php',\n";
                           $out .= "global: false,\n";
                           $out .= "type: 'POST',\n";
                           $out .= $data."\n";
                           $out .= "async:false\n";
                           $out .= "}).responseText;\n";
                           $out .= " eval(resM); \n";
                           $out .= " if ( !Error) { \n";
                               $out .= " var r = save_answer(res); \n";
                               $out .= " if ( r) { \n";
                                    $out .= " self.document.location='".$_GET["RETURN"]."'; \n";
                               $out .= "} else { $('#MDSError').html(res); }\n";
                           $out .= "} else { $('#MDSError').html(res); }\n";
                $out .=" }\n"; //function saveData
                
                $out .= " function save_answer(qid) {\n";
                    $out .= " var fields = ''; \n";
                    for ($f=1;$f < $i ;$f++ ){
                        $out .= " fields +=  $('#fld".$f."').val()+'||'; \n";
                    }
                    $data  = ' data:({';
                    $data .= ' QUES_ST_ID:"'.$this->getId().'",';   
                    $data .= ' QUES_ID:qid,';   
                    $data .= ' FLDS:fields';
                    $data .= ' }),';

                    
                    $out .=" var resM=$.ajax({ \n";
                           $out .= "url: 'include/questionnaire_save.php',\n";
                           $out .= "global: false,\n";
                           $out .= "type: 'POST',\n";
                           $out .= $data."\n";
                           $out .= "async:false\n";
                           $out .= "}).responseText;\n";
                    $out .="return 999;  }\n"; //function save_answer
                $out .="</script>\n"; 
                
                
                
                
                return $out;
        }
        
        private function loadForm(){
            $out = "";
            if ($_GET["PID"]) {
                $patient = new MDSPatient();
                $patient->openId($_GET["PID"]);
                $out .= $patient->patientBannerTiny(20);
            }
            $out .= $this->preview(false);
            return $out;
        }
        
        private function renderInput($type,$pvalue,$dvalue,$i){
            $out = "";
            if ($type == "text"){
                $out .="<input class='input' type='text' id='fld".$i."' ";
                $out .=" value='".$dvalue."'>";
            }
            else if($type == "remarks"){
                $out .="<textarea class='input' style='width:300;'  id='fld".$i."' >";
                $out .=$dvalue;
                $out .=" </textarea>";

            }
            else if($type == "select"){
                $pv = array();
                $pv=explode('||',chop($pvalue));
                $out .="<select class='input'  id='fld".$i."' >";
               $out .="<option value=''></option>"; 
                for ( $i = 0 ; $i < count($pv); ++$i) {
                    $out .="<option value='".$pv[$i]."' ";
                    if ($dvalue == $pv[$i]) $out .= " selected ";    
                    $out .=" >".$pv[$i]."</option>";
                    
                    //$out .=$dvalue;    
                }
                
                $out .=" </select>";

            }            
            else if($type == "yes-no"){
               $out .="<select class='input'  id='fld".$i."' >";
               $out .="<option value=''></option>"; 
                    $out .="<option value='yes' ";
                    if ($dvalue == "yes") $out .= " selected ";    
                    $out .=" >yes</option>";
                    $out .="<option value='no' ";
                    if ($dvalue == "no") $out .= " selected ";    
                    $out .=" >no</option>";
               $out .=" </select>";

            }              
            else {
                $out .="<input class='input' type='text'  id='fld".$i."' ";
                $out .=" value='".$dvalue."'>";
            
            }
            return $out;
        }
}

?>