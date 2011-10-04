<?php


	$pages = ( $modul->getAllAsTree(0, 0) );
	$globalTemplateParam->set('pages',$pages);

	$modul->template = "settings/system_pages.tpl";

