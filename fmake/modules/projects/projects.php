<?php
class projects extends fmakeCore{
		
	public $table = "projects";
	public $idField = "id_project";

	/*
	* Все проект с seo параметрами
	*/
	function getProjectWithSeoParams(){
		$projectSeo = new projects_seo_seoParams();
		$select = $this->dataBase->SelectFromDB( __LINE__);
		$arr = $select 
				 -> addFrom("$this->table LEFT JOIN $projectSeo->table on `$this->table`.$this->idField = `$projectSeo->table`.$projectSeo->idField");
		$select -> addWhere("`$this->table`.`".$this->idField."`='".$this->id."'");
		$arr = $select -> queryDB();
		return $arr[0];
	}
	/*
	 * Все проекты с seo параметрами
	 */
	function getProjectsWithSeoParams(){
		$projectSeo = new projects_seo_seoParams();
		$select = $this->dataBase->SelectFromDB( __LINE__);
		$arr = $select
				-> addFrom("$this->table LEFT JOIN $projectSeo->table on `$this->table`.$this->idField = `$projectSeo->table`.$projectSeo->idField");
		return $select -> queryDB();
	}
}