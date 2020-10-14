<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use DB;

use Session;

use Input;

use App;

use Mail;

class SendingMail extends Model {

	public static function sendIntimationMail($mailformat, $to ,$maildetailssubject,$cc=null ,$protectpath=null,$files=null,$excelpdf=null,$excelfile=null) {
		$msg = $mailformat[0];
		Mail::sendwithoutview($msg, $mailformat, function ($message) use ($to,$maildetailssubject,$cc,$protectpath,$files,$excelpdf,$excelfile) {

			$nickname = "MICROBIT";
			$message->from('staff@microbit.co.jp',$nickname);
			// if(Session::get('nickName')!="") {
			// 	$nickname=Session::get('nickName');
			// } else {
			// 	$nickname = "MICROBIT";
			// }

			// $message->from(Session::get('sessionfrommail'),$nickname);
			for ($i=1; $i < count($files) ; $i++) { 
				$message->attach($protectpath.$files[$i].".pdf");
			}
			if ($excelpdf != "") {
				if (is_array($excelpdf)) {
					foreach ($excelpdf as $key => $value) {
						$message->attach($protectpath.$value);
					}
				} else {
					$message->attach($protectpath.$excelpdf);
				}
			}

			if ($excelfile != "") {
				$message->attach($protectpath.$excelfile);
			}

			$message->to($to)->subject($maildetailssubject);

			if($cc != "") {
				$message->cc($cc);
			}
		});
		
		return true;
	}
}