<?php

function initMainForm($itemObj,$context = array()){

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
		$clients = array(0 => "Вася");
		$layoutForm -> addElement(new FPSelect(array(
				                "name" => 'role[1]',
				                "title" => 'Клиент',
				                "multiple" => false,
				                "options" => $clients,
				                "selected" => array($context['item']['parent']),
				                "css_style" => 'width:308px;',
				                "wrapper" => &$leftWrapper,
		)));
		
		
		
		
		
		$layoutProjectForm = new FPColLayout(array("table_padding" => 5,"element_align" => "left", "hold_output" => true,));
		
		$layoutProjectForm -> addElement(new FPTextField(array(
			                "name" => 'lve',
			                "title" => 'LiveInternet',
			            	"comment" =>
			                    'Только цифрами и латинскими буквами',
			                "size" => 25, 
			                "max_length" => 36,
			                "wrapper" => &$leftWrapper,
			 				"value" => $context['item']['url'],
			 				"align" => "left"
		)));
		
		$layoutProjectForm -> addElement(new FPTextField(array(
					                "name" => 'lve',
					                "title" => 'Метрика',
					            	"comment" =>
					                    'Только цифрами и латинскими буквами',
					                "size" => 25, 
					                "max_length" => 36,
					                "wrapper" => &$leftWrapper,
					 				"value" => $context['item']['url'],
					 				"align" => "left"
		)));
		
		$layoutProjectForm -> addElement(new FPTextField(array(
					                "name" => 'lve',
					                "title" => 'Webmaster ID',
					            	"comment" =>
					                    'Только цифрами',
					                "size" => 25, 
					                "max_length" => 36,
					                "wrapper" => &$leftWrapper,
					 				"value" => $context['item']['url'],
					 				"align" => "left"
		)));
		
		$layoutProjectForm -> addElement(new FPTextField(array(
							                "name" => 'lve',
							                "title" => 'SAPE ID',
							            	"comment" =>
							                    'Только цифрами',
							                "size" => 25, 
							                "max_length" => 36,
							                "wrapper" => &$leftWrapper,
							 				"value" => $context['item']['url'],
							 				"align" => "left"
		)));
		
		$layoutForm -> addElement( new FPGroup(array(
								        "title" => 'Данные проекта',
								        "elements" => array($layoutProjectForm)
		)));
		
		

		
		$promo = new FPRowLayout(array("elements" => array(
											new FPSelect(array(
											                "name" => 'role[1]',
											                "title" => 'Оптимизатор',
											                "multiple" => false,
											                "options" => $clients,
											                "selected" => array($context['item']['parent']),
											                "css_style" => 'width:308px;',
											                "wrapper" => &$leftWrapper,
											)),
											new FPTextField(array(
								                    "name" => "pay1",
								                    "title" => 'Процент оптимизатора',
								                    "valid_RE" => FP_VALID_INTEGER,
								                    "css_style" => 'width:30px;',
								                    "required" => true,
								                    "max_length" => 256
											)),
											new FPText(array("text" => "%")),
						            ),
						        ));
		$manager = new FPRowLayout(array("elements" => array(
										new FPSelect(array(
								                "name" => 'role[1]',
								                "title" => 'Менеджер',
								                "multiple" => false,
								                "options" => $clients,
								                "selected" => array($context['item']['parent']),
								                "css_style" => 'width:308px;',
								                "wrapper" => &$leftWrapper,
										)),
										new FPTextField(array(
							                    "name" => "pay2",
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



$mainFormParam = new templateController_templateParam();
$action_url = "/".$request->parents."/".$request->modul;
$mainFormParam->set('action_url',$action_url);
$globalTemplateParam->set('action_url',$action_url);
$itemObj = new projects();


switch ($request -> action){
	case 'edit':
		$item = $itemObj -> getInfo();
		$mainFormParam -> set('item',$item);
	case 'new':
		$form =  initMainForm($itemObj,$mainFormParam -> get()) -> display();
		$globalTemplateParam->set('form',$form);
		$modul -> template = "projects/projects_edit.tpl";
	break;
	default:
		
		$modul->template = "projects/projects.tpl";
	break;
}



