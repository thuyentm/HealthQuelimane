//  ------------------------------------------------------------------------ //
//                   MDSFoss - Free Patient Record System                    //
//            Copyright (c) 2011 Net Com Technologies (Sri Lanka)            //
//                        <http://www.mdsfoss.org/>                          //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation.                                            //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even an implied warranty of            //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to:                               //
//  Free Software  MDSFoss                                                   //
//  C/- Net Com Technologies,                                                //
//  15B Fullerton Estate II,                                                 //
//  Gamagoda, Kalutara, Sri Lanka                                            //
//  ------------------------------------------------------------------------ //
//  Author: Mr. Thurairajasingam Senthilruban   TSRuban[AT]mdsfoss.org       //
//  Consultant: Dr. Denham Pole                 DrPole[AT]gmail.com          //
//  URL: http://www.mdsfoss.org                                              //
// ------------------------------------------------------------------------- //
function openSearch(ops, rId) {
    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700"
    if (ops == "Village") {
        var url = "lookup_village.php";
    }
    var lookUpW = window.open("include/lookup/" + url + "", "lookUpW", params);
}
function setCookie(vType, value) {
    document.cookie = vType + "=" + value;
}
function printView(d1) {
    $('#' + d1 + "").hide();
    $('#report_cont').css({
        'top' : '10px'
    });
    $('#report_cont').printElement({
        styleToAdd : 'padding:10px;margin:10px;color:#FFFFFF !important;'
    });
    $('#' + d1 + '').show();
}
function normalView(d1) {
    $('#' + d1 + '').show();
// $('#report_cont').css({left:'200px'});

}

$(function () {

    blinking($(".BlnkBtn"));

})($);

function blinking(elm) {
    timer = setInterval(blink, 500);
    blink();

    function blink() {
        elm.fadeOut(250, function () {
            elm.fadeIn(250);
        });
    }
}

function getCookie(c_name) {
    var i, x, y, ARRcookies = document.cookie.split(";");
    for (i = 0; i < ARRcookies.length; i++) {
        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
        x = x.replace(/^\s+|\s+$/g, "");
        if (x == c_name) {
            return unescape(y);
        }
    }
}
function changePassword(uid) {
    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=500,height=200"
    var url = "cpwd.php?UID=" + uid;
    var pwdW = window.open("include/" + url + "", "pwdW1", params);
}
function popup(link) {
    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=500,height=200"
    var url = link;
    var pwdW = window.open(url, "pwdW1", params);
}
function qbillPopup(link,w,h) {
    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width="+w+",height="+h
    var url = link;
    window.open(url, "qbill"+Math.random(), params);
}
function qopen(link) {
    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=600,height=700"
    var url = link;
    var pwdW = window.open(url, "pwdW1", params);
}
function confirmClose() {
    var r = confirm("Do you want to lose the changes you made?");
    if (r == true) {
        window.close();
    }
}
function updateComplaint(comp, el_id) {
    $("#" + el_id).val($(comp).val());
}

function getCannedText(obj) {
    var remarks_text = String($(obj).val());
    var srh_text = "";
    if (remarks_text[String(remarks_text).length - 1] == " ") {
        if (remarks_text.indexOf("\\") >= 0) {
            srh_text = remarks_text.substr(remarks_text.indexOf("\\") + 1,
                remarks_text.indexOf(" "));
            loadCannedText(srh_text, obj);
        }
    }
}

function loadCannedText(srh, obj) {
    var ihtml = $.ajax({
        url : "include/lookup/cannedtext.php?SRH=" + srh + "",
        global : false,
        type : "POST",
        async : false
    }).responseText;
    if (ihtml.length > 1) {
        canned_text = ihtml.substr(1, ihtml.length)
        $(obj).val($(obj).val().replace('\\' + srh, String(canned_text)));
    }

}

function DrugsReady(prsid) {
   // alert (prsid);
	
		$.ajax({        
		type :'POST',
    	url: 'updatepharmacy.php',
    	dataType : 'json',
    	data:{		
    		id:prsid
    	 },
        success: function(){
			
             alert('Drugs are Ready');
			 
        }
    });

}

function fileUpLoad(){
	
	$.getScript('js/ajaxfileupload.js', function(data, textStatus){
		
		if (textStatus == 'success'){
			
			$('#loading')
			.ajaxStart(function(){
				$(this).show();
			})
			.ajaxComplete(function(){
				$(this).hide();
			});
			
			
			$.ajaxFileUpload
			(  
				{
					url:"include/attachment_save.php",
					secureuri:false,
					type: "POST",
					fileElementId:'fileToUpload',
					type: "POST",
					async: false,
										
					data: {		Attach_Type: $('#Attach_Type').val(), 
								Attach_To: $('#Attach_To').val(),
								Attached_By: $('#Attached_By').val(),
								Attach_Description: $('#Attach_Description').val(),
								PID: $('#PID').val(),
								EPISODE: $('#EPISODE').val(),
								Active: $('#Active').val()	
							},						
					success: function (data, textStatus){
						
						
							if(typeof(data.error) != 'undefined'){
							if(data.error != ''){
								alert(data.error);
							}else{
							
								alert(data.msg);
								self.document.location=$('#Continue').val();
							}
						} 
						
						self.document.location=$('#Continue').val();
					},
					error: function (data, status, e){
						alert(e.message);
						//alert(status+" "+e);
					}
				}
			)
			return false;
		
		}	 
   });
}

function SendMessage(){
	
	var file=$('#fileToUpload').val();
	
	if (file == 0) {
	
		saveData();
	
	}
	else{
	
	saveData();
	AthfileUpLoad();

}
			
		
	 	 
  
}


function AthfileUpLoad(){
	
		$.getScript('js/ajaxfileupload.js', function(data, textStatus){
		
		if (textStatus == 'success'){
			
			$('#loading')
			.ajaxStart(function(){
				$(this).show();
			})
			.ajaxComplete(function(){
				$(this).hide();
			});
			
			
			$.ajaxFileUpload
			(  
				{
					url:"include/Message_Save.php",
					secureuri:false,
					fileElementId:'fileToUpload',
					type: "POST",
					async: false,
										
					data: {		From_User: $('#from_user').val(), 
					            Attach_Type: $('#Attach_Type').val(),
								To_User: $('#to_user').val()	
							},						
					success: function (data){
						
						alert("Message Sent");
						window.location.href="home.php?page=message";
						
					}
				
				}
			)
			
		
		}	 
   });
}
	



function updateICD(code, text, code_container, text_container) {

    var ctext = String(text_container);
    var ccode = ctext.replace("Text", "Code")
    $("#" + ccode).val(code);
    $("#" + text_container).val(text);
    closeICDDialog("");
    $("#icdDiv").dialog("destroy");
    //if ($("#IMMR_Code")) {
        data = getIMMRForICD(code);
        if (data) {
            var immr = String(data).split("|||");
            $("#"+ccode.replace("ICD", "IMMR")).val(immr[0]);
            $("#"+ctext.replace("ICD", "IMMR")).val(immr[0] + ": " + immr[1]);
        }
    //}
}
function updateSNOMEDOnly(code, text, text_container, icd_code, icd_text) {

    var ctext = String(text_container);
    var ccode = ctext.replace("Text", "Code")
    $("#" + ccode).val(code);
    $("#" + text_container).val(text);
    $("#snomedDiv").dialog("destroy");
// getICDForSnomed(code);
// updateICD(icd_code,icd_text,'ICD_Text','ICD_Text');
}
function updateSNOMED(code, text, text_container, icd_code, icd_text) {

    var ctext = String(text_container);
    var ccode = ctext.replace("Text", "Code")
    $("#" + ccode).val(code);
    $("#" + text_container).val(text);
    $("#snomedDiv").dialog("destroy");
    // getICDForSnomed(code);
    if (text_container == "Discharge_SNOMED_Text"){
        updateICD(icd_code, icd_text, 'Discharge_ICD_Text', 'Discharge_ICD_Text');
    }
    else{
        updateICD(icd_code, icd_text, 'ICD_Text', 'ICD_Text');
    }
}
function getICDForSnomed(code) {
    var icd = $.ajax({
        url : "include/lookup/lookup_icdlink.php?SNOMEDCODE=" + code + "",
        global : false,
        type : "POST",
        async : false
    }).responseText;

    if (icd != "") {
        if (icd[0] == "#")
            return;
        lookUpICD('', '', 'ICD_Text', icd);
        $("#SNOMEDmap").val(icd);
    }

}
function updatePermission(obj, cbox) {
    var permission = "{";
    $("input:checkbox").each(function(i) {
        var tble = $(this).val();
        var mod = $(this).attr("mod");
        var access = $(this).attr("checked");
        permission += '"' + tble + '_' + mod + '":' + access + ','
    // {"patient_Print": true}
    })
    permission += '"test":false}';
    $("#" + obj).val(permission);
}
function printReport(id, type) {
    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700"
    var url = "";
    if (type == 'PatientSlip') {
        url = "patient_slip.php?PID=" + id;
    } else if (type == 'PatientCard') {
        url = "patient_cards.php?PID=" + id;
    } else if (type == 'PatientHistory') {
        url = "patient_history.php?PID=" + id;
    } else if (type == 'OpdPrescription') {
        url = "opd_prescription.php?OPD=" + id;
    } else if (type == 'OpdInfo') {
        url = "opd_info.php?OPD=" + id;
    } else if (type == 'OpdLabTest') {
        url = "opd_diagnostic_tests.php?OPD=" + id;
    } else if (type == 'bht') {
        url = "admission_bht.php?ADMID=" + id;
    } else if (type == 'AdmDischargeTicket') {
        url = "discharge_ticket.php?ADMID=" + id;
    } else if (type == 'AdmTransfer') {
        url = "admission_transfer.php?ADMID=" + id;
    } else if (type == 'notification') {
        url = "notification.php?NOTIFICATION_ID=" + id;
    } else if (type == 'VisitInfo') {
        url = "opd_visit_info.php?OPD=" + id;
    } else if (type == 'patient_statistics') {
        from = arguments[2];
        to = arguments[3];
        url = "patient_registry.php?from=" + from + "&to=" + to;
    }else if (type == 'hospital_indicator') {
        from = arguments[2];
        to = arguments[3];
        url = "hospital_indicator.php?from=" + from + "&to=" + to;
    }
	else if (type == 'opd_prescriptions') {
        from = arguments[2];
        to = arguments[3];
        url = "clinical_prescriptions.php?from=" + from + "&to=" + to;
    } else if (type == 'lab_tests') {
        from = arguments[2];
        to = arguments[3];
        url = "labtests.php?from=" + from + "&to=" + to;
    } else if (type == 'opd_drug_statistics') {
        from = arguments[2];
        to = arguments[3];
        url = "drug_statistics.php?from=" + from + "&to=" + to;
    } else if (type == 'VisitSummery') {
        url = "visit_summery.php?PID=" + id;
    } else if (type == 'visits') {
        url = "daily_visits.php?date=" + id;
    } else if (type == 'clinics') {
        url = "daily_clinics.php?date=" + id;
    } else if (type == 'admissions') {
        url = "daily_admissions.php?date=" + id;
    } else if (type == 'discharges') {
        url = "daily_discharges.php?date=" + id;
    } else if (type == 'drugsdispensed') {
        url = "pharmacy_balance.php?fdate=" + id;
    } else if (type == "permissions") {
        gid = arguments[4];
        url = "permissions.php?gid=" + gid;
    } else if (type == "visit_complaints_treated") {
        from = arguments[2];
        to = arguments[3];
        visitType = arguments[4];
        sortBy = arguments[5];
        url = "visit_complaints_treated.php?from=" + from + "&to=" + to
        + "&vtype=" + visitType + "&sort=" + sortBy;
    } else if (type == "PatientSummery") {
        pid = arguments[2];
        url = "admission_summary.php?ADMID=" + id + "&PID=" + pid;
    }

    var lookUpW = window.open("include/form_templates/" + url + "", "lookUpW",
        params)
}
/**
 * Open pager out put in a new window as pdf document.
 * 
 * @arguments Object params parameter to pass to report
 * @return void
 */
function printPager(params) {
    var args = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700";
    var url = "include/form_templates/" + params.report + '.php';
    var reportWindow = window.open('', 'Print Pager', args);
    with (reportWindow.document) {
        write("<form id='data_form' method='POST' action='" + url
            + "' enctype='application/x-www-form-urlencoded' hidden>");
        for (param in params) {
            write("<input type='text' name='" + param + "' value='"
                + params[param] + "' />");
        }
        write("</form>");
        getElementById("data_form").submit();
        }
}
/**
 * @auguments string id,string title,string type
 * @return void
 */
function openDialogBox(id, title, type) {
    $('<div id=' + id + '></div>').appendTo('body');
    url = arguments[3];
    if (url) {
        $("#" + id).load(url);
    } else {
        $("#" + id).load('include/date_range_selector.php');
    }
    var w = 0;
    var h = 0;
    var printCall = function() {
    }
    switch (type) {
        case 'permissions':
            printCall = function() {
                printReport(id, type, $("#from_k").val(), $("#to_k").val(), $(
                    "#UserGroupPrint").val());
            }
            break;
        case 'midnight_census':
            w = 500;
            h = 175;
            printCall = function() {
                printReport(id, type, $("#from_k").val(), $("#to_k").val(),
                    arguments[3]);
            }
            break;
        case 'lab_tests':
            w = 500;
            h = 175;
            printCall = function() {
                printReport(id, type, $("#from_k").val(), $("#to_k").val());
            }
            break;
        case 'visit_complaints_treated':
            w = 700;
            h = 175;
            printCall = function() {
                printReport(id, type, $("#from_k").val(), $("#to_k").val(), $(
                    "#VisitTypePrint").val(), $(
                    'input:radio[name=visit_order]:checked').val());
            }
            break;
        default:
            w = 500;
            h = 175;
            printCall = function() {
                printReport(id, type, $("#from_k").val(), $("#to_k").val());
            }
            break;
    }

    $("#" + id).dialog({
        width : w,
        height : h,
        autoOpen : true,
        modal : true,
        resizable : false,
        position : 'center',
        buttons : [ {
            text : 'Generate',
            click : function() {
                printCall();
                $(this).dialog("close");
                $("#" + id).remove();
            }
        }, {
            text : 'Cancel',
            click : function() {
                $(this).dialog("close");
                $("#" + id).remove();
            }
        } ],
        title : title
    });
}

function printLabTest(opdid) {
    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700";
    var dep = arguments[1];
    var url ='';
    switch (dep) {
        case 'OPD':
            url = "opd_labresults.php?OPD=" + opdid;
            break;
        case 'ADMIN':
            url = "admission_labresults.php?OPD=" + opdid;
            break;
        default:
            url = "opd_diagnostic_tests.php?OPD=" + opdid;
            break;
    }

    var lookUpW = window.open("include/form_templates/" + url + "", "lookUpW",
        params)
}
function openLocation(loc) {
    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700"
    var url = loc;
    var locW = window.open(loc, "locW", params);
}
function refreshContent() {
    location.reload();
}
function printTable(table, sort_field) {
    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700";
    search = $('#example_filter input:text').val();
    // alert(search);
    var url = "print_table.php?TABLE=" + table + "&SORTBY=" + sort_field
    + "&SEARCH=" + search;
    var lookUpW = window.open("include/form_templates/" + url + "", "lookUpW",
        params);
}
function clearForm() {
    $('.input').val("");
}
function getVillage() {
    var ds = String($('#ds' + $('#ds').val()).text()).replace(/\s+$/, '');

    var dsd = String($('#dsd' + $('#dsd').val()).text()).replace(/\s+$/, '');
    self.document.location = 'lookup_village.php?DISTRICT=' + ds
    + '&DSDIVISION=' + dsd;
}
function villageUpdate(v, dsd, ds) {
    $('#Address_Village').val(v);
    $('#Address_DSDivision').val(dsd);
    $('#Address_District').val(ds);
}
function changeLanguage(ln, uid) {
    /*
	 * $('.Caption').each(function(index) { var txt=$(this).text() try{
	 * $(this).text(prompt[txt][ln]); } catch(e) {}; });
	 */
    // alert(prompt["* First Name"]["EN"]);
    execute('home.php?page=preferences&mod=Lang&Lang=' + ln + '&UID=' + uid);

}

function loadDataTable(mod, tab) {
	
    execute('home.php?page=preferences&mod=' + mod + tab);
    //window.location.hash = tab;
}

function loadNewMessage(mod, tab) {
	
	
   execute('home.php?page=messagelist&mod=' + mod + tab);
    //window.location.hash = tab;
}


function reDirect(page, params) {
    execute('home.php?page=' + page + '&' + params + '');
}

function addFields(qid) {

    execute('home.php?page=preferences&mod=quest_flds_structNew&QUES_ST_ID=');
    + qid + '';
}

function previewQuestionnaire(qid) {

    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width="
    + screen.width + ",height=700"
    var url = 'home.php?page=questionnaire&mod=preview&QUES_ST_ID=' + qid + '';
    var lookUpW = window.open(url, "Questionnaire", params);

}
function getInfo(tbl, id) {

    var ihtml = $.ajax({
        url : "include/info.php?tbl=" + tbl + "&id=" + id + "",
        global : false,
        type : "POST",
        async : false
    }).responseText;
    jAlert(ihtml, 'Detail');
}
function getYear(str) {
    var y = String(str).replace(/ /g, "");
    var ry = /(\d{1,2})\y/;
    var p = y.match(ry);
    if (p == null) {
        y += y + "y";
        p = y.match(ry);
    }
    if (p[1]) {
        return p[1];
    } else {
        return 0;
    }
};
function changeOver(tr) {
    $(tr).css({
        'background' : '#edfcde',
        'cursor' : 'pointer',
        'border-bottom' : '1px solid #000000'
    });
}
function changeOut(tr) {
    $(tr).css({
        'background' : '#FCFCDA',
        'cursor' : 'default'
    });
}
function updateDateTime(cont) {
    $("#" + cont).val(
        $("#dd").val() + " " + $("#hh").val() + ":" + $("#mm").val());
}
function openOPDDialog(OPDID) {
    // $( "#dialog:ui-dialog" ).dialog( "destroy" );

    var ihtml = $.ajax({
        url : "include/dialog_form.php?page=opd&OPDID=" + OPDID + "",
        global : false,
        type : "POST",
        async : false
    }).responseText;
    $("#opdDialog").html(ihtml);
    $("#opdDialog").dialog({
        height : 400,
        height : 500,
        modal : true,
        position : 'center',
        autoOpen : true
    });
}
function callAjax(f, arg, ocont) {
    var ihtml = $.ajax({
        url : "include/php_ajax.php?f=" + f + "&arg=" + arg + "",
        global : false,
        type : "GET",
        async : false
    }).responseText;
    $("#" + ocont).html(ihtml);
}

function SaveMessage(){
   
var to_user = $("#to_user").val();
var subject = $("#subject").val();
var message = $("#message").val();
var from_user = $("#from_user").val();
var deleted = $("#deleted").val();
var sent_deleted = $("#sent_deleted").val();
var read = $("#Read").val();
var message_date = $("#message_date").val();


	
  $.ajax({
     
	    type :'POST',
    	url :'MessageSave.php',
    	dataType : 'json',
    	data:{
			to_user:to_user,
			subject:subject,
			message:message,
			from_user:from_user,
			deleted:deleted,
			sent_deleted:sent_deleted,
			read:read,
			message_date:message_date
		
    		    	 },
	 
        success: function(data)
        {
         
		
			
        }
    }); 


}

function getBHT(f, arg, ocont) {
    var ihtml = $.ajax({
        url : "include/php_ajax.php?f=" + f + "&arg=" + arg + "&bht="
        + $("#BHT").val() + "",
        global : false,
        type : "GET",
        async : false
    }).responseText;
    $("#" + ocont).val(ihtml);
}
function makeItMainAjax(id, admid) {
    var ihtml = $.ajax({
        url : "include/php_ajax.php?f=makeItMain&arg=" + id + "&admid=" + admid
        + "",
        global : false,
        type : "GET",
        async : false
    }).responseText;
    eval(ihtml);
    if (!Error) {
        window.location.reload();
    }

}
function deleteObjectAjax(table, id, value, next) {
    var ihtml = $.ajax({
        url : "include/php_ajax.php?f=deleteObject&arg=" + id + "&table="
        + table + "&value=" + value + "",
        global : false,
        type : "GET",
        async : false
    }).responseText;
    eval(ihtml);
    if (!Error) {
        if (next == "")
            window.location.reload();
        else
            self.document.location = next;

    }
// $( "#"+ocont ).html(ihtml);
}

function checkNIC(nic) {
    var reg = /^(\d\d\d\d\d\d\d\d\d)[xXvV]$/;
    if (String(nic).match(reg)) {
        return true;
    }
    return false;
}
function checkAge(obj) {
    var reg = /[A-Za-z]/;
    if (String(obj.value).match(reg)) {
        obj.value = '';
    } else {
        if (parseInt(obj.value) > 111) {
            obj.value = '';
        }
    }
}
function checkMonth(obj) {
    var reg = /[A-Za-z]/;
    if (String(obj.value).match(reg)) {
        obj.value = '';
    } else {
        if (parseInt(obj.value) > 11) {
            obj.value = '';
        }
    }
}
function checkDay(obj) {
    var reg = /[A-Za-z]/;
    if (String(obj.value).match(reg)) {
        obj.value = '';
    } else {
        if (parseInt(obj.value) > 30) {
            obj.value = '';
        }
    }
}
function checkDay(obj) {
    var reg = /[A-Za-z]/;
    if (String(obj.value).match(reg)) {
        obj.value = '';
    } else {
        if (parseInt(obj.value) > 30) {
            obj.value = '';
        }
    }
}
function checkNumber(obj) {
    var reg = /[A-Za-z \<\>\'\"\:\;\|\{\}\[\]\,]/;
    if (String(obj.value).match(reg)) {
        obj.value = '';
    }
}
function cleanText(obj){
    var reg = /[\<\>\.\'\"\:\;\|\{\}\[\]\,\=\+\-\_\!\~\`\(\)\$\#\@\^\&\,\d\\/\\?]/;
    if (String($(obj).val()).match(reg)) {
        $(obj).val($(obj).val().replace(reg,''));
    }
    return $(obj).val();
}
function ajaxLookUp(obj){
    var txt = "";
    var key = cleanText(obj);

    if (key =='') return false;
    if (key.length <3)return false;
    $.ajax({
        url : "include/lookup/ajaxlookup_patient.php",
        data :({ "Full_Name_Registered" : key }),
        global : false,
        type : "POST",
        async : true,
        success: function( data ){
            eval(data);
            if (PATdata.patient.length >0){
                    $('#ajax_lookup').remove();
                    $('body').append("<div id='ajax_lookup' class='ajax_lookup' ></div>");
                    var head = "<div class='patient_check_head_cont'><span class='patient_check_head'>Similar patients</span></div>";
                    var content = "<div class='patient_check_cont'>";
                    for ( var p = 0; p < PATdata.patient.length; p++ ){
                        content += "<div style='font-family:Arial;font-size:10px;'>";
                        content += "<a href='home.php?page=patient&action=Edit&PID="+PATdata.patient[p].PID+"'>";
                        content += "<b>"+PATdata.patient[p].Personal_Title+" "+PATdata.patient[p].Personal_Used_Name+" "+PATdata.patient[p].Full_Name_Registered+"</b><br>";
                        content += ""+PATdata.patient[p].Gender+"/"+PATdata.patient[p].DateOfBirth+"/"+PATdata.patient[p].Address_Village+"";
                        content += "</a>";
                        content += "</div><hr>";
                    }
                     content += "</div>";
                    $('#ajax_lookup').html(head + content);                
            }
            else{
                closeList("ajax_lookup");
            }
        }
    }).responseText;

    return true;    
}

function checkBeforeSave(data) {
    var txt = "";
    var nic = String(data.data.NIC).split(" ").join('');
    if (nic != "") {
        if (!checkNIC(nic)) {
            alert("NIC Format error");
            return;
        }
    } else {
        return;
    }

    txt += $.ajax({
        url : "include/lookup/lookup_patient.php?fn="
        + data.data.Full_Name_Registered + "&pun="
        + data.data["Personal_Used_Name"] + "&g=" + data.data.Gender
        + "&age=" + data.data.Age + "&v=" + data.data.Address_Village
        + "&nic=" + nic + "",
        global : false,
        type : "POST",
        async : true
    }).responseText;

    if (txt == "")
        return false;

    $('#patient_check').remove();
    $('body').append("<div id='patient_check' class='patient_check' ></div>");
    var head = "<div class='patient_check_head_cont'><span class='patient_check_head'>Similar patients</span><span class='patient_check_head_close' onclick=closeList('patient_check')>Back</span></div>";

    var content = "<div class='patient_check_cont'><div style='text-align:center;padding:2px;'><input type='button'  class='submit' value='&lt;&lt; Save anyway &gt;&gt;' onclick=saveData('New')></div>"
    + txt + "</div>";
    $('#patient_check').html(head + content);
    return true;
}
function closeList(obj) {
    $('#' + obj + '').remove();
}
function activeBtn(pid, id) {
    var btns = "";
    btns += "<input type='button'  class='submit' value='Edit' onmousedown=reDirect('patient','PID="
    + pid + "&action=Edit')>";
    btns += "<input type='button'  class='submit' value='Give a visit' onmousedown=reDirect('opd','PID="
    + pid + "&action=New')>";
    btns += "<input type='button'  class='submit' value='Admit' onmousedown=reDirect('admission','PID="
    + pid + "&action=New')>";
    // btns += "<input type='button' class='submit' value='Edit'
    // onmousedown=reDirect('patient','PID="+pid+"&action=Edit')>";

    $('.patient_check_btn').html("");
    $('#patient_check_btn' + id + '').html(btns);

}
function inactiveBtn(id) {
// $('#patient_check_btn'+id+'').html("");
}
function closeOPDDialog(el) {
    $("#complaintDiv").dialog('close');

}
function closeICDDialog(el) {
    $("#icdDiv").dialog('close');

}
function lookUpComplaints(el_id, type) {
    // $( "#dialog:ui-dialog" ).dialog( "destroy" );

    var ihtml = $.ajax({
        url : "include/lookup/lookup_complaints.php?ELID=" + el_id + "&TYPE="
        + type + "",
        global : false,
        type : "POST",
        async : false
    }).responseText;
    $("#complaintDiv").html(ihtml);
    $("#complaintDiv").dialog({
        autoOpen : true,
        width : 500,
        height : 500,
        modal : true,
        position : 'right'
    });
}

function lookUpICD(el_id, type, text_container, srch_text) {
    // $( "#dialog:ui-dialog" ).dialog( "destroy" );
    var ihtml = $.ajax({
        url : "include/lookup/lookup_icd.php?ELID=" + el_id + "&TYPE=" + type
        + "&TEXT=" + text_container + "&SRCH=" + srch_text + "",
        global : false,
        type : "POST",
        async : false
    }).responseText;
    $("#icdDiv").html(ihtml);
    $("#icdDiv").dialog({
        autoOpen : true,
        width : 700,
        height : 700,
        modal : true,
        position : 'right'
    });
    $("#example_filter input:text").focus();
}

function lookUpSNOMED(el_id, type, txt) {
    // $( "#dialog:ui-dialog" ).dialog( "destroy" );

    var ihtml = $.ajax({
        url : "include/lookup/lookup_snomed.php?ELID=" + el_id + "&TYPE="
        + type + "&txt=" + txt + "",
        global : false,
        type : "POST",
        async : false
    }).responseText;
    $("#snomedDiv").html(ihtml);
    $("#snomedDiv").dialog({
        autoOpen : true,
        width : 700,
        height : 700,
        modal : true,
        position : 'right'
    });
    $("#example1_filter input:text").focus();
}
function getIMMRForICD(code) {
    var ihtml = $.ajax({
        url : "include/lookup/lookup_immr.php?ICD=" + code + "",
        global : false,
        type : "POST",
        async : false
    }).responseText;
    return ihtml;
}

function getMonth(str) {
    var m = String(str).replace(/ /g, "");
    var rm = /(\d{1,2})\m/;
    var p = m.match(rm);
    if (p != null) {
        return p[1];
    }
};
function setDefault(obj) {
    dd = String($("#" + obj + " option:selected").attr('dosage'));
    df = String($("#" + obj + " option:selected").attr('fre'));
    $("#Dosage").val(dd).attr('selected', true);
    $("#Frequency").val(df).attr('selected', true);
}

function DisableDrugList() {
   $(".inputdruglist").attr('disabled', true);
}

function DisableFavDrugList() {
   $(".inputfavdruglist").attr('disabled', true);
}

function validate1(y, m, d, type) {
    if (y == "") {
        y = 0;
    }
    if (m == "") {
        m = 0;
    }
    if (d == "") {
        d = 0;
    }
    // alert(y+","+m);
    if ((y == 0) && (m == 0) && (d == 0)) {
        return -1;
    }

    var years = parseInt(y);
    var months = parseInt(m);
    var days = parseInt(d);
    var today = new Date();
    var dob_y = today.getFullYear();
    var dob_m = today.getMonth() + 1;
    var dob_d = today.getDate();

    if (days > 0) {
        var diffday = dob_d - days;
        if (diffday > 0) {
            dob_d = diffday;
        } else {
            dob_m = dob_m - 1;
            dob_d = 30 + diffday;
        }
    }
    if (months > 0) {
        var diffmonth = dob_m - months;
        if (diffmonth > 0) {
            dob_m = diffmonth;
        } else {
            dob_y = dob_y - 1;
            dob_m = 12 + diffmonth;
        }
    // dob_d=1;
    }
    if ((years > 0) && (months == 0) && (days == 0)) {
        var diffyear = dob_y - years;
        dob_m = 1;
        dob_d = 1;
        dob_y = diffyear;
        if (dob_m < 10) {
            dob_m = "0" + dob_m;
        }
        if (dob_d < 10) {
            dob_d = "0" + dob_d;
        }
        return String(dob_y + "-" + dob_m + "-" + dob_d);
    }
    if (years > 0) {
        var diffyear = dob_y - years;
        dob_y = diffyear;
    }
    if (dob_m < 10) {
        dob_m = "0" + dob_m;
    }
    if (dob_d < 10) {
        dob_d = "0" + dob_d;
    }
    return String(dob_y + "-" + dob_m + "-" + dob_d);

}
function getSearchText(tbl) {
    $('#stextwin').remove();
    $(
        '<div id="stextwin" title="MDS Search" style="background-color:#f9dfbc;"></div>')
    .appendTo('body');
    var html = "";
    html += "<input class='input' placeholder='Eg.4453' type='text' autofocus id='stext' onkeyup=checkSearchText(event,this,'"
    + tbl + "');>";
    html += "<div id='errmsg' >Type Patient ID and hit ENTER</div>";
    $("#stextwin").html(html);
    $("#stextwin").dialog({
        width : 250,
        height : 100,
        autoOpen : true,
        resizable : false,
        position : 'center'
    });
}
function checkSearchText(e, obj, tbl) {
    var reg = /[\<\>\.\'\"\:\;\|\{\}\[\]\,\=\+\-\_\!\~\`\(\)\$\#\@\^\&\,\?]/;
    if (String(obj.value).match(reg)) {
        obj.value = '';
    }
    if ((e.which == 13)) {
        var res = $.ajax({
            url : "include/lookup/open.php?tbl=" + tbl + "&id=" + obj.value
            + "",
            global : false,
            type : "POST",
            async : false
        }).responseText;
        if ((res == -2) || (res == -1)) {
            $("#errmsg").html("Not Found! Try agin...").css({
                "color" : "#FF0000"
            });
        } else {
            self.document.location = 'home.php?page=' + res;
        }
    }

}

function printBarCode(type,id){
    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700";
    var url='include/form_templates/print_barcode.php?type='+type+'&id='+id;
     window.open(url,'Barcode', params);

	
}
function openPatient(pid) {

    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width="
    + screen.width + ",height=" + screen.height + "";
    var url = "patientmonitor.php?PID="+pid;

    var lookUpW = window.open("include/" + url + "", "patient_win" + pid,
        params);
}

function confirmExit() {
    return "Do you want to lose the changes you made?";
}

function randomString(len) {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var string_length = len;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	document.randform.randomfield.value = randomstring;
}

function openDateRangeBox(id, title, type) {
    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700"
    $('<div id=' + id + '></div>').appendTo('body');
    $("#" + id).load('include/date_range_selector.php');
    wid = arguments[3];
    var w = 0;
    var h = 0;
    var printCall = function() {
    }
    switch (type) {
        case 'midnight_census':
            w = 500;
            h = 175;
            // printCall=function(){
            // printReport(id,type,$("#from_k").val(),$("#to_k").val(),arguments[3]);
            // }
            break;
    }

    $("#" + id).dialog(
    {
        width : w,
        height : h,
        autoOpen : true,
        modal : true,
        resizable : false,
        position : 'center',
        buttons : [
        {
            text : 'Generate',
            click : function() {
                url = "ward_midnight.php?from="
                + $("#from_k").val() + "&to="
                + $("#to_k").val() + "&wid=" + wid;
                var lookUpW = window.open(
                    "include/form_templates/" + url + "",
                    "lookUpW", params)
                $(this).dialog("close");
                $("#" + id).remove();
            }
        }, {
            text : 'Cancel',
            click : function() {
                $(this).dialog("close");
                $("#" + id).remove();
            }
        } ],
        title : title
    });
}
/*
function canvas_save()
{       
    // converting the canvas to data URI
	alert("aaaaabbbbbbb");
	
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
	

	
} */