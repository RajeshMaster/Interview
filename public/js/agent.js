var data = {};
var mainmenu = "menu_agent";
$(function () {
    var cc = 0;
    $('#agentsort').click(function () {
        cc++;
        if (cc == 2) {
            $(this).change();
            cc = 0;
        }         
    }).change (function () {
        sortingfun();
        cc = -1;
    }); 
});
$(document).ready(function(){
    $('.addeditprocess').click(function () {
        resetErrors();
        var url ='AgentRegValidation';
        $.each($('form input, form select, form textarea'), function(i, v) {  
            if (v.type !== "submit") {
                data[v.name] = v.value;
            }
        });
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: url,
            data: data,
            async: false, //blocks window close
            success: function(resp) {
                if(resp == true){
                    var mailId = $('#txt_emailId').val();
                    var agentId = $('#agentId').val();
                    $.ajax({
                        type: 'GET',
                        url: 'getEmailExists',
                        data: {"mailId": mailId,"agentId": agentId},
                        success: function(resp){
                            if(resp > 0){
                                document.getElementById('errorSectiondisplay').innerHTML = "";
                                err_invaliderr = "Email Id Already Exists";
                                var error='<div align="center"><label class="error pl5 mt5 tal" style="color:#9C0000;" for="txt_mailid">'+err_invaliderr+'</label></div>';
                                document.getElementById('errorSectiondisplay').style.display = 'inline-block';
                                document.getElementById('errorSectiondisplay').innerHTML = error;
                                return false;
                            }
                            else{
                                if(agentId == "") {
                                    swal({
                                    title: msg_register,
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    closeOnConfirm: true,
                                    closeOnCancel: true
                                    },
                                    function(isConfirm) {
                                        if (isConfirm) {
                                            pageload();
                                            $("#frmagentaddedit").submit();
                                        } else {
                                            
                                        }
                                    });
                                }else{
                                    swal({
                                    title: msg_update,
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    closeOnConfirm: true,
                                    closeOnCancel: true
                                    },
                                    function(isConfirm) {
                                        if (isConfirm) {
                                            pageload();
                                            $("#frmagentaddedit").submit();
                                        } else {
                                            
                                        }
                                    });
                                }
                            }
                        },
                        error: function(data){

                        }
                    });

                }else{
                    $.each(resp, function(i,v) {
                        var msg = '<label class="error pl5 mt5 tal" style="color:#9C0000;" for="'+i+'">'+v+'</label>';
                        $('input[name="' + i + '"], select[name="' + i + '"],textarea[name="' + i + '"]').focus().addClass('inputTxtError').after(msg);
                    });
                }
            },
            error: function(data){

            }
        });
    });
    $('.cusaddeditprocess').click(function () {
        var agentId = $('#agentId').val();
        var cuseditflg = $('#cuseditflg').val();
        var selected = $('#selected').val();
        if (selected == "") {
           document.getElementById('errorSectiondisplay').innerHTML = "";
            err_invaliderr = "Select Customer Name";
            var error='<div align="center"><label class="error pl5 mt5 tal" style="color:#9C0000;" for="txt_mailid">'+err_invaliderr+'</label></div>';
            document.getElementById('errorSectiondisplay').style.display = 'inline-block';
            document.getElementById('errorSectiondisplay').innerHTML = error;
            $('#selected').focus();
            return false;
        } else {
            if(cuseditflg == "edit") {
                swal({
                    title: msg_update,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    closeOnConfirm: true,
                    closeOnCancel: true
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            pageload();
                            $("#frmcusreg").submit();
                        } else {
                            
                        }
                });

            } else {
                swal({
                    title: msg_register,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    closeOnConfirm: true,
                    closeOnCancel: true
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            pageload();
                            $("#frmcusreg").submit();
                        } else {
                            
                        }
                });
            }
        }
    });
});
function resetErrors() {
    $('form input, form select, form radio, form textarea').css("border-color", "");
    $('form input').removeClass('inputTxtError');
    $('label.error').remove();
}
function sortingfun() {
    pageload();
    $('#plimit').val(50);
    $('#page').val('');
    var sortselect=$('#agentsort').val();
    $('#sortOptn').val(sortselect);
    var alreadySelectedOptn=$('#sortOptn').val();
    var alreadySelectedOptnOrder=$('#sortOrder').val();
    if (sortselect == alreadySelectedOptn) {
        if (alreadySelectedOptnOrder == "asc") {
            $('#sortOrder').val('desc');
        } else {
            $('#sortOrder').val('asc');
        }
    }
    $("#agentindexform").submit();
}
function filter(val) {
    $('#plimit').val(50);
    $('#page').val('');
    $("#filter").val('');
    $('#singlesearchtxt').val('');
    $('#sorting').val('');
    $('#startdate').val('');
    $('#enddate').val('');
    $('#name').val('');
	$('#filterval').val(val);
    $('#agentsort').val('');
	$("#agentindexform").submit();
}
function clearsearch() {
    $('#plimit').val(50);
    $('#page').val('');
    $("#filter").val('');
    $('#singlesearchtxt').val('');
    $('#sorting').val('');
    $('#agentsort').val('');
    $('#name').val('');
    $('#address').val('');
    $('#searchmethod').val('');
    $("#agentindexform").submit();
}
function agentView(id,agentId) {
    $('#id').val(id);
    $('#agentId').val(agentId);
    $('#agentindexform').attr('action', 'AgentView?mainmenu='+mainmenu+'&time='+datetime);
    $("#agentindexform").submit();
}
function edit(id,agentId) {
    $('#id').val(id);
    $('#agentId').val(agentId);
    $('#editflg').val('edit');

    $('#agentviewform').attr('action', 'AgentAddedit?mainmenu='+mainmenu+'&time='+datetime);
    $("#agentviewform").submit();
}
function changeAgentFlg(val,id) {
    swal({
        title: msg_flagchange,
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
            pageload();
            $('#useval').val(val);
            $('#id').val(id);
            $("#agentindexform").submit();
        } else {
            
        }
    });
}
function goindexpage() {
    pageload();
    $('#agentviewform').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
    $("#agentviewform").submit();
}
function gotoindexpage(viewflg) {
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
           if (viewflg == "1") {
                $('#frmagentaddeditcancel').attr('action', 'AgentView?mainmenu='+mainmenu+'&time='+datetime);
                $("#frmagentaddeditcancel").submit();
            } else {
                $('#frmagentaddeditcancel').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
                $("#frmagentaddeditcancel").submit();
            }
        } else {
            
        }
    });
    
        
    
}
function fngotoregister(editFlg){
    $('#editFlg').val(editFlg);
    pageload();
    $('#agentindexform').attr('action', 'AgentAddedit?mainmenu='+mainmenu+'&time='+datetime);
    $("#agentindexform").submit();
}
function isNumberKey(evt) { 
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
function isNumberKeywithminus(evt) { 
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode == 45) {
      return true;
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
}
function addHyphen (element) {
    var ele = document.getElementById(element.id);
    ele = ele.value.split('-').join('');    // Remove dash (-) if mistakenly entered.
    var finalVal = ele.match(/\d{3}(?=\d{2,3})|\d+/g).join('-');
    document.getElementById(element.id).value = finalVal;
}
function fnSingleSearch() {
    var singlesearchtxt = $("#singlesearchtxt").val();
    var singlesearchtxt = document.getElementById('singlesearchtxt').value;
    if (singlesearchtxt == "") {
        alert("Please Enter The agent Search.");
        $("#singlesearchtxt").focus(); 
        return false;
    } else {
        $('#plimit').val('');
        $('#page').val('');
        if ($('#singlesearchtxt').val()) {
            $('#searchmethod').val(1);
        } else {
            $('#searchmethod').val('');
        }
        $('#name').val('');
        $('#address').val('');
        $('#agentindexform').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
        $("#agentindexform").submit();
    }
}
function umultiplesearch() {
    var name = $("#name").val();
    var name = document.getElementById('name').value;
    var address = $("#address").val();
    var address = document.getElementById('address').value;
    if (name == "" && address == "") {
        alert("Agent search is missing.");
        $("#name").focus(); 
        return false;
    } else {
        $('#plimit').val(50);
        $('#page').val('');
        $("#filterval").val('');
        $('#singlesearchtxt').val('');
        $('#searchmethod').val(2);
        $('#agentindexform').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
        $("#agentindexform").submit();
    }
}
/*function customerAddEdit(flg) {
    pageload();
    $('#cuseditflg').val(flg);
    $('#agentviewform').attr('action','addeditCustomer?mainmenu='+mainmenu+'&time='+datetime);
    $("#agentviewform").submit();
}*/
function customerAddEdit(flg,agentId) {
    $('#cuseditflg').val(flg);
    popupopenclose(1);
    $('#cusGroup').load('selectCustomerName?mainmenu='+mainmenu+'&time='+datetime+'&cuseditflg='+flg+'&agentId='+agentId);
    $("#cusGroup").modal({
        backdrop: 'static',
        keyboard: false
    });
    $('#cusGroup').modal('show');
   
}
function listbox_moveacross(sourceID, destID, SelectID, HdnID) {
    var src = document.getElementById(sourceID);
    var dest = document.getElementById(destID);
    for(var count=0; count < src.options.length; count++) {
        if(src.options[count].selected == true) {
            var option = src.options[count];
            var newOption = document.createElement("option");
            newOption.value = option.value;
            newOption.text = option.text;
            newOption.selected = true;
            try {
                 dest.add(newOption, null); //Standard
                 src.remove(count, null);
            }catch(error) {
                dest.add(newOption); // IE only
                src.remove(count);
            }
            count--;
        }
    }
    //set Value for Hidden box
    var dest = document.getElementById(SelectID);
    var str='';
    if(dest.options.length>=1){
        str+=dest.options[0].value;
    }
    for(var count=1; count < dest.options.length; count++) {
        str+=','+dest.options[count].value;
    }
    document.getElementById(HdnID).value=str;
}
function fnselectcustomer() {
    var array = [];
    if ($('input[name="cusId"]:checked').length == 0) {
        alert("Please Select Atleast One Customer To Add");
        return false;
    }else{
        $('input[name="cusId"]:checked').each(function() {
            array.push($(this).val()); 
        }); 
        var sel =$('#selected').val();
        $('#selected').val(sel+array.join(","));
        if (array !="") {
            $('#agentviewform').attr('action','cusaddeditprocess?mainmenu='+mainmenu+'&time='+datetime);
            $("#agentviewform").submit();
        } 
    }
}
function fnRemove(custid){
    $("#hidselectcus").val(custid); 
    pageload();
    $('#agentviewform').attr('action','RemoveProcess?mainmenu='+mainmenu+'&time='+datetime);
    $("#agentviewform").submit();
}
// Enter ker Search process 
function checkSubmitsingle(e) {
    if(e && e.keyCode == 13) {
        fnSingleSearch();
    }
}
function checkSubmitmulti(e) {
    if(e && e.keyCode == 13) {
        umultiplesearch();
    }
}
