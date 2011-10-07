[[ include TEMPLATE_PATH ~ "blocks/header.tpl"]]
<body>
	<div id="page">
		<div class="p-inner">
			<div id="head">
				[[ include TEMPLATE_PATH ~ "blocks/user_info.tpl"]]
				[[ include TEMPLATE_PATH ~ "blocks/menu.tpl"]]
			</div>
			<div id="content">
				<div id="wrapper">
					<div id="center" >
					[[ block content ]]
					[[ endblock ]]
					</div>
				</div>
			</div>	
		</div>
	</div>
</body>
</html>