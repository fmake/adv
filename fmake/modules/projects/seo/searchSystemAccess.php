<?php
class projects_seo_searchSystemAccess extends fmakeCore{
		
	public $table = "projects_seo_search_system";
	public $idField = array("id_project","id_seo_search_system");
	public $order = "position";
	
	
	/**
	*
	* Создание нового объекта, с использованием массива params
	*/
	function newItem(){
		$insert = $this->dataBase->InsertInToDB(__LINE__);
			
		$insert	-> addTable($this->table);
		$this->getFilds();
		
		if($this->filds){
	
			if(in_array('position',$this->filds)){
				$select = $this->dataBase->SelectFromDB(__LINE__);
				$position = $select -> addFild('MAX(`position`) AS `position`') -> addFrom($this->table) -> queryDB();
				$this->params['position'] = $position[0]['position'] + 1;
			}
			
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
	
	function addSystemAccess(){
		foreach($this->idField as $fld){
			$where[] = "`$fld` = '{$this -> params[$fld]}'";
		}
		if($this -> getWhere($where)){
			$this -> update();
		}else{
			$this -> newItem();
		}
	}
	
	/**
	*
	* Удаление записи, перед использованием надо установить id записи
	*/
	function delete(){
		$prSeoExs = new projects_seo_searchSystemExs();
		$prSeoExs -> deleteBySearchSystemProjectId($this->params[id_seo_search_system],$this->params[id_project]);
		
		$delete = $this->dataBase->DeleteFromDB( __LINE__ );
		$delete	-> addTable($this->table) ;
		foreach($this->idField as $fld){
			$delete -> addWhere("{$fld}='".$this->params[$fld]."'");
		}
		$delete -> queryDB();
	}
	
	function deleteWhereNotIn($id_project, $arr){
		//if(!$arr[0])return;
	
		$select = $this->dataBase->SelectFromDB(__LINE__);
	
	
		for($i=0;$i<sizeof($arr);$i++)
		$select -> addWhere("id_seo_search_system !='".$arr[$i]."'");
	
		$deletedElement =  $select -> addFrom($this->table)  -> addWhere("id_project = '{$id_project}'") ->  queryDB();
		for($i=0;$i<sizeof($deletedElement);$i++){
			foreach($this->idField as $fld){
				$this->addParam($fld, $deletedElement[$i][$fld]);
			}
			$this->delete();
		}
			
	}
	/*
	 * получаем роли для проекта
	*/
	function getProjectSystems($id_project){
		$where[] = "`id_project` = '{$id_project}'";
		$searchSystemAll =  ($this -> getWhere($where));
		$index = sizeof($searchSystemAll);
		for ($i = 0; $i < $index; $i++) {
			$systems[$searchSystemAll[$i]["id_seo_search_system"]] = $searchSystemAll[$i];
		}
		return $systems;
	}
	
	/**
	*
	* удаляем по проекту
	* @param unknown_type $id_exs
	*/
	function deleteByProjectId($id_project){
		$delete = $this->dataBase->DeleteFromDB( __LINE__ );
		$delete	-> addTable($this->table) -> addWhere("`id_project` = '".$id_project."'") -> queryDB();
	}
	
	
}