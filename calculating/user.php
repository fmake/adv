<?php 

	function initMainForm($itemObj,$context = array()){
		$myForm = new phpObjectForms(array("name" => 'editform', "action" => $context['action_url'], "display_outer_table" => false, "table_align" => false,
			    "table_width" => '600',"enable_js_validation" => true,"hold_output" => true,"css_class_prefix" => "edit-"
		));
		$leftWrapper = new FPLeftTitleWrapper(array());
		$layoutForm = new FPColLayout(array("table_padding" => 5,"element_align" => "center", "hold_output" => true,));
		

		$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "update")));
		if($context['user'])
			$userInfo = $context['user'] -> getInfo();
          
		$layoutForm -> addElement(new FPTextField(
            array(
                "name" => 'email',
                "title" => 'E-mail',
                "required" => true,
                "size" => 33,
                "valid_RE" => FP_VALID_EMAIL,
                "max_length" => 256,
                "wrapper" => &$leftWrapper,
            	"value" => $userInfo['email'],
                "comment" => 'используется для  '.
									        'отправки системных сообщений!',
            )));  
          $layoutForm -> addElement(new FPTextField(array(
		                "name" => 'login',
		                "title" => 'Имя пользователя',
		                "size" => 25,
		                "wrapper" => &$leftWrapper,
		 				"value" => $context['item']['login'],
          				"comment" => 'используется для входа в систему ',
          				"value" => $context['user'] -> login,
          				"disabled" => true
		            )));          
		$layoutForm -> addElement($passwordField = new FPPassword(array(
									    "name" => 'password',
									    "title" => 'Пароль',
									    "size" => 20,
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

	function initSystemForm($itemObj,$context = array()){
		$myForm = new phpObjectForms(array("name" => 'SystemForm', "action" => $context['action_url'], "display_outer_table" => false, "table_align" => false,
			    "table_width" => '600',"enable_js_validation" => true,"hold_output" => true,"css_class_prefix" => "edit-"
		));
		$leftWrapper = new FPLeftTitleWrapper(array());
		$layoutForm = new FPColLayout(array("table_padding" => 5,"element_align" => "center", "hold_output" => true,));
		
		if($context['user'])
			$userInfo = $context['user'] -> getInfo();
			
		// системные чекбоксы
		$checkboxSystem = new FPGridLayout(array("table_padding" => 5,"columns" => 2,));        
		$checkboxSystem -> addElement(
		        new FPCheckBox(array(
						                "name" => 'email_message',
						                "title" => 'слать сообщение на почту',
						                "table_align" => 'left',
						                "checked" => $userInfo['email_message'],
						         		"comment" => '<img src="/images/load-checkbox.gif" class="show-check" id="email_message" /><br/>Если выключено,<br /> 
						         						то сообщения дублируются на почту',
		        						"events" => array("onClick"=>"checkSystem('email_message',this.checked);")
						            ))
		 );
		$checkboxSystem -> addElement(
		        new FPCheckBox(array(
						                "name" => 'system_message',
						                "title" => 'cлать сообщение в системе',
						                "table_align" => 'left',
						                "checked" => $userInfo['system_message'],
						         		"comment" => '<img src="/images/load-checkbox.gif" class="show-check" id="system_message" /><br/>Если выключено,<br />
						         					 то сообщения высылаются Вам',
		        						"events" => array("onClick"=>"checkSystem('system_message',this.checked);")
						            ))
		 );
		 
		$layoutForm -> addElement(new FPGroup(array(
		                "name" => "monthGroup",
		                "title" => 'Параметры оповещения системой',
		                "table_align" => "left",
		                "elements" => array(
		                    &$checkboxSystem,
		                ))));
		                
		$myForm->setBaseLayout($layoutForm);
		return $myForm;
	}
	
	function helpForm($itemObj,$context = array()){
		$myForm = new phpObjectForms(array("name" => 'helpForm', "action" => $context['action_url']."#tab2", "display_outer_table" => false, "table_align" => false,
			    "table_width" => '600',"enable_js_validation" => true,"hold_output" => true,"css_class_prefix" => "edit-"
		));
		$leftWrapper = new FPLeftTitleWrapper(array());
		$layoutForm = new FPColLayout(array("table_padding" => 5,"element_align" => "center", "hold_output" => true,));
		

		$layoutForm -> addElement(new FPHidden(array("name" => "action","value" => "helpForm")));

		
		$layoutForm -> addElement(new FPTextArea(array(
		                "name" => 'text',
		                "title" => 'Описание ошибки',
		                "max_length" => 2048,
		                "wrapper" => &$leftWrapper,
						"value" => $context['item']['text'],
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
	                    "title" => '   Отправить  ',
	                )),
	            )
	            )));
		$myForm->setBaseLayout($layoutForm);
		return $myForm;
	}
	
	function checkStatus($id_preloader,$cheched){
		$param = false;
		if($id_preloader == "email_message"){
			$param = "email_message";
		}else if($id_preloader == "system_message"){
			$param = "system_message";
		}
		global $user;
		if($user -> id && $param){
			if($cheched){
				$user -> addParam($param,"1");
			}else{
				$user -> addParam($param,"0");
			}
			$user -> update();
		}
		sleep(1);
		$objResponse = new xajaxResponse();
		$objResponse->script("$('#{$id_preloader}').hide()");
		return $objResponse;
	}
	
	$mainFormParam = new templateController_templateParam();
	$action_url = "/".$request->parents."/".$request->modul;
	$mainFormParam -> set('action_url',$action_url);
	$globalTemplateParam->set('action_url',$action_url);
	
	
	include_once ROOT.'/fmake/libs/xajax/xajax_core/xajax.inc.php';
	$xajax = new xajax($action_url);
	$xajax->configure('javascript URI','/fmake/libs/xajax/');
	$xajax->register(XAJAX_FUNCTION,"checkStatus");
	$xajax->processRequest();
	
	
	
	
	
	
	$globalTemplateParam->set('xajax',$xajax);
	switch ($request -> action){
		case 'update':
			$myForm = initMainForm($itemObj,$mainFormParam -> get());
			if ($myForm->getSubmittedData()  &&  $myForm->isDataValid()) {
				$elements = $myForm->getElementValues();
				if($elements["password"]){
					$user -> addParam("password",md5($elements["password"]));	
				}
				$user -> addParam("email",($elements["email"]));
				$user -> update();
			}
			action_redir($action_url);
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
		case 'helpForm':
			$helpForm = helpForm($itemObj,$mainFormParam -> get());
			if ($helpForm->getSubmittedData()  &&  $helpForm->isDataValid()) {
				$elements = $helpForm->getElementValues();
				// сообщение о ошибке
				if($elements["text"]){
						$sendUser = ($user -> getInfo());
						$text = "Отправил: {$sendUser['name']} <{$sendUser['email']}><br/>";
						$text .= $elements["text"];
						$mail = new PHPMailer();
						$mail->CharSet = "utf-8";//кодировка
						$mail->From = "info@{$hostname}";
						$mail->FromName = "ADV System";
						
						$mail->AddAddress("shevlyakov.nikita@gmail.com","Никита");						
						$mail->WordWrap = 50;                                 
						$mail->SetLanguage("ru");
					
						$mail->IsHTML(true);                                  // с помощью html	
						$mail->Subject = "Ошибка";
						$mail->Body    = $text;
						$mail->AltBody = "Если не поддерживает html";
						$mail->Send();
				}
			}
			action_redir($action_url);
		break;
		default:
			$mainFormParam -> set("user",$user);
			$form =  initMainForm($itemObj,$mainFormParam -> get()) -> display();
			$globalTemplateParam->set('form',$form);
			$systemForm = initSystemForm($itemObj,$mainFormParam -> get()) -> display();
			$globalTemplateParam->set('systemForm',$systemForm);
			$helpForm = helpForm($itemObj,$mainFormParam -> get()) -> display();
			$globalTemplateParam->set('helpForm',$helpForm);
			
			$modul->template = "settings/user.tpl";
		break;
	}

	

	