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

include_once 'class/MDSDataBase.php';
$mdsDB = MDSDataBase::GetInstance();
$mdsDB->connect();
$sql = 'select `Name` from user_group order by `Name`';
$result = $mdsDB->mysqlQuery($sql);
$count = $mdsDB->getRowsNum($result);
$html='';
$html.='<div class="caption" style="width:auto;color:#026890;font-size:1em;font-weight:bold;">Select User Group</div>';
$html.='<hr style="clear:both;border:1px solid #A6C9E2">';
$html.='<select class="input" id="UserGroupPrint" name="UserGroupPrint">';
while ($row = $mdsDB->mysqlFetchArray($result)){
    $html.=<<<HTML
   <option value="$row[0]">$row[0]</option>
HTML;
}
$html.='</select>';
echo $html;
?>