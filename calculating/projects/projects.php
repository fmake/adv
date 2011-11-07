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
						                    '<h2>Редактирование проекта</h2>'.
						                    '<a href="'.$context['action_url'].'">вернуться назад</a></div>')));
		}else{
			$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "add")));
			$layoutForm -> addElement(new FPText(array("text" =>
						                    '<div align="left">'.
						                    '<h2>Добавление проекта</h2>'.
						                    '<a href="'.$context['action_url'].'">вернуться назад</a></div>')));
		}
		 
		$layoutForm -> addElement(new FPHidden(array("name" => "type","value" => "seo")));
	

		$layoutForm -> addElement(new FPTextField(array(
			                "name" => 'url',
			                "title" => 'Адрес проекта',
			            	"comment" =>
			                    'Только цифрами и латинскими буквами',
			                "required" => true,
			                "size" => 25, 
			                "valid_RE" => FP_VALID_NAME,
			                "max_length" => 36,
			                "wrapper" => &$leftWrapper,
			 				"value" => $context['item']['url'],
			 				"align" => "left"
		)));
		
		$clientsArr = $usersObj -> getByRole(ID_CLIENT,true);
		for ($i = 0; $i < sizeof($clientsArr); $i++) {
			$clients[$clientsArr[$i][ $usersObj -> idField ]] = $clientsArr[$i]['name'];
		}
		
		$layoutForm -> addElement(new FPSelect(array(
				                "name" => 'role['.ID_CLIENT.']',
				                "title" => 'Клиент',
				                "multiple" => false,
				                "options" => $clients,
				                "selected" => array($context['item']['parent']),
				                "css_style" => 'width:308px;',
				                "wrapper" => &$leftWrapper,
		)));
		
		
		
		
		
		$layoutProjectForm = new FPColLayout(array("table_padding" => 5,"element_align" => "left", "hold_output" => true,));
		$layoutProjectForm -> addElement(new FPTextField(array(
			                "name" => 'date_payment',
			                "id" => "date",
			                "title" => 'Дата премии',
							"comment" => 'С какого времени клиент будет платить за позиции',
			                "size" => 25, 
			                "max_length" => 36,
			                "wrapper" => &$leftWrapper,
			 				"value" => date("d.m.Y",$context['item']['date_payment']),
			 				"align" => "left"
		)));
		
		$layoutProjectForm -> addElement(new FPTextField(array(
					                "name" => 'liveinternet_password',
					                "title" => 'LiveInternet пароль',
					            	"comment" =>
					                    'Только цифрами и латинскими буквами',
					                "size" => 25, 
					                "max_length" => 36,
					                "wrapper" => &$leftWrapper,
					 				"value" => $context['item']['liveinternet_password'],
					 				"align" => "left"
		)));
		
		$layoutProjectForm -> addElement(new FPTextField(array(
					                "name" => 'metrika',
					                "title" => 'Метрика',
					            	"comment" =>
					                    'Только цифрами и латинскими буквами',
					                "size" => 25, 
					                "max_length" => 36,
					                "wrapper" => &$leftWrapper,
					 				"value" => $context['item']['metrika'],
					 				"align" => "left"
		)));
		
		$layoutProjectForm -> addElement(new FPTextField(array(
					                "name" => 'id_webmaster',
					                "title" => 'Webmaster ID',
					            	"comment" =>
					                    'Только цифрами',
					                "size" => 25, 
					                "max_length" => 36,
					                "wrapper" => &$leftWrapper,
					 				"value" => $context['item']['id_webmaster'],
					 				"align" => "left"
		)));
		
		$layoutProjectForm -> addElement(new FPTextField(array(
							                "name" => 'id_sape',
							                "title" => 'SAPE ID',
							            	"comment" =>
							                    'Только цифрами',
							                "size" => 25, 
							                "max_length" => 36,
							                "wrapper" => &$leftWrapper,
							 				"value" => $context['item']['id_sape'],
							 				"align" => "left"
		)));
		
		$layoutForm -> addElement( new FPGroup(array(
								        "title" => 'Данные проекта',
								        "elements" => array($layoutProjectForm)
		)));
		
		
		$promoArr = $usersObj -> getByRole(ID_OPTIMISATOR,true);
		for ($i = 0; $i < sizeof($promoArr); $i++) {
			$promos[$promoArr[$i][ $usersObj -> idField ]] = $promoArr[$i]['name'];
		}
		
		$promo = new FPRowLayout(array("elements" => array(
											new FPSelect(array(
											                "name" => 'role['.ID_OPTIMISATOR.']',
											                "title" => 'Оптимизатор',
											                "multiple" => false,
											                "options" => $promos,
											                "selected" => array($context['item']['parent']),
											                "css_style" => 'width:308px;',
											                "wrapper" => &$leftWrapper,
											)),
											new FPTextField(array(
								                    "name" => "pay[".ID_OPTIMISATOR."]",
								                    "title" => 'Процент оптимизатора',
								                    "valid_RE" => FP_VALID_INTEGER,
								                    "css_style" => 'width:30px;',
								                    "required" => true,
								                    "max_length" => 256
											)),
											new FPText(array("text" => "%")),
						            ),
						        ));
		
		$akkauntArr = $usersObj -> getByRole(ID_AKKAUNT,true);
		for ($i = 0; $i < sizeof($akkauntArr); $i++) {
			$akkaunts[$akkauntArr[$i][ $usersObj -> idField ]] = $akkauntArr[$i]['name'];
		}
		
		$manager = new FPRowLayout(array("elements" => array(
										new FPSelect(array(
								                "name" => 'role['.ID_AKKAUNT.']',
								                "title" => 'Менеджер',
								                "multiple" => false,
								                "options" => $akkaunts,
								                "selected" => array($context['item']['parent']),
								                "css_style" => 'width:308px;',
								                "wrapper" => &$leftWrapper,
										)),
										new FPTextField(array(
							                    "name" => "pay[".ID_AKKAUNT."]",
							                    "title" => 'Процент менеджера',
							                    "valid_RE" => FP_VALID_INTEGER,
							                    "css_style" => 'width:30px;',
							                    "required" => true,
							                    "max_length" => 256
										)),
										new FPText(array("text" => "%")),
										),
										));
		
		$layoutForm -> addElement( new FPGroup(array(
						        "title" => 'Команда проекта',
						        "elements" => array($promo,$manager)
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


function addRegion($name,$lr){
	if(!$name || !$lr){return;}
	$searchSystems = new searchSystems();
	$searchSystems -> addParam("name", $name);
	$searchSystems -> addParam("lr", $lr);
	// родитель только яндекс
	$searchSystems -> addParam("parent", 1);
	$searchSystems -> addParam("class", "Yandex");
	$searchSystems -> newItem();
	
	$objResponse = new xajaxResponse();
	return $objResponse;
}





$mainFormParam = new templateController_templateParam();
$action_url = "/".$request->parents."/".$request->modul;
$mainFormParam->set('action_url',$action_url);
$globalTemplateParam->set('action_url',$action_url);
$itemObj = new projects($request -> id);
$globalTemplateParam->set('itemObj',$itemObj);
$mainFormParam -> set('itemObj',$itemObj);

include_once ROOT.'/fmake/libs/xajax/xajax_core/xajax.inc.php';
$xajax = new xajax($action_url);
$xajax->configure('javascript URI','/fmake/libs/xajax/');
$xajax->register(XAJAX_FUNCTION,"addRegion");
$xajax->processRequest();
$globalTemplateParam->set('xajax',$xajax);




switch ($request -> action){
	case 'update':
		printAr($_REQUEST);
		
		break;
	case 'add':
		//printAr($_REQUEST);
		$itemObj -> addParam("url", $request -> getEscape('url'));
		if($request -> type =="seo"){
			$itemObj -> addParam("is_seo", 1);
		}
		$itemObj -> newItem();
		if($request -> type =="seo" && $itemObj -> id){
			$projectSeo = new projects_seoParams($itemObj -> id);
			$projectSeo -> addParam($projectSeo -> idField, $itemObj -> id);
			$projectSeo -> addParam("date_payment", strtotime($request -> getEscape('date_payment')));
			$projectSeo -> addParam("liveinternet_password", $request -> getEscape('liveinternet_password'));
			$projectSeo -> addParam("metrika", $request -> getEscape('metrika'));
			$projectSeo -> addParam("id_webmaster", $request -> getEscape('id_webmaster'));
			$projectSeo -> addParam("id_sape", $request -> getEscape('id_sape'));
			$projectSeo -> addParam("sape_money", $request -> getEscape('sape_money'));
			$projectSeo -> addParam("abonement", $request -> getEscape('abonement'));
			$projectSeo -> newItem();
		}
		action_redir($action_url);
	break;
	case 'edit':
		$item = $itemObj -> getProjectWithSeoParams();
		$mainFormParam -> set('item',$item);
		$globalTemplateParam->set('item',$item);
	case 'new':
		$searchSystems = new searchSystems();
		$systems = ( $searchSystems -> getChilds(0) );
		$index = sizeof($systems);
		for ($i = 0; $i < $index; $i++) {
			$systems[$i]['child'] = $searchSystems -> getChilds($systems[$i][$searchSystems->idField]);
			$systems[$i]['child'][0]['used'] = true;
		}
		$globalTemplateParam->set('ssystems',$systems);
		$form =  initMainForm($itemObj,$mainFormParam -> get()) -> display();
		$globalTemplateParam->set('form',$form);
		$modul -> template = "projects/projects_edit.tpl";
	break;
	default:
		$filds = array(
					 'url'=>array( 'name' => 'Адрес', 'col' => false),
					 'max_price'=>array( 'name' => 'Макс. Бюджет', 'col' => "200px"),
					 'percent'=>array( 'name' => '%', 'col' => "100px"),
					 'actions'=>array( 'name' => 'Действие', 'col' => "230px"),
		);
		$actions = array('delete', 'edit');
		$globalTemplateParam->set('actions',$actions);
		$globalTemplateParam->set('filds',$filds);
		
		$items = $itemObj -> getProjectsWithSeoParams();
		$globalTemplateParam->set('items',$items);
		$modul->template = "projects/projects.tpl";
	break;
}



