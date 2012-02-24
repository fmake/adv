<?php
class projects_seo_urlParamsValue extends fmakeCore{
		
	public $table = "projects_seo_url_param_value";
	public $idField = array("id_projects_seo_url_param","id_project_url");
	public $order = "id_project_url";

	/**
	*  для url проекта
	*/
	function getValue($id_project_url){
		$where[] = "`id_project_url` = '{$id_project_url}'";
		$arr = ( ($this -> getWhere($where)) );
		$ans = array();
		$index = sizeof($arr);
		for ($i = 0; $i < $index; $i++) {
			$ans[$arr[$i]['id_projects_seo_url_param']] = $arr[$i];
		}
		return $ans;
	}
	
	/**
	* получить позицию по запросу и дате
	*/
	function getByUrlParam( $id_projects_seo_url_param, $id_project_url){
		$where[] = "`id_projects_seo_url_param` = '{$id_projects_seo_url_param}'";
		$where[] = "`id_project_url` = '{$id_project_url}'";
		$arr = ($this -> getWhere($where));
		return $arr[0];
	}
	
	/**
	*
	* Создание нового объекта, с использованием массива params
	*/
	function newItem(){
		if($this -> getByUrlParam($this -> params['id_projects_seo_url_param'],$this -> params['id_project_url'])){
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

