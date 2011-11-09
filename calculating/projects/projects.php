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
	case 'update':
		printAr($_REQUEST);
		$itemObj -> setId($request -> id);
		$itemObj -> addParam("url", $request -> getEscape('url'));
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
			$projectSeoQuery -> addParam("id_project", $itemObj -> id);
			$searchSystemExs -> addParam("id_project", $itemObj -> id);
			$searchSystemAccess -> addParam("id_project", $itemObj -> id);
			$data = $request -> data;
			if($data){
				foreach ($data as $searchSystemID => $datainner){
					
					foreach ($datainner as $regionID => $datainner){
							if($regionID){
								$searchSystemID = $regionID;
							}
							//echo $searchSystemID;
							// добавляем запросы
							if($datainner['querys']){
								$querys = array();
								$index = sizeof($datainner['querys']);
								for ($i = 0; $i < $index; $i++) {
									
									if($datainner['querys'][$i]['id']){
										$projectSeoQuery -> setId(intval($datainner['querys'][$i]['id']));
										$projectSeoQuery -> addParam("query", $query);
										$projectSeoQuery -> update();
										$querys[$i] = $projectSeoQuery -> getInfo();
									}else if($query = trim($datainner['querys'][$i]['query']) ){
										$projectSeoQuery -> addParam("id_seo_search_system", $searchSystemID);
										$projectSeoQuery -> addParam("query", $query);
										$projectSeoQuery -> newItem();
										$querys[$i] = $projectSeoQuery -> getInfo();
									}else{
										break;
									}
									
									
								}
							}
							// все запросы обработанные
							//printAr($querys);
							
							$searchSystemExs -> addParam("id_seo_search_system", $searchSystemID);
							// работаем с правилами
							if($datainner['place']){
								$exs = array();
								$index = sizeof($datainner['place']);
								for ($i = 0; $i < $index; $i++) {
									if($datainner['place'][$i]['id'] && $datainner['place'][$i]['from'] && $datainner['place'][$i]['to']){
										$searchSystemExs -> setId($datainner['place'][$i]['id']);
										$searchSystemExs -> addParam("from", $datainner['place'][$i]['from']);
										$searchSystemExs -> addParam("to", $datainner['place'][$i]['to']);
										$searchSystemExs -> update();
										$exs[$i] = $projectSeoQuery -> getInfo();
									}else if( $datainner['place'][$i]['from'] && $datainner['place'][$i]['to'] ){
										$searchSystemExs -> addParam("from", $datainner['place'][$i]['from']);
										$searchSystemExs -> addParam("to", $datainner['place'][$i]['to']);
										$searchSystemExs -> newItem();
										$exs[$i] = $searchSystemExs -> getInfo();
									}else{
										//заканчиваем на пустом правиле, если удалили поля от и до то и удаляем правило
										if( $datainner['place'][$i]['id'] && (!$datainner['place'][$i]['from'] || !$datainner['place'][$i]['to']) ){
											$searchSystemExs -> setId($datainner['place'][$i]['id']);
											$searchSystemExs -> delete();
										}
										break;
									}
								}
								//printAr($exs);
								//удаляем устаревшие правила
								$searchSystemExs -> deleteWhereNotIn($itemObj -> id,$searchSystemID ,$exs);
							}

							// цены по правилам выставляем
							if($querys){
								foreach ($querys as $i => $val){
									for($j=0; $j < sizeof($exs); $j++){
										
										$searchSystemExsPrice -> addParam("id_exs",$exs[$j][$searchSystemExs -> idField]);
										$searchSystemExsPrice -> addParam("id_seo_query",$querys[$i][$projectSeoQuery -> idField]);
										$searchSystemExsPrice -> addParam("price",$datainner['price'][$i][$j]);
										$exPrice = $searchSystemExsPrice -> addPriceEx();
										//printAr($exPrice);
										if($j==0){
											$maxSitePrice += $arr[$i+1][$j+1];
										}
										
										
									}
								}
								// добавляем поисковую систему к проекту
								$searchSystemAccess -> addParam("id_seo_search_system", $searchSystemID);
								$searchSystemAccess -> addSystemAccess();
								$searchSystemsUsed[] = $searchSystemID;
							}

							
					}
				}
				//printAr($searchSystemsUsed);
				$searchSystemAccess -> deleteWhereNotIn($itemObj -> id,$searchSystemsUsed);
				
				
			}
		}
		//action_redir($action_url);
		break;
	case 'add':
		//printAr($_REQUEST);
		$itemObj -> addParam("url", $request -> getEscape('url'));
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
			
		}
		action_redir($action_url);
	break;
	case 'edit':
		$item = $itemObj -> getProjectWithSeoParams();
		$item['roles'] = $projectAcess -> getProjectRols($itemObj -> id);
		$item['searchsystems'] = $searchSystemAccess -> getProjectSystems($itemObj -> id);
		//printAr($item);
		$data = array();
		if($item['searchsystems']){
			foreach ($item['searchsystems'] as $id => $stm){
				$searchSystems -> setId($id);
				$srcstmp = ( $searchSystems -> getInfo() );
				if($srcstmp['parent']){
					$srcstnum = $srcstmp['parent'];
					$regionnum = $id;
				}else{
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
		//printAr($data);
		$mainFormParam -> set('item',$item);
		$globalTemplateParam->set('item',$item);
		$globalTemplateParam->set('data',$data);
	case 'new':
		$systems = ( $searchSystems -> getChilds(0) );
		$index = sizeof($systems);
		for ($i = 0; $i < $index; $i++) {
			$systems[$i]['child'] = $searchSystems -> getChilds($systems[$i][$searchSystems->idField]);
			
			if( $item['searchsystems'][ $systems[$i][$searchSystems -> idField] ] ){
				$systems[$i]['used'] = true;
			}
			// проверяем используются ли регионы в системе
			$index2 = sizeof($systems[$i]['child']);
			$usedSearchSystem = false;
			for ($j = 0; $j < $index2; $j++) {
				if( $item['searchsystems'][ $systems[$i]['child'][$j][$searchSystems -> idField] ] ){
					$systems[$i]['child'][$j]['used'] = true;
					$usedSearchSystem = true;
				}
			}
			if($index2 && !$usedSearchSystem){
				$systems[$i]['child'][0]['used'] = true;
			}
			
				
		}
		//printAr($systems);
		//printAr($item['searchsystems']);
		
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



