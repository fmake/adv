<?php
define(WEBMASTER_PARAM,1);

class projects_seo_params extends fmakeCore{
		
	public $table = "projects_seo_param";
	public $idField = "id_projects_seo_param";
	public $imageFolder = "/images/errors";
	//public $order = "url";
	
	function webmasterCheck(){
		$projects = new projects();
		$webmaster = new yandex_webmaster();
		$projectsParamValue = new projects_seo_paramsValue();

		$seoProject = $projects -> getProjectsWithSeoParams("*",array('active' => 1));
		$siteInfo = $webmaster -> getSiteInfo();
		
		//printAr($seoProject);
		//printAr($siteInfo);


		$sizeSeoProject = sizeof($seoProject);
		$sizeSiteInfo = sizeof($siteInfo['host']);

		for($i=0;$i<$sizeSeoProject;$i++){
			for($j=0;$j<$sizeSiteInfo;$j++){
				//echo $siteInfo['host'][$j]['name']."  ".$seoProject[$i]['url']."<br />";
				if( $siteInfo['host'][$j]['virused'] == "true" &&  preg_match("/^(www\.)?".$seoProject[$i]['url']."/Ui", $siteInfo['host'][$j]['name'])){
					$projectsParamValue -> addParam("id_projects_seo_param", WEBMASTER_PARAM);
					$projectsParamValue -> addParam("id_project", $seoProject[$i]['id_project']);
					$projectsParamValue -> addParam("value", "1");
					$projectsParamValue -> addParam("date", strtotime("now"));
					$projectsParamValue -> newItem();
				}else if($siteInfo['host'][$j]['virused'] == "false" &&  preg_match("/^(www\.)?{$seoProject[$i]['url']}/Ui", $siteInfo['host'][$j]['name'])){
					$projectsParamValue -> addParam("id_projects_seo_param", WEBMASTER_PARAM);
					$projectsParamValue -> addParam("id_project", $seoProject[$i]['id_project']);
					$projectsParamValue -> addParam("value", "0");
					$projectsParamValue -> addParam("date", strtotime("now"));
					$projectsParamValue -> newItem();
				}
			}
		}

		
	}
} 
