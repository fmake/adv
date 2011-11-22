<?php


function initMainForm($itemObj,$context = array()){
		$usersObj = new fmakeSiteModule_users();
	
	
		$myForm = new phpObjectForms(array("name" => 'editform', "action" => $context['action_url'], "display_outer_table" => false, "table_align" => false,
				    "table_width" => '654',"enable_js_validation" => true,"hold_output" => true,"css_class_prefix" => "edit-"
		));
		$leftWrapper = new FPLeftTitleWrapper(array());
		$layoutForm = new FPColLayout(array("table_padding" => 5,"element_align" => "left", "hold_output" => true,));
	
		if($context['item']){
			$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "update")));
			$layoutForm -> addElement(new FPHidden(array("name" => "id","value" => $context['item'][$itemObj -> idField])));
			$layoutForm -> addElement(new FPText(array("text" =>
						                    '<div align="left">'.
						                    '<h2>Редактирование клиента</h2>'.
						                    '<a href="'.$context['action_url'].'">вернуться назад</a></div>')));
		}else{
			$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "add")));
			$layoutForm -> addElement(new FPText(array("text" =>
						                    '<div align="left">'.
						                    '<h2>Добавление клиента</h2>'.
						                    '<a href="'.$context['action_url'].'">вернуться назад</a></div>')));
		}
	

		$layoutForm -> addElement(new FPTextField(array(
			                "name" => 'name',
			                "title" => 'Контактное лицо',
			                "required" => true,
			                "size" => 25, 
			                "valid_RE" => FP_VALID_NAME_RUS,
			                "max_length" => 36,
			                "wrapper" => &$leftWrapper,
			 				"value" => $context['item']['name'],
			 				"align" => "left"
		)));
		
		$layoutForm -> addElement(new FPTextField(array(
					                "name" => 'company',
					                "title" => 'Организация',
					                "size" => 25, 
					                "max_length" => 36,
					                "wrapper" => &$leftWrapper,
					 				"value" => $context['item']['company'],
					 				"align" => "left"
		)));
		
		$layoutForm -> addElement(new FPTextField(
		array(
		                "name" => 'email',
		                "title" => 'E-mail',
		                "required" => true,
		                "size" => 33,
		                "valid_RE" => FP_VALID_EMAIL,
		                "max_length" => 256,
		                "wrapper" => &$leftWrapper,
		            	"value" => $context['item']['email'],
		                "comment" => 'используется для  '.
													        'отправки системных сообщений и рассылок пользователям!',
		)));
		
		$layoutForm -> addElement(new FPTextField(
		array(
				                "name" => 'send_email',
				                "title" => 'E-mail для рассылок',
				                "size" => 33,
				                "valid_RE" => FP_VALID_EMAIL,
				                "max_length" => 256,
				                "wrapper" => &$leftWrapper,
				            	"value" => $context['item']['send_email'],
				                "comment" => 'используется для  '.
													        'отправки системных сообщений и рассылок пользователям!',
		)));
		
		$layoutForm -> addElement(new FPTextField(array(
				                "name" => 'login',
				                "title" => 'Имя пользователя',
				                "required" => true,
				                "size" => 25,
				                "valid_RE" => FP_VALID_NAME_RUS,
				                "wrapper" => &$leftWrapper,
				 				"value" => $context['item']['login'],
		          				"comment" => 'используется для входа в систему ',
		)));
		
		$layoutForm -> addElement($passwordField = new FPPassword(array(
											    "name" => 'password',
											    "title" => 'Пароль',
		//"required" => $context['item'] ? false : true,
											    "size" => 20,
		// "valid_RE" => $context['item'] ? false : FP_VALID_PASSWORD,
											    "max_length" => 36,
											    "wrapper" => &$leftWrapper,
											    "comment" =>
											        'Пароль состоит из латинских букв, '.
											        'более 6 символов!',
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
$mainFormParam->set('action_url',$action_url);
$globalTemplateParam->set('action_url',$action_url);
$itemObj = new fmakeSiteModule_users($request -> id);
$projectAcess = new projects_accessRole();

$globalTemplateParam->set('itemObj',$itemObj);
$mainFormParam -> set('itemObj',$itemObj);



// основная роль клиент
$request -> setFilter('role', ID_CLIENT);

switch ($request -> action){
	case 'getsite':
		include 'includes/json_function.php';
		$company = strtolower($request -> getEscape('term'));
		$request -> setFilter('company', $company);
		$items = $itemObj -> getUserWithProjectsParams("*",$request -> getFilterArr());
		
		//printAr($items);
		if($role = $request -> getFilter('groupby')){
			$index = sizeof($items);
			for ($i = 0; $i < $index; $i++) {
				$projectTmp = $projectAcess -> getProjectByRoleUser(ID_CLIENT,$items[$i][$itemObj -> idField]);
				$rls = $projectAcess -> getProjectRols($projectTmp['id_project']);
				$items[$i]['user'] = $rls[$role]['id_user'];
			}
			
		}
		
		$result = array();
		foreach ($items as $key=>$value) {
			array_push($result, array("id"=>$value[$itemObj -> idField],"user"=>$value['user'], "label"=>$value['company'], "value" => strip_tags($value['url'])));
		}
		echo array_to_json($result);
		exit;
	break;
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
	case 'update':

		$myForm = initMainForm($itemObj,$mainFormParam -> get());
		if ($myForm->getSubmittedData()  &&  $myForm->isDataValid()) {
			$elements = $myForm->getElementValues();
			foreach ($elements as $name => $val){
				$itemObj -> addParam($name,$val);
			}
			if($elements["password"]){
				$itemObj -> addParam("password",md5($elements["password"]));
			}else{
				unset ( $itemObj -> params["password"] );
			}
			$itemObj -> addParam("role",ID_CLIENT);
			$itemObj -> update();
			action_redir($action_url);
		}else{
			$form =  $myForm  -> display();
			$globalTemplateParam->set('form',$form);
			$modul -> template = "actions/new.tpl";
		}
		
		//action_redir($action_url);
		break; 
	case 'add':	
		$myForm = initMainForm($itemObj,$mainFormParam -> get());
		if ($myForm->getSubmittedData()  &&  $myForm->isDataValid()) {
			$elements = $myForm->getElementValues();
			foreach ($elements as $name => $val){
				$itemObj -> addParam($name,$val);
			}
			$itemObj -> addParam("password",md5($elements["password"]));
			$itemObj -> addParam("role",ID_CLIENT);
			$itemObj -> newItem();
			action_redir($action_url);
		}else{
			$form =  $myForm  -> display();
			$globalTemplateParam->set('form',$form);
			$modul -> template = "actions/new.tpl";
		}
	break;
	case 'edit':
		$item = $itemObj -> getInfo();
		
		$mainFormParam -> set('item',$item);
		$globalTemplateParam->set('item',$item);
		$globalTemplateParam->set('data',$data);
	case 'new':
		$form =  initMainForm($itemObj,$mainFormParam -> get()) -> display();
		$globalTemplateParam->set('form',$form);
		$modul -> template = "actions/new.tpl";
	break;
	default:
		if(!isset($_REQUEST[$request->filter]['active'])){
			$request -> setFilter("active", 1);
		}
		$filds = array(
					 'company'=>array( 'name' => 'Компания', 'col' => false),
					 'name'=>array( 'name' => 'Контактное лицо', 'col' => false),
					 'actions'=>array( 'name' => 'Действие', 'col' => "230px"),
		);
		$actions = array('delete', 'edit');
		$globalTemplateParam->set('actions',$actions);
		$globalTemplateParam->set('filds',$filds);
		$globalTemplateParam->setNonPointer('ID_CLIENT',ID_CLIENT);
		$globalTemplateParam->setNonPointer('ID_OPTIMISATOR',ID_OPTIMISATOR);
		$globalTemplateParam->setNonPointer('ID_AKKAUNT',ID_AKKAUNT);

		if($role = $request -> getFilter('groupby')){
			$items = $user -> getByRole(intval($role));
			$index = sizeof($items);
			for ($i = 0; $i < $index; $i++) {
				//$request -> setFilter('role', intval($role));
				//printAr($request -> getFilterArr());
				$items[$i]['projects'] = $itemObj -> getUserWithProjectsParamsGroupBy("*",$items[$i][$user -> idField],$request -> getFilterArr());
				if(!$items[$i]['projects']){
					unset($items[$i]);
					continue;	
				}
				
			}
			$globalTemplateParam->set('items',$items);
			$modul->template = "projects/clients_groupby.tpl";
		}else{
			$items = $itemObj -> getUserWithProjectsParams("*",$request -> getFilterArr());
			$globalTemplateParam->set('items',$items);
			$globalTemplateParam->set('foot',$foot);
			$modul->template = "projects/clients.tpl";
		}
	break;
}

