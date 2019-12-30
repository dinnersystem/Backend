<?php
namespace order\money_info;

function payment_auth($row ,$target ,$password ,$req_id)
{
	# password control
	\punish\check($row->user->id ,"payment");
	$raw_success = raw_auth($row ,$password);
	if(!$raw_success) {
		\punish\attempt($row->user->id ,$req_id ,"payment");
		throw new \Exception("Wrong password");
	}
		
	# today control
	if(date("Y-m-d" ,strtotime($row->esti_recv)) != date("Y-m-d"))
		throw new \Exception("Only allow payment for today");
	
	# date time control
	if(!\other\date_api::is_between(
		$row->money->payment["payment"]->able_dt,
		date('Y-m-d H:i:s'),
		$row->money->payment["payment"]->freeze_dt
	)) throw new \Exception("The payment has expired or it's not yet to pay.");

	# reversable control
	if(!$target && !$row->money->payment["payment"]->reversable)
		throw new \Exception("Payment is unreversable.");
	return true;
}

?>
