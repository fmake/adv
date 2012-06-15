<?php
class sape_project extends sape{
	public $table = "projects_seo_query_sape_urls";
	public $addWord = "( тк| нтк)?";
	
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
		$irxClient -> query('sape.get_urls',$id_sape_project);
		return ($irxClient -> getResponse());
	}
	
	function cmpNameQuery($name,$query){
		return preg_match("#^{$query}{$this -> addWord}$#is", $name);
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
			$curUrlTmp = $projectUrl -> getUrlProject($curProject[$project -> idField]) ;
			if(!$curUrlTmp){
				return;
			}
			for ($i = 0; $i < sizeof($curUrlTmp); $i++) {
				$curUrl[$curUrlTmp[$i][$projectUrl -> idField]] = $curUrlTmp[$i];
			}
			$querys = $query -> getUniqueQueryProject($id_project);
			
			for ($i = 0; $i < sizeof($querys); $i++) {
				for ($j = 0; $j < sizeof($urls); $j++) {
					//echo mb_strtolower( $urls[$j]['name'] );
					$urls[$j]['name'] = trim( mb_strtolower( $urls[$j]['name'] ) );
					/**
					 * проверяем на совпадение имени, так же не должен присутствовать в таблице
					 */
					//printAr($urls[$j]);
					if( $this->cmpNameQuery($urls[$j]['name'],$querys[$i]['query']) && !$sapeUrl -> getUrlsByQueryUrl($querys[$i]['id_seo_query'], $urls[$j]['id'])){
						
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
	}
	
	/**
	 * 
	 * Добавить урлы для запроса
	 * @param INT $id_project проект в системе
	 */
	function addSapeQueryUrl($id_sape_project,$id_seo_query){
		$projectUrl = new projects_seo_url();
		$projectQuery = new projects_seo_query($id_seo_query);
		$query = $projectQuery -> getInfo();
		if(!$query['id_project_url']){
			return;
		}
		$projectUrl -> setId( $query['id_project_url'] );
		$url = $projectUrl -> getInfo();
		
		$this -> addUrlProject($id_sape_project, $url['url'], $query['query']);
		$this -> addUrlProject($id_sape_project, $url['url'], $query['query']." тк");
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
		/**
		 * преобразуем массив url ов
		 
		for ($i = 0; $i < sizeof($curUrlTmp); $i++) {
			$curUrl[$curUrlTmp[$i][$projectUrl -> idField]] = $curUrlTmp[$i];
		}
		//printAr($curUrl);
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
		}else{
			/**
			 * находим связь запросов и урлов
			 */
			$this -> checkQueryUrl($id_project);
			return;
		}
		printAr($curUrl);
		echo $curProject['id_sape_project'];
		for ($i = 0; $i < sizeof($curUrl); $i++) {
			$querys = ( $projectQuery -> getQueryByUrl($curProject[$project -> idField], $curUrl[$i][$projectUrl -> idField],true) );
			printAr($querys);
			for ($j = 0; $j < sizeof($querys); $j++) {
				$this->addSapeQueryUrl($curProject['id_sape_project'], $querys[$j]['id_seo_query']);
			}
		}
		
		
		
		
	}
	 
}