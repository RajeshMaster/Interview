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
		$result = db::table('mailstatus')
						->select('mailstatus.*','mst_customerdetail.customer_name','branch.branch_name')
						->leftJoin('mst_customerdetail' , 'mst_customerdetail.customer_id' ,'=','mailstatus.companyId')
						->leftjoin('mst_branchdetails AS branch', function($join)
						{
							$join->on('branch.customer_id', '=', 'mailstatus.companyId');
							$join->on('branch.branch_id', '=', 'mailstatus.branchId');
						});
						if ($request->customerid  != "") {
							$result = $result->WHERE('mailstatus.sendFlg','=',$request->historyfilter)
											->WHERE('mailstatus.companyId','=',$request->customerid);
										$result = $result->orderby('mailstatus.id','DESC')
														->paginate($request->plimit);

						} else {

							$result = $result	->WHERE('mailstatus.sendFlg',$request->sendfilter)
												->WHERE('mailstatus.delFlg',0);
									$result = $result->orderby('mailstatus.id','DESC')
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
		$result = db::table('mailstatus')
						->select('mailstatus.*','mst_customerdetail.customer_name')
						->leftJoin('mst_customerdetail' , 'mst_customerdetail.customer_id' ,'=','mailstatus.companyId')
						->WHERE('mailstatus.delFlg',0)
						->WHERE('mailstatus.id','=',$request->statusid)
						->get();
		return $result;
	}
}
