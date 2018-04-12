<?php
class CLS_SUBCAT {
	private $pro=array(
		'ID'=>'0',
		'CatId'=>'',
		'Name'=>'',
		'Alias'=>'',
		'Cdate'=>'',
		'IsActive'=>''
		);
	private $objmysql=null;
	public function CLS_SUBCAT(){
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
		$sql="INSERT INTO `tbl_sub_category`(`cat_id`,`name`,`alias`,`cdate`,`isactive`) 
		VALUES ('".$this->CatId."',N'".$this->Name."','".$this->Alias."',
				'".$cdate."','".$this->IsActive."')";
		return $this->objmysql->Exec($sql);
	}

	public function Update() {
		$sql = "UPDATE tbl_sub_category SET 
					`cat_id`='".$this->CatId."', 
					`name`='".$this->Name."',
					`alias`='".$this->Alias."'
					 WHERE `id`='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}

	public function Delete() {
		$sql1="DELETE FROM `tbl_sub_category` WHERE  `id`= '".$this->ID."' ";
        $objdata=new CLS_MYSQL();
        return $this->objmysql->Exec($sql1);
	}
	
	public function getList($where='' , $limit){
		$sql="SELECT * FROM `tbl_sub_category` WHERE 1=1 ".$where.$limit;
		// echo $sql;
		return $this->objmysql->Query($sql);
	}

	public function getAliasSubCat($idCat) {
		$sql="SELECT `alias` FROM `tbl_sub_category` WHERE id=$idCat";
		$this->objmysql->Query($sql);
		$rs = $this->objmysql->Fetch_Assoc();
		return $rs['alias'];
	}
	
}
?>