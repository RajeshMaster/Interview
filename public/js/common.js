var cancel_check = true;
$(document).ready(function(){
	//for cancel check on resume.js (multiple select)
	$('select').find('option:selected').bind("change keyup paste", function() {
		cancel_check = false;
	});
	$('input, select, textarea').bind("change keyup paste", function() {
		cancel_check = false;
	});
	$(".pageload").click(function(){
	  $(".loadinggif").show();
	});
	// To Avoid Autocomplte -> Sastha 15-09-2020 
	$('input').attr('autocomplete','off');
	// For Scroll Top
	$(window).scroll(function() {
		var height = $(window).scrollTop();
		if (height > 100) {
			$('#back2Top').fadeIn();
		} else {
			$('#back2Top').fadeOut();
		}
	});

	$(document).ready(function() {
		$("#back2Top").click(function(event) {
			event.preventDefault();
			$("html, body").animate({ scrollTop: 0 }, "slow");
			return false;
		});
	});

	// Date Format
	/*$.validator.addMethod('correctformatdate', function (value) {
		if(value == "") {
			return true;
		}
		return /^\d{4}-\d{2}-\d{2}$/.test(value);
	}, 'Date Format Should Be YYYY-MM-DD');*/

	// File field Validation
    /*jQuery.validator.addMethod("checkotherField",function(value,element,params) {
      if (value =="" && $(params).val() =="") {
        return false;
      } else {
        return true;
      }
    },'File field required');*/

    // EMI Date Greater than Start Date - Madasamy_26/08/2020
    /*jQuery.validator.addMethod("greaterThan", 
      function(value, element, params) {
          if (!/Invalid|NaN/.test(new Date(value))) {
              return new Date(value) >= new Date($(params).val());
          }
          return isNaN(value) && isNaN($(params).val()) 
              || (Number(value) >= Number($(params).val())); 
    },'Must be greater than EMI Start Date.');*/

});
// End of Focusing Next Fields
$(window).bind("pageshow", function(event) {
	// Animate loader off screen
	$(".loadinggif").fadeOut();
});
function pageload() {
	$(".loadinggif").show();
}
function fnunderconstruction() {
	alert("Under Construction");
}
function filevalidation(file_id,div_id,flg)
{
	document.getElementById(div_id).innerHTML = '';
	var file = $("#"+file_id).val();
	if(flg == "1") {  // IMG
		var exts = ['gif','jpeg','jpg','png'];
	} else {  // DOCS
		var exts = ['doc','docx','pdf','xls','xlsx'];
	}
	var get_ext = file.split('.');
	get_ext = get_ext.reverse();
	if ( $("#"+file_id).val() != "") {
		var size = parseFloat($("#"+file_id)[0].files[0].size / 1024);
	} else {
		var size = '0';
	}
	if($("#"+file_id).val() == "") {
		$('#'+div_id).show();
		document.getElementById(div_id).innerHTML = '<strong>'+err_fileempty+'</strong>';
		return false;
	} else if ( !($.inArray ( get_ext[0].toLowerCase(), exts ) > -1) ){
		if(flg == "1") { 
			$('#'+div_id).show();
			document.getElementById(div_id).innerHTML = '<strong>'+err_imgext+'</strong>';
		} else {
			$('#'+div_id).show();
			document.getElementById(div_id).innerHTML = '<strong>'+err_Docext+'</strong>';
		}
		return false;
	} else if(size >= "2097") {
		if(flg == "1") { 
			$('#'+div_id).show();
			document.getElementById(div_id).innerHTML = '<strong>'+err_filesize+'</strong>';
		} else {
			$('#'+div_id).show();
			document.getElementById(div_id).innerHTML = '<strong>'+err_Docsize+'</strong>';
		}
		return false;
	} else {
		$('#'+div_id).hide();
	}
}
function setDatePickeraftercurdate(datefield) {
	$('#'+datefield).datetimepicker({
		format: 'yyyy-mm-dd',
		language:  'eng',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0,
		startDate: new Date()
	});
}
//for mozilla firefox
function numberonly(evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)){
		   return false;
	}
		return true;
}
function autocomplete(autocompletedata, field) {
	var jsonData = [];
	var autocompletedata = autocompletedata.split(',');
	for(var i=0;i<autocompletedata.length;i++) jsonData.push({id:autocompletedata[i],name:autocompletedata[i]});
	var autoprocess = $('#'+field).tagSuggest({
		data: jsonData,
		sortOrder: 'name',
		maxDropHeight: 200,
		name: field
	});
}
function blockSpecialChar(e){
	var k;
	document.all ? k = e.keyCode : k = e.which;
	return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
}
function changelanguage() {
	swal({
		title: msg_changelanguage,
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		closeOnConfirm: true,
		closeOnCancel: true
	},
	function(isConfirm) {
		if (isConfirm) {
			pageload();
			$.ajax({
				type:'GET',
				url:'changelanguage',
				data: {
					langvalue: $('#langvalue').val()
				},
				success:function(data){
					location.reload(true);
				},
				error: function (data) {
					// alert(data.status);
				}
			});
		} else {
			return false;
		}
	});
}
function setDatePicker18yearbefore(datefield) {
  $('.'+datefield).datetimepicker({
		format: 'yyyy-mm-dd',
		language:  'eng',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0,
		endDate : '-18y'
	});
}
function setDatePicker(datefield) {
	$('.'+datefield).datetimepicker({
		format: 'yyyy-mm-dd',
		language:  'eng',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
	});
}

// Rajesh Date Picker For Before Current Date
function setDatePickerBeforeCurrent (datefield) {
	$('.'+datefield).datetimepicker({
		format: 'yyyy-mm-dd',
		language:  'eng',
		weekStart: 1,
		todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0,
	});
}

function fncancelcheck(url,frmname) {
	if (cancel_check == false) {
	swal({
		title: msg_cancel,
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		closeOnConfirm: true,
		closeOnCancel: true
	},
	function(isConfirm) {
		if (isConfirm) {
			if(frmname == "frmuseraddeditcancel")
				$('#frmuseraddeditcancel').attr('action', url).submit();
			else {
				$('#forgetprocess').attr('action', url).submit();
			}
		} else {
			return false;
		}
	});
	} else {
		if (frmname == "frmuseraddeditcancel") {
			$('#frmuseraddeditcancel').attr('action', url).submit();
		} else {
			$('#forgetprocess').attr('action', url).submit();
		}
		return false;
	}
}
// MONEY FORMAT
function fnMoneyFormat(name,flg) {
	var timestamp = parseInt($('#'+name).val());
	if (isNaN(timestamp) == true) { 
		$('#'+name).val('');
		return false;
	}
	var value = $('#'+name).val();
	value = value.replace(/[ ]*,[ ]*|[ ]+/g, '');
	fnMoneyFormatWithoutleadingzero(name, value,flg);
}
function fnMoneyFormatWithoutleadingzero(name, value,japmoney) {
	value = value.replace(/[ ]*,[ ]*|[ ]+/g, '');
	var x = event.keyCode;
	var passvalue = value;
	if ((value.length > 15) && (value.indexOf(',') == -1)) {
		passvalue = value.substr(0, 15);
	}
	passvalue = Number(passvalue).toString();
	isformatMoneyINR(name, passvalue,japmoney);
}
function isformatMoneyINR(salaryname, salary,japmoney) {
	var salaryamt = inrFormat(salary,japmoney);
	if (salaryamt != 0) {
		$('#'+salaryname).val(salaryamt);
	}
	return true;
}
function inrFormat(nStr,japmoney) { // nStr is the input string
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	var z = 0;
	var len = String(x1).length;
	var num = parseInt((len/2)-1);
	while (rgx.test(x1)) {
		if(z > 0) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		} else {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
			if(japmoney=="jp") {
				rgx = /(\d+)(\d{3})/;
			} else {
				rgx = /(\d+)(\d{2})/;
			}
		}
		z++;
		num--;
		if(num == 0) {
			break;
		}
	}
	return x1 + x2;
}

function isFloatNumberKey(evt){
	var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
    }
	return true;
}

function popupopenclose(flg) {
  if (flg == 1) {
    // Open
    $('#fixeddiv').removeClass('CMN_menu_fixed').addClass('CMN_positionabsolute');
    $('#sectiondiv').attr('style','margin-top:2px;');
  } else {
    // Close
    $('#fixeddiv').removeClass('CMN_positionabsolute').addClass('CMN_menu_fixed');
    $('#sectiondiv').attr('style','margin-top:125px;');
  }

}