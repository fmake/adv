

//данные поисковой системы и региона
dataSearchSystem = {};
//колличество дней в месяце
dayMonth = 30;

//новую таблицу запросов
function getTableQueryPattern(searchSystem,regionSystem) {
	
	content = $("#table-query-pattern").html();
	content = content.replace(/\\\$search_system_id\\/g,searchSystem);
	content = content.replace(/\\\$search_system_region_id\\/g,regionSystem);
	return content;
}

//получить цену по патерну
function getPricePattern(searchSystem,regionSystem,row_num,exs_num) {
	//alert($("#price-pattern .tr-pattern").html());
	content = $("#price-pattern .tr-pattern").html();
	content = content.replace(/\\\$search_system_id\\/g,searchSystem);
	content = content.replace(/\\\$search_system_region_id\\/g,regionSystem);
	content = content.replace(/\\\$row_num\\/g,row_num);
	content = content.replace(/\\\$exs_num\\/g,exs_num);
	try {
		// вызываем ошибку
		if(dataQuery[searchSystem][regionSystem]['price'][row_num][exs_num] == undefined){sad2312['sad']};
		content = content.replace(/\\\$price_val\\/g,dataQuery[searchSystem][regionSystem]['price'][row_num][exs_num]);
	} catch (e) {
		content = content.replace(/\\\$price_val\\/g,"");
	}
	
	return content;
}

//получить правило по патерну
function getExsPattern(searchSystem,regionSystem) {
	
	content = $("#exs-pattern .tr-pattern").html();
	content = content.replace(/\\\$search_system_id\\/g,searchSystem);
	content = content.replace(/\\\$search_system_region_id\\/g,regionSystem);
	content = content.replace(/\\\$exs_num\\/g,dataSearchSystem[searchSystem][regionSystem]['exs_count']);
	try {
		content = content.replace(/\\\$id_val\\/g,dataQuery[searchSystem][regionSystem]['place'][dataSearchSystem[searchSystem][regionSystem]['exs_count']]['id']);
		content = content.replace(/\\\$from_val\\/g,dataQuery[searchSystem][regionSystem]['place'][dataSearchSystem[searchSystem][regionSystem]['exs_count']]['from']);
		content = content.replace(/\\\$to_val\\/g,dataQuery[searchSystem][regionSystem]['place'][dataSearchSystem[searchSystem][regionSystem]['exs_count']]['to']);
	} catch (e) {
		content = content.replace(/\\\$from_val\\/g,"");
		content = content.replace(/\\\$to_val\\/g,"");
		content = content.replace(/\\\$id_val\\/g,"");
	}
	
	return content;
}

//получить цену по патерну
function getQueryPattern(searchSystem,regionSystem) {
	content = $("#query-pattern .query-tr").parent().html();
	content = content.replace(/\\\$search_system_id\\/g,searchSystem);
	content = content.replace(/\\\$search_system_region_id\\/g,regionSystem);
	content = content.replace(/\\\$row_num\\/g,dataSearchSystem[searchSystem][regionSystem]['row_count']);
	try {
		//alert(dataQuery[searchSystem][regionSystem]['querys'][dataSearchSystem[searchSystem][regionSystem]['row_count']]['query']);
		content = content.replace(/\\\$query_val\\/g,dataQuery[searchSystem][regionSystem]['querys'][dataSearchSystem[searchSystem][regionSystem]['row_count']]['query']);
		content = content.replace(/\\\$id_val\\/g,dataQuery[searchSystem][regionSystem]['querys'][dataSearchSystem[searchSystem][regionSystem]['row_count']]['id']);
	} catch (e) {
		content = content.replace(/\\\$query_val\\/g,"");
		content = content.replace(/\\\$id_val\\/g,"");
	}
	
	return $(content);
}

//добавить строку
function addRow(searchSystem,regionSystem){
	sizeDefault = 3;
	sizeTD = ( $(dataSearchSystem[searchSystem][regionSystem]['selector'] +" tr:first td").size() );
	var newRow =  getQueryPattern(searchSystem,regionSystem);
	for ( var int = 0; int < sizeTD - sizeDefault; int++) {
		$(newRow).find("td:last").before(getPricePattern(searchSystem,regionSystem,dataSearchSystem[searchSystem][regionSystem]['row_count'],int));
	}
	$(dataSearchSystem[searchSystem][regionSystem]['selector'] +" tr:last").before(newRow);
	//alert(newRow.html());
	// прибавляем колличество строк - зопросов
	dataSearchSystem[searchSystem][regionSystem]['row_count']++;
}
//добавить определенное колличество строк
function addRowNum(searchSystem,regionSystem,num) {
	for ( var int = 0; int < num; int++) {
		addRow(searchSystem,regionSystem);
	}
}
//добавить еще одно правило и колонку цен
function addCol(searchSystem,regionSystem){
	$(dataSearchSystem[searchSystem][regionSystem]['selector'] +" tr:first td:last").before(getExsPattern(searchSystem,regionSystem));
	// номер строки которую мы посылаем
	var row = 0;
	$(dataSearchSystem[searchSystem][regionSystem]['selector'] +" tr.query-tr").each(function() {
		$(this).find("td:last").before(getPricePattern(searchSystem,regionSystem,row,dataSearchSystem[searchSystem][regionSystem]['exs_count']));
		row++;
	});
	
	$(dataSearchSystem[searchSystem][regionSystem]['selector'] +" tr:last td:last").before("<td align=\"right\" class=\"sum-exs-"+dataSearchSystem[searchSystem][regionSystem]['exs_count']+"\">0</td>");
	
	// прибавляем колличество столбцов - правил
	dataSearchSystem[searchSystem][regionSystem]['exs_count']++;
}

//добавить определенное колличество колонок
function addColNum(searchSystem,regionSystem,num) {
	for ( var int = 0; int < num; int++) {
		addCol(searchSystem,regionSystem);
	}
}

//инициализируем объект
function initObjectData(searchSystem,regionSystem){
	if(!dataSearchSystem[searchSystem])
		dataSearchSystem[searchSystem] = {};
	dataSearchSystem[searchSystem][regionSystem]={};
	dataSearchSystem[searchSystem][regionSystem]['row_count'] = 0;
	dataSearchSystem[searchSystem][regionSystem]['exs_count'] = 0;
}

function initTableData(searchSystem,regionSystem,row,col,showTable){
	if(showTable == undefined){
		showTable = true;
	}
	if(showTable){
		$(".querys").hide();
		if(dataSearchSystem[searchSystem] && dataSearchSystem[searchSystem][regionSystem]){
			$(dataSearchSystem[searchSystem][regionSystem]['selector']).show();
			return;
		}
	}
	initObjectData(searchSystem,regionSystem);
	var tableContent = ( getTableQueryPattern(searchSystem,regionSystem) );
	$("#querys-tables").append(tableContent);
	dataSearchSystem[searchSystem][regionSystem]['selector'] = '#querys_'+searchSystem+'_'+regionSystem;
	if(showTable){
		$(dataSearchSystem[searchSystem][regionSystem]['selector']).show();
	}
	if(!row || row < 8)
		row = 8;
	if(!col || col < 2)
		col = 2;
	addRowNum(searchSystem,regionSystem,row);
	addColNum(searchSystem,regionSystem,col);
	
}


//получить регион по патерну
function getRegionPattern(regionSystem,regionNameSystem) {
	//alert($("#price-pattern .tr-pattern").html());
	content = $("#region-pattern").html();
	content = content.replace(/\\\$region_id\\/g,regionSystem);
	content = content.replace(/\\\$region_name\\/g,regionNameSystem);
	content = content.replace(/\\\$search_id\\/g,searchId);
	
	return content;
}

//получить регион по патерну
function getSearchSystemPattern(regionSystem,regionNameSystem) {
	//alert($("#price-pattern .tr-pattern").html());
	content = $("#search-system-pattern").html();
	content = content.replace(/\\\$search_id\\/g,regionSystem);
	content = content.replace(/\\\$search_name\\/g,regionNameSystem);
	
	return content;
}

function addSearchSystem() {
	$(".search-systems .search-system-add").before( getSearchSystemPattern($("#search_system_select").val(),$("#search_system_select option:selected").html()) );
	
	$("#search_system_select option:selected").remove();
	if($("#search_system_select option").length == 0){
		$("#search_system_select").remove();
		$("#system_search_calculation_button").remove();
	}
	$('#dialog_system_search').dialog('close');
	initSearchSystems();
}

function addConsecutive(){
	
	
	
	$(".regions .region-add").before( getRegionPattern($("#consecutive_calculation_select").val(),$("#consecutive_calculation_select option:selected").html()) );
	
	$("#consecutive_calculation_select option:selected").remove();
	if($("#consecutive_calculation_select option").length == 0){
		$("#consecutive_calculation_select").remove();
		$("#consecutive_calculation_boton").remove();
	}
	$('#dialog').dialog('close');
	initRegions();
}

function addConsecutiveNew(){
	if(!$("#region_lr_new").val() || !$("#region_caption_new").val()){
		alert('заполните поля');
		return;
	}
	// пишем в базу данных
	
	xajax_addRegion( $("#region_caption_new").val(), $("#region_lr_new").val());
	$(".regions .region-add").before( getRegionPattern( $("#region_lr_new").val(), $("#region_caption_new").val() ) );
	$("#region_lr_new").val('');
	$("#region_caption_new").val('');
	$('#dialog').dialog('close');
	initRegions();
}
//событие на клик регионов
function initRegions(){
	$(".regions .region A").click(function() {
		$(".regions A").removeClass("active");
		$(this).addClass("active");
		regionId = parseInt( $(this).attr("rel") );
		if(!searchId){
			return false;
		}
		initTableData(searchId,regionId);
		return false;
	});
}

//событие на клик поисковой системы
function initSearchSystems(){
	$(".search-system A").click(function() {
		// убираем другие таблицы
		$(".querys").hide();
		// убираем другие регионы
		$(".regions").hide();
		$(".regions A").removeClass("active")
		$(".search-system A").removeClass("active");
		$(this).addClass("active");
		searchId = parseInt($(this).attr("rel"));
		if( $("#region_"+searchId).html() ){
			$("#region_"+searchId).show();
			regionId = parseInt( $("#region_"+searchId +" A:first").attr('rel') );
			$("#region_"+searchId +" A:first").addClass("active");
		}else{
			regionId = 0;
		}
		
		
		if(!searchId){
			return false;
		}
		initTableData(searchId,regionId);
		return false;
	});
}

function maxPrice() {
	// максимальный заработок
	var maxSum = 0;
	$(".exs-0").each(function() { 
		if($(this).val() != ''){
			maxSum += parseInt($(this).val());
		}
	});
	var abonement = parseInt( $("#abonement").val() );
	$("#max-sum-site").html( dayMonth * maxSum + abonement );
	
}

function maxMonthPrice(regionSystem,regionNameSystem,exs_num){
	var sumExs = 0;
	var table = "#querys_"+regionSystem+"_"+regionNameSystem;
	$(table+" .exs-"+exs_num).each(function() { 
		if($(this).val() != ''){
			sumExs += parseInt($(this).val());
		}
	});
	
	$(table + " .sum-exs-"+exs_num).html( dayMonth * sumExs );
	maxPrice();
}

/*
* добавляем верхнюю форму вниз и делаем сабмит
*/
function addFormContent() {
	$('*[name=editformquery]').prepend($('*[name=editform] .edit-Table'));
	$('*[name=editform]').html('');
	return true;
}

function chekAllItems(regionSystem,regionNameSystem){
	$(".checkbox_"+regionSystem+"_"+regionNameSystem).attr("checked", "checked");
	$(this).attr("checked", "");
	return false;
}

$(document).ready(function(){	

	// событие на клик поисковой системы
	initSearchSystems();
	
	// событие на клик регионов
	initRegions();
	
	// Dialog			
	$('#dialog').dialog({
		autoOpen: false,
		width: 400,
		minHeight: 50
	});
	// Dialog			
	$('#dialog_system_search').dialog({
		autoOpen: false,
		width: 300,
		minHeight: 40
	});
	
	
	$('#region-link').click(function(){
		$('#dialog').dialog('open');
		return false;
	});
	
	$('#system-search-link').click(function(){
		$('#dialog_system_search').dialog('open');
		return false;
	});
	
	$( ".search-systems" ).sortable({
		//connectWith: ".search-system",
		cursor: 'crosshair',
		helper: 'clone',
		items: 'div.search-system',
		cancel: 'button'
		//disabled: true
	});
	$( ".regions" ).sortable({
		cursor: 'crosshair',
		helper: 'clone',
		items:  'div.region',
		cancel: 'button'
		//disabled: true
	});
	
});
