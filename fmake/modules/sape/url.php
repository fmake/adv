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
	function getUrlsByQuery($id_seo_query){
		$where[] = "`id_seo_query` = '{$id_seo_query}'";
		return ($this -> getWhere($where));
	}
	
	/**
	 * 
	 * Получить запись по запросу и urlу
	 * @param int $id_project
	 * @param int $url_id
	 */
	function getUrlsByQueryUrl($id_seo_query,$url_id){
		$where[] = "`id_seo_query` = '{$id_seo_query}'";
		$where[] = "`url_id` = '{$url_id}'";
		return ($this -> getWhere($where));
	}
	
}