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
        alert("under Construction");
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

            },
            error: function(data){

            }
        });
    });
});
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
function fngotoregister(editFlg){
    $('#editFlg').val(editFlg);
    pageload();
    $('#agentindexform').attr('action', 'AgentAddedit?mainmenu='+mainmenu+'&time='+datetime);
    $("#agentindexform").submit();
}