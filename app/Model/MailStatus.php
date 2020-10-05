<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Config;
class MailStatus extends Model {
	/**
	*
	* To Mail Status Index View
	* @author Sathish
	* Created At 05/10/2020
	*
	*/
	public static function getMailStausData($request)
	{
		$result = db::table('mailStatus')
						->select('mailStatus.*','mst_customerdetail.customer_name','branch.branch_name')
						->leftJoin('mst_customerdetail' , 'mst_customerdetail.customer_id' ,'=','mailStatus.companyId')
						->leftjoin('mst_branchdetails AS branch', function($join)
						{
							$join->on('branch.customer_id', '=', 'mailStatus.companyId');
							$join->on('branch.branch_id', '=', 'mailStatus.branchId');
						});
						if ($request->customerid  != "") {
							$result = $result->WHERE('mailStatus.sendFlg','=',$request->historyfilter)
											->WHERE('mailStatus.companyId','=',$request->customerid);
										$result = $result->orderby('mailStatus.id','DESC')
														->paginate($request->plimit);

						} else {

							$result = $result	->WHERE('mailStatus.sendFlg',$request->sendfilter)
												->WHERE('mailStatus.delFlg',0);
									$result = $result->orderby('mailStatus.id','DESC')
								->paginate($request->plimit);
						}
						return $result;
	}
	/**
	*
	* To Mail Status Single View
	* @author Sathish
	* Created At 05/10/2020
	*
	*/
	public static function getSingleMailStatus($request){
		$result = db::table('mailStatus')
						->select('mailStatus.*','mst_customerdetail.customer_name')
						->leftJoin('mst_customerdetail' , 'mst_customerdetail.customer_id' ,'=','mailStatus.companyId')
						->WHERE('mailStatus.delFlg',0)
						->WHERE('mailStatus.id','=',$request->statusid)
						->get();
		return $result;
	}
}
