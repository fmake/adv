<?php
/**
 * добавление запросов из таблицы 
 */
$projectSeoQuery -> addParam("id_project", $itemObj -> id);
$searchSystemExs -> addParam("id_project", $itemObj -> id);
$searchSystemAccess -> addParam("id_project", $itemObj -> id);
$monthDay = 30;
$data = $request -> data;
if($data){
	$maxSeoPay = 0;
	foreach ($data as $searchSystemID => $datainner){
		
		foreach ($datainner as $regionID => $datainner){
				if($regionID){
					$searchSystemID = $regionID;
				}
				//echo $searchSystemID;
				// добавляем запросы
				if($datainner['querys']){
					$querys = array();
					$index = sizeof($datainner['querys']);
					for ($i = 0; $i < $index; $i++) {
						
						if($datainner['querys'][$i]['id']){
							// если установленно какое то групповое действие для запроса
							if(isset($datainner['action'][$i])){
								$projectSeoQuery -> setId(intval($datainner['querys'][$i]['id']));
								//printAr($projectSeoQuery -> getInfo());
								switch ($request -> subaction){
									case 'delete':
										$projectSeoQuery -> delete();
										$continue = true;
									break;
								}
								if($continue){
									$continue = false;
									continue;
								}
							}
							//printAr($datainner['querys'][$i]);
							$projectSeoQuery -> setId(intval($datainner['querys'][$i]['id']));
							$projectSeoQuery -> addParam("id_seo_search_system", $searchSystemID);
							$projectSeoQuery -> addParam("query", trim($datainner['querys'][$i]['query']));
							$projectSeoQuery -> update();
							$querys[$i] = $projectSeoQuery -> getInfo();
						}else if($query = trim($datainner['querys'][$i]['query']) ){
							$projectSeoQuery -> addParam("id_seo_search_system", $searchSystemID);
							$projectSeoQuery -> addParam("query", $query);
							$projectSeoQuery -> newItem();
							$querys[$i] = $projectSeoQuery -> getInfo();
						}else{
							break;
						}
						
						
					}
				}
				// все запросы обработанные
				//printAr($querys);
				
				$searchSystemExs -> addParam("id_seo_search_system", $searchSystemID);
				// работаем с правилами
				if($datainner['place']){
					$exs = array();
					$index = sizeof($datainner['place']);
					for ($i = 0; $i < $index; $i++) {
						if($datainner['place'][$i]['id'] && $datainner['place'][$i]['from'] && $datainner['place'][$i]['to']){
							$searchSystemExs -> setId($datainner['place'][$i]['id']);
							$searchSystemExs -> addParam("from", $datainner['place'][$i]['from']);
							$searchSystemExs -> addParam("to", $datainner['place'][$i]['to']);
							$searchSystemExs -> update();
							$exs[$i] = $searchSystemExs -> getInfo();
						}else if( $datainner['place'][$i]['from'] && $datainner['place'][$i]['to'] ){
							$searchSystemExs -> addParam("from", $datainner['place'][$i]['from']);
							$searchSystemExs -> addParam("to", $datainner['place'][$i]['to']);
							$searchSystemExs -> newItem();
							$exs[$i] = $searchSystemExs -> getInfo();
						}else{
							//заканчиваем на пустом правиле, если удалили поля от и до то и удаляем правило
							if( $datainner['place'][$i]['id'] && (!$datainner['place'][$i]['from'] || !$datainner['place'][$i]['to']) ){
								$searchSystemExs -> setId($datainner['place'][$i]['id']);
								$searchSystemExs -> delete();
							}
							break;
						}
					}
					//printAr($exs);
					//удаляем устаревшие правила
					$searchSystemExs -> deleteWhereNotIn($itemObj -> id,$searchSystemID ,$exs);
				}

				// цены по правилам выставляем
				if($querys){
					foreach ($querys as $i => $val){
						for($j=0; $j < sizeof($exs); $j++){
							//printAr($exs);
							$searchSystemExsPrice -> addParam("id_exs",$exs[$j][$searchSystemExs -> idField]);
							$searchSystemExsPrice -> addParam("id_seo_query",$querys[$i][$projectSeoQuery -> idField]);
							$searchSystemExsPrice -> addParam("price",$datainner['price'][$i][$j]);
							$exPrice = $searchSystemExsPrice -> addPriceEx();
							//printAr($exPrice);
							if($j==0){
								$maxSeoPay += $datainner['price'][$i][$j];
							}
							
							
						}
					}
					//printAr($querys);
					// добавляем поисковую систему к проекту
					$searchSystemAccess -> addParam("id_seo_search_system", $searchSystemID);
					$searchSystemAccess -> addSystemAccess();
					$searchSystemsUsed[] = $searchSystemID;
				}

				
		}
	}
	//printAr($searchSystemsUsed);
	$searchSystemAccess -> deleteWhereNotIn($itemObj -> id,$searchSystemsUsed);
	$maxSeoPay = $maxSeoPay*$monthDay+$request -> abonement;
	
}