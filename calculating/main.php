<?php

	$pages = ( $modul->getAllAsTree(0, 0) );
	$globalTemplateParam->set('items',$pages);
	$globalTemplateParam->set('itemObj',$modul);
	$modul->template = "settings/system_pages.tpl";

	$action = new fmakeCore_actionController($request);

	
