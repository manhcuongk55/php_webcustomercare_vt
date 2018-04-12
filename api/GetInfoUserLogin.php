<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
include_once("../includes/gfinnit.php");
include_once("../libs/cls.mysql.php"); 
$objmysql = new CLS_MYSQL;


//$date=date('Y-m-d h:i:s').' Call by '.$_SERVER['REMOTE_ADDR']."\n";
//file_put_contents('logs.txt',$date,FILE_APPEND);

//$data = file_get_contents('php://input');
//$data =  '[{"username":"bachbanhbao","password":"123456a@"}]';
//$data = $data." \n";
//file_put_contents('logs.txt',$data,FILE_APPEND);

// if ($data != null) {
// 	$objRequest = json_decode($data);
// 	$username=$objRequest[0]->username;
// 	$password=md5(sha1($objRequest[0]->password));
// 	// query data
// 	$sql = "select username,password from tbl_member_level where username='".$username."'";
// 	$objmysql->Query($sql);
// 	if ($objmysql->Num_rows()>0) {
// 		$rs=$objmysql->Fetch_Assoc();
// 		if (trim($password)==trim($rs['password'])) {
// 			echo 'sucess';
// 		} else {
// 			echo 'failed';
// 		}
// 	} else {
// 		echo 'failed';
// 	}
// }

$date=date('Y-m-d h:i:s').' Call by '.$_SERVER['REMOTE_ADDR']."\n";
file_put_contents('logs.txt',$date,FILE_APPEND);

if (isset($_GET['user']) && isset($_GET['pass'])) {
	$data = $_GET['user'].'---'.$_GET['pass'];
	$data = $data." \n";
	file_put_contents('logs.txt',$data,FILE_APPEND);

	$username=$_GET['user'];
	$password=md5(sha1($_GET['pass']));
	// query data
	$sql = "select username,password from tbl_member_level where username='".$username."'";
	$objmysql->Query($sql);
	if ($objmysql->Num_rows()>0) {
		$rs=$objmysql->Fetch_Assoc();
		if (trim($password)==trim($rs['password'])) {
			echo "1";
		} else {
			echo "0";
		}
	} else {
		echo "0";
	}
}	
?>