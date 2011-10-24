


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
