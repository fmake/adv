<?php 

	function initSapePassForm($itemObj,$context = array()){
		$myForm = new phpObjectForms(array("name" => 'sapePassform', "action" => $context['action_url'], "display_outer_table" => false, "table_align" => false,
			    "table_width" => '600',"enable_js_validation" => true,"hold_output" => true,"css_class_prefix" => "edit-"
		));
		
		$leftWrapper = new FPLeftTitleWrapper(array());
		$layoutForm = new FPColLayout(array("table_padding" => 5,"element_align" => "center", "hold_output" => true,));
		

		$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "sape_pass_update")));
		$layoutForm -> addElement(new FPText(array("text" =>
					                    '<div align="left">'.
					                    '<h2>Доступ в систему </h2>')));
        global $configs;
		$layoutForm -> addElement(new FPTextField(
            array(
                "name" => 'sape[login]',
                "title" => 'Логин',
                "required" => true,
                "size" => 33,
                "valid_RE" => FP_VALID_NAME,
                "max_length" => 256,
                "wrapper" => &$leftWrapper,
            	"value" => $configs -> sape_login,
            )));  
          $layoutForm -> addElement(new FPTextField(array(
		                "name" => 'sape[password]',
		                "title" => 'Пароль',
		                "size" => 25,
		                "wrapper" => &$leftWrapper,
		 				"value" => $configs -> sape_password,
          				"valid_RE" => FP_VALID_EMPTY,
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

	function initWebmasterPassForm($itemObj,$context = array()){
		$myForm = new phpObjectForms(array("name" => 'webmasterPassform', "action" => $context['action_url']."#tab1", "display_outer_table" => false, "table_align" => false,
			    "table_width" => '600',"enable_js_validation" => true,"hold_output" => true,"css_class_prefix" => "edit-"
		));
		
		$leftWrapper = new FPLeftTitleWrapper(array());
		$layoutForm = new FPColLayout(array("table_padding" => 5,"element_align" => "center", "hold_output" => true,));
		

		$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "webmaster_pass_update")));
		$layoutForm -> addElement(new FPText(array("text" =>
					                    '<div align="left">'.
					                    '<h2>Доступ в систему </h2>')));
        global $configs;
		$layoutForm -> addElement(new FPTextField(
            array(
                "name" => 'webmaster[login]',
                "title" => 'Логин',
                "required" => true,
                "size" => 33,
                "valid_RE" => FP_VALID_NAME,
                "max_length" => 256,
                "wrapper" => &$leftWrapper,
            	"value" => $configs -> webmaster_login,
            )));  
          $layoutForm -> addElement(new FPTextField(array(
		                "name" => 'webmaster[password]',
		                "title" => 'Пароль',
		                "size" => 25,
		                "wrapper" => &$leftWrapper,
		 				"value" => $configs -> webmaster_password,
          				"valid_RE" => FP_VALID_EMPTY,
          				"required" => true,
		            )));     
          $layoutForm -> addElement(new FPTextField(array(
		                "name" => 'webmaster[yandex_api_token]',
		                "title" => 'Токен для API',
		                "size" => 25,
		                "wrapper" => &$leftWrapper,
		 				"value" => $configs -> yandex_api_token,
          				"valid_RE" => FP_VALID_EMPTY,
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
	
	function initMetrikaPassForm($itemObj,$context = array()){
		$myForm = new phpObjectForms(array("name" => 'metrikaPassform', "action" => $context['action_url']."#tab2", "display_outer_table" => false, "table_align" => false,
			    "table_width" => '600',"enable_js_validation" => true,"hold_output" => true,"css_class_prefix" => "edit-"
		));
		
		$leftWrapper = new FPLeftTitleWrapper(array());
		$layoutForm = new FPColLayout(array("table_padding" => 5,"element_align" => "center", "hold_output" => true,));
		

		$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "metrika_pass_update")));
		$layoutForm -> addElement(new FPText(array("text" =>
					                    '<div align="left">'.
					                    '<h2>Доступ в систему </h2>')));
        global $configs;
		$layoutForm -> addElement(new FPTextField(
            array(
                "name" => 'metrika[login]',
                "title" => 'Логин',
                "required" => true,
                "size" => 33,
                "valid_RE" => FP_VALID_NAME,
                "max_length" => 256,
                "wrapper" => &$leftWrapper,
            	"value" => $configs -> metrika_login,
            )));  
          $layoutForm -> addElement(new FPTextField(array(
		                "name" => 'metrika[password]',
		                "title" => 'Пароль',
		                "size" => 25,
		                "wrapper" => &$leftWrapper,
		 				"value" => $configs -> metrika_password,
          				"valid_RE" => FP_VALID_EMPTY,
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
	
	switch ($request -> action){
		case 'sape_pass_update':
			if ($request -> sape['login'] && $request -> sape['password']) {	
				$configs -> udateByValue("sape_login",$request -> getEscapeVal($request -> sape['login']));
				$configs -> udateByValue("sape_password",$request -> getEscapeVal($request -> sape['password']));
			}
			action_redir($action_url);
		break;
		case 'webmaster_pass_update':
			if ($request -> webmaster['login'] && $request -> webmaster['password']) {	
				$configs -> udateByValue("webmaster_login",$request -> getEscapeVal($request -> webmaster['login']));
				$configs -> udateByValue("webmaster_password",$request -> getEscapeVal($request -> webmaster['password']));
				$configs -> udateByValue("yandex_api_token",$request -> getEscapeVal($request -> webmaster['yandex_api_token']));
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

			$sapePassform =  initSapePassForm($itemObj,$mainFormParam -> get()) -> display();
			$globalTemplateParam->set('sapePassform',$sapePassform);
			
			$webmasterPassform =  initWebmasterPassForm($itemObj,$mainFormParam -> get()) -> display();
			$globalTemplateParam->set('webmasterPassform',$webmasterPassform);
			
			$metrikaPassform =  initMetrikaPassForm($itemObj,$mainFormParam -> get()) -> display();
			$globalTemplateParam->set('metrikaPassform',$metrikaPassform);
			
			$modul->template = "settings/passwords.tpl";
		break;
	}


	
