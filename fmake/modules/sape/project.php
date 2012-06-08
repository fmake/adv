<?php
class sape_project extends sape{
	public $table = "projects_seo_query_sape_urls";

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
	
	/**
	 * 
	 * Создать проект в sape c урлами
	 * @param INT $id_project проект в системе
	 */
	function addSapeProject($id_project){
		$project = new projects($id_project);
		$projectSeo = new projects_seo_seoParams($id_project);
		$projectUrl = new projects_seo_url();
		$projectQuery = new projects_seo_query();
		$sapeUrl = new sape_url();
		$curProject = ( $project -> getProjectWithSeoParams() );
		$curUrl = $projectUrl -> getUrlProject($curProject[$project -> idField]) ;
		
		/*
		for ($i = 0; $i < sizeof($curUrlTmp); $i++) {
			$curUrl[$curUrlTmp[$i][$projectUrl -> idField]] = $curUrlTmp[$i];
		}
		printAr($curUrl);
		*/
		if( !$curProject['id_sape_project'] ){
			$id_sape_project = $this -> addProject($curProject['url']);
			if(is_int($id_sape_project)){
				$projectSeo -> setId($id_project);
				$projectSeo -> addParam("id_sape_project", $id_sape_project);
				$projectSeo -> update();
				$curProject['id_sape_project'] = $id_sape_project;
			}else{
				echo "Не удалось создать проект";
				return;
			}
		}
		
		
		for ($i = 0; $i < sizeof($curUrl); $i++) {
			$querys = ( $projectQuery -> getQueryByUrl($curProject[$project -> idField], $curUrl[$i][$projectUrl -> idField],true) );
			for ($j = 0; $j < sizeof($querys); $j++) {
				$urls = $sapeUrl -> getUrlsByQuery($querys[$j][$projectQuery -> idField]);
				printAr($urls);
			}
		}
		
		
		
		
	}
	 
}