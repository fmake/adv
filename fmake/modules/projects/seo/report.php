<?php
/**
 * 
 * статусы отчета
 */
define("REPORT_CREATE",1);
define("REPORT_START",2);
define("REPORT_LINK",10);
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
		
		if($report['status'] == REPORT_CREATE){
			$this -> addParam("status", REPORT_START);
			$this -> update();
		}
		
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
		
		$urls = ( $projectUrl -> getUrlProject($report['id_project']) );
		$sizeUrl = sizeof($urls);
		
		for ($i = 0; $i < $sizeUrl; $i++) {
			$urls[$i][$projectUrl -> idField];
		}
		
	}
	
}