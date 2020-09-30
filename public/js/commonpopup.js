function moveSelected(from, to) {
	$('#'+from+' option:selected').remove().appendTo('#'+to); 
}
function fnSelectedPgmLanguage(setvalfield, hiddenvalue,tablename,type) {
	$('form input').each(function(i, v){
			$(this).val(jQuery.trim($(this).val()));
	});
	var selectedid = "";
	var existflg = "";
	var length = $("#to option").length;
	if(length == 0 && $('#otherstxtbox').val() == "") {
		// alert("Please Select Any One!")
		swal({
			title: msg_selectone,
		})
		return false;
	}
	var optionval = [];
	var optiontext = [];
	var selval = "";
	$('#to option').prop('selected', true);
	$.each($("#to option:selected"), function(){
		optionval.push($(this).val());
		optiontext.push($.trim($(this).text()));
	});
	// alert(optionval);
		swal({
			title: msg_confirmselect,
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			closeOnConfirm: true,
			closeOnCancel: true
		},
		function(isConfirm) {
			if (isConfirm) {
				if ($('#otherstxtbox').val() != "") {
		var others = $('#otherstxtbox').val();
		$.ajax({
			async: false,	// To return the ajax value to parent function 
			dataType:'json',
			type: 'POST',
			url: 'checkExistsPgmlanguage',
			data: {
					others: others,
					tablename: tablename,
					type: type,
					},
			success: function(resp) {
				if (resp['existCheckFlg'] == 1) { 
					existflg = resp['existCheckFlg'];
					$("#popupsessionothers").css("display", "block");
					$("#otherstxtbox").val('');
					optionval = resp['recordId'];
					$('#'+hiddenvalue).val(resp['recordId']);
					selectedid = resp['recordId'];
				} else {
					$.ajax({
						async: false,	// To return the ajax value to parent function 
						type: 'POST',
						url: 'insertotherstext',
						data: {
							others: others,
							tablename: tablename,
							type: type,
							},
						success: function(dataother) {
							if(optionval != "" && others != "") {
								selval = optionval+","+dataother;
							} else if(optionval == "") {
								selval = dataother;
							} else {
								selval = optionval;
							}
							return true;
						},
						error: function(resp) {
							alert(resp.status);
						}
					});
				}
			},
			error: function(resp) {
				alert(resp.status);
			}
		});
			if (others != "" && optiontext != "") {
				if (existflg == 1) { 
					seltext = optiontext;
				} else {
					seltext = optiontext+","+others;
				}
			} else if (optiontext != "") {
				if (existflg == 1) { 
					seltext = optiontext;
				} else {
					seltext = optiontext+","+others;
				}
			} else {
				if (existflg == 1) { 
					seltext = optiontext;
				} else {
					seltext = others;
				}
			}
		} else {
			seltext = optiontext;
			selval = optionval;
		}
			if(selval != "") {
				$('#'+setvalfield).val(seltext);
				$('#'+hiddenvalue).val(selval);
			} else {
				$('#'+setvalfield).val(seltext);
				$('#'+hiddenvalue).val(selectedid);
			}
			if(selval != "") {
				$('#commonpopup').modal('toggle');
			}
		} else {
			return false;
		}
	});
}
function fnInsertSelectedval(userId, tblcolName, tablename, type, heading) {
	$('form input').each(function(i, v){
		$(this).val(jQuery.trim($(this).val()));
	});
	var selectedval = [];
	selectedval = $("#to option").val();
	var others = $('#otherstxtbox').val();
	
	selectedval =[];
	$('#to option').prop('selected', true);
	$.each($("#to option:selected"), function(){
		selectedval.push($(this).val());
	});

	if (selectedval == null) {
		selectedval = "";
	}
	if ((heading === 'lbl_middleware') || (heading === 'lbl_webtools')) {
	} else {
		if ((selectedval == "") && (others == "")) {
			swal({
				title: msg_selectone,
			})
			return false;
		}
	}
	selectedval = selectedval.toString();
	swal({
		title: msg_confirmselect,
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		closeOnConfirm: true,
		closeOnCancel: true
	},
	function(isConfirm) {
		if (isConfirm) {
			if ($('#otherstxtbox').val() != "") {
			var others = $('#otherstxtbox').val();
			$.ajax({
			async: false,	// To return the ajax value to parent function 
			dataType:'json',
			type: 'POST',
			url: 'checkExistsPgmlanguage',
			data: {
					others: others,
					tablename: tablename,
					type: type,
					},
			success: function(resp) {
				if (resp.existCheckFlg > 0) { 
					$("#popupsessionothers").css("display", "block");
					return false;
				} else {
					$.ajax({
						async: false,	// To return the ajax value to parent function 
						dataType:'json',
						type: 'POST',
						url: 'insertOthers',
						data: {
								others: others,
								tablename: tablename,
								type: type,
								},
						success: function(data) {
							if (selectedval != "") {
								selectedval=selectedval+","+data;
							} else {
								selectedval=data;
							}
						},
						error: function(data) {
							alert(data.status);
						}
					});
					$.ajax({
						async: false,	// To return the ajax value to parent function 
						dataType:'json',
						type: 'POST',
						url: 'insertinResume',
						data: {
								userId: userId,
								tblcolName: tblcolName,
								selectedval: selectedval,
								},
						success: function(data) {
						},
						error: function(data) {
						}
					});
					$("#commonPopup").submit();
				}
			},
			error: function(resp) {
				alert(resp.status);
			}
			});
		} else {
			$.ajax({
				async: false,	// To return the ajax value to parent function 
				dataType:'json',
				type: 'POST',
				url: 'insertinResume',
				data: {
						userId: userId,
						tblcolName: tblcolName,
						selectedval: selectedval,
						},
				success: function(data) {
				},
				error: function(data) {
				}
			});
			$("#commonPopup").submit();
		}
		} else {
			return false;
		}
	});
}
function fnclosepopup() {
	if (!cancel_check) {
		swal({
			title: msg_cancel,
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			closeOnConfirm: true,
			closeOnCancel: true
		},
		function(isConfirm) {
			if (isConfirm) {
				$("body div").removeClass( "modalOverlay" );
        		$( '#commonpopup' ).empty();
				$('#commonpopup').modal('toggle');
			} else {
				return false;
			}
		});
    } else {
		$( "body div" ).removeClass( "modalOverlay" );
		$( '#commonpopup' ).empty();
		$('#commonpopup').modal('toggle');
	}
}
function fnSelectCustomer(value, hiddenvalue, setvalfield) {
	var count = $("#fromselectbox :selected").length;
	if(count <= 0){
		// alert("Please Select Atleast One");
		swal({
			title: msg_selectone,
		})
		return false;
	} else {
		swal({
			title: msg_confirmselect,
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			closeOnConfirm: true,
			closeOnCancel: true
		},
		function(isConfirm) {
			if (isConfirm) {
			var selectedval = [];
			selectedval = $("#fromselectbox option:selected").val();
			var splitidincharge = selectedval.split('-');
			selectedtextfield = $("#fromselectbox :selected").text();
			$('#'+setvalfield).val(splitidincharge[1]);
			$('#hiddencustomerName').val(splitidincharge[0]);
			$('#hiddeninchargeName').val(splitidincharge[2]);
			$('#inchargename').val(splitidincharge[2]);
			$( "body div" ).removeClass( "modalOverlay" );
			$('#singlepopup').empty();
			$('#singlepopup').modal('toggle');
			} else {
				return false;
			}
		});
    } 
}
function fnpopupclose() {
	if (!cancel_check) {
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
				$("body div").removeClass( "modalOverlay" );
        		$( '#singlepopup' ).empty();
				$('#singlepopup').modal('toggle');
			} else {
				return false;
			}
		});
    } else {
			$( "body div" ).removeClass( "modalOverlay" );
			$( '#singlepopup' ).empty();
			// $('#customername').val('');
			// $('#inchargename').val('');
			$('#singlepopup').modal('toggle');
	}
}
function enterKeysType(evt) {
	if (evt.charCode == 13) {
		return false;
    }
}