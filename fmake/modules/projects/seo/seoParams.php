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
	
}