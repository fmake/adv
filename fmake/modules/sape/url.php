<?php
class sape_url extends sape{
	public $table = "projects_seo_query_sape_urls";	
	public $idField = "id_projects_seo_query_sape_urls";

	/**
	 * 
	 * Получить url по запросу
	 * @param int $id_project
	 * @param int $date
	 */
	function getUrlsByQuery($id_query){
		$where[] = "`id_seo_query` = '{$id_query}'";
		return ($this -> getWhere($where));
	}
	
}