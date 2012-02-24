<?php
class cURL_mymulti extends cURL_multi{
	private $callBack = false;
	private $params = array();
	
	function addCallBack(){
		if($arg = func_get_args()){
			foreach ($arg AS $ar){
				if(!$this -> callBack)
					$this->callBack = $ar;
				else
					$this->params[] = $ar;
			}
		}
	}
	
	protected function onLoad($url, $content, $info) {
		
		if($this->callBack){
			call_user_method_array($this->callBack[1], $this->callBack[0],array_merge(array($url, $content, $info),$this->params));
		}else{
			$arr = explode(";", $content);
			print ( "[$url]  $arr[0] ".($arr[1])."<br />" );
			//print htmlspecialchars($content);
			//print_r($info);
		}
	}
}