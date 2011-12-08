<?php
class projects_seo_money extends fmakeCore{
		
	public $table = "projects_seo_money";
	public $idField = "id_query";

	
	function checkMoney($date = false){
		if(!$date){
			$date = strtotime("today");
		}
		$projects = new projects();
		$seoSearchSystemsAcces = new projects_seo_searchSystemAccess();
		$seoQuery = new projects_seo_query();
		$seoPosition = new projects_seo_position();
		$searchSystemExs = new projects_seo_searchSystemExs();
		$searchSystemExsPrice = new projects_seo_searchSystemExsPrice();
		$projectsSeo = ( $projects -> getProjectsWithSeoParams(false,array('active' => 1)) );
		$index = sizeof($projectsSeo);
		for ($i = 0; $i < $index; $i++) {
			$projectsSeo[$i]['search_systems'] = $seoSearchSystemsAcces -> getProjectSearchSystems($projectsSeo[$i][$projects -> idField]);
			$index2 = sizeof($projectsSeo[$i]['search_systems']);
			for ($j = 0; $j < $index2; $j++) {
				$money = 0;
				$projectsSeo[$i]['search_systems'][$j]['exs'] = ( $searchSystemExs -> getExsProjectSystem($projectsSeo[$i][$projects -> idField], $projectsSeo[$i]['search_systems'][$j]['id_seo_search_system']) );
				$projectsSeo[$i]['search_systems'][$j]['querys'] = $seoQuery -> getQueryProjectSystem($projectsSeo[$i][$projects -> idField], $projectsSeo[$i]['search_systems'][$j]['id_seo_search_system'],true);
				$index3 = sizeof($projectsSeo[$i]['search_systems'][$j]['querys']);
				$index4 = sizeof($projectsSeo[$i]['search_systems'][$j]['exs']);
				//printAr($projectsSeo[$i]);
				for ($k = 0; $k < $index3; $k++) {
					$pos = $seoPosition -> getPositionByQueryDate($projectsSeo[$i]['search_systems'][$j]['querys'][$k][$seoQuery -> idField], $date);
					for ($h = 0; $h < $index4; $h++) {
						if( $projectsSeo[$i]['search_systems'][$j]['exs'][$h]['from'] <= $pos['pos']
								&&	$pos['pos'] <= $projectsSeo[$i]['search_systems'][$j]['exs'][$h]['to'] ){
							$price = ( $searchSystemExsPrice -> 
								getPriceExsSearch($projectsSeo[$i]['search_systems'][$j]['exs'][$h][$searchSystemExs -> idField],
									 $projectsSeo[$i]['search_systems'][$j]['querys'][$k][$seoQuery -> idField]));
							$money += $price['price'];
							break;
						}
					}
				}
				echo $money;
			}
			exit;
		}
		
	}
	
}