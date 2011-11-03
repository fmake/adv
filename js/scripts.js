


var lasturl="";	//here we store the current URL hash
	function checkURL(hash){
		if(!hash) hash=window.location.hash;	//if no parameter is provided, use the hash value from the current address
		if(hash != lasturl){
			lasturl=hash;
			loadUrl(hash);
		}
	}
	
function loadUrl(url){
	url = (url.replace('#tab',''));
	if(url)
		clickTab( false, parseInt(url) );
}

//работа с табами
var tabs = "#tabs .item";
var tabscontent = ".tab-content";
function clickTab(obj,ind){
	var tab = $(this);
	if(ind != undefined){
		if($(tabs).size() < ind)ind=0;
		var tab = $(tabs)[ind];
	}
	$(tabs).removeClass("active");
	$(tab).addClass("active");
	$(tabscontent).hide();
	$($(tabscontent)[$(tabs).index(tab)]).show();
	return true;
}

$(document).ready(function(){	
	var menucontainer = "#mainmenu-container .item";
	var subblock = "#sub-block-";
	var subblockclass = ".sub-block";
	var menu = $(menucontainer);
	$(menucontainer+" A").click(function() {
		menu.removeClass("active");
		$(this).parent().parent().parent().addClass("active");
		$(subblockclass).hide();
		var subblockt = subblock + $(this).attr("rel");
		$(subblockt).show();
		return false;
	});
	
	$(tabs).click(clickTab);
	//проверка урла на #
	checkURL();
	
	$(".checkbox-role input").click(checkRole);
	
});

function checkSendToPage(val,status){
	re = /(.+)\-(.+)/i;
	found = val.match(re);
	item_id = parseInt(found[1]);
	role_id = parseInt(found[2]);
	
	if(item_id && role_id){
		$("#checkbox-load-"+item_id).show();
		xajax_setStatusRoleModule(item_id,role_id,status,"checkbox-load-"+item_id);
	}
}

function checkRole(obj){
	val = $(this).val();
	checkSendToPage(val,this.checked);
}

function checkSystem(id_preload,checked) {
	$("#"+id_preload).show();
	xajax_checkStatus(id_preload,checked);
}

function chekedOtherRole(className){
	$("."+className+" input").each(function() {
		if(!$(this).attr("checked")){
			val = ($(this).val());
			checkSendToPage(val,true);
		};
	})
	$("."+className+" input").attr("checked", "checked");
}

// данные поисковой системы и региона
dataSearchSystem = {};

//новую таблицу запросов
function getTableQueryPattern(searchSystem,regionSystem) {
	
	content = $("#table-query-pattern").html();
	content = content.replace(/\\\$search_system_id\\/g,searchSystem);
	content = content.replace(/\\\$search_system_region_id\\/g,regionSystem);
	return content;
}

// получить цену по патерну
function getPricePattern(searchSystem,regionSystem,row_num,exs_num) {
	//alert($("#price-pattern .tr-pattern").html());
	content = $("#price-pattern .tr-pattern").html();
	content = content.replace(/\\\$search_system_id\\/g,searchSystem);
	content = content.replace(/\\\$search_system_region_id\\/g,regionSystem);
	content = content.replace(/\\\$row_num\\/g,row_num);
	content = content.replace(/\\\$exs_num\\/g,exs_num);
	
	return content;
}

//получить цену по патерну
function getExsPattern(searchSystem,regionSystem) {
	
	content = $("#exs-pattern .tr-pattern").html();
	content = content.replace(/\\\$search_system_id\\/g,searchSystem);
	content = content.replace(/\\\$search_system_region_id\\/g,regionSystem);
	content = content.replace(/\\\$exs_num\\/g,dataSearchSystem[searchSystem][regionSystem]['exs_count']);
	return content;
}

//получить цену по патерну
function getQueryPattern(searchSystem,regionSystem) {
	content = $("#query-pattern .query-tr").parent().html();
	content = content.replace(/\\\$search_system_id\\/g,searchSystem);
	content = content.replace(/\\\$search_system_region_id\\/g,regionSystem);
	content = content.replace(/\\\$row_num\\/g,dataSearchSystem[searchSystem][regionSystem]['row_count']);
	return $(content);
}

// добавить строку
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
// добавить определенное колличество строк
function addRowNum(searchSystem,regionSystem,num) {
	for ( var int = 0; int < num; int++) {
		addRow(searchSystem,regionSystem);
	}
}
// добавить еще одно правило и колонку цен
function addCol(searchSystem,regionSystem){
	$(dataSearchSystem[searchSystem][regionSystem]['selector'] +" tr:first td:last").before(getExsPattern(searchSystem,regionSystem));
	// номер строки которую мы посылаем
	var row = 0;
	$(dataSearchSystem[searchSystem][regionSystem]['selector'] +" tr.query-tr").each(function() {
		$(this).find("td:last").before(getPricePattern(searchSystem,regionSystem,row,dataSearchSystem[searchSystem][regionSystem]['exs_count']));
		row++;
	});
	
	$(dataSearchSystem[searchSystem][regionSystem]['selector'] +" tr:last td:last").before("<td></td>");
	
	// прибавляем колличество столбцов - правил
	dataSearchSystem[searchSystem][regionSystem]['exs_count']++;
}

//добавить определенное колличество колонок
function addColNum(searchSystem,regionSystem,num) {
	for ( var int = 0; int < num; int++) {
		addCol(searchSystem,regionSystem);
	}
}

function initObjectData(searchSystem,regionSystem){
	if(!dataSearchSystem[searchSystem])
		dataSearchSystem[searchSystem] = {};
	dataSearchSystem[searchSystem][regionSystem]={};
	dataSearchSystem[searchSystem][regionSystem]['row_count'] = 0;
	dataSearchSystem[searchSystem][regionSystem]['exs_count'] = 0;
}

function initTableData(searchSystem,regionSystem){
	$(".querys").hide();
	if(dataSearchSystem[searchSystem] && dataSearchSystem[searchSystem][regionSystem]){
		$(dataSearchSystem[searchSystem][regionSystem]['selector']).show();
		return;
	}
	initObjectData(searchSystem,regionSystem);
	var tableContent = ( getTableQueryPattern(searchSystem,regionSystem) );
	$("#querys-tables").append(tableContent);
	dataSearchSystem[searchSystem][regionSystem]['selector'] = '#querys_'+searchSystem+'_'+regionSystem;
	$(dataSearchSystem[searchSystem][regionSystem]['selector']).show();
	addRowNum(searchSystem,regionSystem,8);
	addColNum(searchSystem,regionSystem,2);
	
}

$(document).ready(function(){	

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
			return;
		}
		initTableData(searchId,regionId);
	});
	
	$(".regions .region A").click(function() {
		$(".regions A").removeClass("active");
		$(this).addClass("active");
		regionId = parseInt( $(this).attr("rel") );
		if(!searchId){
			return;
		}
		initTableData(searchId,regionId);
		
	});
	
	
	// Dialog			
	$('#dialog').dialog({
		autoOpen: false,
		width: 400,
		minHeight: 50
	});
	
	$('#region-link').click(function(){
		$('#dialog').dialog('open');
		return false;
	});
	
});


