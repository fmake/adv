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
				                "selected" => array($context['item']['roles'][ID_CLIENT]["id_user"]),
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
			 				"value" => date("d.m.Y",$context['item']['date_payment'] ? $context['item']['date_payment'] : time()),
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
											                "selected" => array($context['item']['roles'][ID_OPTIMISATOR]["id_user"]),
											                "css_style" => 'width:308px;',
											                "wrapper" => &$leftWrapper,
											)),
											new FPTextField(array(
								                    "name" => "pay[".ID_OPTIMISATOR."]",
								                    "title" => 'Процент оптимизатора',
								                    "valid_RE" => FP_VALID_INTEGER,
								                    "css_style" => 'width:30px;',
								                    "required" => true,
								                    "max_length" => 256,
								                    "value" => $context['item']['roles'][ID_OPTIMISATOR]["pay_percent"]
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
								                "selected" => array($context['item']['roles'][ID_AKKAUNT]["id_user"]),
								                "css_style" => 'width:308px;',
								                "wrapper" => &$leftWrapper,
										)),
										new FPTextField(array(
							                    "name" => "pay[".ID_AKKAUNT."]",
							                    "title" => 'Процент менеджера',
							                    "valid_RE" => FP_VALID_INTEGER,
							                    "css_style" => 'width:30px;',
							                    "required" => true,
							                    "max_length" => 256,
								                 "value" => $context['item']['roles'][ID_AKKAUNT]["pay_percent"]
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
	$searchSystems = new projects_seo_searchSystem();
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
$projectAcess = new projects_accessRole();
$projectSeo = new projects_seo_seoParams();

$projectSeoQuery = new projects_seo_query();
$searchSystemExs = new projects_seo_searchSystemExs();
$searchSystemExsPrice = new projects_seo_searchSystemExsPrice();
$searchSystemAccess = new projects_seo_searchSystemAccess();
$searchSystems = new projects_seo_searchSystem();

$globalTemplateParam->set('itemObj',$itemObj);
$mainFormParam -> set('itemObj',$itemObj);

include_once ROOT.'/fmake/libs/xajax/xajax_core/xajax.inc.php';
$xajax = new xajax($action_url);
$xajax->configure('javascript URI','/fmake/libs/xajax/');
$xajax->register(XAJAX_FUNCTION,"addRegion");
$xajax->processRequest();
$globalTemplateParam->set('xajax',$xajax);




switch ($request -> action){
	case 'getsite':
		include 'includes/json_function.php';
		$url = strtolower($request -> getEscape('term'));
		$request -> setFilter('url', $url);
		$items = $itemObj -> getProjectsWithSeoParams("{$itemObj -> table}.{$itemObj -> idField}, url",$request -> getFilterArr());
		
		$result = array();
		foreach ($items as $key=>$value) {
			array_push($result, array("id"=>$value[$itemObj -> idField], "label"=>$value['url'], "value" => strip_tags($value['url'])));
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
		//printAr($_REQUEST);
		$itemObj -> setId($request -> id);
		$itemObj -> addParam("url", trim($request -> getEscape('url')));
		if($request -> type =="seo"){
			$itemObj -> addParam("is_seo", 1);
		}
		$itemObj -> update();
		if($request -> type =="seo" && $itemObj -> id){
			$projectSeo -> setId($itemObj -> id);
			$projectSeo -> addParam("date_payment", strtotime($request -> getEscape('date_payment')));
			$projectSeo -> addParam("liveinternet_password", $request -> getEscape('liveinternet_password'));
			$projectSeo -> addParam("metrika", $request -> getEscape('metrika'));
			$projectSeo -> addParam("id_webmaster", $request -> getEscape('id_webmaster'));
			$projectSeo -> addParam("id_sape", $request -> getEscape('id_sape'));
			if(isset($_REQUEST['sape_money']))
				$projectSeo -> addParam("sape_money", $request -> getEscape('sape_money'));
			if(isset($_REQUEST['abonement']))
				$projectSeo -> addParam("abonement", $request -> getEscape('abonement'));
			if(isset($_REQUEST['consecutive_calculation']))
				$projectSeo -> addParam("consecutive_calculation", 1);
			else 
				$projectSeo -> addParam("consecutive_calculation", "0");
			
			$projectSeo -> update();
			
			$projectAcess -> addParam("id_project", $itemObj -> id);
			// оптимизатор
			$projectAcess -> addParam("id_role", ID_OPTIMISATOR);
			$projectAcess -> addParam("id_user", $request -> role[ID_OPTIMISATOR][0]);
			$projectAcess -> addParam("pay_percent", $request -> pay[ID_OPTIMISATOR]);
			$projectAcess -> addAccess();
			//менеджер
			$projectAcess -> addParam("id_role", ID_AKKAUNT);
			$projectAcess -> addParam("id_user", $request -> role[ID_AKKAUNT][0]);
			$projectAcess -> addParam("pay_percent", $request -> pay[ID_AKKAUNT]);
			$projectAcess -> addAccess();
			//клиент
			$projectAcess -> addParam("id_role", ID_CLIENT);
			$projectAcess -> addParam("id_user", $request -> role[ID_CLIENT][0]);
			$projectAcess -> addParam("pay_percent", $request -> pay[ID_CLIENT]);
			$projectAcess -> addAccess();
			
			// добавление запросов
			include 'projects_addquery.php';

			if($maxSeoPay){
				$projectSeo -> addParam("max_seo_pay", $maxSeoPay);
				$projectSeo -> update();
			}
			
		}
		action_redir($action_url."?action=edit&id={$itemObj -> id}");
		break; 
	case 'add':
		//printAr($_REQUEST);
		$itemObj -> addParam("url", trim($request -> getEscape('url')));
		if($request -> type =="seo"){
			$itemObj -> addParam("is_seo", 1);
		}
		$itemObj -> newItem();
		if($request -> type =="seo" && $itemObj -> id){
			
			$projectSeo -> addParam($projectSeo -> idField, $itemObj -> id);
			$projectSeo -> addParam("date_payment", strtotime($request -> getEscape('date_payment')));
			$projectSeo -> addParam("liveinternet_password", $request -> getEscape('liveinternet_password'));
			$projectSeo -> addParam("metrika", $request -> getEscape('metrika'));
			$projectSeo -> addParam("id_webmaster", $request -> getEscape('id_webmaster'));
			$projectSeo -> addParam("id_sape", $request -> getEscape('id_sape'));
			$projectSeo -> addParam("sape_money", $request -> getEscape('sape_money'));
			$projectSeo -> addParam("abonement", $request -> getEscape('abonement'));
			if(isset($_REQUEST['consecutive_calculation']))
				$projectSeo -> addParam("consecutive_calculation", 1);
			else
				$projectSeo -> addParam("consecutive_calculation", "0");
			$projectSeo -> newItem();
			
			
			$projectAcess -> addParam("id_project", $itemObj -> id);
			// оптимизатор
			$projectAcess -> addParam("id_role", ID_OPTIMISATOR);
			$projectAcess -> addParam("id_user", $request -> role[ID_OPTIMISATOR][0]);
			$projectAcess -> addParam("pay_percent", $request -> pay[ID_OPTIMISATOR]);
			$projectAcess -> addAccess();
			//менеджер
			$projectAcess -> addParam("id_role", ID_AKKAUNT);
			$projectAcess -> addParam("id_user", $request -> role[ID_AKKAUNT][0]);
			$projectAcess -> addParam("pay_percent", $request -> pay[ID_AKKAUNT]);
			$projectAcess -> addAccess();
			//клиент
			$projectAcess -> addParam("id_role", ID_CLIENT);
			$projectAcess -> addParam("id_user", $request -> role[ID_CLIENT][0]);
			$projectAcess -> addParam("pay_percent", $request -> pay[ID_CLIENT]);
			$projectAcess -> addAccess();
			
			// добавление запросов
			include 'projects_addquery.php';
			if($maxSeoPay){
				$projectSeo -> setId($itemObj -> id);
				$projectSeo -> addParam("max_seo_pay", $maxSeoPay);
				$projectSeo -> update();
			}
			
		}
		action_redir($action_url);
	break;
	case 'edit':
		$item = $itemObj -> getProjectWithSeoParams();
		$item['roles'] = $projectAcess -> getProjectRols($itemObj -> id);
		$item['searchsystems'] = $searchSystemAccess -> getProjectSystems($itemObj -> id);
		$searchSystemsOrder = array();
		//printAr($item['searchsystems']);
		// инициализируем массив data все данные запросы поисковые системы и т.п.
		$data = array();
		if($item['searchsystems']){
			foreach ($item['searchsystems'] as $id => $stm){
				// выставляем номер поисковой системы и региона, так же раставляем их в нужном порядке сортировки
				$searchSystems -> setId($id);
				$item['searchsystems'][$id]  = ( $searchSystems -> getInfo() );
				if($item['searchsystems'][$id]['parent']){
					$srcstnum = $item['searchsystems'][$id]['parent'];
					$regionnum = $id;
					$searchSystems -> setId($item['searchsystems'][$id]['parent']);
					$tmp = $item['searchsystems'][$id];
					$parent = $searchSystems -> getInfo();
					if(!$searchSystemsOrder[ $parent[ $searchSystems -> idField ] ])
						$searchSystemsOrder[ $parent[ $searchSystems -> idField ] ] = $parent;
					// эти системы использованны в проекте
					$searchSystemsOrder[ $parent[ $searchSystems -> idField ] ]['used'] = true;
					$tmp['used'] = true;
					$searchSystemsOrder[ $parent[ $searchSystems -> idField ] ]['child'][] = $tmp;
					
				}else{
					$searchSystemsOrder[$id] = $item['searchsystems'][$id];
					$searchSystemsOrder[$id]['used'] = true;
					$srcstnum =  $id;
					$regionnum = 0;
				}
				
				$data[$srcstnum][$regionnum]['querys'] = $projectSeoQuery -> getQueryProjectSystem($itemObj -> id, $id);
				$data[$srcstnum][$regionnum]['place'] = $searchSystemExs -> getExsProjectSystem($itemObj -> id, $id);
				// получаем цены по запросам
				if($data[$srcstnum][$regionnum]['querys']){
					foreach ($data[$srcstnum][$regionnum]['querys'] as $i => $val){
						for($j=0; $j < sizeof($data[$srcstnum][$regionnum]['place']); $j++){
							$data[$srcstnum][$regionnum]['price'][$i][$j] = 
								$searchSystemExsPrice -> 
									getPriceExsSearch($data[$srcstnum][$regionnum]['place'][$j][$searchSystemExs -> idField],
														$data[$srcstnum][$regionnum]['querys'][$i][$projectSeoQuery -> idField]) ;
						}
					}
				}
				
				
			}
		}
		//printAr($item['searchsystems']);
		//printAr($data);
		$searchSystemsUsedItems = $item['searchsystems'];
		$item['searchsystems'] = $searchSystemsOrder;
		unset($searchSystemsOrder);
		
		$mainFormParam -> set('item',$item);
		$globalTemplateParam->set('item',$item);
		$globalTemplateParam->set('data',$data);
	case 'new':
		// ищем всевозможные поисковые системы, и смотрим какие из них используются
		$systems = ( $searchSystems -> getChilds(0) );
		$index = sizeof($systems);
		$usedSearchSystemOrdering;
		$usedSearchSystem = false;
		for ($i = 0; $i < $index; $i++) {
			$systems[$i]['child'] = $searchSystems -> getChilds($systems[$i][$searchSystems->idField]);
			if( $searchSystemsUsedItems[ $systems[$i][$searchSystems -> idField] ] ){
				$systems[$i]['used'] = true;
				$usedSearchSystem = true;
			}
			// проверяем используются ли регионы в системе
			$index2 = sizeof($systems[$i]['child']);
			$usedSearchSystemRegion = false;
			for ($j = 0; $j < $index2; $j++) {
				if( $searchSystemsUsedItems[ $systems[$i]['child'][$j][$searchSystems -> idField] ] ){
					$systems[$i]['child'][$j]['used'] = true;
					$usedSearchSystemRegion = true;
				}
			}
			if($index2 && !$usedSearchSystemRegion){
				$systems[$i]['child'][0]['used'] = true;
				$usedSearchSystemRegion = true;
			}
			// если используется регион, то и используется поисковая система
			if($usedSearchSystemRegion ){
				$systems[$i]['used'] = true;
			}
		}
		if(!$usedSearchSystem){
			$systems[0]['used'] = true;
			$usedSearchSystem = true;
			$usedSearchSystemOrdering[0] = $systems[0];
		}
		
		// если нет поисковых систем, то заполняем по умолчанию первыми
		if(!$item['searchsystems']){
			$item['searchsystems'] = $usedSearchSystemOrdering;
		}
		//printAr($item['searchsystems']);
		
		$globalTemplateParam -> set('item',$item);
		$globalTemplateParam->set('ssystems',$systems);
		$form =  initMainForm($itemObj,$mainFormParam -> get()) -> display();
		$globalTemplateParam->set('form',$form);
		$modul -> template = "projects/projects_edit.tpl";
	break;
	default:
		if(!isset($_REQUEST[$request->filter]['active'])){
			$request -> setFilter("active", 1);
		}
		$filds = array(
					 'url'=>array( 'name' => 'Адрес', 'col' => false),
					 'max_seo_pay'=>array( 'name' => 'Макс. Бюджет', 'col' => "100px",'align' => "right"),
					 'percent'=>array( 'name' => '%', 'col' => "50px"),
					 'actions'=>array( 'name' => 'Действие', 'col' => "230px"),
		);
		$actions = array('delete', 'edit');
		$globalTemplateParam->set('actions',$actions);
		$globalTemplateParam->set('filds',$filds);
		$globalTemplateParam->setNonPointer('ID_CLIENT',ID_CLIENT);
		$globalTemplateParam->setNonPointer('ID_OPTIMISATOR',ID_OPTIMISATOR);
		$globalTemplateParam->setNonPointer('ID_AKKAUNT',ID_AKKAUNT);
		$items = $itemObj -> getProjectsWithSeoParams("*",$request -> getFilterArr());
		$countPrice = $itemObj -> getProjectsWithSeoParams("SUM(`max_seo_pay`) as sum",$request -> getFilterArr());
		$foot['max_seo_pay'] = $countPrice[0]['sum'];
		//printAr($foot);
		$globalTemplateParam->set('items',$items);
		$globalTemplateParam->set('foot',$foot);
		$modul->template = "projects/projects.tpl";
	break;
}

