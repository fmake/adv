
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
});






