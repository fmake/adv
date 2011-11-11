<?php
interface searchSystems{
	
	/**
	 * 
	 * позиция сайта 
	 */
	function getPosition();
	/**
	 * 
	 * получить позицю с данными сайта, урлом и т.п.
	 */
	function getPositionWhithData();
	/**
	 * 
	 * получить данные с определенной страницы
	 */
	function getResponse();
	/**
	 * 
	 * получить определенное колличество сайтов по запросу
	 */
	function getNumSite();
}