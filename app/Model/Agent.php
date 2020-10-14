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
	public static function fnGetEmailExistsCheck($request){
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_agentdetail')
					->select('*')
					->WHERE('agent_email_id','=', $request->mailId);
			if($request->agentId != ""){
				$result	= $result->WHERE('agent_id','!=', $request->agentId)->get();
			} else {
				$result = $result->get();
			}
		return $result;
	}
	// Update
	public static function updateAgentRec($request) { 
		$db = DB::connection('mysql');
		$updateQuery = $db->table('mst_agentdetail')
			->where('agent_id', $request->agentId)
			->update([ 
			'agent_id' => $request->agentId,
			'agent_name' => $request->txt_agentName,
			'agent_kananame' => $request->txt_agentNameJp,
			'contract' => $request->txt_agentContract,
			'agent_contact_no' => $request->txt_mobilenumber,
			'agent_email_id' => $request->txt_emailId,
			'agent_fax_no' => $request->txt_fax,
			'agent_website' => $request->txt_url,
			'agent_address' => $request->txt_address,
			'postalNumber' => $request->txt_postal,
			'kenmei' => $request->kenmei,
			'shimei' => $request->txt_shimei,
			'street_address' => $request->txt_streetaddress,
			'buildingname' => $request->txt_buildingname,
			'updated_by' => Auth::user()->username ]);
	  	return $updateQuery;
	}
	public static function agentMaxIdGenerate(){
		$query = DB::select("SELECT CONCAT('AG', LPAD(MAX(SUBSTRING(agent_id,4))+1,4,0)) AS agentid FROM mst_agentdetail WHERE agent_id LIKE '%AG%'");
		return $query;
	}
	// Insert
	public static function insertAgentRec($request,$agent) {
		$insertQuery = DB::table('mst_agentdetail')
				->insert([
				'agent_id' => $agent,
				'agent_name' => $request->txt_agentName,
				'agent_kananame' => $request->txt_agentNameJp,
				'contract' => $request->txt_agentContract,
				'agent_contact_no' => $request->txt_mobilenumber,
				'agent_email_id' => $request->txt_emailId,
				'agent_fax_no' => $request->txt_fax,
				'agent_website' => $request->txt_url,
				'agent_address' => $request->txt_address,
				'postalNumber' => $request->txt_postal,
				'kenmei' => $request->kenmei,
				'shimei' => $request->txt_shimei,
				'street_address' => $request->txt_streetaddress,
				'buildingname' => $request->txt_buildingname,
				'created_by' => Auth::user()->username ]);
		return $insertQuery;
	}
	// Customer Id
	public static function getAgentdtls() {
		$query = DB::table('mst_agentdetail')
				->SELECT('customerId')
				->WHERE('delFlg',0)
				->GET();
		return $query;
	}
	// Get Customer 
	public static function getCustomergrp($result, $flg=null) {
		$concat = "";
		if ($result != "" &&  $flg == 2) {
			$concat = "WHERE mergeall.customer_id NOT IN($result)";
		}
		if ($result != "" && $flg == 1) {
			$concat = "WHERE mergeall.customer_id IN($result)";
		}
		$query = DB::select("SELECT * FROM(SELECT customer_id,customer_name
									FROM `mst_customerdetail`) AS mergeall $concat");

		return $query;
	}
	// Update Customer Id 
	public static function updCusDtls($request) {
		$customerId = "";
		$customer = explode(",", $request->selected);
		foreach ($customer as $key => $value) {
			$customerId .= $value.',';
			$updateQuery = DB::table('mst_customerdetail')
					->where('customer_id', $value)
					->where('delFlg', 0)
					->update(['agentId' => $request->agentId]);
		}
		$customerId = substr($customerId,0,-1);
		$update = DB::table('mst_agentdetail')
					->where('agent_id', $request->agentId)
					->where('delFlg', 0)
					->update(['customerId' => $customerId]);
		return $update; 
	} 
}