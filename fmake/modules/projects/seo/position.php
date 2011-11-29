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
	
	function test($url, $content, $info,$date){
		$arr = explode(";", $content);
		print ( "[$url]  $arr[0] ".($arr[1])."<br />" );
		echo "date {$date} <br />";
	}
	
	/**
	* Проверить позицию сайта
	*/
	function checkPosition($id_seo_query,$checkIfExist = false){
		$pos = $this -> getPositionByQueryDate($id_seo_query);
		if($pos && !$checkIfExist){
			return array($pos[0]);
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
		return $searchSystem -> getPositionWhithData();
	}
	
	/**
	* Проверить позицию сайта
	*/
	function getXml($data){
		$xml = '<?xml version="1.0" encoding="utf-8"?>
				<advposition>
					<pos>'.$data[0].'</pos>
					<url>'.htmlentities($data[1]).'</url>
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
		$mc -> addCallBack(array(new self, 'test'),strtotime("today"));
		$mc->setMaxSessions(20); // limit 2 parallel sessions (by default 10)
		//$mc->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
		$url_query = 'http://'.$hostname.'/cron/querys_check_position.php?key='.$cronKey.'&id_seo_query=';
		
		for ($i = 0; $i < $sizeQ; $i++) {
			for ($j = 0; $j < $parallelCheck; $j++) {
				if(!$querys[$j+$parallelCheck*$i][$seoQuery->idField])continue;
				$mc->addUrl($url_query.($i+$j*20));
			}
			$mc->wait();
			echo "wait<br />";
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