<?php
class projects_seo_url extends fmakeCore{
		
	public $table = "projects_seo_url";
	public $idField = "id_project_url";
	public $order = "url";

	/**
	* url для проекта
	*/
	function getUrlProject($id_project){
		$where[] = "`id_project` = '{$id_project}'";
		return ($this -> getWhere($where));
	}
	
}