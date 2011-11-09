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
	
}