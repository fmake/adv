<?php
class projects_seo_position extends fmakeCore{
		
	public $table = "projects_seo_query_position";
	public $idField = array("id_seo_query","date");
	public $order = "date";
	public $order_as = ASC;
	static $count = 0;
	
	
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
	* получить позиции по запросу и датам в массиве
	*/
	function getPositionsByQueryInDate( $id_seo_query, $date){
		$where[] = "`id_seo_query` = '{$id_seo_query}'";
		$whereStr = "( 0 ";
		$index = sizeof($date);
		for ($i = 0; $i < $index; $i++) {
			$whereStr .= "OR `date` = {$date[$i]} ";
		}
		$whereStr .= ")";
		$where[] = $whereStr;
		$arr = ($this -> getWhere($where));
		$ans = array();
		$index = sizeof($date);
		for ($i = 0,$j=0; $i < $index; $i++) {
			
			if($arr[$j]['date'] == $date[$i]){
				$ans[] = $arr[ $j++ ];
			}else{
				$ans[] = array('date' => $date[$i],'pos' => 0);
			}
		}
		return $ans;
	}
	
	/**
	* получить позиции по запросу в промежутке
	*/
	function getPositionsByQueryDate( $id_seo_query, $date_start,$date_end){
		$where[] = "`id_seo_query` = '{$id_seo_query}'";
		$where[] = "`date` >= '{$date_start}'";
		$where[] = "`date` <= '{$date_end}'";
		return ($this -> getWhere($where));
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
		$arr = ($this -> getWhere($where));
		return $arr[0];
	}
	
	function setPosition($url, $content, $info, $date){
		$xml = new xmlParser();
		$ans = $xml -> xmlToArray($content);
		$this -> addParam('id_seo_query', $ans['query']);
		$this -> addParam('date', $date);
		$this -> addParam('pos', $ans['pos'] ? $ans['pos'] : "0");
		$this -> newItem();
		//echo ++self::$count."<br />";
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
	function checkAllPosition( $checkIfExist = false){
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
		$mc->setMaxSessions($parallelCheck); // лимит парралельных запросов
		$url_query = 'http://'.$hostname.'/cron/querys_check_position.php?key='.$cronKey;
		if($checkIfExist){
			$url_query .= '&checkIfExist=1';
		}
		$url_query .= '&id_seo_query=';
		$size = 0;
		for ($i = 0; $i < $sizeQ; $i++) {
			for ($j = 0; $j < $parallelCheck; $j++) {
				$mc->addUrl($url_query.($querys[$i*$parallelCheck+$j][$seoQuery -> idField]));
				$size++;
			}
			$mc->wait();
		}
	}
	/**
	 * 
	 * получаем стандартнй объект select
	 */
	function getChangeQueryPos_defObj($id_project,$date){
		$yesterday = strtotime("-1 days",$date);
		//$yesterday = 1323288000;
		$select = $this->dataBase->SelectFromDB( __LINE__);

		$select -> addWhere("A.`date` ={$date}");
		$select -> addWhere("B.`date` ={$yesterday}");
		$select -> addWhere("Q.`id_project` ={$id_project}");
		$select -> addFild("sum(A.pos - B.pos) `change`");
		$select
				-> addFrom("`projects_seo_query` Q
							LEFT JOIN `projects_seo_query_position` A ON Q.`id_seo_query` = A.`id_seo_query`
							LEFT JOIN `projects_seo_query_position` B ON A.`id_seo_query` = B.`id_seo_query`");				
		return $select;
	}
	
	/**
	 * 
	 * получить измнение позиций с текущей даты 
	 * @param unknown_type $id_project
	 */
	function getChangeQueryPos($id_project,$date){
		$select = $this ->getChangeQueryPos_defObj($id_project, $date);
		$select -> addWhere("(A.pos - B.pos) > 0");			
		$plus = ($select -> queryDB());
		$select = $this ->getChangeQueryPos_defObj($id_project, $date);
		$select -> addWhere("(A.pos - B.pos) < 0");			
		$mines = ($select -> queryDB());
		return array('plus' => $plus[0]['change']?$plus[0]['change']:0,'mines' => $mines[0]['change']?$mines[0]['change']:0);
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