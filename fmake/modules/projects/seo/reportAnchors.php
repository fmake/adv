<?php

/**
 * 
 * приведенные слова анкор листа
 */
class projects_seo_reportAnchors extends fmakeCore{
	public $table = "projects_seo_report_anchorsword";
	public $idField = "id_project_seo_report_anchorsword";
	
	
	/**
	 * 
	 * получить слова по отчету
	 */
	function getWords($id_project_seo_report){
		$where[] = "id_project_seo_report = '{$id_project_seo_report}'";
		return $this -> getWhere($where);
	}
	
	/**
	 * 
	 * получить по проекту и анкору
	 */
	function getWord($id_project_seo_report,$word){
		$where[] = "id_project_seo_report = '{$id_project_seo_report}'";
		$where[] = "word = '{$word}'";
		return $this -> getWhere($where);
	}
	
	/**
	 * 
	 * добавление слова в отчет
	 */
	function addWord($id_project_seo_report,$word){
		$struct  = new Struct();
		printAr($word);
		$word = ( $struct -> stem_word($word) );
		$item = $this -> getWord($id_project_seo_report, $word);
		if($item){
			$this -> setId($item[0]['id_project_seo_report_anchorsword']);
			$this -> addParam("count", $item[0]['count']+1);
			$this -> update();
		}else{
			$this -> addParam("word", $word);
			$this -> addParam("id_project_seo_report", $id_project_seo_report);
			$this -> newItem();
		}
	}
}