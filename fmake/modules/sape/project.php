<?php
class sape_project extends sape{
	public $table = "projects_seo_query_sape_urls";
	public $addWord = " тк";
	
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
	 * проверить связь запросов и url в sape
	 */
	function checkQueryUrl($id_project){
		$project = new projects($id_project);
		$projectUrl = new projects_seo_url();
		$query = $projectQuery = new projects_seo_query();
		$sapeUrl = new sape_url();
		
		$curProject = ( $project -> getProjectWithSeoParams() );
		if($curProject['id_sape_project']){
			$urls = $this -> getUrlsProject($curProject['id_sape_project']);
			printAr($urls);
			$curUrlTmp = $projectUrl -> getUrlProject($curProject[$project -> idField]) ;
			for ($i = 0; $i < sizeof($curUrlTmp); $i++) {
				$curUrl[$curUrlTmp[$i][$projectUrl -> idField]] = $curUrlTmp[$i];
			}
			printAr($curUrl);
			$querys = $query -> getUniqueQueryProject($id_project);
			printAr($querys);
			
			for ($i = 0; $i < sizeof($querys); $i++) {
				for ($j = 0; $j < sizeof($urls); $j++) {
					//echo mb_strtolower( $urls[$j]['name'] );
					$urls[$j]['name'] = trim( mb_strtolower( $urls[$j]['name'] ) );
					if($urls[$j]['name'] == $querys[$i]['query'] || $urls[$j]['name'] . $this -> addWord == $querys[$i]['query']){
						$sapeUrl -> addParam("id_seo_query", $querys[$i]['id_seo_query']);
						$sapeUrl -> addParam("url_id", $urls[$j]['id']);
						$sapeUrl -> addParam("name", $urls[$j]['name']);
						$sapeUrl -> addParam("url", $urls[$j]['url']);
						$sapeUrl -> addParam("id_sape_project", $urls[$j]['project_id']);
						$sapeUrl -> addParam("id_project", $id_project);
						$sapeUrl -> newItem();
						
					}
				}
			}
			
		}
		
		exit;
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
		
		/**
		 * находим связь запросов и урлов
		 */
		$this -> checkQueryUrl($id_project);
		
		for ($i = 0; $i < sizeof($curUrl); $i++) {
			$querys = ( $projectQuery -> getQueryByUrl($curProject[$project -> idField], $curUrl[$i][$projectUrl -> idField],true) );
			printAr($querys);
			for ($j = 0; $j < sizeof($querys); $j++) {
				$urls = $sapeUrl -> getUrlsByQuery($querys[$j][$projectQuery -> idField]);
				printAr($urls);
			}
		}
		
		
		
		
	}
	 
}