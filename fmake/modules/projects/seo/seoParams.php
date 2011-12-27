<?php
class projects_seo_seoParams extends fmakeCore{
		
	public $table = "projects_seo";
	public $idField = "id_project";

	
	/**
	 * 
	 * Создание нового объекта, с использованием массива params, c учетов поля position
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
	
	
	
	/**
	* удаление + очищение запросов, правил цен, поисковых систем связанных с проектом, которые теперь не нужны
	* @see fmakeCore::delete()
	*/
	function delete(){
	
		$prSeoQuery = new projects_seo_query();
		$prSeoQuery -> deleteByProjectId($this -> id);
		$exsSeo = new projects_seo_searchSystemExs();
		$exsSeo -> deleteByProjectId($this -> id);
		$prSeoSearchSystem = new projects_seo_searchSystemAccess();
		$prSeoSearchSystem -> deleteByProjectId($this -> id); 
		
		parent::delete();
	}
	
}