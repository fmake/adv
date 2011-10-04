[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]] 

[[block wrapper]]
		[[ include TEMPLATE_PATH ~ "blocks/rightblock.tpl"]]
		<div id="center" >
			<h1>{modul.caption}</h1>
			<div class="content">
				[[ for page in pages ]]
				
					<div class="page-item livel-{page.level}">
						{page.caption}
						
					</div>
				[[ endfor ]]
			</div>
		</div>
	
	
	<div id="subfooter-mini"></div>	
[[endblock]]