<?php
$id_project = intval($request -> id_project);
$project = new projects($id_project);
$projectSeoUrl = new projects_seo_url();
$projectQuery = new projects_seo_query();
$projectQueryPosition = new projects_seo_position();
$action_url = "/".$request->parents."/".$request->modul;
$globalTemplateParam->set('action_url',$action_url);

$today = strtotime("today");
$yesterday = strtotime("-1 day",$today);
//echo $yesterday;

$projectSeo = $project -> getProjectWithSeoParams();
//printAr($projectSeo);

$updateCount = 7;
$viewCount = 4;
$nonUpdateCount = 2;
$globalTemplateParam->set('updateCount',$updateCount);
$globalTemplateParam->set('viewCount',$viewCount);
$globalTemplateParam->set('nonUpdateCount',$nonUpdateCount);
$updateDate = array('1324929600','1324843200','1324584000','1324497600','1323720000','1323633600','1323374400');
$updateDate = array_reverse($updateDate);
$updateDate[] = strtotime("today");
$globalTemplateParam->set('updateDate',$updateDate);

$projectUrls = ( $projectSeoUrl->getUrlProject($id_project) );
$index = sizeof($projectUrls);
for ($i = 0; $i < $index; $i++) {
	$projectUrls[$i]['query'] = ( $projectQuery -> getQueryByUrl($id_project, $projectUrls[$i][$projectSeoUrl->idField],true) );
	$index2 = sizeof($projectUrls[$i]['query']);
	for ($j = 0; $j < $index2; $j++) {
		$projectUrls[$i]['query'][$j]['position'] = $projectQueryPosition -> getPositionsByQueryInDate($projectUrls[$i]['query'][$j][$projectQuery->idField], $updateDate);	
	}
}
$projectUrls[$index]['query'] = $projectQuery -> getQueryByUrl($id_project, 0,true);
if(!$projectUrls[$index]['query'])
	unset($projectUrls[$index]);
else{
	$projectUrls[$index]['name'] = "Без страницы";
	$projectUrls[$index][$projectSeoUrl->idField] = -1;
	$index2 = sizeof($projectUrls[$index]['name']);
	for ($j = 0; $j < $index2; $j++) {
		$projectUrls[$index]['query'][$j]['position'] = $projectQueryPosition -> getPositionsByQueryInDate($projectUrls[$index]['query'][$j][$projectQuery->idField], $updateDate);	
	}
}
//printAr($projectUrls);
$globalTemplateParam->set('projectUrls',$projectUrls);
$globalTemplateParam->set('projectSeo',$projectSeo);
$modul->template = "promo/projects/project.tpl";