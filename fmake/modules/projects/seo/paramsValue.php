<?php
class projects_seo_paramsValue extends fmakeCore{
		
	public $table = "projects_seo_param_value";
	public $idField = array("id_projects_seo_param","id_project");
	public $order = "id_projects_seo_param";
	/**
	*  значения для проекта
	*/
	function getValue($id_project){
		$where[] = "`id_project` = '{$id_project}'";
		$arr = ( ($this -> getWhere($where)) );
		$ans = array();
		$index = sizeof($arr);
		for ($i = 0; $i < $index; $i++) {
			$ans[$arr[$i]['id_projects_seo_param']] = $arr[$i];
		}
		return $ans;
	}
	
	/**
	* получить позицию по запросу и дате
	*/
	function getByProjectParam( $id_projects_seo_param, $id_project){
		$where[] = "`id_projects_seo_param` = '{$id_projects_seo_param}'";
		$where[] = "`id_project` = '{$id_project}'";
		$arr = ($this -> getWhere($where));
		return $arr[0];
	}
	
	/**
	*
	* Создание нового объекта, с использованием массива params
	*/
	function newItem(){
		if($this -> getByProjectParam($this -> params['id_projects_seo_param'],$this -> params['id_project'])){
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

