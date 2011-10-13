[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]] 


[[block left]]
	{parent()}
[[endblock]]

[[block content]]
	<div id="tabs">			
		<a href="#tab0" class="item active" >Sape</a>
		<a href="#tab1" class="item" >Webmaster</a>
		<a href="#tab2" class="item" >Metrika</a>
	</div>
	<div id="main-container" class="tab-content" style="display:block;">
		{sapePassform|raw}
	</div>
	<div id="main-container" class="tab-content">
		{webmasterPassform|raw}
	</div>
	<div id="main-container" class="tab-content">
		{metrikaPassform|raw}
	</div>
[[endblock]]