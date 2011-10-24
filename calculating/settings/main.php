<?php
	

	function initMainForm($itemObj,$context = array()){
		//printAr($context);
		$pages = ( $itemObj->getAllAsTree(0, 0) );
		$parents = array();
		$parents[0] = "Корневой раздел";
		for ($index = 0; $index < sizeof($pages); $index++) {
			$pages[$index][$itemObj->idField];
			$parents[$pages[$index][$itemObj->idField]] = blankprint($pages[$index]['level']).$pages[$index]['caption'];
		}
		
		$myForm = new phpObjectForms(array("name" => 'editform', "action" => $context['action_url'], "display_outer_table" => false, "table_align" => false,
			    "table_width" => '600',"enable_js_validation" => true,"hold_output" => true,"css_class_prefix" => "edit-"
		));
		$leftWrapper = new FPLeftTitleWrapper(array());
		$layoutForm = new FPColLayout(array("table_padding" => 5,"element_align" => "center", "hold_output" => true,));
		
		if($context['item']){
			$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "update")));
			$layoutForm -> addElement(new FPHidden(array("name" => "id","value" => $context['item'][$itemObj -> idField])));
			$layoutForm -> addElement(new FPText(array("text" =>
					                    '<div align="left">'.
					                    '<h2>Редактирование страницы</h2>'.
					                    '<a href="'.$context['action_url'].'">вернуться назад</a></div>')));
		}else{
			$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "add")));
			$layoutForm -> addElement(new FPText(array("text" =>
					                    '<div align="left">'.
					                    '<h2>Добавление страницы</h2>'.
					                    '<a href="'.$context['action_url'].'">вернуться назад</a></div>')));
		}
		           				
		
		
		// системные чекбоксы
		$checkboxSystem = new FPGridLayout(array("table_padding" => 5,"columns" => 2,));        
		$checkboxSystem -> addElement(
		        new FPCheckBox(array(
						                "name" => 'inmenu',
						                "title" => 'отображени в меню',
						                "table_align" => 'left',
						                "checked" => $context['item'] ? $context['item']['inmenu'] : true,
						         		"comment" => 'Если выключено,<br /> то на страница не видна из меню'
						            ))
		 );
		$checkboxSystem -> addElement(
		        new FPCheckBox(array(
						                "name" => 'active',
						                "title" => 'отображени на сайте',
						                "table_align" => 'left',
						                "checked" => $context['item'] ? $context['item']['active'] : true,
						         		"comment" => 'Если выключено,<br /> то на страницу нельзя зайти'
						            ))
		 );
		 
		$layoutForm -> addElement(new FPGroup(array(
		                "name" => "monthGroup",
		                "title" => 'Параметры отображения страницы',
		                "table_align" => "left",
		                "elements" => array(
		                    &$checkboxSystem,
		                ))));
		 $layoutForm -> addElement(new FPTextField(array(
		                "name" => 'caption',
		                "title" => 'Название страницы',
		                "comment" =>
		                    'Название страницы должно отражать суть, не нужно делать очень длинное (< 30 символов)',
		                "required" => true,
		                "size" => 25,
		                "valid_RE" => FP_VALID_NAME_RUS,
		                "max_length" => 60,
		                "wrapper" => &$leftWrapper,
		 				"value" => $context['item']['caption'],
		            )));
		            
		 $layoutForm -> addElement(new FPTextField(array(
		                "name" => 'url',
		                "title" => 'Адрес страницы',
		            	"comment" =>
		                    'Только цифрами и латинскими буквами',
		                "required" => true,
		                "size" => 25, 
		                "valid_RE" => FP_VALID_NAME,
		                "max_length" => 36,
		 				//"disabled" => $item ? true : false,
		                "wrapper" => &$leftWrapper,
		 				"value" => $context['item']['url'],
		            )));           
		   $layoutForm -> addElement(new FPSelect(array(
		                "name" => 'parent',
		                "title" => 'Родительский раздел',
		                "multiple" => false,
		                "options" => $parents,
		                "selected" => array($context['item']['parent']),
		                "css_style" => 'width:308px;',
		                "wrapper" => &$leftWrapper,
		            )));      
			
			$dir = new readDir(ROOT.'/calculating');
			$files = $dir->listingAll(ROOT.'/calculating');
			//printAr($files);
			for ($index = 0; $index < sizeof($files); $index++) {
					$filesform[$files[$index]['value']] = blankprint($files[$index]['level']).$files[$index]['file'];
			}
			$layoutForm -> addElement(new FPSelect(array(
		                "name" => 'file',
		                "title" => 'Файл',
		                "multiple" => false,
		                "options" => $filesform,
		                "selected" => array($context['item']['file']),
		                "css_style" => 'width:308px;',
		                "wrapper" => &$leftWrapper,
		            )));
			$layoutForm -> addElement(new FPTextArea(array(
		                "name" => 'text',
		                "title" => 'Описание раздела',
		                "max_length" => 2048,
		                "wrapper" => &$leftWrapper,
						"value" => $context['item']['text'],
		            )));
	
		
		
		$checkboxGrid = new FPGridLayout(array("table_padding" => 5,"columns" => 2,));
		$user = $itemObj->getUserObj();
		$roles = $user->getRoleObj() -> getRols();
		if($context['item']){
			$checkRols = $user->getAccesObj()->arraySimple($user->getAccesObj()->getByModulId($context['item'][$itemObj -> idField],"id_role"),"id_role");
			$checkRols = $checkRols ? $checkRols : array();
		}else{
			$checkRols = $checkRols ? $checkRols : array(0 => 1);	
		}
		$i = 0;
		foreach ($roles as $role){
			    $checkboxGrid->addElement(
			        new FPCheckBox(
			        array(
			            "name" => 'rols_array[]',
			        	"value" => $role['id_modul_role'],
			            "title" => $role['role'],
			            "table_align" => 'left',
			            "table_padding" => 0,
			            "checked" => in_array($role['id_modul_role'],$checkRols),
			            "comment" => 'Отметь, если доступ разрешен'
			        ))
			    );
			}
	    	$layoutForm -> addElement(new FPGroup(array(
		                "name" => "accesGroup",
		                "title" => 'Выберите для кого разрешен доступ к разделу',
		                "table_align" => "left",
		                "table_padding" => 7,
		                "elements" => array(
		                    &$checkboxGrid,
		                )
			)));
			$layoutForm -> addElement(new FPRowLayout(array(
	            "table_align" => "left",
	            "table_padding" => 20,
	            "elements" => array(
	                new FPButton(
	                array(
	                    "submit" => true,
	                    "name" => 'submit',
	                    "title" => '   Сохранить  ',
	                )),
	            )
	            )));
	    
	
		$myForm->setBaseLayout($layoutForm);
		return $myForm;
	}

	function setStatusRoleModule($id_modul,$id_role,$checked,$id_preloader){
		
		$objResponse = new xajaxResponse();
		$objResponse->script("$('#{$id_preloader}').hide()");
		if(!$id_modul || !$id_role){
			return $objResponse;
		}
		$itemObj = new fmakeSiteModule();
		if($checked){
			$itemObj -> getUserObj() -> getAccesObj() -> setByModulRoleId($id_modul, $id_role);
		}else{
			$itemObj -> getUserObj() -> getAccesObj() -> deleteByModulRoleId($id_modul, $id_role);
		}
		
		sleep(1);
		
		return $objResponse;
	}
	
	$mainFormParam = new templateController_templateParam();
	$action_url = "/".$request->parents."/".$request->modul;
	$mainFormParam -> set('action_url',$action_url);
	$globalTemplateParam->set('action_url',$action_url);

	include_once ROOT.'/fmake/libs/xajax/xajax_core/xajax.inc.php';
	$xajax = new xajax($action_url);
	$xajax->configure('javascript URI','/fmake/libs/xajax/');
	$xajax->register(XAJAX_FUNCTION,"setStatusRoleModule");
	$xajax->processRequest();
	$globalTemplateParam->set('xajax',$xajax);
	
	$itemObj = new fmakeSiteModule();
	$itemObj -> setId($request -> id) ;
	$globalTemplateParam->set('itemObj',$itemObj);
	$mainFormParam -> set('itemObj',$itemObj);

	
	switch ($request -> action){
		case 'delete':
			$myForm2 = new phpObjectForms(array("name" => 'deleteform', "action" => $action_url, "display_outer_table" => false, "table_align" => false,
			    "table_width" => '600',"enable_js_validation" => true,"hold_output" => true,"css_class_prefix" => "edit-"
			));
			$layoutForm2 = new FPColLayout(array("table_padding" => 5,"element_align" => "center", "hold_output" => true,));
			$layoutForm2 -> addElement(new FPHidden(array("name" => "action","value" => "delete_confirm")));
			$layoutForm2 -> addElement(new FPHidden(array("name" => "id","value" => $request -> id)));		
			$layoutForm2 -> addElement(new FPText(array("text" =>'<div align="left">'.
											                     '<h2>Удаление записи</h2>'.
																 'Вы уверенны что хотите удалить запись?'.
											                     '</div>')));  
			$layoutForm2 -> addElement(new FPCheckBox(array("name" => 'confirm',"title" => 'подтверждаю',"table_align" => 'left',"checked" => false,"comment" => 'Если включено,<br /> то вы подтверждаете удаление'))); 
			$layoutForm2 -> addElement(new FPRowLayout(array("table_align" => "left","table_padding" => 20,"elements" => array(new FPButton(array("submit" => true,"name" => 'submit',"title" => '   Продолжить  ',)),))));
			$myForm2 -> setBaseLayout($layoutForm2);
			$form =  $myForm2 -> display();
			$globalTemplateParam->set('form',$form);
			$modul -> template = "actions/delete.tpl";
		break;
		case 'delete_confirm':
			if($request -> confirm && $request -> id){
				$itemObj -> setId($request -> id);
				$itemObj -> delete();
			}
			action_redir($action_url);
		break;
		case 'add':
			$myForm = initMainForm($itemObj,$mainFormParam -> get());
			if ($myForm->getSubmittedData()  &&  $myForm->isDataValid()) {
				$elements = $myForm->getElementValues();
				foreach ($elements as $name => $val){
					$itemObj -> addParam($name,$val);
				}
				$itemObj -> addParam("inmenu",$elements['inmenu'] ? $elements['inmenu'] : "0");	
				$itemObj -> addParam("active",$elements['active'] ? $elements['active'] : "0");
				$itemObj -> newItem();
				$user -> getAccesObj() -> setAcces($itemObj -> id,$request -> rols_array);
				action_redir($action_url);
			}else{
				$form =  $myForm -> display();
				$globalTemplateParam->set('form',$form);
				$modul -> template = "actions/new.tpl";
			}
		break;
		case 'update':
			$myForm = initMainForm($itemObj,$mainFormParam -> get());
			if ($myForm->getSubmittedData()  &&  $myForm->isDataValid()) {
				$elements = $myForm->getElementValues();
				foreach ($elements as $name => $val){
					$itemObj -> addParam($name,$val);
				}
				$itemObj -> addParam("inmenu",$elements['inmenu'] ? $elements['inmenu'] : "0");	
				$itemObj -> addParam("active",$elements['active'] ? $elements['active'] : "0");
				$itemObj -> update();
				$user -> getAccesObj() -> setAcces($itemObj -> id,$request -> rols_array);
				action_redir($action_url);
			}else{
				$modul -> template = "actions/new.tpl";
			}
		break;
		case 'up':
			$itemObj -> getUp(); 
			action_redir($action_url);
		break;
		case 'down':
			$itemObj -> getDown(); 
			action_redir($action_url);
		break;
		case 'edit':
			$item = $itemObj -> getInfo();
			$mainFormParam -> set('item',$item);
		case 'new':
			$form =  initMainForm($itemObj,$mainFormParam -> get()) -> display();
			$globalTemplateParam->set('form',$form);			
			$modul -> template = "actions/new.tpl";

		break;
		default:
			$filds = array(
				 'caption'=>array( 'name' => 'Роль', 'col' => false),
				 'actions'=>array( 'name' => 'Действие', 'col' => "230px"),
			);
			$globalTemplateParam->set('filds',$filds);
			$actions = array('delete', 'edit','move');
			$globalTemplateParam->set('actions',$actions);
			$modul->tree = false;
			$items = $itemObj -> getAllAsTree();
			$globalTemplateParam->set('items',$items);
			$user = $itemObj->getUserObj();
			$roleObj = $user->getRoleObj();
			$globalTemplateParam->set('roleObj',$roleObj);
			$roles = $user->getRoleObj() -> getRols();
			$globalTemplateParam->set('roles',$roles);
			$accesObj = $user->getAccesObj();
			$checkRoles = array();
			for ($i = 0; $i < sizeof($items); $i++) {
				
				$accesArr =  $accesObj -> getByModulId($items[$i][$itemObj->idField]);
				for ($j = 0; $j < sizeof($accesArr); $j++) {
					$checkRoles[$items[$i][$itemObj->idField]][$accesArr[$j][ 'id_role']] = true;
				}
				
			}
			$globalTemplateParam->set('checkRoles',$checkRoles);
			$modul->template = "settings/system_pages.tpl";
		break;
	}
