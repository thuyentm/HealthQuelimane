<div id="registry_pop" style="display: none"></div>
<script type="text/javascript">
    function openRegistryOptions(){
        $( "#registry_pop" ).load('include/registry_options.php');
        $("#registry_pop").dialog({
            width:500,
            height:200,
            autoOpen:true,
            modal: true,
            resizable:false,
            position:'center',
            buttons:[{
                    text:'OK',
                    click:function(){
                        printPatientRegistry($("#from_k").val(),$("#to_k").val());
                        $(this).dialog("close");
                    }
                }],
            title:'Visit Statistics'
        });
    }
            
</script>
<?php

function loadSearchScreen($action) {
    loadHeader("Patient search");
    ?>
    <div id="container_k" style='margin-top:25px;'>
        <div id="left_k" class="basic">
            <?php
            include_once 'class/MDSLeftMenu.php';
            $mds_left_menu = new MDSLeftMenu();
            $mds_left_menu->renderSearchLeftMenu();
            ?>
        </div>
        <div id="content_k" >
            <table align='center' cellpadding='0' cellspacing='0' border='0' class='display' id='example'>
                <thead>
                    <tr>
                        <th width='10%'><?php echo getPrompt("ID"); ?></th>
                        <th width='0%'></th> 
                        <th style='width:300px'><?php echo getPrompt("Full Name"); ?></th>
                        <th style='width:300px'><?php echo getPrompt("Other Name"); ?></th> 
                        <th style='width:300px'><?php echo getPrompt("Date of birth"); ?></th>
                        <th style='width:300px'><?php echo getPrompt("Gender"); ?></th> 
                        <th style='width:300px'><?php echo getPrompt("Civil Status"); ?></th>
                        <th style='width:300px'><?php echo getPrompt("NIC"); ?></th> 
                        <th style='width:300px'><?php echo getPrompt("Village"); ?></th> 
                    </tr> 
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>


    <script language="javascript">
        oTable = $('#example').dataTable( {
                                        
            "aaSorting": [[1, 'desc']],
            "aoColumns": [ 
                { "bSearchable": true, "bVisible":    true },
                { "bSearchable": false, "bVisible":    false },
                { "bSearchable": true, "bVisible":    true },
                { "bSearchable": true, "bVisible":    true },
                { "bSearchable": false, "bVisible":    true },
                { "bSearchable": false, "bVisible":    true },
                { "bSearchable": false, "bVisible":    true },
                { "bSearchable": true, "bVisible":    true },
                { "bSearchable": false, "bVisible":    true }
            ], 
            "bProcessing": true,
            "bServerSide": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": "include/lookup/patient.php?FORM=patientForm"
        } );
                                                        
        $("#example tbody tr").live("mouseover", function(e){
            if (e.which !== 1) return;
            $(this).mouseover(function(){
                $(this).addClass("mds_state_hover");
            }).mouseout(function(){
                $(this).removeClass("mds_state_hover");
            });

        });
                                                        
        $("#example tbody tr").live("click", function(e){
            if (e.which !== 1) return;
            var aData = oTable.fnGetData( this );
            self.document.location='home.php?page=patient&PID='+aData[0]+'&action=View';
        });

    </script>
    <?php
}

function loadLookUpScreen($srch) {
    $out = "";
    $out .="<div id='mdsHead' class='mdshead'>" . $srch . " lookup</div>\n";
    $tbl = <<<'EOT'
   <div class="tablecont">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="70%">
        <thead> 
                <tr> 
                        <th width="10%">ID</th> 
                        <th width="25%">Village</th> 
                        <th width="25%">DS Division</th> 
                        <th width="25%">District</th> 
                </tr> 
        </thead > 
        <tbody > 
                <tr> 
                        <th width="10%">ID</th> 
                        <th width="25%">Village</th> 
                        <th width="25%">DS Division</th> 
            <th width="25%">District</th> 
                </tr>
        </tbody> 
</table> 
</div>
<script language="javascript">
                     var ihtml=$.ajax({
                                       url: "server_process.php",
                                       global: false,
                                       type: "POST",
                                       async:false
                                    }).responseText;
                     $('#example tbody').html(ihtml);
</script>

EOT;
    echo $out . $tbl;
}

function getDistricts($dDistrict) {
    $out = "";

    include 'config.php';
    $gaSql['user'] = USERNAME;
    $gaSql['password'] = PASSWORD;
    $gaSql['db'] = DB;
    $gaSql['server'] = HOST;


    $gaSql['link'] = mysql_pconnect($gaSql['server'], $gaSql['user'], $gaSql['password']) or
            die('Could not open connection to server');

    mysql_select_db($gaSql['db'], $gaSql['link']) or
            die('Could not select database ' . $gaSql['db']);

    $sql = "SELECT DistrictName ";
    $sql .= " FROM district ORDER BY DistrictName";
    $result = mysql_query($sql);
    if ($result) {
        $out .="<span class='cmb'>District : ";
        $out .="<select id = 'ds' onchange='getVillage()'>";
        $out .="<option >" . $dDistrict . "</option>";
        $i = 0;
        while ($aRow = mysql_fetch_array($result)) {
            $i++;
            if (strcmp($dDistrict, $aRow[0]) == -3) {
                $out .="<option  id='ds" . $i . "' value = " . $i . " selected>" . $aRow[0] . "</option>\n";
            } else {
                $out .="<option  id='ds" . $i . "' value = " . $i . " >" . $aRow[0] . "</option>\n";
            }
        }
        $out .="</select ></span>";
    }
    echo $out . "&nbsp;&nbsp;&nbsp;";
}

function getDSDivsions($dDistrict, $dDsdivision) {
    $out = "";

    include 'config.php';
    $gaSql['user'] = USERNAME;
    $gaSql['password'] = PASSWORD;
    $gaSql['db'] = DB;
    $gaSql['server'] = HOST;


    $gaSql['link'] = mysql_pconnect($gaSql['server'], $gaSql['user'], $gaSql['password']) or
            die('Could not open connection to server');

    mysql_select_db($gaSql['db'], $gaSql['link']) or
            die('Could not select database ' . $gaSql['db']);

    $sql = "SELECT DISTINCT DSDivision ";
    $sql .= " FROM village WHERE (Active = 1) AND (District = \"" . $dDistrict . "\")  ORDER BY DSDivision ";
    $result = mysql_query($sql);
    //$out .=$result.$sql;
    if ($result) {
        $out .="<span class='cmb'>DSDivision : ";
        $out .="<select id='dsd' onchange='getVillage();'>";
        $out .="<option ></option>";
        $i = 0;
        while ($aRow = mysql_fetch_array($result)) {
            $i++;
            if (strcmp($dDsdivision, $aRow[0]) == -3) {
                $out .="<option id='dsd" . $i . "' value = " . $i . " selected>" . $aRow[0] . "</option>\n";
            } else {
                $out .="<option id='dsd" . $i . "' value = " . $i . ">" . $aRow[0] . "</option>\n";
            }
        }
        $out .="</select ></span>";
    }
    echo $out . "&nbsp;&nbsp;&nbsp;";
}

function getGNDivisions($dDistrict, $dDsdivision) {
    $out = "";
    include 'config.php';
    $gaSql['user'] = USERNAME;
    $gaSql['password'] = PASSWORD;
    $gaSql['db'] = DB;
    $gaSql['server'] = HOST;


    $gaSql['link'] = mysql_pconnect($gaSql['server'], $gaSql['user'], $gaSql['password']) or
            die('Could not open connection to server');

    mysql_select_db($gaSql['db'], $gaSql['link']) or
            die('Could not select database ' . $gaSql['db']);

    $sql = "SELECT GNDivision,DSDivision,District ";
    $sql .= " FROM village WHERE (Active = 1) AND (DSDivision = \"" . $dDsdivision . "\") ORDER BY GNDivision";
    $result = mysql_query($sql);
    $out .="<div class='tablecont'>\n";
    $out .="<table align='center' cellpadding='0' cellspacing='0' border='0' class='display' id='example' width='70%'>\n";
    $out .="<thead> \n";
    $out .="<tr> \n";
    $out .="<th width='10%'>District</th> \n";
    $out .="<th width='25%'>DS Division</th> \n";
    $out .="<th width='25%'>Village</th> \n";
    $out .="</tr> \n";
    $out .="</thead> \n";
    $out .="<tbody> \n";


    if ($result) {
        $i = 0;
        while ($aRow = mysql_fetch_array($result)) {
            $i++;
            $aRow[0] = rtrim($aRow[0]);
            $aRow[1] = rtrim($aRow[1]);
            $aRow[2] = rtrim($aRow[2]);
            if ($i % 2 == 1) {
                $out .="<tr class='odd' style='cursor:pointer' onclick=\"villageSelect('" . $aRow[0] . "','" . $aRow[1] . "','" . $aRow[2] . "');\">";
            } else {
                $out .="<tr class='even' style='cursor:pointer' onclick=\"villageSelect('" . $aRow[0] . "','" . $aRow[1] . "','" . $aRow[2] . "');\">";
            }
            $out .="<td>" . $aRow[2] . "</td><td>" . $aRow[1] . "</td><td><b>" . $aRow[0] . "<b></td>";
            $out .="</tr>\n";
        }
    }
    $out .="</tbody> \n";
    $out .="</table> \n";
    $out .="</div>\n";
    echo $out . "&nbsp;&nbsp;&nbsp;";
}
?>