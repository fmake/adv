<?php

define(ID_ADMINISTRATOR,1);
define(ID_OPTIMISATOR,4);
define(ID_AKKAUNT,6);
define(ID_SEO_ANALITIC,7);
define(ID_CLIENT,8);


class fmakeSiteModule_users extends fmakeCore{
	
	public $table = "users";
	public $idField = "id_user";
	public $type = "user";
	public $id; 	// int
	public $login;	// char
	public $role;	// int
	public $status;	// bool
	public $acces;	// char
	public $name;
	
	
	public static $accesObj = false;
	public static $roleObj = false;
	
	/**
	 * 
	 * @return fmakeAcces_adminModul
	 */
	function getAccesObj(){
		if(!self::$accesObj){
			self::$accesObj = new fmakeSiteModule_acces();
		}
		return self::$accesObj;
	}
	
	/**
	 * 
	 * @return fmakeSiteAdministratorRole
	 */
	function getRoleObj(){
		if(!self::$roleObj){
			self::$roleObj = new fmakeSiteModule_role();
		}
		return self::$roleObj;
	}
	
	
	public function setLogin($id, $login, $role, $name = 'Пользователь')
	{
		$this->id = $id;
		$this->login = $login;
		$this->role = $role;
		$this->status = true;
		$this->name = $name;
		$this->save();
	}
	
	public function logout()
	{
		unset($_SESSION[$this->type]);
		$this->status = false;
	}

	public function isLogined()
	{
		return $this->status;
	}

	public function getRole()
	{
		return $this->role;
	}

	public function load()
	{
		
		$this->id = $_SESSION[$this->type]['id'];
		$this->login = $_SESSION[$this->type]['login'];
		$this->role = $_SESSION[$this->type]['role'];
		$this->status = $_SESSION[$this->type]['status'];
		$this->name = $_SESSION[$this->type]['name'];
	}

	public function save()
	{
		$_SESSION[$this->type]['id'] = $this->id;
		$_SESSION[$this->type]['login'] = $this->login;
		$_SESSION[$this->type]['role'] = $this->role;
		$_SESSION[$this->type]['status'] = $this->status;
		$_SESSION[$this->type]['name'] = $this->name;
	}
	
	/**
	 * Проверяет есть ли такой пользователь и если есть то возвращает его
	 * @param string $login  
	 * @param string $password
	 * @param string $ismd5
	 * @return ArrayObject
	 */
	function login($login, $password,$ismd5 = false){
     	$select = $this->dataBase->SelectFromDB( __LINE__);
		$row = $select -> addFrom($this->table) ->	addWhere("login='".mysql_escape_string($login)."'") -> addWhere("active='1'") -> queryDB();
		$row = $row[0];
		if($ismd5 && $password == $row["password"]){
			return $row;
		}else if (!$ismd5 && md5($password) == $row["password"]){
			return $row;
		}else{
			return false;
		}
	}
	
	/**
	* 
	* Получаем записи по роли
	*/
	function getByRole($role,$active = false){
		
		$where[0] = 'role = '.$role;
		if($active !== false){
			if($active){
				$where[1] = 'active = '.$active;
			}else{
				$where[1] = "active = '0'";
			}
		}
		
		return $this->getWhere($where);	
	}
	
	/**
	* 
	* Получаем колличество записей по роли
	*/
	function getNumRows($role,$active = false) {
		
		$where[0] = 'role = '.$role;
		if($active !== false){
			if($active){
				$where[1] = 'active = '.$active;
			}else{
				$where[1] = "active = '0'";
			}
		}
		
		$count = $this->getFieldWhere(array( "COUNT(*)" ),$where);	
		
		return $count[0]["COUNT(*)"];
	}
	
	/**
	*
	* Создаем фильтр
	*/
	function createFilter($filter) {
	
		if($filter){
				
			foreach ($filter as $name => $value){
				switch($name){
					case 'active':
						$filter[$name] = "`{$this->table}`.{$name} = '{$value}'";
						break;
					case 'is_seo':
						$filter[$name] = "{$name} = '{$value}'";
						break;
					case 'is_context':
						$filter[$name] = "{$name} = '{$value}'";
						break;
					case 'company':
						$filter[$name] = "`{$this->table}`.{$name} like '{$value}%'";
						break;
					case 'id_user':
						$filter[$name] = "`{$this->table}`.{$name} = '{$value}'";
						break;
					break;
					case 'role':
						$filter[$name] = "{$name} = '{$value}'";
						break;
					break;
					default:
						unset($filter[$name]);
					break;
				}
			}
				
				
		}
	
	
		return $filter;
	
	}
	/*
	 * Все клиенты с параметрами
	*/
	function getUserWithProjectsParams($filds = false,$filter = array()){
		$filter = $this -> createFilter($filter);
		$project = new projects();
		$projectAccess = new projects_accessRole();
		$select = $this->dataBase->SelectFromDB( __LINE__);
	
		if($filds){
			if(trim($filds) == "*")
				$select -> addFild("DISTINCT `$this->table`.id_user, name, company ");
			else 
			$select -> addFild("DISTINCT `$this->table`.id_user, ".$filds);
		}
		
		if($filter){
			foreach ($filter as $name => $value){
				$select -> addWhere($value);
			}
		}
		$select
			-> addFrom("$this->table LEFT JOIN $projectAccess->table on `$this->table`.$this->idField = `$projectAccess->table`.$this->idField
				 			LEFT JOIN $project->table on `$projectAccess->table`.$project->idField = `$project->table`.$project->idField");
		
		
		return $select -> queryDB();
	}
	/*
	 	SELECT *
		FROM `projects_access_role`
		RIGHT JOIN (
		
		SELECT `id_project`
		FROM `projects_access_role`
		WHERE `id_user` =10
		)A ON `projects_access_role`.`id_project` = A.`id_project`
		LEFT JOIN `projects` ON `projects_access_role`.`id_project` = `projects`.`id_project`
		LEFT JOIN `users` ON `projects_access_role`.`id_user` = `users`.`id_user`
		WHERE `id_role` =8
	 */
	function getUserWithProjectsParamsGroupBy($filds = "*",$groupUserID,$filter = array()){
		$filter = $this -> createFilter($filter);
		$project = new projects();
		$projectAccess = new projects_accessRole();
		$select = $this->dataBase->SelectFromDB( __LINE__);
		if($filter){
			foreach ($filter as $name => $value){
				$fltrstr .= ' AND '.$value;
			}
		}
		//echo $fltrstr;
		$query = "
			SELECT {$filds}
			FROM `projects_access_role`
			RIGHT JOIN (
				SELECT `id_project`
				FROM `{$projectAccess->table}`
				WHERE `{$this -> idField}` = '{$groupUserID}'
			) A ON `{$projectAccess->table}`.`{$project -> idField}` = A.`{$project -> idField}`
			LEFT JOIN `{$project -> table}` ON `projects_access_role`.`{$project -> idField}` = `{$project -> table}`.`{$project -> idField}`
			LEFT JOIN `{$this -> table}` ON `{$projectAccess->table}`.`{$this -> idField}` = `{$this -> table}`.`{$this -> idField}`
			WHERE 1 {$fltrstr}
		";

		return $select -> stringQueryDB($query);
	}	
	
	
}