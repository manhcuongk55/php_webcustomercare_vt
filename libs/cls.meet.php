<?php
class CLS_MEET {
	private $pro=array(
		'ID'=>'0',
		'MemId'=>'',
		'CustomerId'=>'',
		'Content'=>'',
		'Status'=>'',
		'DateTime'=>'',
		'Type'=>'',
		'Address'=>'',		
		'Image'=>'',
		'Result'=>'',
		'NextTime'=>'',
		'NextContent'=>'',
		'Note'=>''
		);
	private $objmysql=null;
	public function CLS_MEET(){
		$this->objmysql=new CLS_MYSQL;		
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
		$sql="INSERT INTO `tbl_meet`(
			`mem_id`,`customer_id`,`content`,`status`,`datetime`,`type`,
			`address`,`image`,`result`,`next_time`,`next_content`,`note`) 
		VALUES (
			'".$this->MemId."','".$this->CustomerId."',N'".$this->Content."','".$this->Status."','".$this->DateTime."','".$this->Type."','".$this->Address."','".$this->Image."','".$this->Result."','".$this->NextTime."','".$this->NextContent."','".$this->Note."')";
		// die($sql);
		return $this->objmysql->Exec($sql);
	}

	public function Update() {
		$sql = "UPDATE tbl_meet SET 
					`mem_id`='".$this->MemId."',
					`customer_id`='".$this->CustomerId."',
					`content`='".$this->Content."',
					`status`='".$this->Status."',
					`datetime`='".$this->DateTime."',
					`type`='".$this->Type."',
					`address`='".$this->Address."',
					`image`='".$this->Image."',
					`result`='".$this->Result."',
					`next_time`='".$this->NextTime."',
					`next_content`='".$this->NextContent."',
					`note`='".$this->Note."'
					 WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_meet` WHERE  `id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql1);
	}
	
	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_meet` WHERE 1=1 ".$where.$limit;
		// echo $sql;
		return $this->objmysql->Query($sql);
	}
	
}
?>