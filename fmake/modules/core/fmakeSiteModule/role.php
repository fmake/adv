<?php
class fmakeSiteModule_role extends fmakeCore{
	
	public $table = "site_modul_role";
	public $idField = "id_modul_role";
	
	function getRols(){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		return $select -> addFild("{$this->idField},role") -> addFrom($this->table) -> addGroup("role") -> queryDB();
	}
	
}