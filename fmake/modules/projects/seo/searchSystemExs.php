<?php
class projects_seo_searchSystemExs extends fmakeCore{
		
	public $table = "projects_seo_search_system_exs";
	public $idField = "id_exs";
	public $order = "`from`";
	public $order_as = ASC;
	/*
	* получаем роли для проекта
	*/
	function getExsProjectSystem($id_project,$id_seo_search_system){
		$where[] = "`id_project` = '{$id_project}'";
		$where[] = "`id_seo_search_system` = '{$id_seo_search_system}'";
		return ($this -> getWhere($where));
	}
	
	function deleteWhereNotIn($id_project,$id_seo_search_system, $arr){
		if(!$arr[0])return;
	
		$select = $this->dataBase->SelectFromDB(__LINE__);

	
		for($i=0;$i<sizeof($arr);$i++)
			$select -> addWhere("{$this -> idField} !='".$arr[$i][$this -> idField]."'");
	
		$deletedElement =  $select -> addFrom($this->table) -> addWhere("id_seo_search_system = '{$id_seo_search_system}'") -> addWhere("id_project = '{$id_project}'") ->  queryDB();
	
		for($i=0;$i<sizeof($deletedElement);$i++){
			$this->setId($deletedElement[$i][$this -> idField]);
			$this->delete();
			
			//$priceObj = new absSeoQueryPriceEx();
			//$priceObj->deleteByExId($deletedElement[$i]['id']);
		}
			
	}
	
	/**
	*
	* удаляем все правила проекта
	* @param unknown_type $id_exs
	*/
	function deleteByProjectId($id_project){
		$where[] = "`id_project` = '{$id_project}'";
		$exs = ($this -> getWhere($where));
		$index = sizeof($exs);
		for ($i = 0; $i < $index; $i++) {
			$this->setId($exs[$i][$this->idField]);
			$this -> delete();
		}
	}
	
	/**
	*
	* удаляем все правила проекта
	* @param unknown_type $id_exs
	*/
	function deleteBySearchSystemProjectId($id_seo_search_system,$id_project){
		$where[] = "`id_seo_search_system` = '{$id_seo_search_system}'";
		$where[] = "`id_project` = '{$id_project}'";
		$exs = ($this -> getWhere($where));
		$index = sizeof($exs);
		for ($i = 0; $i < $index; $i++) {
			$this->setId($exs[$i][$this->idField]);
			$this -> delete();
		}
	}
	
	/**
	 * удаление + очищение правил цен, которые теперь не нужны
	 * @see fmakeCore::delete()
	 */
	function delete(){
		$price = new projects_seo_searchSystemExsPrice();
		$price -> deleteByExId($this -> id);
		parent::delete();
	}
	
}