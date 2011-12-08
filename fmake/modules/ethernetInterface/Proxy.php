<?php
/**
 * 
 */
class ethernetInterface_Proxy extends fmakeCore{
	public $table = "proxy";
	public $order = "position";
	public $default = 1000;
	
	
	function getByYandex($active = false){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		if($active)
			$select -> addWhere("active='1'");
		
		$arr = $select -> addFrom($this->table) -> addOrder($this->order, ASC)-> addWhere("count > 0")  -> queryDB();
	
		if($arr){
			$num = rand(0,count($arr)-1);
			$this->setId($arr[$num]['id']);
			$this->addParam("count",$arr[$num]['count']-1);
			$this->update();
			$ans['proxy'] = $arr[$num]['proxy'];
			$ans['key'] = $arr[$num]['key'];
			return $ans;
		}else{
			return false;
		}
	
	}
	
	function getByGoogle($active = false){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		if($active)
			$select -> addWhere("active='1'");
		
		$arr = $select -> addFrom($this->table) -> addOrder("last_used", ASC)-> queryDB();
		
		// выставляем время использования
		$this->setId($arr[0]['id']);
		$this->addParam("last_used", time());
		$this -> update();
		
		return $arr[0];
	}
	
	function setDefault(){
		$all = $this->getAll();
		for($i=0;$i<count($all);$i++){
			$this->setId($all[$i]['id']);
			$this->addParam("count",$this->default);
			$this->update();
		}
	}
}