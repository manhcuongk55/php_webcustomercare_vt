<?php
class CLS_FIELD_INFOMATION{
	private $pro=array(
		'ID'=>'0',
		'SubCatId'=>'',
		'Alias'=>'',
		'Name'=>'',
		'DataType'=>'',
		'IsActive'=>'',
		'Cdate'=>''
		);
	private $objmysql=null;
	public function CLS_FIELD_INFOMATION(){
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
		$sql="INSERT INTO `tbl_field_infomation`(`mem_id`,`type`,`fullname`,`birthday`,`diedate`,`birthday_family`,`diedate_family`,`cdate`,`phone`,`gender`) 
		VALUES ('".$this->MemId."','".$this->Type."',N'".$this->FullName."','".$this->Birthday."',
				'".$this->DieDate."','".$this->BirthdayFamily."','".$this->DiedateFamily."',
				'".$cdate."','".$this->Phone."','".$this->Gender."')";

		// echo $sql; die;
		$this->objmysql->Exec($sql);
		$lastID = $this->objmysql->LastInsertID();
		return $lastID;
	}

	public function Update() {
		$sql = "UPDATE tbl_field_infomation SET 
					`fullname`='".$this->FullName."', 
					`birthday`='".$this->Birthday."',
					`diedate`='".$this->DieDate."',
					`birthday_family`='".$this->BirthdayFamily."',
					`diedate_family`='".$this->DiedateFamily."',
					`type`='".$this->Type."',
					`phone`='".$this->Phone."',
					`gender`='".$this->Gender."'
					 WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_field_infomation` WHERE  `id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql1);
	}

	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_field_infomation` WHERE 1=1 ".$where.$limit;
		// echo $sql;
		return $this->objmysql->Query($sql);
	}
	
}
?>