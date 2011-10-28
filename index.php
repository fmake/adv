<?php
header('Content-type: text/html; charset=utf-8'); 
setlocale(LC_ALL, 'ru_RU.UTF-8');
mb_internal_encoding('UTF-8');
ini_set('display_errors',1);
error_reporting(7);
session_start();


require('./fmake/FController.php');



$modul = new fmakeSiteModule();
include 'checklogin.php';
$modul->getPage($request -> getEscape('modul'),$user->role ,$twig);
$globalTemplateParam->set('modul',$modul);

$modul->template = "base/main.tpl";

if($modul->file){
	include("calculating/".$modul->file);
}

$menu = $modul->getAllForMenu(0, true,$q=false,$flag=true,true,$user->role);
$globalTemplateParam->set('menu',$menu);

$template = $twig->loadTemplate($modul->template);
$template->display($globalTemplateParam->get());
