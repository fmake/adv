<?php
	function initMainForm($itemObj,$context = array()){
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
					                    '<h2>Редактирование роли</h2>'.
					                    '<a href="'.$context['action_url'].'">вернуться назад</a></div>')));
		}else{
			$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "add")));
			$layoutForm -> addElement(new FPText(array("text" =>
					                    '<div align="left">'.
					                    '<h2>Добавление роли</h2>'.
					                    '<a href="'.$context['action_url'].'">вернуться назад</a></div>')));
		}
		           				
		
		
		
		 $layoutForm -> addElement(new FPTextField(array(
		                "name" => 'role',
		                "title" => 'Название роли',
		                "comment" =>
		                    'Название страницы должно отражать роли, не нужно делать очень длинное (< 40 символов)',
		                "required" => true,
		                "size" => 25,
		                "valid_RE" => FP_VALID_NAME_RUS,
		                "max_length" => 80,
		                "wrapper" => &$leftWrapper,
		 				"value" => $context['item']['role'],
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

	
	$mainFormParam = new templateController_templateParam();
	$action_url = "/".$request->parents."/".$request->modul;
	$mainFormParam -> set('action_url',$action_url);
	$globalTemplateParam->set('action_url',$action_url);
	
	$itemObj = $user -> getRoleObj();
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
				$itemObj -> newItem();
				$user -> getAccesObj() -> setAcces($itemObj -> id,$request -> rols_array);
				action_redir($action_url);
			}
		break;
		case 'update':
			
			$myForm = initMainForm($itemObj,$mainFormParam -> get());
			if ($myForm->getSubmittedData()  &&  $myForm->isDataValid()) {
				$elements = $myForm->getElementValues();
				foreach ($elements as $name => $val){
					$itemObj -> addParam($name,$val);
				}
				$itemObj -> update();
				$user -> getAccesObj() -> setAcces($itemObj -> id,$request -> rols_array);
				action_redir($action_url);
			}
		break;
		case 'edit':
			$item = $itemObj -> getInfo();
			if(!$item){
				action_redir($action_url);
			}
			$mainFormParam -> set('item',$item);
		case 'new':
			$form =  initMainForm($itemObj,$mainFormParam -> get()) -> display();
			$globalTemplateParam->set('form',$form);
			$modul -> template = "actions/new.tpl";
		break;
		default:
			$filds = array(
				 'role'=>array( 'name' => 'Роль', 'col' => false),
				 'actions'=>array( 'name' => 'Действие', 'col' => "230px"),
			);
			$globalTemplateParam->set('filds',$filds);
			$actions = array('delete', 'edit');
			$globalTemplateParam->set('actions',$actions);
			$modul->tree = false;
			$items = $itemObj -> getAll();
			$globalTemplateParam->set('items',$items);
			$modul->template = "actions/default.tpl";
		break;
	}
