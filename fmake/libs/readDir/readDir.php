<?php 
	class readDir {

	public $dir = null;
	public $path = null;
	public $files = array();

	function __construct($dirpath)
	{
		$this->setDir($dirpath);
	}
	
	function setDir ($dirpath)  
	{
		
		if(is_dir($dirpath))
		{
			$this->dir = opendir($dirpath);
			$this->path = $dirpath;
			
		}
	}
	
	function listing($ext = array()) 
	{
		
		while (false !== ($file = readdir($this->dir)))
			if ($file != "." && $file != "..")
			{
				if(!$ext)
					$this->files[] = $file;
				elseif(in_array(substr($file, strrpos($file, '.')), $ext))
					$this->files[] = $file;
			}
		return $this->files;
	}
	
	function listingAll($dir,$level = 0,$addValue = "")
	{
		$level++;
		$curdir = opendir($dir);
		while (false !== ($file = readdir($curdir)))
		if ($file != "." && $file != "..")
		{
			if( is_dir($dir."/".$file) ){
				$this->files[] = array('level' => $level, 'file' => $file."/", value => $file);
				$this -> listingAll($dir."/".$file,$level,$addValue.$file."/");
			}else
				$this->files[] = array('level' => $level, 'file' => $file, 'value' => $addValue.$file);

		}
		return $this->files;
	}
	
	function getAllAsTree($parent = 0, $level = 0, $active = false, $inmenu = false){
		$level++;
		$items = $this -> getChilds($parent, $active, $inmenu);
		if($items){
			foreach ($items as $item){
				$item['level'] = $level;
				$this->tree[] = $item;
				$this->getAllAsTree($item[$this->idField], $level, $active, $inmenu);
			}
		}
		return $this->tree;
	}
	
	function delDir() 
	{		
		foreach ($this->listing() as $file)
		{
			if(is_file($this->path."/".$file))
				utlFile::delFile($this->path."/".$file);
			if(is_dir($this->path."/".$file))
				$this->delDir();
		}

		closedir($this->dir);
		rmdir($this->path);
	}
}	