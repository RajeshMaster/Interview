function pageClick(pageval) {
	$('#page').val(pageval);
	var pageview = $('#pageview').val();
	if (pageview == "banklistview") {
		$("#banklistview").submit();
	} else {
		$("#othbanklistview").submit();
	}
}
function pageLimitClick(pagelimitval) {
	$('#page').val('');
	$('#plimit').val(pagelimitval);
	var pageview = $('#pageview').val();
	if (pageview == "banklistview") {
		$("#banklistview").submit();
	} else {
		$("#othbanklistview").submit();
	}
}
var data = {};
$(document).ready(function() {
	$('.addeditprocess').click(function () {
		$("#bankAddEdit").validate({
			showErrors: function(errorMap, errorList) {
			// Clean up any tooltips for valid elements
				$.each(this.validElements(), function (index, element) {
						var $element = $(element);
						$element.data("title", "") // Clear the title - there is no error associated anymore
								.removeClass("error")
								.tooltip("destroy");
				});
				// Create new tooltips for invalid elements
				$.each(errorList, function (index, error) {
						var $element = $(error.element);
						$element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
								.data("title", error.message)
								.addClass("error")
								.tooltip(); // Create a new tooltip based on the error messsage we just set in the title
				});
			},
			rules: {
				houseId: {required: true},
				belongsTo: {required: true},
				bankName: {required: true},
				bankNickName: {required: true},
				accountType: {required: true},
				accountNo: {required: true},
				branchName: {required: true},
				kanaName: {required: true},
				bankUserName: {required: true},
			},
			submitHandler: function(form) { // for demo
				if($('#editpage').val() != "editpage") {
					var err_cnfirm = msg_register;
				} else {
					var err_cnfirm = msg_update;
				}
				swal({
					title: err_cnfirm,
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					closeOnConfirm: true,
					closeOnCancel: true
				},
				function(isConfirm) {
					if(isConfirm) {    
						pageload();
						form.submit();
						return true;
					} else {
						return false;
					}
				});
			}
		});

		$.validator.messages.required = function (param, input) {
			var article = document.getElementById(input.id);
			return article.dataset.label + ' field is required';
		}
		$.validator.messages.extension = function (param, input) {
			return err_extension;
		}
	});
});
function fnunder() {
	alert('Under Construction');
}
// Redirect to Bank Register Page
function bankRegister(userId){
	var mainmenu = $('#mainmenu').val();
	$('#userId').val(userId);
	var pageview = $('#pageview').val();
	if (pageview == "banklistview") {
		$('#pageview').val('bankAddEdit');
		$('#banklistview').attr('action', 'addEdit?mainmenu='+mainmenu+'&time='+datetime);
		$("#banklistview").submit();
	} else {
		$('#pageview').val('othbankAddEdit');
		$('#othbanklistview').attr('action', 'addEdit?mainmenu='+mainmenu+'&time='+datetime);
		$("#othbanklistview").submit();
	}
}
// Get Bank Nick Name
function fnGetBankNickName(){
	$('#bankNickName').find('option').not(':first').remove();
	var mainmenu = $('#mainmenu').val();
	var bankId = $('#bankName').val();
	$.ajax({
		type: 'GET',
		dataType: "JSON",
		url: 'bankNickName_ajax',
		data: {"bankId": bankId,"mainmenu": mainmenu},
		success: function(resp) {
			for (i = 0; i < resp.length; i++) {
				$('#bankNickName').append('<option value="'+resp[i]["id"]+'">'+resp[i]["nickName"]+'</option>' );
				$('select[name="bankNickName"]').val(resp[i]["id"]);
			}
		},
		error: function(data) {
			// alert(data.status);
		}
	});
}
// Cancel Check in AddEdit
function bankCancel() {
	var mainmenu = $("#mainmenu").val();
	var pageview = $('#bankAddEditcancel #pageview').val();
	if (pageview == "bankAddEdit") {
		var viewFlg = "listview";
		$('#bankAddEditcancel #pageview').val('banklistview');
	} else {
		var viewFlg = "othbanklistview";
		$('#bankAddEditcancel #pageview').val('othbanklistview');
	}
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
				pageload();
				$('#bankAddEditcancel').attr('action', viewFlg+'?mainmenu='+mainmenu+'&time='+datetime); 
				$("#bankAddEditcancel").submit();
			} else {
				return false;
			}
		});
	} else {
		pageload();
		$('#bankAddEditcancel').attr('action', viewFlg+'?mainmenu='+mainmenu+'&time='+datetime);
		$("#bankAddEditcancel").submit();
	}
} 
// Redirect to Bank View Page
function bankview(bankId){
	pageload();
	$('#bankId').val(bankId);
	var mainmenu = $('#mainmenu').val();
	var pageview = $('#pageview').val();
	if (pageview == "banklistview") {
		$('#pageview').val('bankView');
		$('#banklistview').attr('action','view?mainmenu='+mainmenu+'&time='+datetime);
		$("#banklistview").submit();
	} else {
		$('#pageview').val('othbankView');
		$('#othbanklistview').attr('action','view?mainmenu='+mainmenu+'&time='+datetime);
		$("#othbanklistview").submit();
	}
	
}
// Redirect to Bank List View Page
function goToListView(){
	$("#bankId").val("");
	var mainmenu = $('#mainmenu').val();
	var pageview = $('#pageview').val();
	if (pageview == "bankView") {
		$('#pageview').val('banklistview');
		$('#bankView').attr('action', 'listview?mainmenu='+mainmenu+'&time='+datetime);
		$("#bankView").submit();
	} else {
		$('#pageview').val('othbanklistview');
		$('#bankView').attr('action', 'othbanklistview?mainmenu='+mainmenu+'&time='+datetime);
		$("#bankView").submit();
	}
}
// Go to Edit Bank Details
function fnEditBank(id,userId){
	$("#bankId").val(id);
	$("#userId").val(userId);
	$('#editChk').val(1);
	var pageview = $('#pageview').val();
	if (pageview == "bankView") {
		$('#pageview').val('bankAddEdit');
	} else {
		$('#pageview').val('othbankAddEdit');
	}
	var mainmenu = $('#mainmenu').val();
	$('#bankView').attr('action', 'addEdit?mainmenu='+mainmenu+'&time='+datetime);
	$("#bankView").submit();
}