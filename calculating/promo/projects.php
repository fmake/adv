<?php
if($request -> id_project){
	include 'projects/project.php';
}else{
	include 'projects/main.php';
}