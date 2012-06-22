<?php
header('Content-type: text/html; charset=utf-8'); 
ini_set('display_errors',1);
error_reporting(7);
ini_set ('max_execution_time',3500);
ini_set("memory_limit","128M");
mb_internal_encoding('UTF-8');

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
	* проверка позиций не пробитых
	*/
	case 'check_positions_fail':
		$pos = new projects_seo_position();
		$pos -> checkPositionFail($request -> date );
	break;
	/**
	* подсчет денег
	*/
	case 'check_money':
		$money = new projects_seo_money();
		$money -> checkMoney($request -> date);
		break;
	/**
	* подсчет денег
	*/
	case 'check_money_period':
		$money = new projects_seo_money();
		$today = strtotime("today");
		$start = strtotime($request -> date);
		while ($start <= $today){
			$money -> checkMoney($start);
			$start = strtotime("+1 day",$start);	
		}
		
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
	 * считаем max деньги для пользователя за проект
	 */	
	case 'seo_pay_add':
		$projects = new projects();
		$searcs = new projects_seo_searchSystemAccess();
		$queryo = new projects_seo_query();
		$exs = new projects_seo_searchSystemExs();
		$exsPrice = new projects_seo_searchSystemExsPrice();
		$pr = $projects -> getAll();
		for ($i = 0; $i < sizeof($pr); $i++) {
			$sum = 0;
			$serc = ( $searcs->getProjectSystems($pr[$i]['id_project']) );
			foreach ($serc as $s) {
				$query =  $queryo -> getQueryProjectSystem($pr[$i]['id_project'],$s['id_seo_search_system']) ;
				
				$exsp = ($exs -> getExsProjectSystem($pr[$i]['id_project'],$s['id_seo_search_system']));
				
				foreach ($exsp as $ex) {
					for ($j = 0; $j < sizeof($query); $j++) {
						$tmp = $exsPrice -> getPriceExsSearch($ex['id_exs'],$query[$j]['id_seo_query']);
						$sum += $tmp['price'];
					}
					break;
				}
				
				
				
				
				break;
			}
			$sum = $sum*30;
			$projectSeo = new projects_seo_seoParams();
			$projectSeo -> setId($pr[$i]['id_project']);
			$projectSeo -> addParam("max_seo_user_pay", $sum);
			$projectSeo -> update();
			echo $sum;
		}
		
		break;
	/**
	* подсчет апдейтов
	*/
	case 'update_period':
		$update = new projects_update();
		$today = strtotime("today");
		$start = strtotime($request -> date);
		while ($start <= $today){
			$update -> getUpdate($start);
			$start = strtotime("+1 day",$start);	
		}
		
		break;	
	/**
	* связь запросов и урлов
	*/
	case 'check_sape_urls':
		$sape = new sape_project();
		$projects = new projects();
		$pr = $projects -> getAll();
		//echo $sape -> cmpNameQuery("сборный груз из италии тк ", "сборный груз из италии");
		//exit;
		//printAr($pr);
		for ($i = 0; $i < sizeof($pr); $i++) {
			$sape -> checkQueryUrl($pr[$i]['id_project']);
		}
		break;
	/**
	* проверка вирусов через вебмастер
	*/
	case 'check_virused':
		$param = new projects_seo_params();
		$param -> webmasterCheck();
		break;


	/**
	 * выставляем все значения по умолчанию
	 */	
	case 'default_value':
		$interface = new ethernetInterface();
		$interface -> setDefault();
	break;
}
