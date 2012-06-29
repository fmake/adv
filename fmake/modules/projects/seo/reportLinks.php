<?php

/**
 * 
 * ссылки в отчетах для оптимизаторов
 */
class projects_seo_reportLinks extends fmakeCore{
		
	public $table = "projects_seo_report_links";
	public $idField = array("id_project_seo_report","	id_link");
	public $order = "id_project_seo_report";
	
	/**
	 * 
	 * Получить сгруппированные данные тиц
	 */
	function getCyData($id_project_seo_report){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$select -> addWhere('id_project_seo_report = \''.$id_project_seo_report.'\'');
		return $select -> addFild('`cy`,count(*) as `count`') -> addFrom($this->table) -> addGroup("`cy`") -> addOrder("`cy`") -> queryDB();
	}
	
/**
	 * 
	 * Получить сгруппированные данные pr
	 */
	function getPrData($id_project_seo_report){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$select -> addWhere('id_project_seo_report = \''.$id_project_seo_report.'\'');
		return $select -> addFild('`pr`,count(*) as `count`') -> addFrom($this->table) -> addGroup("`pr`") -> addOrder("`pr`") -> queryDB();
	}
	
	/**
	 * 
	 * получить Ссылки
	 */
	function getLinks($id_project_seo_report){
		$where[] = "id_project_seo_report = '{$id_project_seo_report}'";
		return $this -> getWhere($where);
	}
	
	/**
	 * 
	 * получить ссылку
	 */
	function getLink($id_project_seo_report,$id_link){
		$where[] = "id_project_seo_report = '{$id_project_seo_report}'";
		$where[] = "id_link = '{$id_link}'";
		return $this -> getWhere($where);
	}
	
	/**
	*
	* Создание нового объекта, с использованием массива params
	*/
	function newItem(){
		if($this -> getLink($this -> params['id_project_seo_report'],$this -> params['id_link'])){
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