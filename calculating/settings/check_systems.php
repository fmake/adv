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
                "valid_RE" => FP_VALID_NAME,
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
	
	$mainFormParam = new templateController_templateParam();
	$action_url = "/".$request->parents."/".$request->modul;
	$mainFormParam -> set('action_url',$action_url);
	$globalTemplateParam->set('cronKey',$cronKey);
	
	switch ($request -> action){
		case 'pos_update':
			if ($request -> pos['query_parallel_check']) {	
				$configs -> udateByValue("query_parallel_check",$request -> getEscapeVal($request -> pos['query_parallel_check']));
			}
			action_redir($action_url);
		break;
		case 'webmaster_pass_update':
			if ($request -> webmaster['login'] && $request -> webmaster['password']) {	
				$configs -> udateByValue("webmaster_login",$request -> getEscapeVal($request -> webmaster['login']));
				$configs -> udateByValue("webmaster_password",$request -> getEscapeVal($request -> webmaster['password']));
			}
			action_redir($action_url);
		break;
		case 'metrika_pass_update':
			if ($request -> metrika['login'] && $request -> metrika['password']) {	
				$configs -> udateByValue("metrika_login",$request -> getEscapeVal($request -> metrika['login']));
				$configs -> udateByValue("metrika_password",$request -> getEscapeVal($request -> metrika['password']));
			}
			action_redir($action_url);
		break;
		default:

			$posForm =  initPosForm($itemObj,$mainFormParam -> get()) -> display();
			$globalTemplateParam->set('posForm',$posForm);
			
			$modul->template = "settings/check.tpl";
		break;
	}


	