<?php 

	function initPosForm($itemObj,$context = array()){
		$myForm = new phpObjectForms(array("name" => 'posForm', "action" => $context['action_url'], "display_outer_table" => false, "table_align" => false,
			    "table_width" => '600',"enable_js_validation" => true,"hold_output" => true,"css_class_prefix" => "edit-"
		));
		
		$leftWrapper = new FPLeftTitleWrapper(array());
		$layoutForm = new FPColLayout(array("table_padding" => 5,"element_align" => "center", "hold_output" => true,));
		

		$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "pos_update")));
		$layoutForm -> addElement(new FPText(array("text" =>
					                    '<div align="left">'.
					                    '<h2>Доступ в систему </h2>')));
        global $configs;
		$layoutForm -> addElement(new FPTextField(
            array(
                "name" => 'pos[query_parallel_check]',
                "title" => 'Параллельных проверок запросов',
				"comment" =>
					        'Количество одновременно проверяемых запросов в поисковых системах',
                "required" => true,
                "size" => 33,
                "valid_RE" => FP_VALID_QUANTITY,
                "max_length" => 256,
                "wrapper" => &$leftWrapper,
            	"value" => $configs -> 	query_parallel_check,
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
	
	function initPayForm($itemObj,$context = array()){
		$myForm = new phpObjectForms(array("name" => 'webmasterPassform', "action" => $context['action_url']."#tab1", "display_outer_table" => false, "table_align" => false,
				    "table_width" => '600',"enable_js_validation" => true,"hold_output" => true,"css_class_prefix" => "edit-"
		));
	
		$leftWrapper = new FPLeftTitleWrapper(array());
		$layoutForm = new FPColLayout(array("table_padding" => 5,"element_align" => "center", "hold_output" => true,));
	
	
		$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "pay_update")));
		$layoutForm -> addElement(new FPText(array("text" =>
						                    '<div align="left">'.
						                    '<h2>Доступ в систему </h2>')));
		global $configs;
		$layoutForm -> addElement(new FPTextField(
		array(
	                "name" => 'pay[promo]',
	                "title" => 'Процент для оптимизатора',
	                "required" => true,
	                "size" => 33,
	                "valid_RE" => FP_VALID_INTEGER,
	                "max_length" => 256,
	                "wrapper" => &$leftWrapper,
	            	"value" => $configs -> promo_percent_default,
		)));
		$layoutForm -> addElement(new FPTextField(array(
			                "name" => 'pay[accaunt]',
			                "title" => 'Процент для аккаунта',
			                "size" => 25,
			                "wrapper" => &$leftWrapper,
			 				"value" => $configs -> accaunt_percent_dafault,
	          				"valid_RE" => FP_VALID_INTEGER,
	          				"required" => true,
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
	$globalTemplateParam->set('cronKey',$cronKey);
	
	switch ($request -> action){
		case 'pos_update':
			if ($request -> pos['query_parallel_check']) {
				if($request -> pos['query_parallel_check'] < 1){
					$_REQUEST['pos']['query_parallel_check'] = 1;
				}	
				$configs -> udateByValue("query_parallel_check",$request -> getEscapeVal($request -> pos['query_parallel_check']));
			}
			action_redir($action_url);
		break;
		case 'pay_update':
			$configs -> udateByValue("promo_percent_default",$request -> getEscapeVal($request -> pay['promo']));
			$configs -> udateByValue("accaunt_percent_dafault",$request -> getEscapeVal($request -> pay['accaunt']));
			action_redir($action_url);
		break;
		default:

			$posForm =  initPosForm($itemObj,$mainFormParam -> get()) -> display();
			$globalTemplateParam->set('posForm',$posForm);
			
			$payForm =  initPayForm($itemObj,$mainFormParam -> get()) -> display();
			$globalTemplateParam->set('payForm',$payForm);
			$modul->template = "settings/check.tpl";
		break;
	}


	