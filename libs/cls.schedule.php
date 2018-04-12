<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
class CLS_SCHEDULE{
	private $pro=array(
		'ID'=>'0',
		'MemId'=>'',
		'UserId'=>'',
		'ServiceName'=>'',
		'ServicePrice'=>'',
		'EvtSubject'=>'',
		'EvtDescription'=>'',
		'EvtStart'=>'',
		'EvtEnd'=>'',
		'AllDay'=>'0',
		'Cdate'=>'',
		'Mdate'=>'',
		'Status'=>'0'
		);
	private $objmysql=null;
	public function CLS_SCHEDULE(){
		$this->objmysql=new CLS_MYSQL;
		$this->Cdate=date('Y-m-d H:i:s');
	}
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ("Can not found $proname member");
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ("Can not found $proname member");
			return;
		}
		return $this->pro[$proname];
	}

	
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}

	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}

	public function Add_new(){
		$cdate=date('Y/m/d H:i:s');
		$sql="INSERT INTO `tbl_schedule`(`mem_id`,`user_id`,`service_name`,`service_price`,`event_subject`,`event_description`,`all_day`,`event_start`,`event_end`,`cdate`,`mdate`,`status`) 
		VALUES ('".$this->MemId."','".$this->UserId."',N'".$this->ServiceName."','".$this->ServicePrice."',N'".$this->EvtSubject."',N'".$this->EvtDescription."','".$this->AllDay."',
				'".$this->EvtStart."','".$this->EvtEnd."',
				'".$cdate."','".$cdate."','".$this->Status."')";
		//echo $sql;

		return $this->objmysql->Exec($sql);
	}

	public function Update() {
		$mdate=date('Y/m/d H:i:s');
		$dateTime = date('Y-m-d H:i:s');
		$st = $this->getStatusById($this->ID);
		if ($st > 2 && strtotime($dateTime) < strtotime($this->EvtStart)) {
			// qua han hoac cancel thi cap nhat ve trang thai cho
			$q = "update tbl_schedule set status=0 where id='".$this->ID."'";
			$this->objmysql->Query($q);
		}

		$sql = "UPDATE tbl_schedule SET 
					`service_name`='".$this->ServiceName."',
					`service_price`='".$this->ServicePrice."',
					`event_subject`='".$this->EvtSubject."',
					`event_description`='".$this->EvtDescription."',					
					`event_start`='".$this->EvtStart."',
					`event_end`='".$this->EvtEnd."',					
					`mdate`='".$mdate."'

					 WHERE `id`='".$this->ID."'";
		//echo $sql; 
		return $this->objmysql->Exec($sql);
	}

	public function getStatusById($id) {
		$sql="select status from tbl_schedule where id=".$id;
		$this->objmysql->Query($sql);
		if($this->objmysql->Num_rows() > 0 ){
			$rs = $this->objmysql->Fetch_Assoc();
			return $rs['status'];
		} else {
			return 0;
		}
		
	}
	public function updateStatus() {
		$mdate=date('Y/m/d H:i:s');
		$sql = "UPDATE tbl_schedule SET 
					`status`='".$this->Status."',				
					`mdate`='".$mdate."'
					 WHERE `id`=".$this->ID;
		//echo $sql; 
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql="DELETE FROM `tbl_schedule` WHERE  `id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql);
	}

	public function getList($where='' , $limit){
		$sql="SELECT * FROM tbl_schedule WHERE 1=1 ".$where.$limit;		
		return $this->objmysql->Query($sql);
	}

	public function getListUserByMemId($memId) {
		$sql = "SELECT id, fullname, phone from tbl_user where mem_id=".$memId;
		$this->objmysql->Query($sql);
		$html = "<option value=''>Lựa chọn khách hàng</option>";
		if ($this->objmysql->Num_rows() > 0) {
			while ($r=$this->objmysql->Fetch_Assoc()) {
				$html.= "<option value='".$r['id']."'>".$r['fullname']." <strong>".$r['phone']."</strong></option>";
			}
		} 

		echo $html;
	}

	public function getListService() {
		$sql = "SELECT id, name from tbl_service";
		$this->objmysql->Query($sql);
		$html = "<option value=''>Lựa chọn dịch vụ</option>";
		if ($this->objmysql->Num_rows() > 0) {
			while ($r=$this->objmysql->Fetch_Assoc()) {
				$html.= "<option value='".$r['id']."'>".$r['name']."</strong></option>";
			}
		} 

		echo $html;
	}

	public function autoUpdateStatusOutDate($memId) {
		// update nhung task dang co trang thai cho trong qua khu ve qua hạn so vơi hiện tại
		$datetime = date("Y-m-d H:i:s");
		$query = "update tbl_schedule set status=3 where status=0 and event_start<'".$datetime."' and mem_id=".$memId;
		return $this->objmysql->Query($query);
	}

	public function getListSchedule($where, $limit) {

		$sql="select tbl_schedule.id as schedule_id, tbl_schedule.service_price, tbl_schedule.service_name,
			tbl_user.fullname as name_user, tbl_user.phone as phone_user, type, address,
			 event_subject, event_description, event_start, event_end, 
			tbl_schedule.status as status_schedule, tbl_user.id as user_id
			from tbl_user, tbl_schedule, tbl_member_level 
			where tbl_user.id = tbl_schedule.user_id 
			and tbl_schedule.mem_id = tbl_member_level.id 
			and ".$where." 
			order by tbl_schedule.cdate desc";	
		//echo $sql;
		//die;
		
		return $this->objmysql->Query($sql);
	}

	public function getNameStatus($status) {
		switch ($status) {
			case '0':
				return "<strong style=\"color:red\">Đang chờ</strong>";
				break;
			case '1':
				return "<strong style=\"color:red\">Đang thực hiện</strong>";
				break;
			case '2':
				echo "<strong style=\"color:red\">Hoàn thành</strong>";
				return;
			case '3':
				return "<strong style=\"color:red\">Quá hạn xử lý</strong>";
				break;
			case '-1':
				return "<strong style=\"color:red\">Được hủy bỏ</strong>";
				break;
			
			default:
				# code...
				break;
		}
	}
	
	
}
?>