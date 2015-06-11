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


include_once 'class/MDSWard.php';
include_once 'class/MDSLeftMenu.php';
function loadWardList(){
        $out ="";
        $header = loadHeader("Ward List");
        $ward = MDSWard::GetInstance();
        $l_menu = new MDSLeftMenu();
        $out .=$l_menu->renderLeftMenu("Ward",null);
        $out .=$ward->loadWardList();
        return $header.$out;
}

function loadWardFloorPlan(){
        if (!$_GET['WID']) return ;   
        $out ="";
        
        $ward = new MDSWard();
        $ward->openId($_GET['WID']);
        $l_menu = new MDSLeftMenu();
        $header = loadHeader($ward->getValue("Name")."( ".$ward->getValue("Type")." ) ");
        $out .=$l_menu->renderLeftMenu("WardPlan",$ward);       
        $out .=$ward->renderWardPlan();
        return $header.$out;
}
function loadWardPatient(){
        if (!$_GET['WID']) return ;   
        $out ="";
        
        $ward = new MDSWard();
        $ward->openId($_GET['WID']);
        $l_menu = new MDSLeftMenu();
        $header = loadHeader($ward->getValue("Name")."( ".$ward->getValue("Type")." ) ");
        $out .=$l_menu->renderLeftMenu("WardPlan",$ward);       
        $out .=$ward->renderWardPatient();
        return $header.$out;
}
?>
