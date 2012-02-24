<?php
/**
 * добавление запросов из таблицы 
 */
//printAr($_REQUEST);
//printAr($_FILES);
$excel = new ExcelParser();
$projectSeoQuery -> addParam("id_project", $itemObj -> id);
$searchSystemExs -> addParam("id_project", $itemObj -> id);
$searchSystemAccess -> addParam("id_project", $itemObj -> id);
$data = $request -> data;
//exit;
/*
$excel = new ExcelParser();
$excel->file = $file['tmp_name'];
$arr = $excel->getFileInArray();
*/
if($data){
	$maxSeoPay = 0;
	$maxSeoPayUser = 0;
	$firstSearchSystem = true;
	foreach ($data as $searchSystemID => $datainner){
		$searchSystemParentID = $searchSystemID;
		foreach ($datainner as $regionID => $datainner){
				if($regionID){
					$searchSystemID = $regionID;
				}
				//echo "{$searchSystemParentID} ----  {$regionID}";
				// если загрузили файл
				if($_FILES['file']['name'][$searchSystemParentID][$regionID] && !$_FILES['file']['error'][$searchSystemParentID][$regionID]){
					//echo "qqq";
					$excel->file = $_FILES['file']['tmp_name'][$searchSystemParentID][$regionID];
					$arr = $excel->getFileInArray();
					$datainner['place'] = $excel->getExt($arr);
					if(!$searchSystemExs -> valid($datainner['place'])){
						echo "Правила заполнены неверно";
						continue;
					}
					$index = sizeof($datainner['place']);
					for ($i = 0; $i < $index; $i++) {	
						$tmpexs = $searchSystemExs -> getExsProjectSystemFromTo($itemObj -> id,$searchSystemID,$datainner['place'][$i]['from'],$datainner['place'][$i]['to']);
						if($tmpexs){
							$datainner['place'][$i]['id'] = $tmpexs[$searchSystemExs -> idField];
						}
					}
					
					$datainner['querys'] = ( $excel->getQuery($arr) );
					$datainner['price'] = ( $excel->getPrice($arr,$datainner['place']) );
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
							// необходимо проверить может такой запрос уже существует
							if( ($tmpQuery = $projectSeoQuery -> getItemProjectSystemQuery($itemObj -> id,$searchSystemID, $query)) ){
								$querys[$i] = $tmpQuery;
							}else{
								$projectSeoQuery -> addParam("id_seo_search_system", $searchSystemID);
								$projectSeoQuery -> addParam("query", $query);
								$projectSeoQuery -> newItem();
								$querys[$i] = $projectSeoQuery -> getInfo();
							}
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
								if($firstSearchSystem){
									$maxSeoPayUser += $datainner['price'][$i][$j];
								}
							}
							
							
						}
					}
					//printAr($querys);
					$position = 3000;
					for ($ind = 0; $ind < sizeof($request -> searchorder); $ind++) {
						if($searchSystemParentID == $request -> searchorder[$ind] ){
							$position = ($ind+1)*100;
						}
					}
					
					$positionRegion = 0;
					//printAr($request -> regionorder);
					// если это регион
					if($searchSystemParentID != $searchSystemID){
						for ($ind = 0; $ind < sizeof($request -> regionorder[$searchSystemParentID]); $ind++) {
							if($searchSystemID == $request -> regionorder[$searchSystemParentID][$ind] ){
								$positionRegion = sizeof($request -> regionorder[$searchSystemParentID]) - $ind;
							}
						}
					}
					// добавляем поисковую систему к проекту
					$searchSystemAccess -> addParam("id_seo_search_system", $searchSystemID);
					$searchSystemAccess -> addParam("position", $position - $positionRegion);
					$searchSystemAccess -> addSystemAccess();
					$searchSystemsUsed[] = $searchSystemID;
				}

			$firstSearchSystem = false;	
		}
	}
	//printAr($searchSystemsUsed);
	$searchSystemAccess -> deleteWhereNotIn($itemObj -> id,$searchSystemsUsed);
	$maxSeoPay = $maxSeoPay*$monthDay+$request -> abonement;
	$maxSeoPayUser = $maxSeoPayUser*$monthDay+$request -> abonement;
}