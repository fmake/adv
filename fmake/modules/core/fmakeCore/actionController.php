<?php 
/**
 * Действия при редактирровании  
 * @author n1k
 *
 */
class fmakeCore_actionController{
	
	private $options = array();
	private $request = false;
	function __construct($request,$options = array()){
		 $this -> options = array_merge(
			 array(
	            'debug'               => false,
	            'charset'             => 'UTF-8',
	            'base_template_class' => 'Twig_Template',
	            'strict_variables'    => false,
	            'autoescape'          => true,
	            'cache'               => false,
	            'auto_reload'         => null,
	            'optimizations'       => -1,
	        ), $options);
	      $this -> request = &$request; 
	        
	        
		$this -> actionProcess( $this -> request -> action);	
	}
	
	function actionProcess($action){
		switch ($action){
			case 'new':
				$this -> actionNew();
			break;
		}
	}
	
	function actionNew(){
		global $modul;
		$modul -> template = "actions/new.tpl";
	}
	
}