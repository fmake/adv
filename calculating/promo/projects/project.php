<?php
$id_project = intval($request -> id_project);
$project = new projects($id_project);
$projectSeoUrl = new projects_seo_url();
$projectQuery = new projects_seo_query();
$today = strtotime("today");
$yesterday = strtotime("-1 day",$today);
//echo $yesterday;

$projectSeo = $project -> getProjectWithSeoParams();
//printAr($projectSeo);

$projectUrls = ( $projectSeoUrl->getUrlProject($id_project) );
$index = sizeof($projectUrls);
for ($i = 0; $i < $index; $i++) {
	$projectUrls[$i]['query'] = ( $projectQuery -> getQueryByUrl($id_project, $projectUrls[$i][$projectSeoUrl->idField],true) );
}
$projectUrls[$index]['query'] = $projectQuery -> getQueryByUrl($id_project, 0,true);
if(!$projectUrls[$index]['query'])
	unset($projectUrls[$index]);
else
	$projectUrls[$index]['name'] = "Без страницы";
//printAr($projectUrls);
$globalTemplateParam->set('projectUrls',$projectUrls);
$globalTemplateParam->set('projectSeo',$projectSeo);
$modul->template = "promo/projects/project.tpl";