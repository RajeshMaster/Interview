<?php
    session_start();
    $_SESSION['previous_location'] = 'homepage';
    $actionName = Route::getCurrentRoute()->getActionName();
    $split_action_name = explode('@', $actionName);
    $action = $split_action_name['1'];
?>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/error.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/widthbox.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/font-awesome.min.css') }}">
  <title></title>
	<script type="text/javascript">
		var datetime = '<?php echo date('Ymdhis'); ?>';
		function previouspage(path) {
			$('#mysqlerrorform').action(path)
			$('#mysqlerrorform').submit();
		}
	</script>
</head>
<body>
	{{ Form::open(array( 'id'=>'mysqlerrorform','name'=>'mysqlerrorform', 
'files'=>true,'method' => 'POST')) }}
		<div class="box100per pr10 pl10" style="min-height: 150px">
			<table class="tablealternate box100per mt30" >
				<colgroup>
					<col width="7%">
					<col width="10%">
					<col width="">
					<col width="8%">
					<col width="50%">
				</colgroup>
				<thead class="CMN_tbltheadcolor">
					<tr class="tableheader fwb">
						<th class="fwb tac">S.No</th>
						<th class="fwb tac">Date</th>
						<th class="fwb tac">File Path</th>
						<th class="fwb tac">Line No.</th>
						<th class="fwb tac">Error Information</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="text-center">{{ "1" }}</td>
						<td class="text-center">{{ date('Y-m-d') }}</td>
						<td style="word-wrap:break-word;">
							{{ $e->getfile() }} 
						</td>
						<td class="text-center">
							{{ $e->getline() }}
						</td>
						<td>
							{{ $e->getMessage() }}
						</td>
					</tr>
			@php 
			$date=date('Ymd');
			$path=storage_path("../storage/error_".$date."/");
			$ldate="Date : ".date('Y-m-d H:i:s')."\n";
			$lpath="Path : ".$e->getfile()."\n";
			$lline="Line : ".$e->getline()."\n";
			$lmsg="Message : ".$e->getMessage()."\n\n";
			$contents=$ldate.$lpath.$lline.$lmsg;
			$file=$path.$date.".php";
			if(is_dir($path)) {
			File::append($file, $contents);
			} else {
			File::makeDirectory($path);
			File::put($file, $contents);
			}
			@endphp
			</table>
		</div>
		<br>
		<fieldset class="bg-info ml10 mr10">
			<div class="form-group">
				<div align="center" class="mt5">
					<a href="{{  URL::previous() }}" class="box7per fwb mt5 btn btn-info box100">
						<span class="fa fa-arrow-left"></span> Back
					</a>
				</div>
			</div>
		</fieldset>
        {{ Form::close() }}
</body>
</html>