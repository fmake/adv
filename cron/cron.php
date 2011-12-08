<?php
header('Content-type: text/html; charset=utf-8'); 
ini_set('display_errors',1);
error_reporting(7);
ini_set ('max_execution_time',3500);

require '../fmake/configs.php';
if($_GET['key'] != $cronKey)exit;
require('../fmake/FController.php');

switch ($request -> action){
	/**
	* проверка позиций
	*/
	case 'check_positions':
		$pos = new projects_seo_position();
		$pos -> checkAllPosition();
	break;
	/**
	 * выставляем все значения по умолчанию
	 */	
	case 'default_value':
		$interface = new ethernetInterface();
		$interface -> setDefault();
	break;
}