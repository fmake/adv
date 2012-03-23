<?php
class projects_seo_queryParamsValue extends fmakeCore{
		
	public $table = "projects_seo_query_param_value";
	public $idField = array("id_projects_seo_query_param","id_seo_query");
	public $order = "id_seo_query";

	/**
	*  для url проекта
	*/
	function getValue($id_seo_query){
		$where[] = "`id_seo_query` = '{$id_seo_query}'";
		$arr = ( ($this -> getWhere($where)) );
		$ans = array();
		$index = sizeof($arr);
		for ($i = 0; $i < $index; $i++) {
			$ans[$arr[$i]['id_projects_seo_query_param']] = $arr[$i];
		}
		return $ans;
	}
	
	/**
	* получить позицию по запросу и дате
	*/
	function getByQueryParam( $id_projects_seo_query_param, $id_seo_query){
		$where[] = "`id_projects_seo_query_param` = '{$id_projects_seo_query_param}'";
		$where[] = "`id_seo_query` = '{$id_seo_query}'";
		$arr = ($this -> getWhere($where));
		return $arr[0];
	}
	
	/**
	*
	* Создание нового объекта, с использованием массива params
	*/
	function newItem(){
		if($this -> getByQueryParam($this -> params['id_projects_seo_query_param'],$this -> params['id_seo_query'])){
			$this->update();
			return;
		}
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
		
		foreach($this->filds as $fild){
			if(!isset($this->params[$fild]) || in_array($fild,  $this -> idField)) continue;
				$update =  $this->dataBase->UpdateDB( __LINE__);
				$update	-> addTable($this->table) -> addFild("`".$fild."`", $this->params[$fild]);
				
				foreach($this->idField as $fld){
					$update -> addWhere("{$fld}='".$this->params[$fld]."'");
				}
			$update  -> queryDB();
		}
	}
	
} 

