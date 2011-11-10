<?php
class projects_seo_query extends fmakeCore{
		
	public $table = "projects_seo_query";
	public $idField = "id_seo_query";

	/*
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