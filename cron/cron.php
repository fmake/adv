<?php
header('Content-type: text/html; charset=utf-8'); 
ini_set('display_errors',1);
error_reporting(7);
ini_set ('max_execution_time',3500);
ini_set("memory_limit","128M");

require '../fmake/configs.php';
if($_GET['key'] != $cronKey)exit;
require('../fmake/FController.php');

switch ($request -> action){
	/**
	* проверка позиций
	*/
	case 'check_positions':
		$pos = new projects_seo_position();
		$pos -> checkAllPosition($request -> checkIfExist );
	break;
	/**
	* подсчет денег
	*/
	case 'check_money':
		$money = new projects_seo_money();
		$money -> checkMoney($request -> date);
		break;
	/**
	* подсчет денег sape
	*/
	case 'check_money_sape':
		$sape = new sape_money();
		$sape -> checkMoney($request -> date);
		break;
	/**
	* пересчет денег sape
	*/
	case 'check_money_sape_all':
		$sape = new sape_money();
		$sape -> checkMoneyAll();
		break;	
	/**
	 * выставляем все значения по умолчанию
	 */	
	case 'default_value':
		$interface = new ethernetInterface();
		$interface -> setDefault();
	break;
}