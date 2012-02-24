<?php
class projects_update extends fmakeCore{
		
	public $table = "update_position";
	public $idField = "id_update";
	public $order = "date";
	public $timeHold = 3600;
	public $bg = "/images/picbg.gif";
	public $font = "/images/fonts/tahoma.ttf";
	public $symbols = "23456789abcdeghkmnpqsuvxyz";
	public $line = "";
	

	/**
	 * 
	 * Картинка апдейта
	 */	
	function genPic(){

		$this->line = $this->getUpdate()."%";

		$bg = imagecreatefromgif(ROOT.$this->bg);
		$color = imagecolorallocate($bg, 0, 0, 0);
		imagettftext($bg, 12, 0, 5, 17, $color, ROOT.$this->font, $this->line);
		header("Content-type: image/png");
		imagepng($bg);
		imagedestroy($bg);
	}
	
	/**
	 * 
	 * Получить апдейт по дате
	 */
	function getByDate($date){
		$where[0] = '`date` = '.$date.'';
		$arr = $this -> getWhere($where);
		return $arr[0];
	}
	
	/**
	 * 
	 * Получить апдейт по дате из кеша
	 */
	function getUpdate($date = false){
		
		if(!$date)
			$date = strtotime("today");
		$update = $this->getByDate($date);

		if($update && (time()-$update['time']) < $this->timeHold)
			return $update['update'];
		
		
		$pos = new projects_seo_position();
		$mysql = $this->dataBase->SelectFromDB(__LINE__);
		$mysql->addFrom($this->table);
		$arr = $mysql->stringQueryDB("SELECT (
						sum( abs( A.pos - B.pos ) ) 
						)as sum
						FROM (
						
						SELECT *
						FROM `{$pos->table}`
						WHERE `date` = '".strtotime("-1 day",$date)."'
						) AS A
						JOIN (
						
						SELECT *
						FROM `{$pos->table}`
						WHERE `date` = '".$date."'
						) AS B ON A.`id_seo_query` = B.`id_seo_query` ",
					 __LINE__);
					 
		$absolute = ($arr[0]['sum']);
		
		$arr = $mysql->stringQueryDB("SELECT sum(pos) as sum
							FROM `{$pos->table}`
							WHERE `date` = '".strtotime("-1 day",$date)."'",
					 __LINE__);
		$allPosition = ($arr[0]['sum']); 
	
		
		$this -> addParam("update",round($absolute/$allPosition * 100));
		$this -> addParam("date",$date);
		$this -> addParam("time",time());
		
		if($update){
			$this->setId($update[$this -> idField]);
			$this->update();	
		}else{
			$this->newItem();
		}
		
		return round($absolute/$allPosition * 100);
	}
	/**
	 * 
	 * Получить последние апдейты
	 * @param unknown_type $size процентное изменение
	 * @param unknown_type $count колличество
	 */
	function getByLimit($size,$count){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		if($active) $select -> addWhere("active='1'");
		return  $select->addFild('date,`update`') -> addFrom($this->table)-> addOrder('date', 'DESC')-> addWhere("`update` > '{$size}'") -> addLimit(0, $count)  -> queryDB();
		
	}
	
	
	
}