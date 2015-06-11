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

$html = <<< HTML
<h3>Period:</h3>
<label for="from">From</label>
<input type="text" id="from_k" name="from" value="" disabled="true"/>
<label for="to">to</label>
<input type="text" id="to_k" name="to" value="" disabled="true"/>
<br/>
<!--        <h3>Fields:</h3>
        <ul id="options_list_k">
            <li>
                <label for="admission_c">Admission</label>
                <input type="checkbox" name="admission_c" checked="true" />
            </li>
            <li>
                <label for="opd_c">OPD</label>
                <input type="checkbox" name="opd_c" checked="true" />
            </li>
        </ul>-->
HTML;

$js=<<< JS
<script type="text/javascript">
    var dates = $( "#from_k, #to_k" ).datepicker({
        //                defaultDate: "+1w",
        changeMonth: true,
        changeYear:true,
        showButtonPanel:true,
        numberOfMonths: 1,
        dateFormat: 'yy-mm-dd',
        showOn: 'button',
        beforeShow:function(input,instance){
            var option = this.id == "from_k" ? "minDate" : "maxDate",
            date=dates.not( this ).datepicker( "getDate" );
        },
        onSelect: function( selectedDate ) {
            var option = this.id == "from_k" ? "minDate" : "maxDate",
            instance = $( this ).data( "datepicker" ),
            date = $.datepicker.parseDate(
            instance.settings.dateFormat ||
                $.datepicker._defaults.dateFormat,
            selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });
    var fromDate=new Date();
    var toDate=new Date();
    fromDate.setDate(1);
    $("#from_k").datepicker( "setDate" , fromDate);
    $("#to_k").datepicker( "setDate" , toDate );
    $("#from_k").datepicker( "option", "maxDate",toDate );
    $("#to_k").datepicker( "option", "minDate",  fromDate);
</script>
JS;
echo $html.$js;
?>