<?php
include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.user.php");
include_once("../libs/cls.schedule.php");
date_default_timezone_set("Asia/Ho_Chi_Minh");

$date=date('Y-m-d h:i:s').' Call by '.$_SERVER['REMOTE_ADDR']."\n";
file_put_contents('logs.txt',$date,FILE_APPEND);

// get list member id 
$objmysql=new CLS_MYSQL;
$objUser=new CLS_USER;
$objSchedule=new CLS_SCHEDULE;

$year=date('Y');
$month=date('m');
$day=date('d')+1;
$start = $year."-".$month."-".$day." 00:00:00";
$end = $year."-".$month."-".$day." 23:59:59";

// in case manual send to sms from management schedule
if (isset($_POST['scheduleId']) && isset($_POST['memId'])) {
	// Get info api_key and secret key
	$sql="SELECT `id`,`api_key`, `secret_key` FROM tbl_member_level where id='".$_POST['memId']."' and permistion='0' group by id";
	$objmysql->Query($sql);
	$r=$objmysql->Fetch_Assoc();
	$APIKey=trim($r['api_key']);
	$SecretKey=trim($r['secret_key']);
	
	$query="SELECT * FROM tbl_schedule WHERE id='".$_POST['scheduleId']."' ";
	$objmysql->Query($query);
	
	if($objmysql->Num_rows() > 0) { 
		while($rs=$objmysql->Fetch_Assoc()) {	
			$memId = $rs['mem_id'];
			$userId = $rs['user_id'];

			$YourPhone=getPhoneUser($rs['user_id']);		
			$Content=un_unicode_sms($rs['event_description']);		
			$SendContent=urlencode($Content);

			$data="http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$YourPhone&ApiKey=$APIKey&SecretKey=$SecretKey&Content=$SendContent&SmsType=4";

			//echo $data;

			$curl = curl_init($data); 
			curl_setopt($curl, CURLOPT_FAILONERROR, true); 
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
			$result = curl_exec($curl); 
			$obj = json_decode($result,true);
			$respone = "";
			$time_send = date('Y-m-d H:i:s');

		    if($obj['CodeResult']==100)
		    {
		        $respone.="CodeResult:".$obj['CodeResult'];
		        file_put_contents('logs.txt',$respone,FILE_APPEND);

		        $q = "INSERT INTO tbl_sms (`mem_id`,`user_id`,`content`,`status`,`time_send`,`type`) VALUES ('".$memId."','".$userId."','".$Content."',1,'".$time_send."', 'eSMS')";
		        $objmysql->Exec($q);
		        echo "success";
		    }
		    else
		    {
		        $respone.="ErrorMessage:".$obj['ErrorMessage'];
		        file_put_contents('logs.txt',$respone,FILE_APPEND);

		        $q = "INSERT INTO tbl_sms (`mem_id`,`user_id`,`content`,`status`,`time_send`, `type`) VALUES ('".$memId."','".$userId."','".$Content."',0, '".$time_send."', 'eSMS')";
		        $objmysql->Exec($q);
		        echo $data;
		    }

		} // end while

	} // end if


}  
// incase send sms by esms multiple user
else if (isset($_POST['smsContent']) && isset($_POST['memId'])) {
	$lstIds = $_POST['lstIds'];
	$lstIds = substr($lstIds, 0, strlen($lstIds)-1);
	$lstIds = str_replace(",", "','", $lstIds);

	if ($lstIds != "") {
		// Get list phone number by list id
		$lstPhone = $objUser->getListPhoneNumberByIds($lstIds);
		// Get info api_key and secret key by mem id
		$sql="SELECT `id`,`api_key`, `secret_key` FROM tbl_member_level where id='".$_POST['memId']."' and permistion='0' group by id";
		$objmysql->Query($sql);
		$r=$objmysql->Fetch_Assoc();

		$APIKey=trim($r['api_key']);
		$SecretKey=trim($r['secret_key']);

		$YourPhone=$lstPhone;		
		$Content=un_unicode_sms($_POST['smsContent']);		
		$SendContent=urlencode($Content);

			//echo $YourPhone."--".$Content."</br>";
			$data="http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$YourPhone&ApiKey=$APIKey&SecretKey=$SecretKey&Content=$SendContent&SmsType=4";

			//echo $data;

			$curl = curl_init($data); 
			curl_setopt($curl, CURLOPT_FAILONERROR, true); 
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
			$result = curl_exec($curl); 
			$obj = json_decode($result,true);
			$respone = "";
			$time_send = date('Y-m-d H:i:s');

		    if($obj['CodeResult']==100)
		    {
		        $respone.="CodeResult:".$obj['CodeResult'];
		        file_put_contents('logs.txt',$respone,FILE_APPEND);

		        $q = "INSERT INTO tbl_sms (`mem_id`,`user_id`,`content`,`status`,`time_send`,`type`) VALUES ('".$memId."','".$userId."','".$Content."',1,'".$time_send."','eSMS')";
		        $objmysql->Exec($q);
		        echo "success";
		    }
		    else
		    {
		        $respone.="ErrorMessage:".$obj['ErrorMessage'];
		        file_put_contents('logs.txt',$respone,FILE_APPEND);

		        $q = "INSERT INTO tbl_sms (`mem_id`,`user_id`,`content`,`status`,`time_send`,`type`) VALUES ('".$memId."','".$userId."','".$Content."',0, '".$time_send."','eSMS')";
		        $objmysql->Exec($q);
		        echo "error";
		    }

	} else {
		echo "error";
	}

} else {
	// get list member id in case system send sms automatic
	$sql="SELECT `id`,`api_key`, `secret_key` FROM tbl_member_level where permistion='0' group by id";
	$objmysql->Query($sql);

	if($objmysql->Num_rows() > 0) {
		while ($r=$objmysql->Fetch_Assoc()) {
			$APIKey=trim($r['api_key']);
			$SecretKey=trim($r['secret_key']);
			//echo $APIKey."--".$SecretKey."-->";

			$query="SELECT * FROM tbl_schedule WHERE `event_start` >= '".$start."' and `event_start` <= '".$end."' and status=0 AND mem_id in ('".$r['id']."')";
			//echo $query;
			$objDB = new CLS_MYSQL;
			$objDB->Query($query);

			if($objDB->Num_rows() > 0) { 

				while($rs=$objDB->Fetch_Assoc()) {	
					$memId = $rs['mem_id'];
					$userId = $rs['user_id'];

					$YourPhone=getPhoneUser($rs['user_id']);		
					$Content=un_unicode_sms($rs['event_description']);		
					$SendContent=urlencode($Content);

					//echo "---phone".$YourPhone."--".$Content."</br>";
					
					$data="http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$YourPhone&ApiKey=$APIKey&SecretKey=$SecretKey&Content=$SendContent&SmsType=4";

					$curl = curl_init($data); 
					curl_setopt($curl, CURLOPT_FAILONERROR, true); 
					curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
					$result = curl_exec($curl); 
						
					$obj = json_decode($result,true);
					$respone = "";
					$time_send = date('Y-m-d H:i:s');
				    if($obj['CodeResult']==100)
				    {
				        
				        $respone.="CodeResult:".$obj['CodeResult'];
				        file_put_contents('logs.txt',$respone,FILE_APPEND);

				        $q = "INSERT INTO tbl_sms (`mem_id`,`user_id`,`content`,`status`,`time_send`,`type`) VALUES ('".$memId."','".$userId."','".$Content."',1,'".$time_send."','eSMS')";
				        $objDB->Exec($q);
				    }
				    else
				    {
				    	
				        $respone.="ErrorMessage:".$obj['ErrorMessage'];
				        file_put_contents('logs.txt',$respone,FILE_APPEND);

				        $q = "INSERT INTO tbl_sms (`mem_id`,`user_id`,`content`,`status`,`time_send`,`type`) VALUES ('".$memId."','".$userId."','".$Content."',0, '".$time_send."','eSMS')";
				        $objDB->Exec($q);
				    }

				} // end while
			} // end if


		} // end while
	}

}

function getPhoneUser($id) {
	$sql="SELECT phone FROM tbl_user WHERE id='".$id."'";	
	$obj=new CLS_MYSQL;
	$obj->Query($sql);
	$rs=$obj->Fetch_Assoc();
	return $rs['phone'];
}


?>
