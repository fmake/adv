<?php
include ("excel.php");
class ExcelParser{
	public $exc;
	public $file;
	
	
	function __construct(){
		
		$this->exc = new ExcelFileParser("debug.log", ABC_NO_LOG );
		
		
	}
	
	function getmicrotime() {
	    list($usec, $sec) = explode(" ",microtime());
	    return ((float)$usec + (float)$sec);
	}

	function convertUnicodeString( $str ){
		for( $i=0; $i<strlen($str)/2; $i++ )
		{
			$no = $i*2;
			$hi = ord( $str[$no+1] );
			$lo = $str[$no];
			
			if( $hi != 0 )
				continue;
			elseif( ! ctype_alnum( $lo ) )
				continue;
			else
				$result .= $lo;
		}
		
		return $result;
	}
	
	
	function uc2html($str) {
		$ret = '';
		for( $i=0; $i<strlen($str)/2; $i++ ) {
			$charcode = ord($str[$i*2])+256*ord($str[$i*2+1]);
			$ret .= "&#".$charcode.";";
		}
		return html_entity_decode($ret,ENT_QUOTES,cp1251);;
	}
	
	function show_time() {
		global $time_start,$time_end;
	
		$time = $time_end - $time_start;
		echo "Анализ сделан за $time секунды<hr size=1><br>";
	}
	
	function fatal($msg = '') {
		echo '[Fatal error]';
		if( strlen($msg) > 0 )
			echo ": $msg";
		echo "<br>\nВыполнение Скрипта прервано <br>\n";
		if( $f_opened) @fclose($fh);
		exit();
	}
	
	function getDataFormat($exc,$data){
		
		switch ($data['type']) {
			// строка
			case 0:
				$ind = $data['data'];
				if( $exc->sst['unicode'][$ind] ) {
					$s = $this->uc2html($this->exc->sst['data'][$ind]);
				} else{
					$s = $this->exc->sst['data'][$ind];
				}
				return $s;
			break;
			//целое число
			case 1:
				return (int)($data['data']);
			break;
			//вещественное число
			case 2:
				return (float)($data['data']);
			break;
			// дата
			case 3:
				$ret = $this->exc->getDateArray($data['data']);
				return "{$ret['day']} {$ret['month']} {$ret['year']}";
			break;
		}
		
		return false;
		
	}
	
	function getFileInArray(){
		$excel_file_size;
		$excel_file = $this->file;	
		$time_start = $this->getmicrotime();
		$time_end = $this->getmicrotime();
	
		switch ($this->exc->ParseFromFile($excel_file)) {
			case 0: break;
			case 1: $this->fatal("Невозможно открыть файл");
			case 2: $this->fatal("Файл, слишком маленький чтобы быть файлом Excel");
			case 3: $this->fatal("Ошибка чтения заголовка файла");
			case 4: $this->fatal("Ошибка чтения файла");
			case 5: $this->fatal("Это - не файл Excel или файл, сохраненный в Excel < 5.0");
			case 6: $this->fatal("Битый файл");
			case 7: $this->fatal("В файле не найдены данные  Excel");
			case 8: $this->fatal("Неподдерживаемая версия файла");
		
			default:
				fatal("Неизвестная ошибка");
		}

		
		for( $ws_num=0; $ws_num<count($this->exc->worksheet['name']); $ws_num++ ){
			$ws = $this->exc->worksheet['data'][$ws_num];
			if( is_array($ws) && isset($ws['max_row']) && isset($ws['max_col']) ) {
				for( $i=0; $i<=$ws['max_row']; $i++ ) {
					if(isset($ws['cell'][$i]) && is_array($ws['cell'][$i]) ) {
						for( $j=0; $j<=$ws['max_col']; $j++ ) {//////
							if( ( is_array($ws['cell'][$i]) ) && ( isset($ws['cell'][$i][$j]) ) ){//
								$data = $ws['cell'][$i][$j];
								$font = $ws['cell'][$i][$j]['font'];
								$ansArray[$i][$j] = html_entity_decode($this->getDataFormat($this->exc,$data));
								
							}
						}
					}
				}
			}
		}
		
		return $ansArray;
	}
	

function  getExt($arr){

	if($arr[0]){
		for($i=1;$i <= sizeof($arr[0]);$i++){	
			$ans[$i-1] = explode("=",$arr[0][$i]);
			$ans[$i-1]['from'] = $ans[$i-1]['0'];
			$ans[$i-1]['to'] = $ans[$i-1]['1'];
			unset($ans[$i-1]['0']);
			unset($ans[$i-1]['1']);
		}
		
		return $ans;
	}
		
	return false;
}


function  getQuery($arr){
	if($arr){
		for($i=1;$i < sizeof($arr);$i++){	
			$ans[$i-1]['query'] = trim(iconv("CP1251", "UTF-8", $arr[$i][0])) ;
		}
		return $ans;
	}
		
	return array();
}

function  getPrice($arr,$exs){
	if($arr){
		for($i=1;$i < sizeof($arr);$i++){
			for ($j = 1; $j <= sizeof($exs); $j++) {
				$ans[$i-1][$j-1] = $arr[$i][$j];
			}
			
		}
		return $ans;
	}
	
	return array();
}

	
}
