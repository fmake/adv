<?php
class projects_seo_moneyUsers extends fmakeCore{
		
	public $table = "projects_seo_money_users";
	public $idField = array("id_project","id_role","date");
	public $order = "date";
	
	/**
	 * 
	 * посчет денег по ролям пользователей
	 * @param unknown_type $money
	 * @param unknown_type $id_project
	 * @param unknown_type $date
	 */
	function addMoney($money,$id_project,$date){
		$acccessRole = new projects_accessRole();
		$acccess = ($acccessRole -> getProjectRols($id_project));
		$index = sizeof($money);
		$index1 = sizeof($acccess);
		for ($i = 0; $i < $index && $acccess; $i++) {
			foreach ($acccess as $j => $acccessChild){
				if(!$acccess[$j]['pay_percent'])
					continue;
				$this -> addParam('money', $money[$i]['money']*$acccess[$j]['pay_percent']/100);
				$this -> addParam('id_project', $id_project);
				$this -> addParam('id_role', $acccess[$j]['id_role']);
				$this -> addParam('date', $date);
				$this -> addParam('id_user', $acccess[$j]['id_user']);
				$this -> newItem();
			}
			// только для первой поисковой системы
			break;
		}
	}
	
	/**
	 * 
	 * Получаем деньги для пользователя за период
	 * @param unknown_type $id_project
	 * @param unknown_type $id_user
	 */
	function getProjectUserDateMoney($id_project,$id_user,$role,$date_start,$date_end){
		if($id_project)
			$where[] = "`id_project` = '{$id_project}'";
		if($id_user)
			$where[] = "`id_user` = '{$id_user}'";
		if($role)
			$where[] = "`id_role` = '{$role}'";	
		$where[] = "`date` >= '{$date_start}'";
		$where[] = "`date` <= '{$date_end}'";
		$m = ( ($this -> getFieldWhere(array("SUM(money) as money"),$where)) );
		return $m[0]['money'];
	}
	
	/**
	*
	* Создание нового объекта, с использованием массива param
	*/
	function newItem(){
		if($this -> getMoneyByProjectSearchSystemDate($this -> params['id_project'],$this -> params['id_role'],$this -> params['date'])){
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
	* получить деньги по запросу в промежутке
	*/
	function getMoneyByProjectSearchSystemDate( $id_project,$id_role, $date){
		$where[] = "`id_project` = '{$id_project}'";
		$where[] = "`id_role` = '{$id_role}'";
		$where[] = "`date` = '{$date}'";
		return ($this -> getWhere($where));
	}
	
	
}