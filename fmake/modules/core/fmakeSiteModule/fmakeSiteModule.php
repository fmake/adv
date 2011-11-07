<?php
class fmakeSiteModule extends fmakeCore{
		
	public $table = "site_modul";
	public $idField = "id_modul";
	public $setName = "";
	public $fileDirectory = "images/sitemodul_image/";
	/**
	 * 
	 * 
	 * @var ArrayObject fmakeSiteModule_ExtensionInterface 
	 */
	protected $extensions; 	
	public $order = "position";
	public $tree = array();
	
	
	/**
	 * @var fmakeSiteAdministrator
	 */
	public static $userObj;
	public static $adminModulAccessQuery = false;
	
	public function __isset($key){
		
 		return isset($this->params[$key]);
  	}
	
	function __get($key){
		return $this->params[$key];
		
	}
	
	function getUserObj(){
		if(!self::$userObj){
			self::$userObj = new fmakeSiteModule_users();
		}
		return self::$userObj;
	}
	

	
	function getChilds ($id = null, $active = false, $inmenu = false,$type = false){
		if($id === null)
			$id = $this->id;

		$select = $this->dataBase->SelectFromDB(_LINE_);
		if($active)
			$select -> addWhere("active='1'");
		if($inmenu)
			$select -> addWhere("inmenu='1'");
			
		if($this -> order){
			$select -> addOrder($this->order);
		}
		return $select -> addFrom($this->table) -> addWhere("parent='".$id."'") -> queryDB();	
	}	
	
	function _getChilds ($id = null, $active = false, $inmenu = false,$role = false){
		
		if($id === null)
			$id = $this->id;
		// поля которе будем запрашивать для меню	
		$field = array($this -> idField,'caption','url','file','`index`','active');
		$where = array("parent = '".$id."'");
		if($active)
			$where[sizeof($where)] = "active='1'";
		if($inmenu)
			$where[sizeof($where)] = "inmenu='1'";
				
		// если указана роль пользователя	
		if($role){
			$modulAccess = self::$userObj->getAccesObj();
			//$adminModulAccess = new fmakeAcces_adminModul();
			
			// генерируем запрос который будет выгружать доступные модули для пользователя
			if(!fmakeSiteModule::$adminModulAccessQuery){
				fmakeSiteModule::$adminModulAccessQuery = $modulAccess->getAccessStandartQuery($role);
			}
			
			$where[sizeof($where)] = $this->idField." in (".fmakeSiteModule::$adminModulAccessQuery.")";
		}	
		return $this->getFieldWhere($field,$where);	
	}
		
	function getAllAsTree($parent = 0, $level = 0, $active = false, $inmenu = false){
			$level++;
			$items = $this -> getChilds($parent, $active, $inmenu);
				if($items){
					foreach ($items as $item){
						$item['level'] = $level;
						$this->tree[] = $item;
						$this->getAllAsTree($item[$this->idField], $level, $active, $inmenu);
					}
				}
		return $this->tree;
	}
	
	function getAllForMenu($parent = 0, $active = false,&$q,&$flag,$inmenu,$role = false,$level = 0,$level_vlojennost = false){
		
		if($level != $level_vlojennost || !$level_vlojennost){
			$items = $this->_getChilds($parent,$active,$inmenu,$role);
				
			if(!$items)	return;
			foreach ($items as $key => $item) {
					if($items[$key][$this -> idField] == $this->id && $this->setName == $this->getName()){
						$items[$key]['status'] = true;
						$flag = !$flag;
						$q = true;
					}	
					if($flag)$items[$key]['status'] = &$q;
					 $items[$key]['child'] = $this->getAllForMenu($item[ $this -> idField ], $active,$q,$flag,$inmenu,$role,$level++,$level_vlojennost);
					if($flag)unset($items[$key]['status'] );
			}
		}
		
		return $items;
	}
	
	function getModul($modul){
		
		$where = array();
		if($modul){
			$where[sizeof($where)] = "`url` = '".$modul."'";
		}else{
			$where[sizeof($where)] = "`index` = '1'";
		}	
		
		$arr = $this->getWhere($where);
		
		if($arr[0]){
			foreach($arr[0] as $key => $mod){
				$this->addParam($key, $mod);
			}
			$this -> id = $arr[0][$this -> idField];
		}
		
		return $arr;
			
	}

	function error404(){
		
		global $globalTemplateParam,$twig;
		HttpError(404);
		$template = $twig->loadTemplate('404.tpl');
		$template->display($globalTemplateParam->get());
		exit();
	}	
	
	function getPage($modul,$role,$twig){
		
		$this->getModul($modul);
		
		// находим страницы из других 
		if(!$this->id && $this->extensions){
			foreach ($this->extensions as $name=>&$obj){
				if($obj->getModul($modul)){
					$this->params = $obj->params;
					$this->setName = $name;
					break;
				}
			}
		}else{
			$this->setName = $this->getName();
		}
		
		
		if(!$this->id || !$this->isAccesPage($this->id,$role)){
			global $globalTemplateParam;
			HttpError(404);
			$template = $twig->loadTemplate('404.tpl');
			$template->display($globalTemplateParam->get());
			exit();
		}
	}
	
    function addExtension(fmakeSiteModule_ExtensionInterface $extension){
    
        $this->extensions[$extension->getName()] = $extension;
       
    }
    
	function getUp (){
		
		$order = $this->getInfo();
		$select = $this->dataBase->SelectFromDB( __LINE__);
		$arr = $select -> addFrom($this->table)-> addWhere("`parent` = '{$order['parent']}' ")  -> addWhere("`position` < '{$order['position']}' ") -> addOrder('position', 'DESC')  -> addLimit(0, 1) -> queryDB();
		$arr = $arr[0];
		
		if($arr)
		{
			$update = $this->dataBase->UpdateDB( __LINE__);
			$update	-> addTable($this->table) -> addFild("`position`", $order['position']) -> addWhere("`".$this->idField."` = '".$arr[$this->idField]."'") -> queryDB();
			$update	-> addTable($this->table) -> addFild("`position`", $arr['position']) -> addWhere("`".$this->idField."` = '".$this->id."'") -> queryDB();
		}
	}
	
	function getDown (){
		
		$order = $this->getInfo();
		$select = $this->dataBase->SelectFromDB( __LINE__);
		$arr = $select -> addFrom($this->table)-> addWhere("`parent` = '{$order['parent']}' ") -> addWhere("`position` > '{$order['position']}' ") -> addOrder('position', 'ASC')  -> addLimit(0, 1) -> queryDB();
		$arr = $arr[0];

		if($arr){
			
			$update = $this->dataBase->UpdateDB( __LINE__);			
			$update	-> addTable($this->table) -> addFild("`position`", $order['position']) -> addWhere("`".$this->idField."` = '".$arr[$this->idField]."'") -> queryDB();
			$update	-> addTable($this->table) -> addFild("`position`", $arr['position']) -> addWhere("`".$this->idField."` = '".$this->id."'") -> queryDB();
			
		}
	}
    /*
     * делаем две записи на одном уровне, устонавливает позицуии
     */
    function setGeneralParent($from,$to){
		$this->setId($to);
		$info = $this->getInfo();
		// добавляем объект в дерево
		$this->setId($from);
		$this->addParam("parent", $info['parent']);
		$this->update();		
		$select = $this->dataBase->SelectFromDB( __LINE__);
		$arr = $select->addFild("id") -> addFrom($this->table)->addWhere("`parent` = '".$info['parent']."' ") -> addOrder('position', 'ASC') -> queryDB();
		$fromNum = 0;
		$toNum = 0;
		for($i=0;$i<sizeof($arr);$i++){
			if($fromNum && $toNum)
				break;
			
			if($arr[$i]['id']==$from){
				$fromNum = $i+1;
			}else if($arr[$i]['id']==$to){
				$toNum = $i+1;
			}
		}
		$action = $fromNum - $toNum - 1; // -1 так как они должны быть друг под другом
		$this->setId($from);
		while($action > 0){
			$this->getUp();
			$action--;
		}
    	while($action < 0){
			$this->getDown();
    		$action++;
		}

    }
    /*
     * выставляем родителя и делаем самой последней
     */
    function setParent($child,$parent){
    	$this->setId($child);
		$this->addParam("parent", $parent);
		$this->update();
		
		$select = $this->dataBase->SelectFromDB( __LINE__);
		$arr = $select->addFild("id") -> addFrom($this->table)->addWhere("`parent` = '".$info['parent']."' ") -> addOrder('position', 'ASC') -> queryDB();
		$childNum = 0;
		for($i=0;$i<sizeof($arr);$i++){
			if($arr[$i]['id'] == $child){
				$childNum = $i;
				break;
			}
		}
		
		$action = sizeof($arr) - $childNum;
		
		$this->setId($child);
    	while($action > 0){
			$this->getDown();
    		$action--;
		}
		
		
    }
    
	function getName(){
    
        return 'siteModul';
       
    }

	
     function getParent ($parent) // Берем родителя раздела
     {
          
          $select = $this->dataBase->SelectFromDB(__LINE__);
          $parent = $select -> addFrom($this->table) -> addWhere("active='1'") -> addWhere("{$this->idField}='$parent'") -> addOrder($this->order) -> queryDB();
          return $parent[0];
     }

     function getParents($parent){
     
          $parents[] = $this -> getParent($parent);
          if($parents[sizeof($parents)-1]['parent']){
               $subparents = $this->getParents($parents[sizeof($parents)-1]['parent']);
               if($subparents){
                    $parents = array_merge( $parents, $subparents );
               }
          }
          return $parents;
     }
     
     
	 function isAccesPage($modul_id,$role){
		$user = $this -> getUserObj();
		$adminModulAccess = $user -> getAccesObj();
		// генерируем запрос который будет выгружать доступные модули для пользователя
		self::$adminModulAccessQuery = $adminModulAccess->getAccessStandartQuery($role);
		
		$field = array($this->idField);
		$where = array();
		$where[sizeof($where)] = $this->idField." in (".self::$adminModulAccessQuery.")";
		$where[sizeof($where)] = "`$this->idField` = '{$modul_id}'";
		if ( $this->getFieldWhere($field,$where) ){
			return true;
		}
		return false;
		
	 }
	 
	 ///////// возвращает true или false можно войти на эту страницу или нет
	  function getAccesParents($modul_id,$role){
		 if( !$this -> isAccesPage($modul_id,$role) ){
			return false;
		 }else{
			$this -> setId($modul_id);
			$item = ($this ->getInfo()); 
			$parent = ( $this -> getParent($item['parent']) );
			//printAr($parent);
			if($parent){
				return $this -> getAccesParents($parent[$this->idField],$role);
			}
		 }
		 return true;
     }
	 
	///////// вызывает страницу ошибки доступа
	function isAccesable($twig,$modul_id,$role){
		
		if( !$this -> getAccesParents($modul_id,$role) ){
			//echo("aa");
			global $globalTemplateParam;
			HttpError(404);
			$globalTemplateParam->set('url',$_SERVER['REQUEST_URI']);
			$template = $twig->loadTemplate('error_acces.tpl');
			$template->display($globalTemplateParam->get());
			exit();
		}
	}
	 
}