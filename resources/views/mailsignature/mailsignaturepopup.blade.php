{{ HTML::script('resources/assets/js/mailsignature.js') }}
{{ HTML::script('public/js/common.js') }}
{{ HTML::style(asset('public/css/settinglayout.css')) }}
<style>
  #dwnArrow,#upArrow {
    text-decoration:none;
    font-size:22px;
    color:#bbb5b5;
    box-shadow: none;
    background-color: Transparent;
    border: none; 
    padding: 0px;
  }
  @media all and (max-width: 1200px) {
  .messagedisplay{
    font-size: 80%;
    margin-top:3%!important;
    margin-bottom:-6%!important;
    margin-left:11%!important;
  }
  .designchange{
    margin-right:4%!important;
  }
}
</style>
{{ Form::hidden('mainmenu', $request->mainmenu, array('id' => 'mainmenu')) }}
<div class="popupstyle popupsize">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" style="color: red;" aria-hidden="true">&#10006;</button>
            <h3 class="modal-title custom_align"><B>{{ trans('messages.lbl_username') }}</B></h3>
        </div>
        <div class="box100per pr5 pt15 pl10">
            <table class="tablealter  table-bordered table-striped" width="96.95%" style="table-layout: fixed;">
                <colgroup>
                    <col width="6%">
                    <col width="8%">
                    <col width="15%">
                    <col width="">
                </colgroup>
                <thead class="CMN_tbltheadcolor" >
                    <th class="tac"></th>
                    <th class="tac">{{ trans('messages.lbl_sno') }}</th>
                    <th class="tac">{{ trans('messages.lbl_userid') }}</th>
                    <th class="tac">{{ trans('messages.lbl_username') }}</th>
                </thead>
                <tbody id="search" class="staff">
                    <?php $i=0; ?>
                     @forelse($empname as $key => $value)
                        <tr id="popup" ondblclick="fndbclick('<?php echo $value->usercode; ?>','<?php echo $value->username; ?>',
                        '<?php echo $value->givenname; ?>','<?php echo $value->nickName; ?>');"  
                          onclick="fngetData('<?php echo $value->usercode; ?>','<?php echo $value->username; ?>',
                        '<?php echo $value->givenname; ?>','<?php echo $value->nickName; ?>');"
                            >
                          <td align="center">
                            <input  type="radio" id="<?php echo $value->usercode; ?>" name="empid" onclick="fngetempid(this.id,this.value);">
                          </td>
                          <td align="center">
                            {{ $i + 1 }}
                          </td>
                          <td align="center">
                            {{ $value->usercode }}
                          </td>
                          <td>
                            {{ $value->username }} {{ $value->givenname }} 
                            @if($value->nickName != "")
                              ({{ $value->nickName }})
                            @else 
                            @endif 
                          </td>
                        </tr>
                        <?php $i++; ?>
                    @empty
                      <tr>
                        <td class="text-center" colspan="4" style="color: red;">{{ trans('messages.lbl_nodatafound') }}</td>
                      </tr>
                     @endforelse
                </tbody>
            </table>
        </div>
   <div class="modal-footer bg-info mt10">
      <center>
         <!-- <button id="add" onclick="javascript:fnselect();" class="btn btn-success CMN_display_block box100">
            <i class="fa fa-plus" aria-hidden="true"></i>
               {{ trans('messages.lbl_select') }}
         </button> -->
        <a href="javascript:fnselect()"  class="btn btn-success CMN_display_block box100"> <i class="fa fa-plus" aria-hidden="true"></i>
               {{ trans('messages.lbl_select') }}</a>
         <button data-dismiss="modal" onclick="javascript:fnclose();" class="btn btn-danger CMN_display_block box100">
            <i class="fa fa-times" aria-hidden="true"></i>
               {{ trans('messages.lbl_cancel') }}
         </button>
         <!-- onclick="javascript:return cancelpopupclick();" -->
      </center>
   </div>
      </div>
   </div>
   </div>
   