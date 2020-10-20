<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Carbon\Carbon ;
class Ourdetail extends Model {

	public static function viewdetails($request) {
		$db = DB::connection('mysql');
		$result= $db->table('dev_ourdetails')
						->SELECT('*')
						->get();
		return $result;
	}
}