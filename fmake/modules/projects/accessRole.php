<?php
class projects_accessRole extends fmakeCore{
		
	public $table = "projects_access_role";
	public $idField = array("id_project","id_role");
	public $order = "id_project";
	
	
	
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
	
	function addAccess(){
		$where[] = "`id_project` = '{$this -> params[id_project]}'";
		$where[] = "`id_role` = '{$this -> params[id_role]}'";
		if($this -> getWhere($where)){
			$this -> update();
		}else{
			$this -> newItem();
		}
	}
	/*
	 * получаем роли для проекта
	 */
	function getProjectRols($id_project){
		$where[] = "`id_project` = '{$id_project}'";
		$rolesAll =  ($this -> getWhere($where));
		$index = sizeof($rolesAll);
		for ($i = 0; $i < $index; $i++) {
			$rols[$rolesAll[$i]["id_role"]] = $rolesAll[$i];
		}
		return $rols;
	}
	
	/**
	*
	* удаляем по проекту
	*/
	function deleteByProjectId($id_project){
		$delete = $this->dataBase->DeleteFromDB( __LINE__ );
		$delete	-> addTable($this->table) -> addWhere("`id_project` = '".$id_project."'") -> queryDB();
	}
	
}