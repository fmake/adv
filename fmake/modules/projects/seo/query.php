<?php
class projects_seo_query extends fmakeCore{
		
	public $table = "projects_seo_query";
	public $idField = "id_seo_query";
	public $order = "query";

	/**
	* запросы для проекта
	*/
	function getQueryProjectSystem($id_project,$id_seo_search_system, $active = 1){
		$where[] = "`id_project` = '{$id_project}'";
		$where[] = "`id_seo_search_system` = '{$id_seo_search_system}'";
		if($active)
			$where[] = "`active` = '{$active}'";
		return ($this -> getWhere($where));
	}
	
	/**
	* получаем запись по проекту системе и запросу
	*/
	function getItemProjectSystemQuery($id_project,$id_seo_search_system,$query, $active = 1){
		$where[] = "`id_project` = '{$id_project}'";
		$where[] = "`id_seo_search_system` = '{$id_seo_search_system}'";
		$where[] = "`query` = '{$query}'";
		if($active)
			$where[] = "`active` = '{$active}'";
		$query = ($this -> getWhere($where));
		return $query[0];
	}
	
	/**
	* получаем все запросы для которых необходимо проверить поисковую выдачу
	*/
	function getQuerys($filds = "id_seo_query", $active = 1 ){
		$project = new projects();
		$select = $this->dataBase->SelectFromDB( __LINE__);
		if($active){
			$select -> addWhere("`$project->table`.active = '1'");
		}
		$select -> addFild($filds);
		$arr = $select
				-> addFrom("$this->table LEFT JOIN $project->table on `$this->table`.$project->idField = `$project->table`.$project->idField");
		
		return $select -> queryDB();
	}
	
	/**
	*
	* удаляем все запросы проекта
	* @param unknown_type $id_exs
	*/
	function deleteByProjectId($id_project){
		$where[] = "`id_project` = '{$id_project}'";
		$querys = ($this -> getWhere($where));
		$index = sizeof($querys);
		for ($i = 0; $i < $index; $i++) {
			$this->setId($querys[$i][$this->idField]);
			$this -> delete();
		}
	}
	
	/**
	* удаление + очищение правил-цен, которые теперь не нужны
	* @see fmakeCore::delete()
	*/
	function delete(){
		$price = new projects_seo_searchSystemExsPrice();
		$price -> deleteByQueryId($this -> id);
		parent::delete();
	}
	
}