<?php
include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.user.php");
$objUser = new CLS_USER;
$objmysql = new CLS_MYSQL;
date_default_timezone_set("Asia/Ho_Chi_Minh");

$date=date('Y-m-d h:i:s').' Call by '.$_SERVER['REMOTE_ADDR']."\n";
file_put_contents('logs.txt',$date,FILE_APPEND);

$lstPhone = $smsContent = $memId = $lstIds"" ;
if (isset($_POST['lstIds']) && isset($_POST['smsContent']) && $_POST['memId']) {
	$lstIds = substr($_POST['lstIds'], 0, strlen($_POST['lstIds'])-1);	
	$lstIds = str_replace(",", "','", $lstIds);
	$lstPhone = $objUser->getListPhoneNumberByIds($lstIds);

	$smsContent = $_POST['smsContent'];
	$memId = $_POST['memId'];	

	
	$arrPhone = explode(",", $lstPhone);
	$lstPhone = "";
	for ($i=0; $i < count($arrPhone); $i++) { 
		$lstPhone .= "+84".substr($arrPhone[$i], 1, strlen($arrPhone[$i])).',';
	}
	$lstPhone = substr($lstPhone, 0, strlen($lstPhone)-1);

	$jsons = array(
		'user'=>'bach',
		'pass'=>'passbach',
		'phone'=>'+841682118888,+841656241161,+841656241161,+841656241161,+841656241161,+841656241161,+841656241161',
		'content'=>$smsContent 
	);	

	$data_post = "";
	foreach($jsons as $key=>$value) { 
		$data_post .= $key.'='.$value.'&'; 
	}
	$data_post = substr($data_post, 0, strlen($data_post)-1);

	// POST data to webserver
	$curl = curl_init();	
	curl_setopt($curl, CURLOPT_URL, 'http://localhost:2816/SMS.ashx');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_post);

	$json_response = curl_exec($curl);

	if($json_response === false) {
		echo "Error:";
		curl_error($curl);
	}
	curl_close($curl);

	$response = json_decode($json_response, true);
	//var_dump($response);

	foreach ($response as $key => $value) {
		if ($key=="Data") {
			$sql = "INSERT INTO tbl_sms (`mem_id`,`user_id`,`content`,`status`,`time_send`,`type`) VALUES ";
			foreach ($value as $k => $val) {
				$phone = "0".substr($val['Phone'], 3, strlen($val['Phone'])); // substring +84 replace +84 equals 0	
				$content = $val['Content'];
				$result = $val['Result'];
				$status = $result == "1" ? "1" : "0"; // 1; success, 0 failed

				$userId = $objUser->getIdByPhone($phone); 
				$time_send = date('Y-m-d H:i:s');
				$sql .= "('".$memId."','".$userId."','".$content."','".$status."','".$time_send."', 'USB 3G'),";
			        
			}
			$sql = substr($sql, 0, strlen($sql)-1);
			$objmysql->Exec($sql);
			echo "success";
		}
	}
} 

?>