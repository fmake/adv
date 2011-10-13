
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
	
	// работа с табами
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
	
	$(tabs).click(clickTab);

	//проверка урла на #
	checkURL();
	
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
	

	
});


function checkSystem(id_preload,checked) {
	$("#"+id_preload).show();
	xajax_checkStatus(id_preload,checked);
}






