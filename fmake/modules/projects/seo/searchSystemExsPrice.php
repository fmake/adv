<?php
class projects_seo_searchSystemExsPrice extends fmakeCore{
		
	public $table = "projects_seo_search_system_exs_price";
	public $idField = array("id_exs","id_seo_query");
	public $order ="id_seo_query";
	
	/**
	*
	* Создание нового объекта, с использованием массива params
	*/
	function newItem(){
		$insert = $this->dataBase->InsertInToDB(__LINE__);
			
		$insert	-> addTable($this->table);
		$this->getFilds();
	
		if($this->filds){
	
			foreach($this->filds as $fild){
				if(!isset($this->params[$fild])) continue;
				$insert -> addFild("`".$fild."`", $this->params[$fild]);
			}
	
		}
		$insert->queryDB();
		$this->id = $insert	-> getInsertId();
	}
	
	function update() {
		if(!$this->filds)
		$this->getFilds();
	
		foreach($this->filds as $fild)
		{
			if(!isset($this->params[$fild]) || in_array($fild,  $this -> idField)) continue;
			$update =  $this->dataBase->UpdateDB( __LINE__);
			$update	-> addTable($this->table) -> addFild("`".$fild."`", $this->params[$fild]);
			foreach($this->idField as $fld){
				$update -> addWhere("{$fld}='".$this->params[$fld]."'");
			}
			$update  -> queryDB();
		}
	}
	
	function addPriceEx(){
		foreach($this->idField as $fld){
			$where[] = "`$fld` = '{$this -> params[$fld]}'";
		}
		$ex = $this -> getWhere($where);
		if($exs){
			$this -> update();
		}else{
			$this -> newItem();
			$ex = $this -> getWhere($where);
		}
		return $ex;
	}
	
	function getPriceExsSearch($id_exs,$id_seo_query){
		$where[] = "`id_exs` = '{$id_exs}'";
		$where[] = "`id_seo_query` = '{$id_seo_query}'";
		
		$arr = $this -> getWhere($where);
		return $arr[0];
	}
	
}