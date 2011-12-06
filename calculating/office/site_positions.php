<?php 
$projects = new projects();
$seoSearchSystemsAcces = new projects_seo_searchSystemAccess();
$seoQuery = new projects_seo_query();
$seoPosition = new projects_seo_position();
$searchSystemExs = new projects_seo_searchSystemExs();
$projects1 = ( $projects -> getProjectsWithSeoParams(false,array('active' => 1)) );

$id_project = 14;

$date_from = strtotime("-6 days",strtotime("today"));
$date_to = strtotime("today");

$projects -> setId($id_project);
$project = $projects -> getProjectWithSeoParams();



$project['search_systems'] = ( $seoSearchSystemsAcces -> getProjectSearchSystems($project[$projects -> idField]) );
$index = sizeof($project['search_systems']);
for ($i = 0; $i < $index; $i++) {
	$project['search_systems'][$i]['exs'] = ( $searchSystemExs -> getExsProjectSystem($project[$projects -> idField], $project['search_systems'][$i]['id_seo_search_system']) );
	$project['search_systems'][$i]['querys'] = $seoQuery -> getQueryProjectSystem($project[$projects -> idField], $project['search_systems'][$i]['id_seo_search_system'],true);
	$index2 = sizeof($project['search_systems'][$i]['querys']);
	for ($j = 0; $j < $index2; $j++) {
		$project['search_systems'][$i]['querys'][$j]['pos'] = $seoPosition -> getPositionsByQueryDate($project['search_systems'][$i]['querys'][$j][$seoQuery->idField], $date_from, $date_to);
	}
	
}

printAr($project);
$modul->template = "office/site_positions.tpl";