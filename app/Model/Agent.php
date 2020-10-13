<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Config;
class Agent extends Model {
	public static function getAgentdetails($request)
	{
		$db = DB::connection('mysql');
		$query = $db->TABLE('mst_agentdetail')
					->SELECT('*');
			if ($request->filterval == 1) {
				$query = $query->where(function($joincont) use ($request) {
								  $joincont->where('delflg', '=', 0);
								  });
			} else {
				$query = $query->where(function($joincont) use ($request) {
								  $joincont->where('delflg', '=', 1);
								  });
			}
			if (!empty($request->singlesearchtxt)) {
				$query = $query->where(function($joincont) use ($request) {
								$joincont->where('agent_name', 'LIKE', '%' . $request->singlesearchtxt . '%')
								->orWhere('agent_address', 'LIKE', '%' . $request->singlesearchtxt . '%');
								});
			}
			if (!empty($request->name)) {
				$query = $query->where(function($joincont) use ($request) {
								$joincont->where('agent_name', 'LIKE', '%' . $request->name . '%');
								});
			}
			if (!empty($request->address)) {
				$query = $query->where(function($joincont) use ($request) {
								$joincont->where('agent_address', 'LIKE', '%' . $request->address . '%');
								});
			}
			if (!empty($request->name && $request->address)) {
				$query = $query->where(function($joincont) use ($request) {
								$joincont->where('agent_name', 'LIKE', '%' . $request->name . '%')
								->orWhere('agent_address', 'LIKE', '%' . $request->address . '%');
								});
			}
			if($request->oldfilter == $request->filterval){
				$query = $query->ORDERBY($request->agentsort, $request->sortOrder)
							   ->ORDERBY('agent_id', 'DESC');	
			} else {
				$query = $query->ORDERBY($request->agentsort, $request->sortOrder)
								->ORDERBY('agent_id', 'DESC');
								$request->agentsort = "agent_id";
			}
			$query = $query-> paginate($request->plimit);
					// $query =$query->tosql();
					// dd($query);
		return $query;
	}
	// Change Flg
	public static function changeAgentFlg($request) {
		$db = DB::connection('mysql');
		$update = DB::table('mst_agentdetail')
			->where('id', $request->id)
			->update(['delflg' => $request->useval]);
		return $update;
	}
	// Ken Name
	public static function getKenName($kenId) {
		$db = DB::connection('mysql');
		$query = $db->TABLE('mst_prefecture')
					->select('prefecture_name_jp')
					->WHERE('id','=',$kenId)
					->get();
		return $query;
	}
	// getSingle Record
	public static function getSingleAgentRecord($request){
		$db =DB::connection('mysql');
		$query= $db->table('mst_agentdetail')
				   ->select('mst_agentdetail.id AS id',
							 'agent_id AS txt_agentId', 
							 'agent_name AS txt_agentName', 
							 'agent_kananame AS txt_agentNameJp',
							 'customerId AS customerId',
							 'contract AS txt_agentContract',
							 'agent_contact_no AS txt_mobilenumber',
							 'agent_email_id AS txt_emailId',
							 'agent_fax_no AS txt_fax', 
							 'agent_website AS txt_url', 
							 'agent_address As txt_address',
							 'postalNumber As postalNumber',
							 'kenmei As kenmei',
							 'shimei As shimei',
							 'street_address As street_address',
							 'buildingname As buildingname',
							 'mst_prefecture.prefecture_name_jp As prefNameJP',
							 'mst_prefecture.prefecture_name_en As prefNameEN'
							 )
				   ->leftJoin('mst_prefecture', 'mst_prefecture.id', '=', 'mst_agentdetail.kenmei')
				   ->where('mst_agentdetail.agent_id','=', $request->agentId)
				   ->get();
		return $query;
	}
	// Get Customer Name
	public static function getCusName($request,$val) {
		$query = DB::table('mst_customerdetail')
				->SELECT('customer_name','customer_id')
				->where('customer_id','=', $val)
				->get();
		return $query;
	}
	// Ken Details
	public static function getKendetails() {
		$query = DB::table('mst_prefecture')
				->select('id','prefecture_name_jp')
				->WHERE('delflg', '=', 0)
				->lists('prefecture_name_jp','id');
		return $query;	
	} 
}