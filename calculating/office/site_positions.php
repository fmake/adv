<?php 
$projects = new projects();
$seoSearchSystemsAcces = new projects_seo_searchSystemAccess();
$seoQuery = new projects_seo_query();
$seoPosition = new projects_seo_position();
$searchSystemExs = new projects_seo_searchSystemExs();
$projectsSeo = ( $projects -> getProjectsWithSeoParams(false,array('active' => 1)) );
$globalTemplateParam->set('projectsSeo',$projectsSeo);

$id_project = $request->id_project ? $request->id_project : 14;

switch($request -> area){
	case 'month':
		$date_from = strtotime(date('m/01/y'));
		$date_to =  strtotime("today");
		$days = ceil( ($date_to - $date_from) / (60*60*24) );
		for ($i = $days; $i >= 0; $i--) {
			$daysView[] = strtotime("-{$i} days",$date_to);
		}
	break;
	case 'lastmonth':
		$date_from = strtotime('-1 month', strtotime(date('m/01/y')));
		$date_to =  strtotime('-1 day', strtotime(date('m/01/y')));
		$days = ceil( ($date_to - $date_from) / (60*60*24) );
		for ($i = $days; $i >= 0; $i--) {
			$daysView[] = strtotime("-{$i} days",$date_to);
		}
	break;
	case '2lastmonth':
		$date_from = strtotime('-2 month', strtotime(date('m/01/y')));
		$date_to =  strtotime('last day', strtotime('-1 month', strtotime(date('m/01/y'))));
		$days = ceil( ($date_to - $date_from) / (60*60*24) );
		for ($i = $days; $i >= 0; $i--) {
			$daysView[] = strtotime("-{$i} days",$date_to);
		}	
	break;		
	case '3lastmonth':
		$date_from =  strtotime('-3 month', strtotime(date('m/01/y')));
		$date_to = strtotime('last day', strtotime('-2 month', strtotime(date('m/01/y'))));
		$days = ceil( ($date_to - $date_from) / (60*60*24) );
		for ($i = $days; $i >= 0; $i--) {
			$daysView[] = strtotime("-{$i} days",$date_to);
		}
	break;
	case 'week':
	default:
		$days = 6;
		$date_from = strtotime("-{$days} days",strtotime("today"));
		$date_to = strtotime("today");
		for ($i = $days; $i >= 0; $i--) {
			$daysView[] = strtotime("-{$i} days",$date_to);
		}
	break;
	
}




$globalTemplateParam->set('daysView',$daysView);

$projects -> setId($id_project);
$project = $projects -> getProjectWithSeoParams();



$project['search_systems'] = ( $seoSearchSystemsAcces -> getProjectSearchSystems($project[$projects -> idField]) );
$index = sizeof($project['search_systems']);
for ($i = 0; $i < $index; $i++) {
	$project['search_systems'][$i]['exs'] = ( $searchSystemExs -> getExsProjectSystem($project[$projects -> idField], $project['search_systems'][$i]['id_seo_search_system']) );
	$project['search_systems'][$i]['querys'] = $seoQuery -> getQueryProjectSystem($project[$projects -> idField], $project['search_systems'][$i]['id_seo_search_system'],true);
	$index2 = sizeof($project['search_systems'][$i]['querys']);
	for ($j = 0; $j < $index2; $j++) {
		$posTmp = $seoPosition -> getPositionsByQueryDate($project['search_systems'][$i]['querys'][$j][$seoQuery->idField], $date_from, $date_to);
		$index3 = sizeof($posTmp);
		$pos = array();
		for ($k = 0; $k < $index3; $k++) {
			$pos[$posTmp[$k]['date']] = $posTmp[$k];
		}
		$project['search_systems'][$i]['querys'][$j]['pos'] = $pos;
		unset($pos);
	}
	
}

//printAr($project);
$globalTemplateParam->set('project',$project);
$modul->template = "office/site_positions.tpl";