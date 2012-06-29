<?php
/**
 * 
 * статусы отчета
 */
define("REPORT_CREATE",1);
define("REPORT_START",2);
define("REPORT_LINK",10);
define("REPORT_ANCHORS",20);
define("REPORT_ADDQUERY",30);
define("REPORT_CHECKQUERY",40);
define("REPORT_ADDSITE",50);
define("REPORT_DONE",100);
/**
 * 
 * отчеты для оптимизаторов
 */
class projects_seo_report extends fmakeCore{
		
	public $table = "projects_seo_report";
	public $idField = "id_project_seo_report";
	public $order = "date";
	
	/**
	 * Создать отчет для проекта
	 */
	function createReport($id_project){
		$this -> addParam("id_project", $id_project);
		$this -> addParam("date", time());
		$this -> addParam("status", REPORT_CREATE);
		$this -> newItem();
		return $this -> id;
	}
	
	/**
	 * Создать отчет для проекта
	 */
	function getReport($id_project,$status){
		$where[] = "id_project = '{$id_project}'";
		$where[] = "status = '{$status}'";
		return $this -> getWhere($where);
	}
	
	/**
	 * Получить все отчеты кроме данного
	 */
	function getForeignReport($id_project, $status){
		$where[] = "id_project = '{$id_project}'";
		$where[] = "status != '{$status}'";
		return $this -> getWhere($where);
	}

	/**
	 * 
	 * Получить сгруппированные данные тиц
	 */
	function getCyData($id_project_seo_report){
		$reportLinks = new projects_seo_reportLinks();
		return $reportLinks -> getCyData($id_project_seo_report);
	}
	
	/**
	 * 
	 * Получить сгруппированные данные тиц
	 */
	function getPrData($id_project_seo_report){
		$reportLinks = new projects_seo_reportLinks();
		return $reportLinks -> getPrData($id_project_seo_report);
	}
	/**
	 * Выполнение отчета
	 */
	function makeReport($id_project_seo_report){
		$this -> setId($id_project_seo_report);
		$report = ($this -> getInfo());
		$projects = new projects($report['id_project']);
		$sapeProject = new sape_project();
		$reportLinks = new projects_seo_reportLinks();
		$project = ( $projects -> getProjectWithSeoParams() );
		$projectUrl = new projects_seo_url();
		$projectAnchors = new projects_seo_reportAnchors();
		$projectQuery = new projects_seo_query();
		$projectReportQuery = new projects_seo_reportQuerys();
		$wordstat = new yandex_wordstat();
		$yandex = new searchSystems_Yandex();
		
		if($report['status'] == REPORT_CREATE){
			$this -> addParam("status", REPORT_START);
			$this -> update();
		}
		
		/**
		 * получаем ссылки
		 */
		if($report['status'] < REPORT_LINK){
			$links = ($sapeProject -> getProjectsLinks($project['id_sape_project']));
			$sizeLinks = sizeof($links);
			//printAr($links);
			for ($i = 0; $i < $sizeLinks; $i++) {
				//printAr($links[$i]);
				$reportLinks -> addParam("id_project_seo_report",$id_project_seo_report);
				$reportLinks -> addParam("id_link",$links[$i]['id']);
				$reportLinks -> addParam("cy",$links[$i]['site_cy']);
				$reportLinks -> addParam("pr",$links[$i]['page_pr']);
				$reportLinks -> addParam("link", mysql_real_escape_string( $links[$i]['site_url'].$links[$i]['page_uri'] ) );
				preg_match_all("/#a#(.+)#\/a#/iU", $links[$i]['txt'], $anchor);
				$reportLinks -> addParam("anchor",mysql_real_escape_string($anchor[1][0]));
				$reportLinks -> addParam("txt",$links[$i]['txt']);
				$reportLinks -> addParam("page_level",$links[$i]['page_level']);
				$reportLinks -> newItem();
			}
			$this -> addParam("status", REPORT_LINK);
			$this -> update();
		}
		
		
		/**
		 * 
		 * формирование приведенного анкор файла
		 */
		if($report['status'] < REPORT_ANCHORS){
			$links = $reportLinks -> getLinks($id_project_seo_report);
			$sizeLinks = sizeof($links);
			//printAr($links);
			for ($i = 0; $i < $sizeLinks; $i++) {
				$arr = ( explode(" ", $links[$i]['anchor'] ) );
				for ($j = 0; $j < sizeof($arr); $j++) {
					$projectAnchors -> addWord($id_project_seo_report,$arr[$j]);
				}
				
			}
			
			$this -> addParam("status", REPORT_ANCHORS);
			$this -> update();
		}
		
		
		/**
		 * 
		 * добавление запросов
		 */
		if($report['status'] < REPORT_ADDQUERY){
			
			$urls = ( $projectUrl -> getUrlProject($report['id_project']) );
			$sizeUrl = sizeof($urls);
			
			for ($i = 0; $i < $sizeUrl; $i++) {
				$query = ( $projectQuery -> getQueryByUrl($report['id_project'], $urls[$i][$projectUrl -> idField]) );
				for ($j = 0; $j < sizeof($query); $j++) {
					//$query[$j][];
					$projectReportQuery -> addParam("id_project_seo_report",$id_project_seo_report);
					$projectReportQuery -> addParam("id_project_url",$query[$j]['id_project_url']);
					$projectReportQuery -> addParam("id_seo_query",$query[$j]['id_seo_query']);
					$projectReportQuery -> newItem();
				}
				
			}
			$this -> addParam("status", REPORT_ANCHORS);
			$this -> update();
		}
		
		/**
		 * 
		 * проверка запросов
		 */
		if($report['status'] < REPORT_CHECKQUERY){
			$query = ( $projectReportQuery -> getNonCheckQuery($id_project_seo_report) );
			for ($i = 0; $i < sizeof($query); $i++) {
				$projectReportQuery -> addParam("id_project_seo_report",$id_project_seo_report);
				$projectReportQuery -> addParam("id_seo_query",$query[$i]['id_seo_query']);
				$projectReportQuery -> addParam("wordstat",$wordstat -> getWordTotalCount($query[$i]['query']));
				$projectReportQuery -> addParam("check","1");
				$projectReportQuery -> update();
			}
			$this -> addParam("status", REPORT_CHECKQUERY);
			$this -> update();
		}
		
		/**
		 * 
		 * Выбор конкурентов по запросам запросов
		 */
		if($report['status'] < REPORT_ADDSITE){
			$urls = ( $projectUrl -> getUrlProject($report['id_project']) );
			$sizeUrl = sizeof($urls);
			for ($i = 0; $i < $sizeUrl; $i++) {
				$query = ( $projectReportQuery -> getPollQuery($id_project_seo_report, $urls[$i][$projectUrl -> idField]) );
				$projectQuery -> setId($query[0]['id_seo_query']);
				$query = ($projectQuery -> getInfo() );
				$yandex -> setData($query['query'], '');
				printAr($yandex->getNumSite(10));
				exit;
			}
		}
	}
	
}