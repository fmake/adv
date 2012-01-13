<?php
class sape_money extends sape{
	public $table = "sape_money";	
	public $idField = array("id_project","date");
	public $order = "date";
	public $order_as = ASC;
	/**
	 * 
	 * Получить потреченные деньги в промежутке
	 * @param unknown_type $id_project
	 * @param unknown_type $date_start
	 * @param unknown_type $date_end
	 */
	function getMoney($id_project,$date_start,$date_end){
		
		
		
		return array();	
	}
	/**
	 * 
	 * Получить потреченные деньги на проект за текущую дату из базы данных
	 * @param int $id_project
	 * @param int $date
	 */
	function getMoneyDay($id_project,$date){
		$where[] = "`id_project` = '{$id_project}'";
		$where[] = "`date` = '{$date}'";
		return ($this -> getWhere($where));
	}
	/**
	 * 
	 * Получить потреченные деньги на проект за текущую дату из Sape
	 * @param int $id_project
	 * @param int $date
	 */
	function getSapeMoneyDay($id_project,$date){
		
		if( !$this -> loginDefault() )
			return 0;
		$irxClient = $this -> getIrxClient();
		$year = date("Y",($date));
		$month = date("m",($date));
		$day = date("d",($date));
		$irxClient -> query('sape.get_project_money_stats',$id_project,$year,$month,$day);
		$ans = ($irxClient -> getResponse());
		return $ans['sum'];
	}
	/**
	 * 
	 * Получить потреченные деньги на проект за текущую дату из Sape
	 * @param unknown_type $id_project
	 * @param int $date
	 */
	function getSapeMoneyDayProjects($date = false){
		
		if( !$this -> loginDefault() )
			return array();
		$irxClient = $this -> getIrxClient();
		if($date){
			$year = date("Y",($date));
			$month = date("m",($date));
			$day = date("d",($date));
			$irxClient -> query('sape.get_projects_money_stats',$year,$month,$day);
		}
		// за все доступное время
		else{
			$irxClient -> query('sape.get_projects_money_stats');
		}
		return ($irxClient -> getResponse());
	}
	/**
	 * 
	 * Записываем затраты по Sape на определенную дату
	 * @param int $date
	 */
	function checkMoney($date = false){
		if(!$date)
			$date = strtotime("yesterday");
		$projects = new projects();
		$projectsSeo = ( $projects -> getProjectsWithSeoParams() );	
		$projectStat = $this -> getSapeMoneyDayProjects($date);
		//echo $projectStat[0]['date_logged']->year;
		$index = sizeof($projectStat);
		$index2 = sizeof($projectsSeo);
		for ($i = 0; $i < $index; $i++) {
			for ($j = 0; $j < $index2; $j++) {
				// сумма по текущему проекту
				if($projectsSeo[$j]['id_sape'] == $projectStat[$i]['project_id']){
					$this -> addParam('id_project', $projectsSeo[$j][$projects -> idField]);
					$this -> addParam('date', $date);
					$this -> addParam('sum', abs($projectStat[$i]['sum']));
					$this -> newItem();
				}
			}
		}
		
	}
	
	/**
	 * 
	 * Записываем затраты по Sape на определенную дату
	 * @param int $date
	 */
	function checkMoneyAll(){
		$projects = new projects();
		$projectsSeo = ( $projects -> getProjectsWithSeoParams() );
		$projectStat = $this -> getSapeMoneyDayProjects();
		$index = sizeof($projectStat);
		$index2 = sizeof($projectsSeo);
		for ($i = 0; $i < $index; $i++) {
			for ($j = 0; $j < $index2; $j++) {
				// сумма по текущему проекту
				if($projectsSeo[$j]['id_sape'] == $projectStat[$i]['project_id']){
					$this -> addParam('id_project', $projectsSeo[$j][$projects -> idField]);
					$this -> addParam('date',
						strtotime("{$projectStat[$i]['date_logged']->year}-{$projectStat[$i]['date_logged']->month}-{$projectStat[$i]['date_logged']->day}"));
					$this -> addParam('sum', abs($projectStat[$i]['sum']));
					$this -> newItem();
					
				}
				
			}
			unset ($projectStat[$i]);
		}
		
	}
	
	/**
	*
	* Создание нового объекта, с использованием массива params
	*/
	function newItem(){
		if($this -> getMoneyDay($this -> params['id_project'],$this -> params['date'])){
			$this->update();
		}else{
			parent::newItem();
		}
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
	
	
}