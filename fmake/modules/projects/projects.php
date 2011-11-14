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

	/**
	 * 
	 * Создаем фильтр
	 */
	function createFilter($filter) {
	
		if($filter){
			
			foreach ($filter as $name => $value){
				switch($name){
					case 'active':
						$filter[$name] = "`{$this->table}`.{$name} = '{$value}'";
					break;
					case 'is_seo':
						$filter[$name] = "`{$this->table}`.{$name} = '{$value}'";
					break;
					case 'is_context':
						$filter[$name] = "`{$this->table}`.{$name} = '{$value}'";
					break;
					case 'url':
						$filter[$name] = "`{$this->table}`.{$name} like '{$value}%'";
					break;
				}
			}
			
			
		}
		
		
		return $filter;
		
	}
	/*
	 * Все проекты с seo параметрами
	 */
	function getProjectsWithSeoParams($filds = false,$filter = array()){
		$filter = $this -> createFilter($filter);
		$projectSeo = new projects_seo_seoParams();
		$select = $this->dataBase->SelectFromDB( __LINE__);
		
		if($filds){
			$select -> addFild($filds);
		}
		
		if($filter){
			foreach ($filter as $name => $value){
				$select -> addWhere($value);
			}
		}

		$arr = $select
				-> addFrom("$this->table LEFT JOIN $projectSeo->table on `$this->table`.$this->idField = `$projectSeo->table`.$projectSeo->idField");
		return $select -> queryDB();
	}

	/**
	* удаление + очищение запросов, правил цен, поисковых систем связанных с проектом, которые теперь не нужны
	* @see fmakeCore::delete()
	*/
	function delete(){
		
		/*
		 * сео параметры проекта
		 */
		$prSeo = new projects_seo_seoParams($this -> id);
		$prSeo -> delete();
		$prAcces = new projects_accessRole();
		$prAcces -> deleteByProjectId($this -> id);
		parent::delete();
	}
}