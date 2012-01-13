<?php
$userObj = $modul -> getUserObj();
$projects = new projects();
$filtr['date'] =  $request -> getFilter('date');
$filtr['id_role'] = ID_OPTIMISATOR;
$userProjects = ( $projects -> getProjectsWithSeoParamsWithAccessUser("DISTINCT ".$projects ->table.".id_project,url,max_seo_pay,pay_percent",$filtr)  );
printAr($userProjects);


if(!isset($_REQUEST[$request->filter]['active'])){
	$request -> setFilter("active", 1);
}
$promos = $userObj -> getByRole(ID_OPTIMISATOR,$request -> getFilter('active'));

$globalTemplateParam->set('promos',$promos);
$globalTemplateParam->setNonPointer('ID_ADMINISTRATOR',ID_ADMINISTRATOR);
$globalTemplateParam->setNonPointer('ID_AKKAUNT',ID_AKKAUNT);
$modul->template = "promo/projects.tpl";