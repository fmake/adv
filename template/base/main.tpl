[[ include TEMPLATE_PATH ~ "blocks/header.tpl"]]
<body>
	<div class="left-background"></div>
	<div id="page">
		<div class="p-inner">
			<div id="head">
				[[ include TEMPLATE_PATH ~ "blocks/user_info.tpl"]]
				[[ include TEMPLATE_PATH ~ "blocks/menu.tpl"]]
			</div>
			
			<div id="content">
				<div id="wrapper">
					<div id="left">
					[[ block left ]]
						[[for m in menu]]
							[[if m.status]]
								[[for c in m['child']]]
									[[if c.status]]
										[[for sc in c['child']]]
											<h4>{sc.caption}</h4>
											<ul>
											[[for ssc in sc['child']]]
												<li>
													[[ if ssc.status ]]
														{ssc.caption}
													[[else]]
														<a href="/{m.url}/{c.url}/{sc.url}/{ssc.url}">{ssc.caption}</a>
													[[endif]]
												</li>
											[[endfor]]
											</ul>
										[[endfor]]
									[[endif]]
								[[endfor]]
							[[endif]]
						[[endfor]]
						[[ endblock ]]
					</div>
					<div id="right">
					[[ block content ]]
						
					[[ endblock ]]
					</div>
				</div>
			</div>
		
		</div>
	
	</div>

	
</body>
</html>