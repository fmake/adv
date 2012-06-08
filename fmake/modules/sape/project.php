<?php
class sape_project extends sape{
	

	/**
	 * 
	 * Получить все проекты из sape
	 */
	function getProjects(){
		
		if( !$this -> loginDefault() )
			return 0;
		$irxClient = $this -> getIrxClient();
		$year = date("Y",($date));
		$irxClient -> query('sape.get_projects');
		return ($irxClient -> getResponse());
	}
	
	/**
	 * 
	 * Создать проект sape
	 * @param name имя проекта 
	 * @return 
	 */
	function addProject($name){
		if( !$this -> loginDefault() )
			return 0;
		$irxClient = $this -> getIrxClient();
		$irxClient -> query('sape.project_add',$name);
		$ans = ($irxClient -> getResponse());
		return intval($ans);
	}
	
	/**
	 * 
	 * Создать url в проекте sape
	 * @param int $id_sape_project проект
	 * @param string $url адрес страницы
	 * @param string $name имя урла
	 */
	function addUrlProject($id_sape_project,$url,$name){
		if( !$this -> loginDefault() )
			return 0;
		$irxClient = $this -> getIrxClient();
		$irxClient -> query('sape.url_add',$id_sape_project, $url, $name);
		$ans = ($irxClient -> getResponse());
		return intval($ans);
	}
	
	/**
	 * 
	 * Получить все url проекта sape
	 * @param int $id_sape_project проект
	 */
	function getUrlsProject($id_sape_project){
		
		if( !$this -> loginDefault() )
			return 0;
		$irxClient = $this -> getIrxClient();
		$year = date("Y",($date));
		$irxClient -> query('sape.get_urls',$id_sape_project);
		return ($irxClient -> getResponse());
	}
	 
}