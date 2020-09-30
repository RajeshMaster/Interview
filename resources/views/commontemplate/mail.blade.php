<div style="padding-bottom:10px">
	<table style="border:#f6f2f2 solid 5px;font-family:Calibri" width="670" cellspacing="0" cellpadding="0" border="0" align="center">
		<tbody>
			<tr>
				<td colspan="2" style="padding:15px 5px 15px 5px;border-bottom:#ccc solid 1px">
					<table style="font-family:Arial,Helvetica,sans-serif;font-size:12px" width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td style="padding-right:10px" width="187" align="left">
									<img src="http://ssdev.microbit.co.jp/AssetManagement/public/images/Microbit_logo.jpg" alt="Microbit" class="CToWUd">
								</td>
							</tr>
							<tr>
								<td colspan="2" style="font-family:Calibri;text-align:left;color:#959595;padding:10px;line-height:18px;font-size:13px"><span class="il">
									</span>To Login directly to the Employer, please click on Login button
								</td>
							</tr>
							<tr>
								<td colspan="2" style="padding:20px;color:#5a5a5a;font-family:Calibri;font-size:16px" bgcolor="#d8e8f5">
									<div><b>Welcome to Microbit Pvt Ltd..! </b></div>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="padding:20px 20px 0 20px;color:#5a5a5a;line-height:22px;font-family:Calibri;font-size:14px" bgcolor="#FFFFFF">
									<p>Dear &nbsp;{{ $mailcontent['name'] }}</p>{!! nl2br(e($mailcontent['content'])) !!}
								</td>
							</tr>
							<tr>
								<td colspan="2" bgcolor="#FFFFFF">
									<table width="650" style="font-family:Calibri;text-align:left;padding:10px 5px 0;line-height:18px;font-size:14px" cellspacing="0" cellpadding="5" border="0" align="center">
										<colgroup>
											<col width="5%">
											<col width="4%">
											<col>
										</colgroup>
										<tbody>
											<tr>
												<td colspan="3" height="54" bgcolor="#E4E4E4" align="center">
													<a href="{{ url('User/verifyLogin?userId='.$mailcontent['userid'].'&name='.$mailcontent['name']) }}" target="_blank" style="background:#bf4237;font-size:18px;color:#fff;text-decoration:none;border-radius:2px;padding:7px 30px;display:inline-block">Verify Login</a>
												</td>
											</tr>
											<tr>
												<td colspan="3" style="padding:20px 20px 0 20px;color:#5a5a5a;line-height:22px;font-family:Calibri;font-size:16px" bgcolor="#FFFFFF">
													<?php
														$word = "Microbit.com";
														echo str_replace("Microbit.com", "<a target=\"_blank\" href=\"{$visiturl}\">{$word}</a>", $signature);
													?>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>