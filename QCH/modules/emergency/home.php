<?php
session_start();
if (!session_is_registered(username)) header("location:login.php");
if (!isset($_GET['page']))  header("location:index.php");
//echo '<script>history.replaceState({loc: "hhims"}, "hhims", "'.$_GET["page"].'");</script>';
//echo '<span id="loading" style="position:absolute;color:#0000FF	;">Loading....</span>';
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

//manifest="manifest.appcache"
?>
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>HHIMS</title>
        <link rel="icon" type="image/ico" href="images/mds-icon.png">
        <link rel="shortcut icon" href="images/mds-icon.png">
        <link href="css/mdstheme1.css" rel="stylesheet" type="text/css">
        <link href="css/jquery.alerts.css" rel="stylesheet" type="text/css">

        <link href="css/demo.css" rel="stylesheet" type="text/css">
        <link href="css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css">
        <link href="css/jquery.ui.datetimepicker.css" rel="stylesheet" type="text/css">
        
        <link href="css/mds_k.css" rel="stylesheet" type="text/css">
        <link href="css/layout_k.css" rel="stylesheet" type="text/css">
        
        <!-- styles for pager starts-->
        <link rel="stylesheet" type="text/css" media="screen" href="css/themes/ui.jqgrid.css" />
        <!-- styles for pager ends-->        
		
        <script type="text/javascript" src="js/jquery-1.4.2.js"></script>
        <script type="text/javascript" src="js/jquery.event.drag.min.js"></script>
        <script type="text/javascript" src="js/jquery.RightClik.js"></script>
        <script type="text/javascript" src="js/jquery.hotkeys-0.7.9.min.js"></script>
        <script type="text/javascript" src="js/jquery.UI.Min.js"></script>
        <script type="text/javascript" src="js/jquery.print.js"></script>
        <script type="text/javascript" src="js/chili-1.7.pack.js"></script> 
        <script type="text/javascript" src="js/jquery.accordion.js"></script> 
        <script type="text/javascript" src="js/jquery.alerts.js"></script> 
        <script type="text/javascript" src="js/jquery.cookie.js"></script> 
        <script type="text/javascript" src="js/jquery.ui.datetimepicker.min.js"></script>

        <script type="text/javascript" src="js/mdsCore.js"></script> 
        <script type="text/javascript" src="js/mdsmailer.js"></script> 
        <script type="text/javascript" src="js/prompt.js"></script> 
		<script type="text/javascript" src="js/sketch.js"></script> 
        <script type="text/javascript" src="js/jquery.text.js"></script> 
		
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script> 
        <script type="text/javascript" language="javascript" src="js/jquery.ui.datepicker.js"></script> 
        
<!--        scripts for pager starts-->
        <script src="js/jquery.layout.js" type="text/javascript"></script>
            <script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
            <script type="text/javascript">
                $.jgrid.no_legacy_api = true;
                $.jgrid.useJSON = true;
            </script>
            <script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>
            <script src="js/jquery.tablednd.js" type="text/javascript"></script>
            <script src="js/jquery.contextmenu.js" type="text/javascript"></script>
            <script src="js/ui.multiselect.js" type="text/javascript"></script>
<!--        scripts for pager ends-->
        <?php
            if ($_SESSION["BC"]==1){
                //echo '<script type="text/javascript" src="js/jquery.barcodelistener-1.1.js"></script>';
            }
        ?>
        <style type="text/css" title="currentStyle"> 
            @import "css/demo_page.css";
            @import "css/demo_table.css";
			.mybold td {font-weight : bold !important}
            th {font-weight:  normal;font-size: 12;}
        </style>   
        <script language="javascript"> 
            parent.window.onbeforeunload = 'void(0)';

		
            $(document).ready(function(){
				
				
				$("#loading").remove();
                //jQuery(document).bind('keydown', 'Ctrl+s',function (evt){evt.preventDefault( ); $('#SaveBtn').trigger('click'); return false;});
                //jQuery(document).bind('keydown', 'alt+s',function (evt){evt.preventDefault( );  $('#SaveBtn').trigger('click').click( function(){return true}); return false;});
                jQuery(document).bind('keydown', 'alt+n',function (evt){evt.preventDefault( ); self.document.location='home.php?page=patient&action=New'; return false;});
                jQuery(document).bind('keydown', 'alt+h',function (evt){evt.preventDefault( ); self.document.location='home.php'; return false;});
                jQuery(document).bind('keydown', 'Ctrl+f',function (evt){evt.preventDefault( ); getSearchText('patient'); return false;});
                jQuery(document).bind('keydown', 'Alt+f',function (evt){evt.preventDefault( ); getSearchText('patient'); return false;});
                $(document).keyup(function (e) {
                    if (( e.which == 13 )){
                       //$(this).next().text('ss'); 
                       //$(".input[pos='"+(parseInt($(this).attr('pos'))+1)+"']").first().focus();
                    }
					
                })
    
                $('INPUT[value=Home]').focus();
            char0 = new Array("§", "32");
            char1 = new Array("˜", "732");
            characters = new Array(char0, char1);
			//$(document).BarcodeListener(characters, function(code) {
            //});
            });
            function execute( st ) {
                self.document.location = st;
             }
			
			function canvas_save($pid,$date)
{       
    // converting the canvas to data URI
	var canvas  = document.getElementById("tools_sketch");
    var strImageData = canvas.toDataURL("image/png");  
	//var a=encodeURIComponent(strImageData);
	//alert(strImageData);
	//var dataUrl = canvas.toDataURL();
     
   $.ajax({
     
	    type :'POST',
    	url :'testSave.php',
    	dataType : 'json',
    	data:{
		
    		seid:strImageData,
			seid1:$pid,
			seid2:$date
    	 },
	 
        success: function(data)
        {
         
		
			
        }
    });  
	
}

			function canvas_save1($pid,$date)
{       
    // converting the canvas to data URI
	var canvas  = document.getElementById("tools_sketch");
    var strImageData = canvas.toDataURL("image/png");  
	//var a=encodeURIComponent(strImageData);
	//alert(strImageData);
	//var dataUrl = canvas.toDataURL();
     
   $.ajax({
     
	    type :'POST',
    	url :'testSave1.php',
    	dataType : 'json',
    	data:{
		
    		seid:strImageData,
			seid1:$pid,
			seid2:$date
    	 },
	 
        success: function(data)
        {
         
		
			
        }
    });  
	
}

			function canvas_save2($pid,$date)
{       
    // converting the canvas to data URI
	var canvas  = document.getElementById("tools_sketch");
    var strImageData = canvas.toDataURL("image/png");  
	//var a=encodeURIComponent(strImageData);
	//alert(strImageData);
	//var dataUrl = canvas.toDataURL();
     
   $.ajax({
     
	    type :'POST',
    	url :'testSave2.php',
    	dataType : 'json',
    	data:{
		
    		seid:strImageData,
			seid1:$pid,
			seid2:$date
    	 },
	 
        success: function(data)
        {
         
		
			
        }
    });  
	
}


        </script> 
    </head>
    <body oncontextmenu="return false; " >
	<article role="main">
        <?php
			include 'include/mdsCore.php';
			include 'include/class/MDSFoss.php';
            $MDSFoss = new MDSFoss();
	//echo "g";
	//echo "      ";
	//echo $_GET['page'];

            $MDSFoss->loadMDS($_GET['page'], $_GET['action']);
        ?>
		</article> 
    </body>
</html>
