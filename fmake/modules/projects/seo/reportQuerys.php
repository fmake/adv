<?php

/**
 * 
 * запросы в отчетах для оптимизаторов
 */
class projects_seo_reportQuerys extends fmakeCore{
		
	public $table = "projects_seo_report_querys";
	public $idField = array("id_seo_query","id_project_seo_report");
	public $order = "wordstat";
	
	/**
	 * 
	 * получить главный запрос по url
	 */
	function getPollQuery($id_project_seo_report,$id_project_url){
		$select = $this->dataBase->SelectFromDB( __LINE__);
		return $select -> addFrom($this->table)-> addWhere("id_project_url = '{$id_project_url}'") -> addWhere("id_project_seo_report = '{$id_project_seo_report}'") -> addOrder('wordstat', 'DESC')  -> addLimit(0, 1) -> queryDB();
	}
	
	/**
	 * 
	 * получить не проверенные запросы
	 */
	function getNonCheckQuery($id_project_seo_report){
		$where[] = "id_project_seo_report = '{$id_project_seo_report}'";
		$where[] = "`check` = '0'";
		return $this -> getWhere($where);
	}
	
	/**
	 * 
	 * получить запрос
	 */
	function getQuery($id_seo_query,$id_project_seo_report){
		$where[] = "id_project_seo_report = '{$id_project_seo_report}'";
		$where[] = "id_seo_query = '{$id_seo_query}'";
		return $this -> getWhere($where);
	}
	
	/**
	*
	* Создание нового объекта, с использованием массива params
	*/
	function newItem(){
		if($this -> getQuery($this -> params['id_seo_query'],$this -> params['id_project_seo_report'])){
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