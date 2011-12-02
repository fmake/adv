<?php
class projects_seo_position extends fmakeCore{
		
	public $table = "projects_seo_query_position";
	public $idField = array("id_seo_query","date");
	public $order = "date";
	public $order_as = DESC;

	
	
	/**
	*
	* Создание нового объекта, с использованием массива params
	*/
	function newItem(){
		if($this -> getPositionByQueryDate($this -> params['id_seo_query'],$this -> params['date'])){
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
	* получить позицию по запросу и дате
	*/
	function getPositionByQueryDate( $id_seo_query, $date = false){
		$where[] = "`id_seo_query` = '{$id_seo_query}'";
		if(!$date){
			$date = strtotime("today");
		}
		$where[] = "`date` = '{$date}'";
		if($active)
			$where[] = "`active` = '{$active}'";
		$arr = ($this -> getWhere($where));
		return $arr[0];
	}
	
	function setPosition($url, $content, $info, $date){
		$xml = new xmlParser();
		$ans = $xml -> xmlToArray($content);
		$this -> addParam('id_seo_query', $ans['query']);
		$this -> addParam('date', $date);
		$this -> addParam('pos', $ans['pos'] ? $ans['pos'] : 0);
		$this -> newItem();
	}
	
	/**
	* Проверить позицию сайта
	*/
	function checkPosition($id_seo_query,$checkIfExist = false){
		$pos = $this -> getPositionByQueryDate($id_seo_query);
		if($pos && !$checkIfExist){
			return array('pos' => $pos['pos'],'id_seo_query' => $id_seo_query);
		}
		$seoQuery = new projects_seo_query($id_seo_query);
		$seoSearchSystem = new projects_seo_searchSystem();
		$project = new projects();
		$query = $seoQuery -> getInfo();
		if(!$query){
			return array();
		}
		$project -> setId($query[ $project -> idField ]);
		$project = $project -> getInfo();
		$seoSearchSystem -> setId($query[ $seoSearchSystem -> idField ]);
		$system = $seoSearchSystem -> getInfo();
		$class = searchSystems::$parentClassName.'_'.$system['class'];
		$searchSystem = new $class;
		$searchSystem -> setData($query['query'], $project['url'], 213);
		$arrPos = $searchSystem -> getPositionWhithData();
		$arrPos['id_seo_query'] = $id_seo_query;
		return $arrPos;
	}
	
	/**
	* Проверить позицию сайта
	*/
	function getXml($data){
		$xml = '<?xml version="1.0" encoding="utf-8"?>
				<advposition>
					<pos>'.$data['pos'].'</pos>
					<url>'.htmlentities($data['url']).'</url>
					<query>'.($data['id_seo_query']).'</query>
				</advposition>
		';
		return $xml;
	}
	
	/**
	* получить позицию по запросу и дате
	*/
	function checkAllPosition(){
		$seoQuery = new projects_seo_query();
		$querys = ( $seoQuery -> getQuerys() );
		global $configs,$hostname,$cronKey;
		$parallelCheck = $configs -> query_parallel_check;
		if(!$parallelCheck || $parallelCheck < 1){
			$parallelCheck = 1;
		}
		$querysSize = sizeof($querys);
		$sizeQ = ceil($querysSize/$parallelCheck);
		$mc = new cURL_mymulti();
		$mc -> addCallBack(array(new self, 'setPosition'),strtotime("today"));
		$mc->setMaxSessions($parallelCheck); // limit 2 parallel sessions (by default 10)
		$url_query = 'http://'.$hostname.'/cron/querys_check_position.php?key='.$cronKey.'&id_seo_query=';
		for ($i = 0; $i < $sizeQ; $i++) {
			for ($j = 0; $j < $parallelCheck; $j++) {
				if(!$querys[$j+$parallelCheck*$i][$seoQuery->idField])continue;
				$mc->addUrl($url_query.($querys[$i*$parallelCheck+$j][$seoQuery -> idField]));
			}
			$mc->wait();
			//echo "wait<br />";
		}
	}
	
	/**
	* удаление + очищение правил-цен, которые теперь не нужны
	* @see fmakeCore::delete()
	*/
	function delete(){
		$price = new projects_seo_searchSystemExsPrice();
		$price -> deleteByQueryId($this -> id);
		parent::delete();
	}
	
}