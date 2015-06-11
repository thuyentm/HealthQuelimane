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


include 'MDSDataBase.php';
include 'MDSUser.php';
	
class MDSMainMenu
{
	function load($mdsfoss){
			$mdsDB = MDSDataBase::GetInstance();
			$mdsDB->connect();
			$lang = $mdsfoss->Lang;
			$menuItems = "";
			$sql  = "SELECT Name, Link ";
			$sql .= " FROM user_menu WHERE Active = TRUE and UserGroup REGEXP '".$mdsfoss->UserGroup."'  " ;
			$sql .= " ORDER BY MenuOrder";
			$result=$mdsDB->mysqlQuery($sql);
			
			//$user = new MDSUser();
			//$user->openId($_SESSION["UID"]);
			$inboxsql = "SELECT * FROM messages WHERE to_user = '".$_SESSION["UID"]."' and Seen='No'";
			$resultinbox=$mdsDB->mysqlQuery($inboxsql);
			$inbox=mysql_num_rows($resultinbox);
						
							
			if (!$result) {echo "ERROR"; }
			
			while($row = $mdsDB->mysqlFetchArray($result))  {
							
				if ($row["Link"] == "home.php?page=".$mdsfoss->Page) {
					$menuItems .="<input type='button' class='menuBtnSelect'  value='".getPrompt($row["Name"])."' onmousedown=execute(String('".$row[Link]."'),this)>";
				 }
				else if($row["Name"] =='Messages' && $inbox>0){
				
					$menuItems .="<input type='button' id='BlnkBtn' class='BlnkBtn'  value='".getPrompt($row["Name"])."' onmousedown=execute(String('".$row[Link]."'),this)>";
									
				}
				 else {
                    $menuItems .="<input type='button' class='menuBtn'  value='".getPrompt($row["Name"])."' onmousedown=execute(String('".$row[Link]."'),this)>";
					
				 }
			}
			
			
            $menuItems .= "<img src='images/ecg.gif' width=30 height=25  valign=bottom />";
			$menu = "";
                        $menu .="<div id='header'> ";
                        $menu .= "<table border=0 width=100% cellspacing=0 style='margin-left:5px'>";
                        $menu .= "<tr>";
                        $menu .= "<td class='user' width=100px><span class='mds'><img src='images/hhims121.png' /></span></td>";
                        $menu .= "<td class='user' >";
                        $menu .= "<table border=0 width=100% cellspacing=0 >";
                        $menu .= "<tr>";
                        $menu .= "<td >";
			$menu .="<div class='menu'>";
			$menu .= $menuItems ;			
			$menu .="</div>";
                        $menu .= "</td >";
                        $menu .= "</tr>";
                        $menu .= "</table>";
                        $menu .= "</td>";
						$menu .= "<td class='user' valign=top align=right >";
						$icon  = "&nbsp;&nbsp;&nbsp;";
                        if ($_SESSION["BC"]==1){
                            $icon  .= "<span>";
                            //$icon  .= "<input id='bc' name='bc' style='width:10:height:10;'  type='text' autofocus=true />";
                            //$icon  .= "<img title='Barcode ready' src='images/bar_ready.gif'  valign=bottom ></span>"; 
                        }
                        $icon  .= "<img style='cursor:pointer;' title='Change language' src='images/language.png' width=20 height=20 valign=bottom onclick='changeLanguage(this.value,".$mdsfoss->Uid.")' >\n"; 
			$icon  .= "<img style='cursor:pointer;' title='Help' src='images/help1.png' width=20 height=20 valign=bottom onclick=openLocation('help/index.php') >\n";  
			$icon  .= "<img style='cursor:pointer;' title='Refresh' src='images/refresh.png' width=20 height=20 valign=bottom onclick=refreshContent(); >\n";  
			$icon  .= "<img style='cursor:pointer;' title='About MDSFoss' src='images/info.png' width=20 height=20 valign=bottom onclick=openLocation('about/index.php') >\n";  
                        $icon  .= "<img style='cursor:pointer;' title='Send suggestions / opinions / bugs' src='images/mail.png' width=20 height=20 valign=bottom onclick='loadMailer(\"".$mdsfoss->FullName."\",\"".$mdsfoss->UserGroup."\",\"".$mdsfoss->Hospital."\")' >\n"; 
                        
			$menu  .="<span style='padding-right:10px;'>".$icon ."</span>";
                        $menu .= "</td>";
                        $menu .= "</tr>";
                        $menu .= "</table>";
                        $menu .="</div>";
			$mdsDB->close();	
			echo $menu;
	}
}
?>
