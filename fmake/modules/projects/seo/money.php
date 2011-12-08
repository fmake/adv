<?php
class projects_seo_money extends fmakeCore{
		
	public $table = "projects_seo_money";
	public $idField = array("id_project","id_seo_search_system","date");

	
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
						// проверяем позицию запроса по правилу
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
				$this -> addParam("money", $money);
				$this -> addParam("id_project", $projectsSeo[$i][$projects -> idField]);
				$this -> addParam("id_seo_search_system", $projectsSeo[$i]['search_systems'][$j]['id_seo_search_system']);
				$this -> addParam("date", $date);
				$this -> newItem();
			}
			exit;
		}
		
	}
	
	/**
	*
	* Создание нового объекта, с использованием массива params
	*/
	function newItem(){
		if($this -> getMoneyByProjectSearchSystemDate($this -> params['id_project'],$this -> params['id_seo_search_system'],$this -> params['date'])){
			$this->update();
			return;
		}
		$insert = $this->dataBase->InsertInToDB(__LINE__);
		$insert	-> addTable($this->table);
		$this->getFilds();
		
		if($this->filds){
			foreach($this->filds as $fild){
				if(!isset($this->params[$fild])) continue;
					$insert -> addFild("`".$fild."`", $this->params[$fild]);
			}
		}
		$insert->queryDB();
		$this->id = $insert	-> getInsertId();
	}
	
	function update() {
		
		if(!$this->filds)
			$this->getFilds();
		
		foreach($this->filds as $fild){
			if(!isset($this->params[$fild]) || in_array($fild,  $this -> idField)) continue;
				$update =  $this->dataBase->UpdateDB( __LINE__);
				$update	-> addTable($this->table) -> addFild("`".$fild."`", $this->params[$fild]);
				
				foreach($this->idField as $fld){
					$update -> addWhere("{$fld}='".$this->params[$fld]."'");
				}
			$update  -> queryDB();
		}
	}	
	
	/**
	* получить позиции по запросу в промежутке
	*/
	function getMoneyByProjectSearchSystemDate( $id_project,$id_seo_search_system, $date){
		$where[] = "`id_project` = '{$id_project}'";
		$where[] = "`id_seo_search_system` >= '{$id_seo_search_system}'";
		$where[] = "`date` = '{$date}'";
		return ($this -> getWhere($where));
	}
	
	
}